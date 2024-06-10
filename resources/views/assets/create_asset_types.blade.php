<div class="modal-header">
    <h5 class="modal-title" id="modelHeading">@lang('modules.assets.assetType')</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <x-table class="table-bordered asset-type-table" headType="thead-light">
        <x-slot name="thead">
            <th>#</th>
            <th>@lang('modules.assets.name')</th>
            <th class="text-right">@lang('app.action')</th>
        </x-slot>
        
        @forelse($assets as $key=>$asset)
            <tr id="type-{{ $asset->id }}">
                <td>{{ $key + 1 }}</td>
                <td data-row-id="{{ $asset->id }}" contenteditable="true">{{ $asset->type_name }}</td>
                <td class="text-right">
                    {{-- Assuming there's a permission check here --}}
                    {{-- @if ($deletePermission == 'all' || $deletePermission == 'added') --}}
                    <x-forms.button-secondary data-asset-type-id="{{ $asset->id }}" icon="trash" class="delete-asset">
                        @lang('app.delete')
                    </x-forms.button-secondary>
                    {{-- @endif --}}
                </td>
            </tr>
        @empty
            <x-cards.no-record-found-list />
        @endforelse
    </x-table>

    <x-form id="createAssetType">
        <div class="row border-top-grey">
            <div class="col-sm-12">
                <x-forms.text fieldId="type_name" :fieldLabel="__('modules.assets.name')" fieldName="type_name" fieldRequired="true" :fieldPlaceholder="__('placeholders.asset.name')"></x-forms.text>
            </div>
        </div>
    </x-form>
</div>
<div class="modal-footer">
    <x-forms.button-cancel data-dismiss="modal" class="border-0">@lang('app.close')</x-forms.button-cancel>
    <x-forms.button-primary id="save-asset-type" icon="check">@lang('app.save')</x-forms.button-primary>
</div>

<script>
    $('.delete-asset').click(function() {
        var id = $(this).data('asset-type-id');
        var url = "{{ route('assets-types.destroy', ':id') }}".replace(':id', id);
        var token = "{{ csrf_token() }}";

        Swal.fire({
            title: "@lang('messages.sweetAlertTitle')",
            text: "@lang('messages.recoverRecord')",
            icon: 'warning',
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: "@lang('messages.confirmDelete')",
            cancelButtonText: "@lang('app.cancel')",
            customClass: {
                confirmButton: 'btn btn-primary mr-3',
                cancelButton: 'btn btn-secondary'
            },
            showClass: {
                popup: 'swal2-noanimation',
                backdrop: 'swal2-noanimation'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                $.easyAjax({
                    type: 'POST',
                    url: url,
                    data: {
                        '_token': token,
                        '_method': 'DELETE'
                    },
                    success: function(response) {
                        if (response.status == "success") {
                            $('#type-' + id).fadeOut();
                            // Handle additional actions if necessary
                        }
                    }
                });
            }
        });
    });

    $('#save-asset-type').click(function() {
        var url = "{{ route('assets-types.store') }}";
        $.easyAjax({
            url: url,
            container: '#createAssetType',
            type: "POST",
            data: $('#createAssetType').serialize(),
            success: function(response) {
                if (response.status == 'success') {
                    // Refresh category options
                    var options = [];
                    $.each(response.data, function(index, value) {
                        options.push('<option value="' + value.id + '">' + value.type_name + '</option>');
                    });

                    $('#asset_type_id').html('<option value="">--</option>' + options).selectpicker('refresh');
                    $(MODAL_LG).modal('hide');
                }
            }
        });
    });

    $('.asset-type-table [contenteditable=true]').focus(function() {
        $(this).data("initialText", $(this).html());
    }).blur(function() {
        if ($(this).data("initialText") !== $(this).html()) {
            var id = $(this).data('row-id');
            var value = $(this).html();
            var url = "{{ route('assets-types.update', ':id') }}".replace(':id', id);
            var token = "{{ csrf_token() }}";

            $.easyAjax({
                url: url,
                container: '#type-' + id,
                type: "POST",
                data: {
                    'type_name': value,
                    '_token': token,
                    '_method': 'PUT'
                },
                blockUI: true,
                success: function(response) {
                    if (response.status == 'success') {
                        // Refresh category options
                        var options = [];
                        $.each(response.data, function(index, value) {
                            options.push('<option value="' + value.id + '">' + value.type_name + '</option>');
                        });

                        $('#asset_type_id').html('<option value="">--</option>' + options).selectpicker('refresh');
                    }
                }
            });
        }
    });
</script>
