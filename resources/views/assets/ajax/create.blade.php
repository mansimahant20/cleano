{{-- @php
$addPermission = user()->permission('add_assets');
@endphp --}}

<link rel="stylesheet" href="{{ asset('vendor/css/dropzone.min.css') }}">

<div class="row">
    <div class="col-sm-12">
        <x-form id="save-assets-data-form">

            <div class="add-client bg-white rounded">
                <h4 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-bottom-grey">
                    @lang('modules.assets.assetInfo')</h4>

                <div class="row p-20">
                    <div class="col-lg-8 col-xl-9">
                        <div class="row">
                            <div class="col-md-6">
                                <x-forms.text fieldId="asset_name" :fieldLabel="__('modules.assets.assetName')" fieldName="asset_name"
                                    fieldRequired="true" :fieldPlaceholder="__('placeholders.asset.assetName')"
                                    :fieldValue="$asset->asset_name ?? ''"></x-forms.text>
                            </div>
                            <div class="col-md-6">
                                <x-forms.label class="mt-3" fieldId="category"
                                fieldRequired="true" :fieldLabel="__('modules.assets.assetType')">
                                </x-forms.label>
                                <x-forms.input-group>
                                    <select class="form-control select-picker" name="asset_type_id" id="asset_type_id"
                                        data-live-search="true">
                                        <option value="">--</option>
                                        @foreach ($assetTypes as $asset)
                                            <option value="{{ $asset->id }}">{{ $asset->type_name }}</option>
                                        @endforeach
                                    </select>
            
                                    {{-- {{-- @if ($addClientCategoryPermission == 'all') --}}
                                        <x-slot name="append">
                                            <button id="addAssetTypes" type="button"
                                                class="btn btn-outline-secondary border-grey"
                                                data-toggle="tooltip" data-original-title="{{ __('app.add').' '.__('modules.assets.assetType') }}">
                                                @lang('app.add')</button>
                                            </x-slot>
                                    {{-- @endif --}} 
                                </x-forms.input-group>
                            </div>
                            <div class="col-md-6">
                                <x-forms.text fieldId="serial_number" :fieldLabel="__('modules.assets.serialNumber')" fieldName="serial_number"
                                    fieldRequired="true" :fieldPlaceholder="__('placeholders.asset.serialNumber')"
                                    :fieldValue="$asset->serial_number ?? ''"></x-forms.text>
                            </div>
                            <div class="col-md-6">
                                <x-forms.text fieldId="name" :fieldLabel="__('modules.assets.assetValue')" fieldName="name"
                                    :fieldPlaceholder="__('placeholders.asset.assetValue')"
                                    :fieldValue="$asset->value ?? ''"></x-forms.text>
                            </div>
                            <div class="col-md-6">
                                <x-forms.text fieldId="name" :fieldLabel="__('modules.assets.assetLocation')" fieldName="name"
                                    :fieldPlaceholder="__('placeholders.asset.assetLocation')"
                                    :fieldValue="$asset->location ?? ''"></x-forms.text>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group my-3">
                                    <label class="f-14 text-dark-grey mb-12 w-100 mt-3" for="asset_status">@lang('modules.assets.assetStatus')</label>
                                    <div class="d-flex">
                                        @foreach(['available','non-functional','lost','damaged','under-maintenance'] as $status)
                                            <x-forms.radio fieldId="status-{{ $status }}" :fieldLabel="__(ucfirst($status))" fieldName="asset_status" fieldValue="{{ $status }}">
                                            </x-forms.radio>
                                        @endforeach
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <div class="col-lg-4 col-xl-3">
                        <x-forms.file allowedFileExtensions="png jpg jpeg svg bmp" class="mr-0 mr-lg-2 mr-md-2 cropper"
                            :fieldLabel="__('modules.assets.assetPicture')" fieldName="image" fieldId="image"
                             fieldHeight="119" :popover="__('messages.fileFormat.ImageFile')" />
                    </div>  
                    <div class="col-md-12">
                        <div class="form-group my-3">
                            <x-forms.textarea class="mr-0 mr-lg-2 mr-md-2"
                                :fieldLabel="__('modules.assets.description')" fieldName="description"
                                fieldId="description" :fieldPlaceholder="__('placeholders.asset.description')"
                                :fieldValue="$lead->address ?? ''">
                            </x-forms.textarea>
                        </div>
                    </div>
                </div>               

                <x-form-actions>
                    <x-forms.button-primary id="save-assets-form" class="mr-3" icon="check">@lang('app.save')
                    </x-forms.button-primary>
                    <x-forms.button-cancel :link="route('assets.index')" class="border-0">@lang('app.cancel')
                    </x-forms.button-cancel>
                </x-form-actions>
            </div>
        </x-form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#save-assets-form').click(function() {
            // if(add_client_note_permission == 'all' || add_client_note_permission == 'added' || add_client_note_permission == 'both')
            // {
            //     var note = document.getElementById('note').children[0].innerHTML;
            //     document.getElementById('note-text').value = note;
            // }

            const url = "{{ route('assets.store') }}";
            var data = $('#save-assets-data-form').serialize();

            saveAsset(data, url, "#save-assets-form");

        });

        function saveAsset(data, url, buttonSelector) {
            $.easyAjax({
                url: url,
                container: '#save-assets-data-form',
                type: "POST",
                disableButton: true,
                blockUI: true,
                buttonSelector: buttonSelector,
                file: true,
                data: data,
                success: function(response) {
                    if (response.status == 'success') {
                        if ($(MODAL_XL).hasClass('show')) {

                            $(MODAL_XL).modal('hide');
                            window.location.reload();
                        } else if(typeof response.redirectUrl !== 'undefined'){
                            window.location.href = response.redirectUrl;
                        }
                        else if(response.add_more == true) {

                            var right_modal_content = $.trim($(RIGHT_MODAL_CONTENT).html());
                            if(right_modal_content.length) {

                                $(RIGHT_MODAL_CONTENT).html(response.html.html);
                                $('#add_more').val(false);
                            }
                            else {

                                $('.content-wrapper').html(response.html.html);
                                init('.content-wrapper');
                                $('#add_more').val(false);
                            }
                        }

                        if (typeof showTable !== 'undefined' && typeof showTable === 'function') {
                            showTable();
                        }
                    }
                }
            });
        }
        init(RIGHT_MODAL);

        $('#addAssetTypes').click(function() {
        const url = "{{ route('assets-types.create') }}";
        $(MODAL_LG + ' ' + MODAL_HEADING).html('...');
        $.ajaxModal(MODAL_LG, url);
    })
    });
</script>


