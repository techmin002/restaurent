<?php

namespace Modules\Testimonial\DataTables;

use Modules\Faq\Entities\Faq;
use Modules\Team\Entities\Team;
use Modules\Testimonial\Entities\Testimonial;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TestimonialDataTable extends DataTable
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
                return view('testimonial::testimonials.partials.actions', compact('data'));
            })
            ->editColumn('image', function (Testimonial $testimonial) {
                return '<img src=' . asset('images/testimonials/' . $testimonial->image) . ' height="100px" width="100px">';
            })
            ->editColumn('status', function (Testimonial $testimonial) {
                return $testimonial->status ? '<span style="color:white;background-color:green; padding:5px; border-radius:10px;">On</span>' : '<span style="color:white;background-color:red; padding:5px; border-radius:10px;">Off</span>';
            })
            ->editColumn('name', function (Testimonial $testimonial) {
                return $testimonial->name;
            })
            ->editColumn('message', function (Testimonial $testimonial) {
                return $testimonial->message;
            })

            ->editColumn('created_at', function (Testimonial $testimonial) {
                return date('Y-m-d', strtotime($testimonial->created_at));
            })
            ->escapeColumns([]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Testimonial $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Testimonial $model)
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
            Column::make('name'),
            Column::make('message'),
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
