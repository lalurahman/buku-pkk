<?php

namespace App\DataTables\Admin;

use App\Models\VillageActivity;
use App\Models\Village;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProgressDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Progress> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('village_name', function ($row) {
                return $row->name;
            })
            ->addColumn('district_name', function ($row) {
                return $row->district->name ?? '-';
            })
            ->addColumn('total_activities', function ($row) {
                return $row->total_activities;
            })
            ->addColumn('completed_activities', function ($row) {
                return $row->completed_activities;
            })
            ->addColumn('percentage', function ($row) {
                $percentage = $row->total_activities > 0
                    ? round(($row->completed_activities / $row->total_activities) * 100, 1)
                    : 0;

                $badgeClass = 'bg-warning';
                if ($percentage >= 100) {
                    $badgeClass = 'bg-success';
                } elseif ($percentage >= 50) {
                    $badgeClass = 'bg-primary';
                }

                return '<span class="badge ' . $badgeClass . ' rounded-pill">' . $percentage . '%</span>';
            })
            ->addColumn('action', function ($row) {
                $detailUrl = route('admin.activities.progress-detail', ['id' => request()->route('id'), 'villageId' => $row->id]);
                return <<<BLADE
                    <div class="d-flex justify-content-center">
                        <a href="{$detailUrl}" class="btn btn-sm btn-outline-info me-2">
                            Lihat Detail
                        </a>
                    </div>
                BLADE;
            })
            ->rawColumns(['percentage', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Village $model): QueryBuilder
    {
        $activityId = request()->route('id');

        // Get villages that have village activities for this activity
        return $model->newQuery()
            ->select([
                'villages.id',
                'villages.name',
                'villages.district_id',
                DB::raw('COUNT(village_activities.id) as total_activities'),
                DB::raw('SUM(CASE WHEN village_activities.status = "completed" THEN 1 ELSE 0 END) as completed_activities')
            ])
            ->join('village_activities', 'villages.id', '=', 'village_activities.village_id')
            ->join('sub_activities', 'village_activities.sub_activity_id', '=', 'sub_activities.id')
            ->where('sub_activities.activity_id', $activityId)
            ->with('district')
            ->groupBy('villages.id', 'villages.name', 'villages.district_id');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('progress-table')
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
            Column::make('village_name')->title('Desa/Kelurahan')->searchable(true),
            Column::make('district_name')->title('Kecamatan'),
            Column::make('completed_activities')
                ->title('Kegiatan Selesai')
                ->addClass('text-center'),
            Column::computed('percentage')
                ->title('Persentase')
                ->addClass('text-center')
                ->exportable(false)
                ->printable(false),
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
        return 'Admin\Progress_' . date('YmdHis');
    }
}
