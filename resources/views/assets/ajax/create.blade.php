{{-- @php
$addPermission = user()->permission('add_assets');
@endphp --}}

<link rel="stylesheet" href="{{ asset('vendor/css/dropzone.min.css') }}">

<div class="row">
    <div class="col-sm-12">
        <x-form id="save-client-data-form">

            <div class="add-client bg-white rounded">
                <h4 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-bottom-grey">
                    @lang('modules.assets.assetInfo')</h4>

                {{-- @if (isset($lead->id)) <input type="hidden" name="lead"
                        value="{{ $lead->id }}"> @endif --}}

                <div class="row p-20">
                    <div class="col-lg-8 col-xl-9">
                        <div class="row">
                            <div class="col-md-6">
                                <x-forms.text fieldId="name" :fieldLabel="__('modules.assets.assetName')" fieldName="name"
                                    fieldRequired="true" :fieldPlaceholder="__('placeholders.asset.assetName')"
                                    :fieldValue="$asset->asset_name ?? ''"></x-forms.text>
                            </div>
                            <div class="col-md-6">
                                <x-forms.label class="mt-3" fieldId="category"
                                    :fieldLabel="__('modules.assets.assetType')">
                                </x-forms.label>
                                <x-forms.input-group>
                                    <select class="form-control select-picker" name="category_id" id="category_id"
                                        data-live-search="true">
                                        <option value="">--</option>
                                        {{-- @foreach ($categories as $category)
                                            <option @if (isset($lead) && $lead->category_id == $category->id) selected @endif value="{{ $category->id }}">
                                            {{ $category->category_name }}</option>
                                        @endforeach --}}
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
                                <x-forms.text fieldId="name" :fieldLabel="__('modules.assets.serialNumber')" fieldName="number"
                                    fieldRequired="true" :fieldPlaceholder="__('placeholders.asset.serialNumber')"
                                    :fieldValue="$asset->serial_number ?? ''"></x-forms.text>
                            </div>
                            <div class="col-md-6">
                                <x-forms.text fieldId="name" :fieldLabel="__('modules.assets.assetValue')" fieldName="name"
                                    :fieldPlaceholder="__('placeholders.asset.assetValue')"
                                    :fieldValue="$asset->asset_name ?? ''"></x-forms.text>
                            </div>
                            <div class="col-md-6">
                                <x-forms.text fieldId="name" :fieldLabel="__('modules.assets.assetLocation')" fieldName="name"
                                    :fieldPlaceholder="__('placeholders.asset.assetLocation')"
                                    :fieldValue="$asset->asset_name ?? ''"></x-forms.text>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group my-3">
                                    <label class="f-14 text-dark-grey mb-12 w-100 mt-3"
                                        for="usr">@lang('modules.assets.assetStatus')</label>
                                    <div class="d-flex">
                                        <x-forms.radio fieldId="login-yes" :fieldLabel="__('app.yes')" fieldName="login"
                                            fieldValue="enable">
                                        </x-forms.radio>
                                        <x-forms.radio fieldId="login-no" :fieldLabel="__('app.no')" fieldValue="disable"
                                            fieldName="login" checked="true"></x-forms.radio>
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
                {{-- @includeIf('einvoice::form.client-create') --}}
                <input type ="hidden" name="add_more" value="false" id="add_more" />

                {{-- <x-forms.custom-field :fields="$fields"></x-forms.custom-field> --}}

                <x-form-actions>
                    <x-forms.button-primary id="save-client-form" class="mr-3" icon="check">@lang('app.save')
                    </x-forms.button-primary>
                    <x-forms.button-cancel :link="route('clients.index')" class="border-0">@lang('app.cancel')
                    </x-forms.button-cancel>
                </x-form-actions>
            </div>
        </x-form>
    </div>
</div>

<script>
   $('#addAssetTypes').click(function() {
        const url = "{{ route('assets-types.create') }}";
        $(MODAL_LG + ' ' + MODAL_HEADING).html('...');
        $.ajaxModal(MODAL_LG, url);
    })
</script>


