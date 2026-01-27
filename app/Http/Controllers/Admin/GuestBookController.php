<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\GuestBookDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\GuestBookRequest;
use App\Services\ActivityService;
use App\Services\GuestBookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestBookController extends Controller
{
    protected $activityService;
    protected $guestBookService;

    public function __construct(ActivityService $activityService, GuestBookService $guestBookService)
    {
        $this->activityService = $activityService;
        $this->guestBookService = $guestBookService;
    }

    private function user()
    {
        return Auth::user();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(GuestBookDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.guest_book.index');
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
    public function store(GuestBookRequest $request)
    {
        try {
            $guestBook = $this->guestBookService->createGuestBook($request->validated());

            $this->activityService->log(
                'admin',
                $this->user()->id,
                'create',
                'Menambahkan data buku tamu dari ' . $guestBook->visitor_name
            );

            return redirect()->route('admin.guest-books.index')
                ->with('success', 'Data buku tamu berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan data buku tamu: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $guestBook = $this->guestBookService->getGuestBookById($id);
        return view('pages.admin.guest_book.show', compact('guestBook'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $guestBook = $this->guestBookService->getGuestBookById($id);
        return view('pages.admin.guest_book.edit', compact('guestBook'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GuestBookRequest $request, string $id)
    {
        try {
            $guestBook = $this->guestBookService->getGuestBookById($id);
            $updatedGuestBook = $this->guestBookService->updateGuestBook($guestBook, $request->validated());

            $this->activityService->log(
                'admin',
                $this->user()->id,
                'update',
                'Mengubah data buku tamu dari ' . $updatedGuestBook->visitor_name
            );

            return redirect()->route('admin.guest-books.show', $updatedGuestBook->id)
                ->with('success', 'Data buku tamu berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui data buku tamu: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $guestBook = $this->guestBookService->getGuestBookById($id);
            $visitorName = $guestBook->visitor_name;

            $this->guestBookService->deleteGuestBook($guestBook);

            $this->activityService->log(
                'admin',
                $this->user()->id,
                'delete',
                'Menghapus data buku tamu dari ' . $visitorName
            );

            return redirect()->route('admin.guest-books.index')
                ->with('success', 'Data buku tamu berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data buku tamu: ' . $e->getMessage());
        }
    }
}
