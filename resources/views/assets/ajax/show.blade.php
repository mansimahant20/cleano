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
