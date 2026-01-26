<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\OutgoingLetterDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Letter\OutgoingLetterRequest;
use App\Services\ActivityService;
use App\Services\OutgoingLetterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OutgoingLetterController extends Controller
{
    protected $activityService;
    protected $outgoingLetterService;

    public function __construct(ActivityService $activityService, OutgoingLetterService $outgoingLetterService)
    {
        $this->activityService = $activityService;
        $this->outgoingLetterService = $outgoingLetterService;
    }

    private function user()
    {
        return Auth::user();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(OutgoingLetterDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.outgoing_letter.index');
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
    public function store(OutgoingLetterRequest $request)
    {
        try {
            $outgoingLetter = $this->outgoingLetterService->createOutgoingLetter($request->validated());

            $this->activityService->log(
                'admin',
                $this->user()->id,
                'created',
                'Created outgoing letter: ' . $outgoingLetter->letter_number
            );

            return redirect()->route('admin.outgoing-letters.index')
                ->with('success', 'Surat keluar berhasil ditambahkan.');
        } catch (\Throwable $th) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan surat keluar: ' . $th->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $outgoingLetter = $this->outgoingLetterService->getOutgoingLetterById($id);

        if (!$outgoingLetter) {
            return redirect()->back()
                ->with('error', 'Surat keluar tidak ditemukan.');
        }

        $outgoingLetter->load('outgoingLetterCcs');

        return view('pages.admin.outgoing_letter.show', compact('outgoingLetter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $outgoingLetter = $this->outgoingLetterService->getOutgoingLetterById($id);

        if (!$outgoingLetter) {
            return redirect()->back()
                ->with('error', 'Surat keluar tidak ditemukan.');
        }

        return view('pages.admin.outgoing_letter.edit', compact('outgoingLetter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OutgoingLetterRequest $request, string $id)
    {
        try {
            $outgoingLetter = $this->outgoingLetterService->getOutgoingLetterById($id);

            if (!$outgoingLetter) {
                return redirect()->back()
                    ->with('error', 'Surat keluar tidak ditemukan.');
            }

            $updatedLetter = $this->outgoingLetterService->updateOutgoingLetter($outgoingLetter, $request->all());

            $this->activityService->log(
                'admin',
                $this->user()->id,
                'updated',
                'Updated outgoing letter: ' . $updatedLetter->letter_number
            );

            return redirect()->route('admin.outgoing-letters.index')
                ->with('success', 'Surat keluar berhasil diperbarui.');
        } catch (\Throwable $th) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui surat keluar: ' . $th->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $outgoingLetter = $this->outgoingLetterService->getOutgoingLetterById($id);

            if (!$outgoingLetter) {
                return redirect()->back()
                    ->with('error', 'Surat keluar tidak ditemukan.');
            }

            $letterNumber = $outgoingLetter->letter_number;
            $this->outgoingLetterService->deleteOutgoingLetter($outgoingLetter);

            $this->activityService->log(
                'admin',
                $this->user()->id,
                'deleted',
                'Deleted outgoing letter: ' . $letterNumber
            );

            return redirect()->route('admin.outgoing-letters.index')
                ->with('success', 'Surat keluar berhasil dihapus.');
        } catch (\Throwable $th) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus surat keluar: ' . $th->getMessage());
        }
    }
}
