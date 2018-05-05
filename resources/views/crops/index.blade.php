@extends('layouts.app')
@section('title', 'Crops Page')
@section('content')
<header class="content__title">
    <h1>Crops Page</h1>
</header>
<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Crop Information</h2>
            </div>
            <form id="form-crop">
                {{ csrf_field() }}
                <div class="card-block">
                    <div class="form-group">
                        <label class="form-control-label" for="name">Crop Name</label>
                        <input name="name" id="name" type="text" class="form-control capitalize" required>
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="description">Description</label>
                        <textarea name="description" id="description" type="text" rows="5" class="form-control capitalize-first-period"></textarea>
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="minimum_production">Minimum Production Required <small>(Metric Ton)</small></label>
                        <input name="minimum_production" id="minimum_production" type="number" class="form-control" required>
                        <i class="form-group__bar"></i>
                    </div>
                </div>
                <div class="card-footer float-right">
                    <button type="button" id="crop-clear" class="btn btn-danger">Clear Form</button>
                    <button type="submit" id="crop-add" class="btn btn-success">Create</button>
                </div>  
            </form>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Crop List</h2>
            </div>
            <div class="card-block">
                <div class="table-responsive">
                    {!! $dataTable->table([
                        'id' => 'table-crop',
                        'class' => 'table table-bordered dataTable table-hover',
                        'role' => 'grid',
                        'cellspacing' => '0',
                        'width' => '100%',
                        'style' => 'width:100%']
                    )!!}
                </div>
            </div>
            <div class="card-footer">
            </div>
        </div>
    </div>
</div>
<div id="modal-crop-edit" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="modal-crop-edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        </div>
    </div>
</div>
@push('scripts')
{!! $dataTable->scripts() !!}
@endpush
@endsection
