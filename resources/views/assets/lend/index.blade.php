<div class="modal-header">
    <h5 class="modal-title" id="modelHeading">@lang('app.lendAsset')</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <div class="portlet-body">
        <!-- Add form elements for lending an asset -->
        <x-form id="lendForm" method="POST" class="ajax-form">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group my-3">
                            <h1>hello</h1>
                        </div>
                    </div>
                </div>
            </div>
        </x-form>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('app.close')</button>
    <button type="button" class="btn btn-primary" id="save-lend">@lang('app.save')</button>
</div>
