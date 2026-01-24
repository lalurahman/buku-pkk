<?php

namespace App\DataTables\District;

use App\Models\Village;
use App\Models\UserHasDistrict;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class VillageDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('district_name', function ($row) {
                return $row->district->name ?? '-';
            })
            ->addColumn('regency_name', function ($row) {
                return $row->district->regency->name ?? '-';
            })
            ->addColumn('total_activities', function ($row) {
                return '<span class="badge bg-label-primary">' . $row->village_activities_count . '</span>';
            })
            ->addColumn('completed_activities', function ($row) {
                return '<span class="badge bg-success">' . $row->completed_activities_count . '</span>';
            })
            ->addColumn('pending_activities', function ($row) {
                return '<span class="badge bg-warning">' . $row->pending_activities_count . '</span>';
            })
            ->addColumn('progress', function ($row) {
                $totalActivities = $row->village_activities_count;
                $completedActivities = $row->completed_activities_count;

                if ($totalActivities === 0) {
                    return '<span class="text-muted">0%</span>';
                }

                $percentage = round(($completedActivities / $totalActivities) * 100, 1);
                $badgeClass = $percentage == 100 ? 'bg-success' : ($percentage >= 50 ? 'bg-primary' : 'bg-warning');

                return <<<HTML
                    <div class="d-flex align-items-center">
                        <span class="badge {$badgeClass} me-2">{$percentage}%</span>
                        <small class="text-muted">{$completedActivities}/{$totalActivities}</small>
                    </div>
                HTML;
            })
            ->addColumn('action', function ($row) {
                $detailUrl = route('district.villages.show', $row->id);
                return <<<HTML
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{$detailUrl}" class="btn btn-sm btn-outline-info" title="Lihat Detail">
                            <i class="bx bx-show"></i>
                        </a>
                    </div>
                HTML;
            })
            ->rawColumns(['total_activities', 'completed_activities', 'pending_activities', 'progress', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Village $model): QueryBuilder
    {
        // Get district_id dari user yang login
        $userHasDistrict = UserHasDistrict::where('user_id', Auth::id())->first();
        $districtId = $userHasDistrict ? $userHasDistrict->district_id : null;

        $query = $model->newQuery()
            ->with(['district.regency'])
            ->withCount([
                'villageActivities',
                'villageActivities as completed_activities_count' => function ($q) {
                    $q->where('status', 'completed');
                },
                'villageActivities as pending_activities_count' => function ($q) {
                    $q->where('status', 'pending');
                }
            ]);

        // Filter by district_id if exists
        if ($districtId) {
            $query->where('district_id', $districtId);
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('village-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->parameters([
                'responsive' => true,
                'autoWidth' => false,
            ]);
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
                ->width(50)
                ->addClass('text-center'),
            Column::make('name')
                ->title('Nama Desa/Kelurahan')
                ->width(200),
            Column::computed('total_activities')
                ->title('Total Kegiatan')
                ->searchable(false)
                ->orderable(false)
                ->width(120)
                ->addClass('text-center'),
            Column::computed('completed_activities')
                ->title('Selesai')
                ->searchable(false)
                ->orderable(false)
                ->width(100)
                ->addClass('text-center'),
            Column::computed('pending_activities')
                ->title('Pending')
                ->searchable(false)
                ->orderable(false)
                ->width(100)
                ->addClass('text-center'),
            Column::computed('progress')
                ->title('Progress')
                ->searchable(false)
                ->orderable(false)
                ->width(150)
                ->addClass('text-center'),
            Column::computed('action')
                ->title('Aksi')
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'District_Village_' . date('YmdHis');
    }
}
