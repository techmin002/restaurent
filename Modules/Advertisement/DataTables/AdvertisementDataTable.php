<?php

namespace Modules\Advertisement\DataTables;

use Modules\Advertisement\Entities\Advertisemment;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AdvertisementDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($data) {
                return view('advertisement::advertisements.partials.actions', compact('data'));
            })
            ->editColumn('image', function (Advertisemment $advertisemment) {
                return '<img src=' . asset('images/advertisements/' . $advertisemment->image) . ' height="80px" width="400px">';
            })
            ->editColumn('status', function (Advertisemment $advertisemment) {
                return $advertisemment->status ? '<span style="color:white;background-color:green; padding:5px; border-radius:10px;">On</span>' : '<span style="color:white;background-color:red; padding:5px; border-radius:10px;">Off</span>';
            })
            ->editColumn('title', function (Advertisemment $advertisemment) {
                return $advertisemment->title;
            })
            ->editColumn('expire_date', function (Advertisemment $advertisemment) {
                return date('Y-m-d', strtotime($advertisemment->expire_date));
            })
            ->editColumn('link', function (Advertisemment $advertisemment) {
                return $advertisemment->link;
            })
            ->editColumn('created_at', function (Advertisemment $advertisemment) {
                return date('Y-m-d', strtotime($advertisemment->created_at));
            })
            ->escapeColumns([]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Team $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Advertisemment $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('teams-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row'<'col-md-3'l><'col-md-5 mb-2'B><'col-md-4'f>> .
                                'tr' .
                                <'row'<'col-md-5'i><'col-md-7 mt-2'p>>")
            ->orderBy(4)
            ->buttons(
                Button::make('excel')
                    ->text('<i class="bi bi-file-earmark-excel-fill"></i> Excel'),
                Button::make('print')
                    ->text('<i class="bi bi-printer-fill"></i> Print'),
                Button::make('reset')
                    ->text('<i class="bi bi-x-circle"></i> Reset'),
                Button::make('reload')
                    ->text('<i class="bi bi-arrow-repeat"></i> Reload')
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id'),
            Column::make('image'),
            Column::make('title'),
            Column::make('expire_date'),
            Column::make('link'),
            Column::make('status'),
            Column::make('created_at'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Team_' . date('YmdHis');
    }
}
