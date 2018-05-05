@extends('layouts.app')
@section('title', 'Add Cropping Page')
@section('content')
<header class="content__title">
    <h1>Add Cropping Page</h1>
</header>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-block">
                <div class="row">
                    <div class="col-sm-6">
                        <label class="form-control-label" for="lot_number">Search Lot</label>
                        <div class="input-group mb-3">
                            <select id="lot_number" name="lot_number" style="width: 100%">
                                <option></option>
                            </select>
                            <div class="input-group-prepend" style="padding-left: 10px">
                                <button id="cropping-search" name="cropping-search" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="map" style="width: 100%; height: 600px; border: 1px solid #ccc; z-index: 0"></div>
            </div>  
        </div>
    </div>
</div>
<div id="modal-cropping" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="modal-cropping" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="lot_title" class="modal-title pull-left"></h5>
            </div>
            <hr class="hr">
            <div class="modal-body" style="padding: 5px 30px;">
                <div class="row">
                    <div class="col-sm-6 text-center">
                        Municipality <span id="municipality" class="badge badge-pill badge-success"></span>
                    </div>
                    <div class="col-sm-6 text-center">
                        Barangay <span id="barangay" class="badge badge-pill badge-success"></span>
                    </div>
                    <hr>
                    <div class="col-sm-6 text-center">
                        Watering Type <span id="watering_type" class="badge badge-pill badge-info"></span>
                    </div>
                    <div class="col-sm-6 text-center">
                        Soil Type <span id="soil_type" class="badge badge-pill badge-info"></span>
                    </div>
                </div>
                <ul class="nav nav-tabs nav-fill" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#add_cropping" role="tab">Add New Cropping</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#list_cropping" role="tab">Cropping List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#list_harvest" role="tab">Harvest List</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active fade show" id="add_cropping" role="tabpanel">
                        <form id="form-cropping">
                            <h3 class="card-block__title">Cropping Information</h3>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="crop_id">Crop</label>
                                        <select name="crop_id" id="crop_id" style="width: 100%" required>
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                     <div class="form-group">
                                        <label class="form-control-label" for="farmer_id">Farmer</label>
                                        <select name="farmer_id" id="farmer_id" style="width: 100%" required>
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="date_start">Date Start</label>
                                        <input name="date_start" id="date_start" type="text" class="form-control" required>
                                        <i class="form-group__bar"></i>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="date_end">Date End</label>
                                        <input name="date_end" id="date_end" type="text" class="form-control" required>
                                        <i class="form-group__bar"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="season">Season</label>
                                        <select name="season" id="season" style="width: 100%" required>
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                     <div class="form-group">
                                        <label class="form-control-label" for="process">Process</label>
                                        <select name="process" id="process" style="width: 100%" required>
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div id="div-harvest">
                                <h3 class="card-block__title">Harvest Information</h3>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="harvested">Harvested <small class="text-muted">(Hectare)</small></label>
                                            <input name="harvested" id="harvested" type="number" min="0" step="0.01" class="form-control" required>
                                            <i class="form-group__bar"></i>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="production">Production <small class="text-muted">(Metric Ton)</small></label>
                                            <input name="production" id="production" type="number" min="0" step="0.01" class="form-control" required>
                                            <i class="form-group__bar"></i>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="yield">Yield <small class="text-muted">(Metric Ton / Hectare)</small></label>
                                            <input name="yield" id="yield" type="number" min="0" step="0.01" class="form-control" required readonly>
                                            <i class="form-group__bar"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="status">Status</label>
                                            <select name="status" id="status" style="width: 100%" required>
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="div-reason" class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="reason">Reason</label>
                                            <select name="reason" id="reason" style="width: 100%" required>
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="climate">Climate</label>
                                            <input name="climate" id="climate" type="text" class="form-control capitalize" required>
                                            <i class="form-group__bar"></i>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="fertilizer">Fertilizer</label>
                                            <input name="fertilizer" id="fertilizer" type="text" class="form-control capitalize" required>
                                            <i class="form-group__bar"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="remarks">Remarks</label>
                                    <textarea name="remarks" id="remarks" type="text" class="form-control capitalize-first-period"></textarea>
                                    <i class="form-group__bar"></i>
                                </div>
                            </div>
                            <div class="row float-right">
                                <button type="submit" id="cropping-add" class="btn btn-success">Create</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="list_cropping" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-bordered dataTable table-hover" id="table-cropping" role="grid" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Cropping ID</th>
                                        <th>Crop</th>
                                        <th>Date Start</th>
                                        <th>Date End</th>
                                        <th>Season</th>
                                        <th>Process</th>
                                        <th>Farmer</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="list_harvest" role="tabpanel">
                       <div class="table-responsive">
                            <table class="table table-bordered dataTable table-hover" id="table-harvest" role="grid" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Harvest ID</th>
                                        <th>Crop</th>
                                        <th>Date Start</th>
                                        <th>Date End</th>
                                        <th>Season</th>
                                        <th>Harvested</th>
                                        <th>Production</th>
                                        <th>Yield</th>
                                        <th>Status</th>
                                        <th>Reason</th>
                                        <th>Climate</th>
                                        <th>Fertilizer</th>
                                        <th>Remarks</th>
                                        <th>Farmer</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection