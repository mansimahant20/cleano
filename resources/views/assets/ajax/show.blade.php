{{-- @php
$editPermission = user()->permission('edit_product');
$deletePermission = user()->permission('delete_product');
@endphp --}}
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
                            {{-- @if (
                                ($editPermission == 'all' || ($editPermission == 'added' && $asset->added_by == user()->id))
                                || ($deletePermission == 'all' || ($deletePermission == 'added' && $asset->added_by == user()->id))
                                ) --}}
                                <div class="dropdown">
                                    <button
                                        class="btn btn-lg f-14 px-2 py-1 text-dark-grey text-capitalize rounded  dropdown-toggle"
                                        type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </button>

                                    <div class="dropdown-menu dropdown-menu-right border-grey rounded b-shadow-4 p-0"
                                        aria-labelledby="dropdownMenuLink" tabindex="0">
                                        {{-- @if ($editPermission == 'all' || ($editPermission == 'added' && $asset->added_by == user()->id))
                                            <a class="dropdown-item openRightModal"
                                                href="{{ route('products.edit', $asset->id) }}">@lang('app.edit')
                                            </a>
                                        @endif

                                        @if ($deletePermission == 'all' || ($deletePermission == 'added' && $asset->added_by == user()->id))
                                            <a class="dropdown-item delete-product"
                                                data-product-id="{{ $asset->id }}">@lang('app.delete')</a>
                                        @endif --}}
                                    </div>
                                </div>
                            {{-- @endif --}}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <x-cards.data-row :label="__('app.assetName')" :value="$asset->asset_name ?? '--'" />
                            <x-cards.data-row :label="__('app.assetType')" :value="$asset->asset_type_id ?? '--'" />
                            <x-cards.data-row :label="__('app.status')" :value="$asset->status ?? '--'" />
                            <x-cards.data-row :label="__('app.serialNumber')" :value="$asset->serial_number ?? '--'" />
                            <x-cards.data-row :label="__('app.value')" :value="$asset->value ?? '--'" />
                            <x-cards.data-row :label="__('app.location')" :value="$asset->location ?? '--'" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <script>
    $('body').on('click', '.delete-product', function() {
        var id = $(this).data('product-id');
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
                let url = "{{ route('products.destroy', ':id') }}";
                url = url.replace(':id', id);

                const token = "{{ csrf_token() }}";

                $.easyAjax({
                    type: 'POST',
                    url: url,
                    data: {
                        '_token': token,
                        '_method': 'DELETE'
                    },
                    success: function(response) {
                        if (response.status === "success") {
                            window.location.href = response.redirectUrl;
                        }
                    }
                });
            }
        });
    });

</script> --}}
