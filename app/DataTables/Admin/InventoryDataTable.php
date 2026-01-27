<?php

namespace App\DataTables\Admin;

use App\Models\Inventory;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class InventoryDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Inventory> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('name', function ($row) {
                return '<div class="fw-semibold">' . $row->name . '</div>';
            })
            ->editColumn('source', function ($row) {
                return '<small class="text-muted"><i class="bx bx-package"></i> ' . $row->source . '</small>';
            })
            ->editColumn('received_date', function ($row) {
                $date = \Carbon\Carbon::parse($row->received_date);
                return '<div><i class="bx bx-calendar text-primary"></i> ' . $date->translatedFormat('d M Y') . '</div>';
            })
            ->editColumn('quantity', function ($row) {
                return '<span class="badge bg-info">' . number_format($row->quantity, 0, ',', '.') . ' Unit</span>';
            })
            ->editColumn('storage_location', function ($row) {
                return '<small><i class="bx bx-map text-warning"></i> ' . $row->storage_location . '</small>';
            })
            ->editColumn('condition', function ($row) {
                $badgeClass = match ($row->condition) {
                    'Baik' => 'bg-success',
                    'Rusak Ringan' => 'bg-warning',
                    'Rusak Berat' => 'bg-danger',
                    default => 'bg-secondary'
                };

                $icon = match ($row->condition) {
                    'Baik' => 'bx-check-circle',
                    'Rusak Ringan' => 'bx-error-circle',
                    'Rusak Berat' => 'bx-x-circle',
                    default => 'bx-info-circle'
                };

                return '<span class="badge ' . $badgeClass . '"><i class="bx ' . $icon . '"></i> ' . $row->condition . '</span>';
            })
            ->addColumn('action', function ($row) {
                $showUrl = route('admin.inventories.show', $row->id);
                return <<<BLADE
                    <div class="d-flex justify-content-center">
                        <a href="{$showUrl}" class="btn btn-sm btn-outline-info">
                            <i class="bx bx-show me-2"></i>
                            Lihat Detail
                        </a>
                    </div>
                BLADE;
            })
            ->rawColumns(['name', 'source', 'received_date', 'quantity', 'storage_location', 'condition', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Inventory>
     */
    public function query(Inventory $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('inventory-table')
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
            Column::make('name')
                ->title('Nama Barang')
                ->width(200),
            Column::make('source')
                ->title('Sumber')
                ->width(120),
            Column::make('received_date')
                ->title('Tgl. Diterima')
                ->width(120)
                ->addClass('text-center'),
            Column::make('quantity')
                ->title('Jumlah')
                ->width(100)
                ->addClass('text-center'),
            Column::make('storage_location')
                ->title('Lokasi')
                ->width(150),
            Column::make('condition')
                ->title('Kondisi')
                ->width(120)
                ->addClass('text-center'),
            Column::computed('action')
                ->title('Aksi')
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
        return 'Admin\Inventory_' . date('YmdHis');
    }
}
