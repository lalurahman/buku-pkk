<?php

namespace App\DataTables\Admin;

use App\Models\MeetingMinute;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MeetingMinuteDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<MeetingMinute> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $showUrl = route('admin.meeting-minutes.show', $row->id);
                return <<<BLADE
                    <div class="d-flex justify-content-center">
                        <a href="{$showUrl}" class="btn btn-sm btn-outline-info me-2">
                            Lihat Detail
                        </a>
                    </div>
                BLADE;
            })
            ->editColumn('meeting_date', function ($row) {
                $date = \Carbon\Carbon::parse($row->meeting_date)->format('d M Y');
                $start = \Carbon\Carbon::parse($row->start_time)->format('H:i');
                $end = $row->end_time ? \Carbon\Carbon::parse($row->end_time)->format('H:i') : '-';
                return '<div>' .
                    '<div class="fw-medium">' . $date . '</div>' .
                    '<small class="text-muted"><i class="bx bx-time-five me-1"></i>' . $start . ' - ' . $end . '</small>' .
                    '</div>';
            })
            ->editColumn('location', function ($row) {
                return '<div><i class="bx bx-map text-muted me-1"></i>' . $row->location . '</div>';
            })
            ->editColumn('meeting_type', function ($row) {
                if ($row->meeting_type) {
                    return '<span class="badge bg-label-info">' . $row->meeting_type . '</span>';
                }
                return '<span class="text-muted">-</span>';
            })
            ->editColumn('leader', function ($row) {
                if ($row->leader) {
                    return '<div><i class="bx bx-user text-muted me-1"></i>' . $row->leader . '</div>';
                }
                return '<span class="text-muted">-</span>';
            })
            ->addColumn('attendance', function ($row) {
                if ($row->attended_count && $row->invited_count) {
                    $percentage = round(($row->attended_count / $row->invited_count) * 100);
                    $color = $percentage >= 80 ? 'success' : ($percentage >= 50 ? 'warning' : 'danger');
                    return '<div>' .
                        '<span class="fw-medium text-' . $color . '">' . $row->attended_count . '</span>' .
                        ' / ' . $row->invited_count .
                        '<small class="text-muted ms-1">(' . $percentage . '%)</small>' .
                        '</div>';
                } elseif ($row->attended_count) {
                    return '<span class="fw-medium">' . $row->attended_count . '</span> <small class="text-muted">orang</small>';
                }
                return '<span class="text-muted">-</span>';
            })
            ->editColumn('agenda', function ($row) {
                if ($row->agenda) {
                    $agenda = strlen($row->agenda) > 50 ? substr($row->agenda, 0, 50) . '...' : $row->agenda;
                    return '<div class="text-truncate" style="max-width: 250px;" title="' . htmlspecialchars($row->agenda) . '">' . $agenda . '</div>';
                }
                return '<span class="text-muted">-</span>';
            })
            ->rawColumns(['action', 'meeting_date', 'time_range', 'location', 'meeting_type', 'leader', 'attendance', 'agenda'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<MeetingMinute>
     */
    public function query(MeetingMinute $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('meetingminute-table')
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
            Column::make('meeting_date')
                ->title('Tanggal & Waktu')
                ->width(150),
            Column::make('location')
                ->title('Lokasi')
                ->width(150),
            Column::make('meeting_type')
                ->title('Jenis Rapat')
                ->width(120),
            Column::make('leader')
                ->title('Pimpinan')
                ->width(150),
            Column::computed('attendance')
                ->title('Kehadiran')
                ->searchable(false)
                ->orderable(false)
                ->width(100)
                ->addClass('text-center'),
            Column::make('agenda')
                ->title('Agenda'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Admin\MeetingMinute_' . date('YmdHis');
    }
}
