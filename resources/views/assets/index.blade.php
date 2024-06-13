@extends('layouts.app')

@push('datatable-styles')
    @include('sections.datatable_css')
@endpush

@section('filter-section')

    <x-filters.filter-box>

        <!-- ASSET TYPE START -->
        <div class="select-box d-flex py-2 px-lg-2 px-md-2 px-0 border-right-grey border-right-grey-sm-0">
            <p class="mb-0 pr-2 f-14 text-dark-grey d-flex align-items-center">@lang('app.assets.assetType')</p>
            <div class="select-status">
                <select class="form-control select-picker" name="assets" id="assets" data-live-search="true" data-size="8">
                    <option value="all">@lang('app.all')</option>
                    @foreach ($assetTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->type_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- CLIENT END -->

        <!-- Employees START -->
        <div class="select-box d-flex py-2 px-lg-2 px-md-2 px-0 border-right-grey border-right-grey-sm-0">
            <p class="mb-0 pr-2 f-14 text-dark-grey d-flex align-items-center">@lang('app.employees')</p>
            <div class="select-status">
                <select class="form-control select-picker" name="employee" id="employee" data-live-search="true" data-size="8">
                    <option value="all">@lang('app.all')</option>
                    @foreach ($employees as $employees)
                        <x-user-option :user="$employees" />
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Status START -->
        <div class="select-box d-flex py-2 px-lg-2 px-md-2 px-0 border-right-grey border-right-grey-sm-0">
            <p class="mb-0 pr-2 f-14 text-dark-grey d-flex align-items-center">@lang('app.status')</p>
            <div class="select-status">
                <select class="form-control select-picker" name="status" id="status" data-live-search="true" data-size="8">
                    <option value="all">@lang('app.all')</option>
                    @foreach (['lent', 'available', 'non-functional', 'lost', 'damaged', 'under-maintenance'] as $status)
                        <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- CLIENT END -->

        <!-- SEARCH BY TASK START -->
        <div class="task-search d-flex  py-1 px-lg-3 px-0 border-right-grey align-items-center">
            <form class="w-100 mr-1 mr-lg-0 mr-md-1 ml-md-1 ml-0 ml-lg-0">
                <div class="input-group bg-grey rounded">
                    <div class="input-group-prepend">
                        <span class="input-group-text border-0 bg-additional-grey">
                            <i class="fa fa-search f-13 text-dark-grey"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control f-14 p-1 border-additional-grey" id="search-text-field"
                        placeholder="@lang('app.startTyping')">
                </div>
            </form>
        </div>
        <!-- SEARCH BY TASK END -->

        <!-- RESET START -->
        <div class="select-box d-flex py-1 px-lg-2 px-md-2 px-0">
            <x-forms.button-secondary class="btn-xs d-none" id="reset-filters" icon="times-circle">
                @lang('app.clearFilters')
            </x-forms.button-secondary>
        </div>
        <!-- RESET END -->

    </x-filters.filter-box>
@endsection

@section('content')

    <!-- CONTENT WRAPPER START -->
    <div class="content-wrapper">
        <!-- Add Task Export Buttons Start -->
        <div class="d-grid d-lg-flex d-md-flex action-bar">

            <div id="table-actions" class="flex-grow-1 align-items-center">
                {{-- @if ($addClientPermission == 'all' || $addClientPermission == 'added' || $addClientPermission == 'both') --}}
                    <x-forms.link-primary :link="route('assets.create')" class="mr-3 openRightModal float-left mb-2 mb-lg-0 mb-md-0" icon="plus">
                        @lang('app.assets.addAsset')
                    </x-forms.link-primary>
                {{-- @endif --}}

                {{-- @if ($addClientPermission == 'all' || $addClientPermission == 'added' || $addClientPermission == 'both') --}}
                    {{-- <x-forms.link-secondary :link="route('assets.export')" class="mr-3 float-left mb-2 mb-lg-0 mb-md-0 d-sm-bloc d-none d-lg-block" icon="file-upload"> --}}
                        {{-- @lang('app.assets.exportExcel') --}}
                    {{-- </x-forms.link-secondary> --}}
                {{-- @endif  --}}
            </div>

            <x-datatable.actions>
                <div class="select-status mr-3">
                    <select name="action_type" class="form-control select-picker" id="quick-action-type" disabled>
                        <option value="">@lang('app.selectAction')</option>
                        <option value="change-status">@lang('modules.tasks.changeStatus')</option>
                        <option value="delete">@lang('app.delete')</option>
                    </select>
                </div>
            </x-datatable.actions>
        </div>
        <!-- Add Task Export Buttons End -->

        <!-- Task Box Start -->
        <div class="d-flex flex-column w-tables rounded mt-3 bg-white table-responsive">
            {!! $dataTable->table(['class' => 'table table-hover border-0 w-100']) !!}
        </div>
        <!-- Task Box End -->
    </div>
    <!-- CONTENT WRAPPER END -->

@endsection

@push('scripts')
@include('sections.datatable_js')
<script>
    $(document).ready(function() {
    var table = $('#assets-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('assets.index') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'asset_image', name: 'asset_image' }, 
            { data: 'asset_name', name: 'asset_name' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        error: function (xhr, err, opt) {
            console.log('Request Failed: ' + xhr.statusText, err, opt);
        }
    });

    $('#assets-table').on('click', '.delete-table-row', function() {
        var id = $(this).data('asset-id');
        var url = "{{ route('assets.destroy', ':id') }}";
        url = url.replace(':id', id);
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
                            table.ajax.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message || 'An error occurred while deleting the asset.',
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'An error occurred while deleting the asset.',
                        });
                    }
                });
            }
        });
    });
});

    $('#employee, #status, #assets, #gender, #skill, #designation, #department').on('change keyup',
        function () {
            if ($('#status').val() != "all") {
                $('#reset-filters').removeClass('d-none');
            } else if ($('#employee').val() != "all") {
                $('#reset-filters').removeClass('d-none');
            } else if ($('#assets').val() != "all") {
                $('#reset-filters').removeClass('d-none');
            } else if ($('#gender').val() != "all") {
                $('#reset-filters').removeClass('d-none');
            } else if ($('#designation').val() != "all") {
                $('#reset-filters').removeClass('d-none');
            } else if ($('#department').val() != "all") {
                $('#reset-filters').removeClass('d-none');
            } else {
                $('#reset-filters').addClass('d-none');
            }
            showTable();
    });

    $('#search-text-field').on('keyup', function () {
        if ($('#search-text-field').val() != "") {
            $('#reset-filters').removeClass('d-none');
            showTable();
        }
    });

    $('#reset-filters, #reset-filters-2').click(function () {
        $('#filter-form')[0].reset();
        $('.filter-box .select-picker').selectpicker("refresh");
        $('#reset-filters').addClass('d-none');
        showTable();
    });

    $('body').on('click', '.assets-action-lend', function() {
        let assetId = $(this).data('asset-id');
        let url = "{{ route('assets.lend-modal') }}";
        let searchQuery = "?id=" + assetId;
        
        $(MODAL_LG + ' ' + MODAL_HEADING).html('@lang("app.lendAsset")');
        $.ajaxModal(MODAL_LG, url + searchQuery);
    });
</script>
@endpush
