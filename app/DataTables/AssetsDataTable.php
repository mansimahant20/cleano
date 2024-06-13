<?php

namespace App\DataTables;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use App\Models\CustomFieldGroup;

class AssetsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable($query)
    {
        $datatables = datatables()->eloquent($query);
        $datatables->addIndexColumn();
        $datatables->addColumn('action', function ($row) {
            $action = '<div class="task_view">
                    <div class="dropdown">
                        <a class="task_view_more d-flex align-items-center justify-content-center dropdown-toggle" type="link"
                            id="dropdownMenuLink-' . $row->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-options-vertical icons"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-' . $row->id . '" tabindex="0">';
        
            $action .= '<a class="dropdown-item openRightModal" href="' . route('assets.show', [$row->id]) . '">
                                <i class="fa fa-eye mr-2"></i>
                                ' . trans('app.view') . '
                            </a>';
        
            $action .= '<a class="dropdown-item openRightModal" href="' . route('assets.edit', [$row->id]) . '">
                                <i class="fa fa-edit mr-2"></i>
                                ' . trans('app.edit') . '
                            </a>';
        
            if ($row->status == 'available') {
                $action .= '<a class="dropdown-item assets-action-lend" data-asset-id="' . $row->id . '" 
                                href="javascript:void(0);">
                                <i class="fa fa-share mr-2"></i>
                                ' . trans('app.lend') . '
                                </a>';
            }
                            
            $action .= '<a class="dropdown-item delete-table-row" href="javascript:;" data-asset-id="' . $row->id . '">
                                <i class="fa fa-trash mr-2"></i>
                                ' . trans('app.delete') . '
                            </a>';
        
            $action .= '</div>
                    </div>
                </div>';
        
            return $action;
        });

        $datatables->editColumn('status', function ($row) {
            if ($row->status == 'available') {
                return ' <i class="fa fa-circle mr-1 text-light-green f-15"></i>' . __('app.available');
            } elseif ($row->status == 'non-functional') {
                return '<i class="fa fa-circle mr-1 text-red f-15"></i>' . __('app.nonFunctional');
            } elseif ($row->status == 'lost') {
                return '<i class="fa fa-circle mr-1 text-yellow f-15"></i>' . __('app.lost');
            } elseif ($row->status == 'damaged') {
                return '<i class="fa fa-circle mr-1 text-pink f-15"></i>' . __('app.damaged');
            } elseif ($row->status == 'under-maintenance') {
                return '<i class="fa fa-circle mr-1 text-orange f-15"></i>' . __('app.underMaintenance');
            }
        });        

        $datatables->editColumn('asset_image', function ($row) {
            if ($row->asset_image) {
                $imageUrl = asset('user-uploads/assets/' . $row->asset_image);
                return '<img src="' . $imageUrl . '" alt="' . $row->asset_name . '" width="100">';
            }
            else {
                return '--';
            }
        });
        
        $datatables->editColumn('created_at', function ($row) {
            return '';
        });
        
        $datatables->editColumn('lent_to', function ($row) {
            if ($row->lent_to) {
                return $row->lent_to->name;
            }
            else {
                return '-';
            }
        });

        // if ($request->searchText != '') {
        //     $users = $users->where(function ($query) {
        //         $query->where('users.name', 'like', '%' . request('searchText') . '%')
        //             ->orWhere('users.email', 'like', '%' . request('searchText') . '%')
        //             ->orWhere('client_details.company_name', 'like', '%' . request('searchText') . '%');
        //     });
        // }

        $datatables->addIndexColumn();
        $datatables->smart(false);
        $datatables->setRowId(function ($row) {
            return 'row-' . $row->id;
        });

        $datatables->rawColumns(['action', 'status', 'asset_image']);

        return $datatables;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Asset $model): QueryBuilder
    {
        $request = $this->request();
        $assets = $model->newQuery();

        if ($request->asset) {
            $assets->whereIn('id', collect($request->asset)->pluck('id'));
        }

        return $assets;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $assetTypes = \App\Models\AssetType::all();

                    return $this->builder()
                    ->setTableId('assets-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ])
                    ->parameters([
                        'assetTypes' => $assetTypes,
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        $columns = [
            Column::make('id')->title(__('app.id')),
            Column::make('asset_image')->title(__('app.assetPicture'))->exportable(false)->printable(false),
            Column::make('asset_name')->title(__('app.assetName')),
            Column::make('lent_to')->title(__('app.lentTo')),
            Column::make('status')->title(__('app.status')),
            Column::make('created_at')->title(__('app.date')),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->searchable(false)
                ->addClass('text-right pr-20')
        ];

        return array_merge($columns, CustomFieldGroup::customFieldsDataMerge(new Asset()));
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Assets_' . date('YmdHis');
    }
}
