<?php

namespace App\DataTables\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserVillageDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<UserVillage> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('villages', function ($row) {
                $villages = $row->userHasVillages->map(function ($userVillage) {
                    return '<span class="badge bg-success mb-1"><i class="bx bx-map"></i> ' . ($userVillage->village->name ?? '-') . '</span>';
                })->join(' ');
                return $villages ?: '-';
            })
            ->addColumn('districts', function ($row) {
                $districts = $row->userHasVillages->map(function ($userVillage) {
                    return $userVillage->village->district->name ?? '-';
                })->unique()->map(function ($district) {
                    return '<span class="badge bg-primary mb-1"><i class="bx bx-buildings"></i> ' . $district . '</span>';
                })->join(' ');
                return $districts ?: '-';
            })
            ->addColumn('action', function ($row) {
                $showUrl = route('admin.user.villages.show', $row->id);
                return <<<BLADE
                    <div class="d-flex justify-content-center">
                        <a href="{$showUrl}" class="btn btn-sm btn-outline-info">
                            <i class="bx bx-show"></i>
                        </a>
                    </div>
                BLADE;
            })
            ->rawColumns(['villages', 'districts', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<UserVillage>
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery()
            ->whereHas('userHasVillages')
            ->with(['userHasVillages.village.district']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('uservillage-table')
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
            Column::make('name')->title('Nama'),
            Column::make('email')->title('Email'),
            Column::computed('villages')
                ->title('Desa')
                ->searchable(false)
                ->orderable(false)
                ->width(150),
            Column::computed('districts')
                ->title('Kecamatan')
                ->searchable(false)
                ->orderable(false)
                ->width(150),
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
        return 'Admin\UserVillage_' . date('YmdHis');
    }
}
