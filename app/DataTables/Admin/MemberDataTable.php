<?php

namespace App\DataTables\Admin;

use App\Models\Member;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MemberDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Member> $query Results from query() method.
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
            ->editColumn('name', function ($row) {
                $functionalPosition = $row->functionalPosition ? $row->functionalPosition->name : '-';
                return $row->name . '<br><small class="text-muted"><i class="bx bx-briefcase"></i> ' . $functionalPosition . '</small>';
            })
            ->editColumn('date_of_birth', function ($row) {
                return $row->date_of_birth ? date('d-m-Y', strtotime($row->date_of_birth)) . ' (' . \Carbon\Carbon::parse($row->date_of_birth)->age . ' tahun)' : '-';
            })
            ->editColumn('status', function ($row) {
                $badgeClass = $row->status === 'active' ? 'bg-label-success' : 'bg-label-secondary';
                $statusText = $row->status === 'active' ? 'Aktif' : 'Tidak Aktif';
                return '<span class="badge ' . $badgeClass . '">' . $statusText . '</span>';
            })
            ->rawColumns(['action', 'name', 'status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Member>
     */
    public function query(Member $model): QueryBuilder
    {
        $query = $model->newQuery()
            ->with(['memberRole', 'functionalPosition'])
            ->select('members.*');

        // Filter by functional position if provided (exclude 'all' option)
        if (
            request()->has('functional_position_id') &&
            request('functional_position_id') !== '' &&
            request('functional_position_id') !== 'all'
        ) {
            $query->where('functional_position_id', request('functional_position_id'));
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('member-table')
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
            Column::make('name')->title('Nama Lengkap & Jabatan'),
            Column::make('registration_number')->title('No. Registrasi'),
            Column::make('date_of_birth')->title('Tanggal Lahir (Usia)'),
            Column::make('phone_number')->title('No. Telepon'),
            Column::make('status')->title('Status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                ->orderable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Admin\Member_' . date('YmdHis');
    }
}
