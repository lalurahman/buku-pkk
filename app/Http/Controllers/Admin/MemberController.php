<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\MainMemberDataTable;
use App\DataTables\Admin\MemberDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\MemberRequest;
use App\Models\FunctionalPosition;
use App\Models\Member;
use App\Models\MemberRole;
use App\Services\ActivityService;
use App\Services\MemberService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    protected $activityService;
    protected $memberService;

    public function __construct(ActivityService $activityService, MemberService $memberService)
    {
        $this->activityService = $activityService;
        $this->memberService = $memberService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(MemberDataTable $dataTable)
    {
        $memberRoles = MemberRole::all();
        $functionalPositions = FunctionalPosition::all();

        // Get member count by functional position
        $memberStats = FunctionalPosition::withCount('members')->get();
        $totalMembers = Member::count();
        $activeMembers = Member::where('status', 'active')->count();

        return $dataTable->render('pages.admin.member.index', compact(
            'memberRoles',
            'functionalPositions',
            'memberStats',
            'totalMembers',
            'activeMembers'
        ));
    }

    public function mainMember(MainMemberDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.member.main_member');
    }

    private function user()
    {
        return Auth::user();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MemberRequest $request)
    {
        try {
            $member = $this->memberService->createMember($request->validated());

            $this->activityService->log(
                'admin',
                $this->user()->id,
                'created',
                'Created member: ' . $member->name
            );

            return redirect()->route('admin.members.index')
                ->with('success', 'Member berhasil ditambahkan.');
        } catch (\Throwable $th) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan member: ' . $th->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $member = $this->memberService->getMemberById($id);

        if (!$member) {
            return redirect()->back()
                ->with('error', 'Member tidak ditemukan.');
        }

        $member->load(['memberRole', 'functionalPosition']);

        return view('pages.admin.member.show', compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $member = $this->memberService->getMemberById($id);

        if (!$member) {
            return redirect()->back()
                ->with('error', 'Member tidak ditemukan.');
        }

        $memberRoles = MemberRole::all();
        $functionalPositions = FunctionalPosition::all();

        return view('pages.admin.member.edit', compact('member', 'memberRoles', 'functionalPositions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MemberRequest $request, string $id)
    {
        try {
            $member = $this->memberService->getMemberById($id);

            if (!$member) {
                return redirect()->back()
                    ->with('error', 'Member tidak ditemukan.');
            }

            $updatedMember = $this->memberService->updateMember($member, $request->validated());

            $this->activityService->log(
                'admin',
                $this->user()->id,
                'updated',
                'Updated member: ' . $updatedMember->name
            );

            return redirect()->route('admin.members.index')
                ->with('success', 'Member berhasil diperbarui.');
        } catch (\Throwable $th) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui member: ' . $th->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $member = $this->memberService->getMemberById($id);

            if (!$member) {
                return redirect()->back()
                    ->with('error', 'Member tidak ditemukan.');
            }

            $memberName = $member->name;
            $member->delete();

            $this->activityService->log(
                'admin',
                $this->user()->id,
                'deleted',
                'Deleted member: ' . $memberName
            );

            return redirect()->route('admin.members.index')
                ->with('success', 'Member berhasil dihapus.');
        } catch (\Throwable $th) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus member: ' . $th->getMessage());
        }
    }
}
