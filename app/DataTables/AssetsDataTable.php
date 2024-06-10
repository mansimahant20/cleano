<?php

namespace App\DataTables;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\Models\CustomFieldGroup;

class AssetsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'assets.action')
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Asset $model): QueryBuilder
    {
        $request = $this->request();
        $assets = $model->withoutGlobalScope(ActiveScope::class)->with('session', 'clientDetails', 'clientDetails.addedBy')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->leftJoin('client_details', 'users.id', '=', 'client_details.user_id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select('users.id', 'users.salutation', 'users.name', 'client_details.company_name', 'users.email', 'users.mobile', 'users.image', 'users.created_at', 'users.status', 'client_details.added_by', 'users.admin_approval')
            ->where('roles.name', 'client');

        if ($request->status != 'all' && $request->status != '') {
            $assets = $assets->where('users.status', $request->status);
        }

        if ($request->client != 'all' && $request->client != '') {
            $assets = $assets->where('users.id', $request->client);
        }

        // if ($request->searchText != '') {
        //     $assets = $assets->where(function ($query) {
        //         $query->where('users.name', 'like', '%' . request('searchText') . '%')
        //             ->orWhere('users.email', 'like', '%' . request('searchText') . '%')
        //             ->orWhere('client_details.company_name', 'like', '%' . request('searchText') . '%');
        //     });
        // }

        return $assets;;
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
        $data = [
            __('app.id') => ['data' => 'id', 'name' => 'id', 'title' => __('app.id'), 'visible' => showId()],
            __('app.assetPicture') => ['data' => 'asset_image', 'name' => 'asset_image', 'exportable' => false, 'title' => __('app.assetPicture')],
            __('app.assetName') => ['data' => 'asset_name', 'name' => 'asset_name', 'exportable' => false, 'title' => __('app.assetName')],
            __('app.lentTo') => ['data' => 'client_name', 'name' => 'users.name', 'visible' => false, 'title' => __('app.lentTo')],
            __('app.date') => ['data' => 'email', 'name' => 'email', 'title' => __('app.date')],
            __('app.status') => ['data' => 'status', 'name' => 'status', 'title' => __('app.status')],
        ];

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
