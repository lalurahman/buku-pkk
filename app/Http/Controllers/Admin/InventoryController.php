<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\InventoryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\InventoryRequest;
use App\Services\ActivityService;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    protected $activityService;
    protected $inventoryService;

    public function __construct(ActivityService $activityService, InventoryService $inventoryService)
    {
        $this->activityService = $activityService;
        $this->inventoryService = $inventoryService;
    }

    private function user()
    {
        return Auth::user();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(InventoryDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.inventory.index');
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
    public function store(InventoryRequest $request)
    {
        try {
            $inventory = $this->inventoryService->createInventory($request->validated());

            $this->activityService->log(
                'admin',
                $this->user()->id,
                'create',
                'Menambahkan data inventaris ' . $inventory->name
            );

            return redirect()->route('admin.inventories.index')
                ->with('success', 'Data inventaris berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan data inventaris: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $inventory = $this->inventoryService->getInventoryById($id);
        return view('pages.admin.inventory.show', compact('inventory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $inventory = $this->inventoryService->getInventoryById($id);
        return view('pages.admin.inventory.edit', compact('inventory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InventoryRequest $request, string $id)
    {
        try {
            $inventory = $this->inventoryService->getInventoryById($id);
            $updatedInventory = $this->inventoryService->updateInventory($inventory, $request->validated());

            $this->activityService->log(
                'admin',
                $this->user()->id,
                'update',
                'Mengubah data inventaris ' . $updatedInventory->name
            );

            return redirect()->route('admin.inventories.show', $updatedInventory->id)
                ->with('success', 'Data inventaris berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui data inventaris: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $inventory = $this->inventoryService->getInventoryById($id);
            $inventoryName = $inventory->name;

            $this->inventoryService->deleteInventory($inventory);

            $this->activityService->log(
                'admin',
                $this->user()->id,
                'delete',
                'Menghapus data inventaris ' . $inventoryName
            );

            return redirect()->route('admin.inventories.index')
                ->with('success', 'Data inventaris berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data inventaris: ' . $e->getMessage());
        }
    }
}
