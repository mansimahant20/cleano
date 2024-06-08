<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\Reply;
use App\Http\Requests\Assets\AssetTypes;
use App\Models\AssetType;

class AssetTypeController extends AccountBaseController
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->assets = AssetType::all();
        return view('Assets.create_asset_types', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AssetTypes $request)
    {
        $assets = new AssetType();
        $assets->type_name = strip_tags($request->type_name);
        $assets->save();
        $assetsData = AssetType::all();
        return Reply::successWithData(__('messages.recordSaved'), ['data' => $assetsData]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $this->editPermission = user()->permission('manage_client_category');
        // abort_403 ($this->editPermission != 'all');

        $assets = AssetType::findOrFail($id);
        $assets->type_name = strip_tags($request->type_name);
        $assets->save();

        $assetData = AssetType::all();

        return Reply::successWithData(__('messages.updateSuccess'), ['data' => $assetData]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $this->deletePermission = user()->permission('manage_client_category');
        // abort_403 ($this->deletePermission != 'all');

        $assets = AssetType::findOrFail($id);
        $assets->delete();
        $assetData = AssetType::all();
        return Reply::successWithData(__('messages.deleteSuccess'), ['data' => $assetData]);
    }
}
