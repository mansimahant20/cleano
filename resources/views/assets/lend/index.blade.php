<div class="modal-header">
    <h5 class="modal-title" id="modelHeading">@lang('app.lendAsset')</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <div class="portlet-body">
        <form method="POST" id="lendForm" class="ajax-form" autocomplete="off">
            @csrf
            <input type="hidden" name="asset_id" value="{{ $asset->id }}">
            <div class="form-body">
                <div class="row">
                    <div class="col-lg-4">
                        <x-forms.select fieldId="lentTo" :fieldLabel="__('app.employee')"
                            fieldName="lentTo" search="true" fieldRequired="true">
                            <option value="">--</option>
                            @foreach ($employees as $employee)
                                <x-user-option :user="$employee" :selected="($employee->id == old('lentTo'))"/>
                            @endforeach
                        </x-forms.select>    
                    </div>
                    <div class="col-md-4">
                        <x-forms.datepicker fieldId="dateGiven" fieldRequired="true"
                        :fieldLabel="__('modules.assets.dateGiven')" fieldName="dateGiven"
                        :fieldPlaceholder="__('placeholders.date')" />
                    </div>
                    <div class="col-md-4">
                        <x-forms.datepicker fieldId="estimatedDateOfReturn"
                        :fieldLabel="__('modules.assets.estimatedDateOfReturn')" fieldName="estimatedDateOfReturn"
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
    <button type="button" class="btn btn-primary" id="save-lend">@lang('app.save')</button>
</div>

<script>
    $(document).ready(function () {
        $('.custom-date-picker').each(function(ind, el) {
            datepicker(el, {
                position: 'bl',
                ...datepickerConfig
            });
        });

        const dp1 = datepicker('#dateGiven', {
            position: 'bl',
            onSelect: (instance, date) => {
                dp2.setMin(date);
            },
            ...datepickerConfig
        });

        const dp2 = datepicker('#estimatedDateOfReturn', {
            position: 'bl',
            onSelect: (instance, date) => {
                dp1.setMax(date);
            },
            ...datepickerConfig
        });

        $('#save-lend').click(function () {
            $.easyAjax({
                url: "{{ route('assets.lentStore') }}",
                container: '#lendForm',
                type: "POST",
                disableButton: true,
                blockUI: true,
                buttonSelector: "#save-lend",
                data: $('#lendForm').serialize(),
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
