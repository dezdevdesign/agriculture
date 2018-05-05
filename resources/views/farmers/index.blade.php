@extends('layouts.app')
@section('title', 'Farmers Page')
@section('content')
<header class="content__title">
    <h1>Farmers Page</h1>
</header>
<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Farmer Information</h2>
            </div>
            <form id="form-farmer" novalidate>
                {{ csrf_field() }}
                <div class="card-block">
                    <div class="form-group">
                        <label class="form-control-label" for="name">Full Name</label>
                        <input name="name" id="name" type="text" class="form-control capitalize" required>
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="age'">Age</label>
                        <input name="age" id="age" type="number" min="0" class="form-control">
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="address">Address</label>
                        <input name="address" id="address" type="text" class="form-control capitalize" required>
                        <i class="form-group__bar"></i>
                    </div>                   
                    <div class="form-group">
                        <label class="form-control-label" for="contact">Contact</label>
                        <input name="contact" id="contact" type="text" class="form-control" required>
                        <i class="form-group__bar"></i>
                    </div>
                </div>
                <div class="card-footer float-right">
                    <button type="button" id="farmer-clear" class="btn btn-danger">Clear Form</button>
                    <button type="submit" id="farmer-add" class="btn btn-success">Create</button>
                </div>  
            </form>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Farmer List</h2>
            </div>
            <div class="card-block">
                <div class="table-responsive">
                    {!! $dataTable->table([
                        'id' => 'table-farmer',
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
<div id="modal-farmer-edit" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="modal-farmer-edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        </div>
    </div>
</div>
@push('scripts')
{!! $dataTable->scripts() !!}
@endpush
@endsection
