<div id="product-detail-section">
    <div class="row">
        <div class="col-sm-12">
            <div class="card bg-white border-0 b-shadow-4">
                <div class="card-header bg-white  border-bottom-grey text-capitalize justify-content-between p-20">
                    <div class="row">
                        <div class="col-lg-10 col-10">
                            <h3 class="heading-h1 mb-3">@lang('modules.assets.assetDetail')</h3>
                        </div>
                        <div class="col-lg-2 col-2 text-right">
                                <div class="dropdown">
                                    <button
                                        class="btn btn-lg f-14 px-2 py-1 text-dark-grey text-capitalize rounded  dropdown-toggle"
                                        type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </button>

                                    <div class="dropdown-menu dropdown-menu-right border-grey rounded b-shadow-4 p-0"
                                        aria-labelledby="dropdownMenuLink" tabindex="0">
                                            <a class="dropdown-item openRightModal"
                                                href="{{ route('assets.edit', $asset->id) }}">@lang('app.edit')
                                            </a>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @php
                        if ($asset->status == 'available') {
                            $class = 'text-light-green';
                            $status = __('app.available');
                        } elseif ($asset->status == 'non-functional') {
                            $class = 'text-red';
                            $status = __('app.nonFunctional');
                        } elseif ($asset->status == 'lost') {
                            $class = 'text-yellow';
                            $status = __('app.lost');
                        } elseif ($asset->status == 'damaged') {
                            $class = 'text-pink';
                            $status = __('app.damaged');
                        } elseif ($asset->status == 'under-maintenance') {
                            $class = 'text-orange';
                            $status = __('app.underMaintenance');
                        } elseif ($asset->status == 'lent') {
                            $class = 'text-yellow';
                            $status = __('app.lent');
                        }
                        $assetStatus = '<i class="fa fa-circle mr-1 ' . $class . ' f-10"></i> ' . $status;
                    @endphp
                    <div class="row">
                        <div class="col-12">
                            <x-cards.data-row :label="__('app.assetName')" :value="$asset->asset_name ?? '--'" />
                            <x-cards.data-row :label="__('app.assetType')"  :value="$assetType->type_name ?? '--'" />
                            <x-cards.data-row :label="__('app.status')" :value="$assetStatus ?? '--'" />
                            <x-cards.data-row :label="__('app.serialNumber')" :value="$asset->serial_number ?? '--'" />
                            <x-cards.data-row :label="__('app.value')" :value="$asset->value ?? '--'" />
                            <x-cards.data-row :label="__('app.location')" :value="$asset->location ?? '--'" />
                        </div>
                    </div>
                </div>

                <div class="card-header bg-white  border-bottom-grey text-capitalize justify-content-between p-20">
                    <div class="row">
                        <div class="col-lg-10 col-10">
                            <h3 class="heading-h1 mb-3">@lang('modules.assets.assetHistory')</h3>
                        </div>
                        {{-- <div class="col-lg-2 col-2 text-right">
                                <div class="dropdown">
                                    <button
                                        class="btn btn-lg f-14 px-2 py-1 text-dark-grey text-capitalize rounded  dropdown-toggle"
                                        type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </button>

                                    <div class="dropdown-menu dropdown-menu-right border-grey rounded b-shadow-4 p-0"
                                        aria-labelledby="dropdownMenuLink" tabindex="0">
                                            <a class="dropdown-item openRightModal"
                                                href="{{ route('assets.edit', $asset->id) }}">@lang('app.edit')
                                            </a>
                                    </div>
                                </div>
                        </div> --}}
                    </div>
                </div>
                @php
                function formatDateWithRelativeTime($date) {
                    if (!$date) {
                        return '--';
                    }

                    $formattedDate = \Carbon\Carbon::parse($date)->format('d M Y H:i A');
                    $relativeTime = \Carbon\Carbon::parse($date)->diffForHumans();

                    return "$formattedDate ($relativeTime)";
                }
                @endphp
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            @foreach ($assetHistories as $history)
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <strong>{{ __('app.lentTo') }}</strong>
                            </div>
                            <div class="col-md-9">
                                <div class="d-flex align-items-start">
                                    <div class="employee-image mr-3">
                                        <img src="{{ asset($history->employee_image ? 'user-uploads/avatar/' . $history->employee_image : 'img/avatar.png') }}" alt="{{ $history->employee_name ?? '--' }}" class="rounded-circle" style="width: 50px; height: 50px;">
                                    </div>
                                    <div class="employee-details">
                                        <div class="employee-name font-weight-bold">
                                            {{ $history->employee_name ?? '--' }}
                                        </div>
                                        <div class="employee-designation text-muted">
                                            {{ $history->designation ?? '--' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <x-cards.data-row :label="__('app.dateGiven')" :value="formatDateWithRelativeTime($history->dateGiven ?? null)" />
                        <x-cards.data-row :label="__('app.estimatedDateOfReturn')" :value="formatDateWithRelativeTime($history->estimatedDateOfReturn ?? null)" />
                        <x-cards.data-row :label="__('app.dateOfReturn')" :value="formatDateWithRelativeTime($history->dateOfReturn ?? null)" />
                        <x-cards.data-row :label="__('app.returnedBy')" :value="$history->returned_by_name ?? '--'" />
                        <x-cards.data-row :label="__('app.notes')" :value="$history->notes ?? '--'" />

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <strong>{{ __('app.returnedBy') }}</strong>
                            </div>
                            <div class="col-md-9">
                                <div class="d-flex align-items-start">
                                    <div class="employee-image mr-3">
                                        <img src="{{ asset($history->returned_by_image ? 'user-uploads/avatar/' . $history->returned_by_image : 'img/avatar.png') }}" alt="{{ $history->returned_by_name ?? '--' }}" class="rounded-circle" style="width: 50px; height: 50px;">
                                    </div>
                                    <div class="employee-details">
                                        <div class="employee-name font-weight-bold">
                                            {{ $history->returned_by_name ?? '--' }}
                                        </div>
                                        <div class="employee-designation text-muted">
                                            {{ $history->returned_by_designation ?? '--' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
