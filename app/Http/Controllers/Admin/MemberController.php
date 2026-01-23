<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\MemberDataTable;
use App\Http\Controllers\Controller;
use App\Models\FunctionalPosition;
use App\Models\Member;
use App\Models\MemberRole;
use Illuminate\Http\Request;

class MemberController extends Controller
{
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
