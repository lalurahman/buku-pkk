<?php

namespace App\DataTables\Admin;

use App\Models\CashFlow;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CashFlowDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<CashFlow> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $showUrl = route('admin.cash-flows.show', $row->id);
                return <<<BLADE
                    <div class="d-flex justify-content-center">
                        <a href="{$showUrl}" class="btn btn-sm btn-outline-info me-2">
                            Lihat Detail
                        </a>
                    </div>
                BLADE;
            })
            ->editColumn('amount', function ($row) {
                return 'Rp ' . number_format($row->amount, 0, ',', '.');
            })
            ->editColumn('type', function ($row) {
                if ($row->type === 'income') {
                    return '<span class="badge bg-success">Pemasukan</span>';
                } else {
                    return '<span class="badge bg-danger">Pengeluaran</span>';
                }
            })
            ->rawColumns(['action', 'type'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<CashFlow>
     */
    public function query(CashFlow $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('cashflow-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle();
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')
                ->title('#')
                ->searchable(false)
                ->orderable(false)
                ->width(30)
                ->addClass('text-center'),
            Column::make('date')->title('Tanggal'),
            Column::make('type')->title('Tipe'),
            Column::make('description')->title('Deskripsi'),
            Column::make('amount')->title('Jumlah'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Admin\CashFlow_' . date('YmdHis');
    }
}
