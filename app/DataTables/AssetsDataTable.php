<?php

namespace App\DataTables;

use App\Models\Asset;
use App\Models\AssetHistory;
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
            } elseif ($row->status == 'lent') {
                $action .= '<a class="dropdown-item assets-action-return" data-asset-id="' . $row->id . '" 
                                href="javascript:void(0);">
                                <i class="fa fa-undo mr-2"></i>
                                ' . trans('app.return') . '
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
            } elseif ($row->status == 'lent') {
                return '<i class="fa fa-circle mr-1 text-yellow f-15"></i>' . __('app.lent');
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

        $datatables->editColumn('lentTo', function ($row) {
            if ($row->status === 'lent' && $row->name) {
                $name = $row->name;
                $designation = $row->designation_name ?? '-';
                $userImage = $row->image ? asset('user-uploads/avatar/' . $row->image) : asset('img/avatar.png');
        
                $imageHeight = '35px'; 
                $imageWidth = '35px';
        
                return "<div class='user-info d-flex align-items-center'>
                            <img src='{$userImage}' class='user-image taskEmployeeImg rounded-circle mr-2' height='{$imageHeight}' width='{$imageWidth}'>
                            <div class='user-details'>
                                <span class='user-name font-weight-medium'>{$name}</span><br>
                                <span class='user-designation text-muted'>{$designation}</span>
                            </div>
                        </div>";
            } else {
                return '-';
            }
        });
        
        $datatables->editColumn('date', function ($row) {
            if ($row->status === 'lent') {
                $dateGiven = $row->dateGiven ? date('d-m-Y', strtotime($row->dateGiven)) : '';
                $estimatedDateOfReturn = $row->estimatedDateOfReturn ? date('d-m-Y', strtotime($row->estimatedDateOfReturn)) : '';
        
                return ($dateGiven ? 'Given Date: ' . $dateGiven : '') . '<br>' . ($estimatedDateOfReturn ? 'Estimated Return: ' . $estimatedDateOfReturn : '');
            } else {
                return '-';
            }
        });
        
        $datatables->addIndexColumn();
        $datatables->smart(false);
        $datatables->setRowId(function ($row) {
            return 'row-' . $row->id;
        });

        $datatables->rawColumns(['action', 'status', 'asset_image', 'date', 'lentTo']);

        return $datatables;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Asset $model): QueryBuilder
    {
        $request = $this->request();
        $assets = $model->newQuery();
    
        $assets = $assets->join('asset_types', 'assets.asset_type_id', '=', 'asset_types.id')
                 ->leftJoin('asset_histories', function ($join) {
                     $join->on('assets.id', '=', 'asset_histories.asset_id')
                          ->whereNull('asset_histories.dateOfReturn');
                 })
                 ->leftJoin('users', 'asset_histories.lentTo', '=', 'users.id') 
                 ->leftJoin('employee_details', 'employee_details.user_id', '=', 'users.id')
                 ->leftJoin('designations', 'employee_details.designation_id', '=', 'designations.id')
                 ->select('assets.*', 
                          'asset_types.type_name', 
                          'asset_histories.dateGiven as dateGiven', 
                          'asset_histories.estimatedDateOfReturn as estimatedDateOfReturn', 
                          'users.name as name',
                          'designations.name as designation_name',
                          'users.image as image');
    
        if ($request->status != 'all' && $request->status != '') {
            $assets = $assets->where('assets.status', $request->status);
        }
    
        if ($request->employee != 'all' && $request->employee != '') {
            $assets = $assets->where('asset_histories.lentTo', $request->employee);
        }
    
        if ($request->asset_type_id != 'all' && $request->asset_type_id != '') {
            $assets = $assets->where('assets.asset_type_id', $request->asset_type_id);
        }
    
        if ($request->searchText != '') {
            $assets = $assets->where(function ($query) use ($request) {
                $query->where('assets.asset_name', 'like', '%' . $request->searchText . '%')
                    ->orWhere('asset_types.type_name', 'like', '%' . $request->searchText . '%');
            });
        }
    
        return $assets;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $assetTypes = \App\Models\AssetType::all();

        \Log::info('DataTable HTML Configuration: ', [
            'tableId' => 'assets-table',
            'columns' => $this->getColumns(),
            'minifiedAjax' => true,
            'orderBy' => 1,
            'selectStyleSingle' => true,
            'buttons' => [
                Button::make('create'),
                Button::make('export'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ],
            'parameters' => [
                'assetTypes' => $assetTypes,
            ],
        ]);

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

     protected function getColumns()
     {
        $data = [
            '#' => ['data' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false, 'visible' => !showId(), 'title' => '#'],
            __('app.id') => ['data' => 'id', 'name' => 'id', 'title' => __('app.id'), 'visible' => showId()],
            __('app.assetPicture') => ['data' => 'asset_image', 'name' => 'asset_image', 'exportable' => false, 'title' => __('app.assetPicture')],
            __('app.assetName') => ['data' => 'asset_name', 'name' => 'asset_name', 'title' => __('app.assetName')],
            __('app.lentTo') => ['data' => 'lentTo', 'name' => 'lentTo', 'title' => __('app.lentTo')],
            __('app.status') => ['data' => 'status', 'name' => 'status', 'title' => __('app.status')],
            __('app.date') => ['data' => 'date', 'name' => 'date', 'title' => __('app.date')]
        ];
     
         \Log::info('Columns for DataTable: ', $data);
     
         $action = [
             Column::computed('action', __('app.action'))
                 ->exportable(false)
                 ->printable(false)
                 ->orderable(false)
                 ->searchable(false)
                 ->addClass('text-right pr-20')
         ];
     
         return array_merge($data, CustomFieldGroup::customFieldsDataMerge(new Asset()), $action);
     }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Assets_' . date('YmdHis');
    }
}