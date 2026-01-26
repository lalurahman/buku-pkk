<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\IncomingLetterDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Letter\IncomingLetterRequest;
use App\Models\IncomingLetter;
use App\Services\ActivityService;
use App\Services\IncomingLetterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomingLetterController extends Controller
{
    protected $activityService;
    protected $incomingLetterService;

    public function __construct(ActivityService $activityService, IncomingLetterService $incomingLetterService)
    {
        $this->activityService = $activityService;
        $this->incomingLetterService = $incomingLetterService;
    }

    private function user()
    {
        return Auth::user();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(IncomingLetterDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.incoming_letter.index');
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
    public function store(IncomingLetterRequest $request)
    {
        try {
            $incomingLetter = $this->incomingLetterService->createIncomingLetter($request->validated());

            $this->activityService->log(
                'admin',
                $this->user()->id,
                'created',
                'Created incoming letter: ' . $incomingLetter->letter_number
            );

            return redirect()->route('admin.incoming-letters.index')
                ->with('success', 'Surat masuk berhasil ditambahkan.');
        } catch (\Throwable $th) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan surat masuk: ' . $th->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $incomingLetter = $this->incomingLetterService->getIncomingLetterById($id);

        if (!$incomingLetter) {
            return redirect()->back()
                ->with('error', 'Surat masuk tidak ditemukan.');
        }

        $incomingLetter->load('letterDispositions');

        return view('pages.admin.incoming_letter.show', compact('incomingLetter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $incomingLetter = $this->incomingLetterService->getIncomingLetterById($id);

        if (!$incomingLetter) {
            return redirect()->back()
                ->with('error', 'Surat masuk tidak ditemukan.');
        }

        return view('pages.admin.incoming_letter.edit', compact('incomingLetter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IncomingLetterRequest $request, string $id)
    {
        try {
            $incomingLetter = $this->incomingLetterService->getIncomingLetterById($id);

            if (!$incomingLetter) {
                return redirect()->back()
                    ->with('error', 'Surat masuk tidak ditemukan.');
            }

            $updatedLetter = $this->incomingLetterService->updateIncomingLetter($incomingLetter, $request->all());

            $this->activityService->log(
                'admin',
                $this->user()->id,
                'updated',
                'Updated incoming letter: ' . $updatedLetter->letter_number
            );

            return redirect()->route('admin.incoming-letters.index')
                ->with('success', 'Surat masuk berhasil diperbarui.');
        } catch (\Throwable $th) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui surat masuk: ' . $th->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $incomingLetter = $this->incomingLetterService->getIncomingLetterById($id);

            if (!$incomingLetter) {
                return redirect()->back()
                    ->with('error', 'Surat masuk tidak ditemukan.');
            }

            $letterNumber = $incomingLetter->letter_number;
            $this->incomingLetterService->deleteIncomingLetter($incomingLetter);

            $this->activityService->log(
                'admin',
                $this->user()->id,
                'deleted',
                'Deleted incoming letter: ' . $letterNumber
            );

            return redirect()->route('admin.incoming-letters.index')
                ->with('success', 'Surat masuk berhasil dihapus.');
        } catch (\Throwable $th) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus surat masuk: ' . $th->getMessage());
        }
    }
}
