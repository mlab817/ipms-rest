<?php

namespace App\DataTables;

use App\Models\Project;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ReviewsDataTable extends DataTable
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
            ->addColumn('pap_type', function($project) {
                return $project->pap_type->name ?? '';
            })
            ->addColumn('office', function ($row) {
                return $row->creator->office->name ?? '';
            })
            ->addColumn('reviewed', function($project) {
                if ($project->review()->exists()) {
                    return '<span class="badge badge-success">Yes</span>';
                } else {
                    return '<span class="badge badge-danger">No</span>';
                }
            })
            ->addColumn('pip', function($row) {
                if ($row->review) {
                    return $row->review->pip
                        ? '
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon-sm text-success" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        '
                        : '
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon-sm text-danger" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        ';
                }
            })
            ->addColumn('trip', function ($row) {
                if ($row->review) {
                    return $row->review->trip
                        ? '
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon-sm text-success" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        '
                        : '
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon-sm text-danger" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        ';
                }
            })
            ->addColumn('reviewed_on', function ($project) {
                if ($project->review) {
                    return $project->review->updated_at->diffForHumans(null, null, true);
                } else {
                    return '';
                }
            })
            ->addColumn('action', function ($project) {
                if (auth()->user()->can('reviews.create') || auth()->user()->can('projects.review', $project)) {
                    if ($project->review) {
                        return '<a href="' . route('reviews.edit', ['review' => $project->review->getRouteKey()]) . '" class="btn btn-sm btn-secondary">Edit</a>';
                    } else {
                        return '<a href="'. route('reviews.create', ['project' => $project->getRouteKey()]).'" class="btn btn-sm btn-info">Create</a>';
                    }
                }
            })
            ->addColumn('view', function ($project) {
                if ($project->review) {
                    return '<a href="' . route('reviews.show', $project->review) .'" class="btn btn-success btn-sm">View</a>';
                }
            })
            ->rawColumns(['pip','trip','reviewed','action','view']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Project $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Project $model): \Illuminate\Database\Eloquent\Builder
    {
        return $model->with('review','pap_type','creator.office','creator.roles','creator.permissions')->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('reviewsdatatable-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(0)
                    ->buttons(
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
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
            Column::make('title'),
            Column::make('office')
                ->addClass('text-center'),
            Column::make('pap_type')
                ->addClass('text-center'),
            Column::make('reviewed')
                ->addClass('text-center'),
            Column::make('pip')
                ->addClass('text-center'),
            Column::make('trip')
                ->addClass('text-center'),
            Column::make('reviewed_on')
                ->addClass('text-center'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
            Column::make('view'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Reviews_' . date('YmdHis');
    }
}
