<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\ImportExcel;
use App\Helper\Reply;

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

    public function index()
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

        return view('assets.index', compact('pageTitle','pushSetting','pusherSettings','checkListCompleted',
        'checkListTotal','activeTimerCount','unreadNotificationCount','appTheme','appName','user','sidebarUserPermissions',
        'companyName','currentRouteName','unreadMessagesCount','worksuitePlugins','customLink'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->pageTitle = __('app.asset');
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
    public function store(Request $request)
    {
        //
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
