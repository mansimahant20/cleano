<div class="modal-header">
    <h5 class="modal-title" id="modelHeading">@lang('app.lendAsset')</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <div class="portlet-body">
        <form method="POST" id="lenfForm" class="ajax-form" autocomplete="off">
            <div class="form-body">
                <div class="row">
                    <div class="col-lg-4">
                        <label class="f-14 text-dark-grey mb-12 mt-3" data-label="true" for="employee_id">Employee<sup class="f-14 mr-1">*</sup></label>
                        <div class="form-group mb-0" data-live-search="true" data-size="8">
                            <div class="dropdown bootstrap-select form-control select-picker"><select name="employee_id"
                                    id="employee_id" data-live-search="true" class="form-control select-picker"
                                    data-size="8" tabindex="null">
                                    <option data-content="<span class='badge badge-pill badge-light border abc'><div class='d-flex align-items-center text-left'>
                                        <div class='taskEmployeeImg border-0 d-inline-block mr-1'>
                                            <img class='rounded-circle' src='https://i.pravatar.cc/300?u=bahol@mailinator.com'>
                                        </div>
                                        <div>Cassidy Byrd</div></span>" value="27">
                                        Cassidy Byrd
                                    </option>
                                </select><button type="button" tabindex="-1" class="btn dropdown-toggle btn-light"
                                    data-toggle="dropdown" role="combobox" aria-owns="bs-select-5" aria-haspopup="listbox"
                                    aria-expanded="false" data-id="employee_id" title="Cassidy Byrd">
                                    <div class="filter-option">
                                        <div class="filter-option-inner">
                                            <div class="filter-option-inner-inner"><span
                                                    class="badge badge-pill badge-light border abc">
                                                    <div class="d-flex align-items-center text-left">
                                                        <div class="taskEmployeeImg border-0 d-inline-block mr-1">
                                                            <img class="rounded-circle"
                                                                src="https://i.pravatar.cc/300?u=bahol@mailinator.com">
                                                        </div>
                                                        <div>Cassidy Byrd</div>
                                                    </div>
                                                </span></div>
                                        </div>
                                    </div>
                                </button>
                                <div class="dropdown-menu ">
                                    <div class="bs-searchbox"><input type="search" class="form-control" autocomplete="off"
                                            role="combobox" aria-label="Search" aria-controls="bs-select-5"
                                            aria-autocomplete="list"></div>
                                    <div class="inner show" role="listbox" id="bs-select-5" tabindex="-1">
                                        <ul class="dropdown-menu inner show" role="presentation"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group my-3" style="position: relative;">
                            <label class="f-14 text-dark-grey mb-12" data-label="true" for="date_given">Date Given
                                <sup class="f-14 mr-1">*</sup>
                            </label>
                            <input type="text" class="form-control  date-picker height-35 f-14" placeholder="Select Date"
                                value="" name="date_given" id="date_given">
                            
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group my-3" style="position: relative;">
                            <label class="f-14 text-dark-grey mb-12" data-label="" for="return_date">Estimated Date of
                                Return
    
                            </label>
    
                            <input type="text" class="form-control  date-picker height-35 f-14" placeholder="Select Date"
                                value="" name="return_date" id="return_date">
    
                           
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group my-3">
                            <div class="form-group my-3 mr-0 mr-lg-2 mr-md-2">
                                <label class="f-14 text-dark-grey mb-12" data-label="" for="notes">Notes
    
                                </label>
    
                                <textarea class="form-control f-14 pt-2" rows="3" placeholder="Notes" name="notes"
                                    id="notes" data-gramm="false" wt-ignore-input="true"></textarea>
                            </div>
                        </div>
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
