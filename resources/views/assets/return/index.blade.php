<div class="modal-header">
    <h5 class="modal-title" id="modelHeading">@lang('app.returnAsset')</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <div class="portlet-body">
        <form method="POST" id="returnForm" class="ajax-form" autocomplete="off">
            @csrf
            <input type="hidden" name="asset_id" value="{{ $asset->id }}">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-6">
                        <p class="simple-text">
                            @if($employees->isNotEmpty())
                                <ul>
                                    @foreach($employees as $employee)
                                        <li>
                                            <div style="display: flex; align-items: center;">
                                                <div style="margin-right: 10px;">
                                                    <img src="{{ asset($employee->image ? 'user-uploads/avatar/' . $employee->image : 'img/avatar.png') }}" alt="{{ $employee->name }}" class="taskEmployeeImg rounded-circle">
                                                </div>
                                                <div>
                                                    <div>{{ $employee->name }}</div>
                                                    <div>{{ $employee->designation }}</div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No employees found for this asset.</p>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label class="f-14 text-dark-grey mb-12" data-label="" for="asset_type_id">Date Given</label>
                        <p class="simple-text">
                            @if ($assetHistory->dateGiven)
                                {{ \Carbon\Carbon::parse($assetHistory->dateGiven)->format('j F Y g:i A') }}
                                ({{ \Carbon\Carbon::parse($assetHistory->dateGiven)->diffForHumans(['parts' => 1, 'join' => true]) }})
                            @else
                                Date not available
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label class="f-14 text-dark-grey mb-12" data-label="" for="asset_type_id">Estimated Date of Return</label>
                        <p class="simple-text">
                            @if ($assetHistory->estimatedDateOfReturn)
                                {{ \Carbon\Carbon::parse($assetHistory->estimatedDateOfReturn)->format('j F Y g:i A') }}
                                ({{ \Carbon\Carbon::parse($assetHistory->estimatedDateOfReturn)->diffForHumans(['parts' => 1, 'join' => true]) }})
                            @else
                                Date not available
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <x-forms.datepicker fieldId="dateOfReturn" fieldRequired="true"
                        :fieldLabel="__('modules.assets.dateOfReturn')" fieldName="dateOfReturn"
                        :fieldPlaceholder="__('placeholders.date')" />
                    </div>
                    <div class="col-md-12">
                        <x-forms.textarea class="mr-0 mr-lg-2 mr-md-2" :fieldLabel="__('modules.contracts.notes')" :fieldPlaceholder="__('placeholders.notes')"
                                          fieldName="notes" fieldId="notes">
                        </x-forms.textarea>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('app.close')</button>
    <button type="button" class="btn btn-primary" id="save-return">@lang('app.save')</button>
</div>

<script>
    $(document).ready(function () {
        $('.custom-date-picker').each(function(ind, el) {
            datepicker(el, {
                position: 'bl',
                ...datepickerConfig
            });
        });

        const dp1 = datepicker('#dateOfReturn', {
            position: 'bl',
            onSelect: (instance, date) => {
                dp2.setMin(date);
            },
            ...datepickerConfig
        });

        $('#save-return').click(function () {
            $.easyAjax({
                url: "{{ route('assets.returnStore') }}",
                container: '#returnForm',
                type: "POST",
                disableButton: true,
                blockUI: true,
                buttonSelector: "#save-return",
                data: $('#returnForm').serialize(),
                success: function(response) {
                    if (response.status == 'success') {
                        window.location.href = response.redirectUrl;
                    } else {
                        console.error(response);
                    }
                }
            });
        });
    });
</script>
