<?php

namespace App\DataTables\Village;

use App\Models\Activity;
use App\Models\UserHasVillage;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ActivityDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Activity> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        // Get village_id dari user yang login
        $userHasVillage = UserHasVillage::where('user_id', Auth::id())->first();
        $villageId = $userHasVillage ? $userHasVillage->village_id : null;

        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('sub_activities_count', function ($row) {
                return $row->subActivities->count() . ' Sub Kegiatan';
            })
            ->addColumn('progress', function ($row) use ($villageId) {
                if (!$villageId) {
                    return '<span class="text-muted">-</span>';
                }

                // Hitung village activities untuk desa ini
                $totalActivities = 0;
                $completedActivities = 0;

                foreach ($row->subActivities as $subActivity) {
                    $villageActivity = $subActivity->villageActivities()
                        ->where('village_id', $villageId)
                        ->first();

                    if ($villageActivity) {
                        $totalActivities++;
                        if ($villageActivity->status === 'completed') {
                            $completedActivities++;
                        }
                    }
                }

                if ($totalActivities === 0) {
                    return '<span class="text-muted">0%</span>';
                }

                $percentage = round(($completedActivities / $totalActivities) * 100, 1);

                // Tentukan warna badge berdasarkan persentase
                $badgeClass = $percentage == 100 ? 'bg-success' : ($percentage >= 50 ? 'bg-primary' : 'bg-warning');

                return <<<HTML
                    <div class="d-flex align-items-center">
                        <span class="badge {$badgeClass} me-2">{$percentage}%</span>
                        <small class="text-muted">{$completedActivities}/{$totalActivities}</small>
                    </div>
                HTML;
            })
            ->addColumn('action', function ($row) {
                $showUrl = route('village.activities.show', $row->id);
                return <<<BLADE
                    <div class="d-flex justify-content-center">
                        <a href="{$showUrl}" class="btn btn-sm btn-outline-info">
                            <i class="bx bx-show me-2"></i> Detail
                        </a>
                    </div>
                BLADE;
            })
            ->rawColumns(['action', 'progress']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Activity>
     */
    public function query(Activity $model): QueryBuilder
    {
        return $model->newQuery()
            ->with(['subActivities.villageActivities']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('activity-table')
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
            Column::make('title')->title('Judul Kegiatan'),
            Column::computed('sub_activities_count')
                ->title('Jumlah Sub Kegiatan')
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
        return 'Village\Activity_' . date('YmdHis');
    }
}
