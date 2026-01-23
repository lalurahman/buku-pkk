<?php

namespace App\DataTables\Admin;

use App\Models\OutgoingLetter;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class OutgoingLetterDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<OutgoingLetter> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return <<<BLADE
                    <div class="d-flex justify-content-center">
                        <a href="#" class="btn btn-sm btn-outline-info me-2">
                            Lihat Detail
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-info me-2">
                            <i class="bx bx-edit"></i>
                        </a>
                        <button class="btn btn-sm btn-outline-danger btn-delete" data-id="{$row->id}">
                            <i class="bx bx-trash"></i>
                        </button>
                    </div>
                BLADE;
            })
            ->rawColumns(['action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<OutgoingLetter>
     */
    public function query(OutgoingLetter $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('outgoingletter-table')
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
            Column::make('letter_number'),
            Column::make('recipient'),
            Column::make('subject'),
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
        return 'Admin\OutgoingLetter_' . date('YmdHis');
    }
}
