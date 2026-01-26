<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\CashFlowDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CashFlowRequest;
use App\Services\ActivityService;
use App\Services\CashFlowService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashFlowController extends Controller
{
    protected $activityService;
    protected $cashFlowService;

    public function __construct(ActivityService $activityService, CashFlowService $cashFlowService)
    {
        $this->activityService = $activityService;
        $this->cashFlowService = $cashFlowService;
    }

    private function user()
    {
        return Auth::user();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(CashFlowDataTable $dataTable)
    {
        $sourceFunds = \App\Models\SourceFund::all();
        return $dataTable->render('pages.admin.cash_flow.index', compact('sourceFunds'));
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
    public function store(CashFlowRequest $request)
    {
        try {
            $cashFlow = $this->cashFlowService->createCashFlow($request->validated());

            $this->activityService->log(
                'admin',
                $this->user()->id,
                'create',
                'Menambahkan data keuangan ' . $cashFlow->receipt_number
            );

            return redirect()->route('admin.cash-flows.index')
                ->with('success', 'Data keuangan berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan data keuangan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cashFlow = $this->cashFlowService->getCashFlowById($id);
        return view('pages.admin.cash_flow.show', compact('cashFlow'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cashFlow = $this->cashFlowService->getCashFlowById($id);
        $sourceFunds = \App\Models\SourceFund::all();
        return view('pages.admin.cash_flow.edit', compact('cashFlow', 'sourceFunds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CashFlowRequest $request, string $id)
    {
        try {
            $cashFlow = $this->cashFlowService->getCashFlowById($id);
            $updatedCashFlow = $this->cashFlowService->updateCashFlow($cashFlow, $request->validated());

            $this->activityService->log(
                'admin',
                $this->user()->id,
                'update',
                'Mengubah data keuangan ' . $updatedCashFlow->receipt_number
            );

            return redirect()->route('admin.cash-flows.show', $updatedCashFlow->id)
                ->with('success', 'Data keuangan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui data keuangan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $cashFlow = $this->cashFlowService->getCashFlowById($id);
            $receiptNumber = $cashFlow->receipt_number;

            $this->cashFlowService->deleteCashFlow($cashFlow);

            $this->activityService->log(
                'admin',
                $this->user()->id,
                'delete',
                'Menghapus data keuangan ' . $receiptNumber
            );

            return redirect()->route('admin.cash-flows.index')
                ->with('success', 'Data keuangan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data keuangan: ' . $e->getMessage());
        }
    }
}
