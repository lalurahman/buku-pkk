<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity as ActivityModel;
use App\Models\CashFlow;
use App\Models\GuestBook;
use App\Models\IncomingLetter;
use App\Models\Inventory;
use App\Models\LetterDisposition;
use App\Models\Member;
use App\Models\MeetingMinute;
use App\Models\OutgoingLetter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Statistics
        $stats = [
            'total_members' => Member::count(),
            'active_members' => Member::where('status', 'active')->count(),
            'total_activities' => ActivityModel::count(),
            'total_guest_books' => GuestBook::count(),
            'total_incoming_letters' => IncomingLetter::count(),
            'total_outgoing_letters' => OutgoingLetter::count(),
            'total_inventories' => Inventory::count(),
            'total_meetings' => MeetingMinute::count(),
        ];

        // Cash Flow Statistics
        $totalIncome = CashFlow::where('type', 'income')->sum('amount');
        $totalExpense = CashFlow::where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        // Recent Activities
        $recentActivities = ActivityModel::orderBy('start_date', 'desc')->take(5)->get();

        // Recent Guest Books
        $recentGuests = GuestBook::orderBy('visit_date', 'desc')->take(5)->get();

        // Recent Meetings
        $recentMeetings = MeetingMinute::orderBy('meeting_date', 'desc')->take(3)->get();

        // Monthly Cash Flow (last 6 months)
        $monthlyCashFlow = CashFlow::select(
            DB::raw('MONTH(date) as month'),
            DB::raw('YEAR(date) as year'),
            DB::raw('SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as income'),
            DB::raw('SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as expense')
        )
            ->where('date', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        // log activity user
        $logActivities = Activity::where('causer_id', $user->id)
            ->where('causer_type', 'App\Models\User')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('pages.admin.dashboard.index', compact(
            'stats',
            'totalIncome',
            'totalExpense',
            'balance',
            'recentActivities',
            'recentGuests',
            'recentMeetings',
            'monthlyCashFlow',
            'logActivities',
        ));
    }
}
