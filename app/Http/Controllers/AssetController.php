<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\ImportExcel;
use App\Helper\Reply;
use App\Models\Asset;
use App\Models\AssetType;
use App\Http\Requests\Assets\AssetRequest;
use App\Helper\Files; 
use App\DataTables\AssetsDataTable;

class AssetController extends AccountBaseController
{
    use ImportExcel;

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.assets';
        $this->middleware(function ($request, $next) {
            abort_403(!in_array('assets', $this->user->modules));

            return $next($request);
        });
    }

    public function index(AssetsDataTable $dataTable)
    {
        $pageTitle = $this->pageTitle;
        $pushSetting = push_setting();
        $pusherSettings = pusher_settings();
        $checkListCompleted = $this->checkListCompleted;
        $checkListTotal = $this->checkListTotal;
        $activeTimerCount = $this->activeTimerCount;
        $unreadNotificationCount  = $this->unreadNotificationCount;
        $appTheme = $this->appTheme;
        $appName = $this->appName;
        $user = $this->user;
        $sidebarUserPermissions = $this->sidebarUserPermissions;
        $companyName = $this->companyName;
        $currentRouteName = $this->currentRouteName;
        $unreadMessagesCount = $this->unreadMessagesCount;
        $worksuitePlugins = $this->worksuitePlugins;
        $customLink = $this->customLink;
        $assetTypes = AssetType::all();

        return $dataTable->render('assets.index', compact(
            'pageTitle',
            'pushSetting',
            'pusherSettings',
            'checkListCompleted',
            'checkListTotal',
            'activeTimerCount',
            'unreadNotificationCount',
            'appTheme',
            'appName',
            'user',
            'sidebarUserPermissions',
            'companyName',
            'currentRouteName',
            'unreadMessagesCount',
            'worksuitePlugins',
            'customLink',
            'assetTypes'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->pageTitle = __('app.asset');
        $this->assetTypes = AssetType::all(); 
        
        $this->data = [
            'pageTitle' => $this->pageTitle,
            'assetTypes' => $this->assetTypes,
        ];

        if (request()->ajax()) {
            if (request('quick-form') == 1) {
                return view('clients.ajax.quick_create', $this->data);
            }

            $html = view('assets.ajax.create', $this->data)->render();

            return Reply::dataOnly(['status' => 'success', 'html' => $html, 'title' => $this->pageTitle]);
        }

        $this->view = 'assets.ajax.create';

        return view('assets.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AssetRequest $request)
    {
        try {
            $asset = new Asset();
            $asset->asset_name = $request->asset_name;  
            $asset->asset_type_id = $request->asset_type_id;
            $asset->serial_number = $request->serial_number;
            $asset->value = $request->value;
            $asset->location = $request->location;
            $asset->status = $request->asset_status;
            $asset->description = $request->description;

            if ($request->hasFile('asset_image')) {
                Files::deleteFile($asset->asset_image, 'avatar');
                $asset->asset_image = Files::uploadLocalOrS3($request->asset_image, 'avatar', 300);
            }

            $asset->save();

        } catch (\Exception $e) {
            logger($e->getMessage());
            return Reply::error('Some error occurred when inserting the data. Please try again or contact support '. $e->getMessage());
        }

        return Reply::successWithData(__('messages.recordSaved'), ['redirectUrl' => route('assets.index')]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
