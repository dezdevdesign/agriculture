@extends('layouts.app')
@section('title', 'Map Page')
@section('content')
<header class="content__title">
    <h1>Map Page</h1>
</header>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-block">
                <div class="row">
                    <div class="col-sm-6">
                        <label class="form-control-label" for="lot_number">Search Lot</label>
                        <div class="input-group mb-3">
                            <select  id="lot_number" name="lot_number" style="width: 100%">
                                <option></option>
                            </select>
                            <div class="input-group-prepend" style="padding-left: 10px">
                                <button id="map-search" name="map-search" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="map" style="width: 100%; height: 600px; border: 1px solid #ccc; z-index: 0"></div>
            </div>  
        </div>
    </div>
</div>
<div id="modal-map" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="modal-map" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">Lot Information</h5>
            </div>
            <form id="form-map">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="card-block">
                        <div class="form-group">
                            <label class="form-control-label" for="lot">Lot</label>
                            <input name="lot" id="lot" type="text" class="form-control capitalize" required>
                            <i class="form-group__bar"></i>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="watering_type">Watering Type</label>
                             <select name="watering_type" id="watering_type" style="width: 100%" required>
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="soil_type">Soil Type</label>
                             <select name="soil_type" id="soil_type" style="width: 100%" required>
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="municipality">Municipality</label>
                            <select name="municipality" id="municipality" style="width: 100%" required>
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="barangay">Barangay</label>
                             <select name="barangay" id="barangay" style="width: 100%" required>
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="area">Area <small>(Hectares)</small></label>
                            <input name="area" id="area" type="text" class="form-control" required readonly>
                            <i class="form-group__bar"></i>
                        </div>
                        <div class="form-group hidden">
                            <label class="form-control-label" for="coordinates">Coordinates</label>
                            <input name="coordinates" id="coordinates" type="text" class="form-control" required readonly>
                        </div>
                        <div class="form-group hidden">
                            <label class="form-control-label">Center</label>
                            <input name="lot_lat" id="lot_lat" type="text" class="form-control" required readonly>
                            <input name="lot_lng" id="lot_lng" type="text" class="form-control" required readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" id="map-save" class="btn btn-success">Save</button>
                    <button type="button" id="map-update" class="btn btn-info">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection