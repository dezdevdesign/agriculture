@extends('layouts.app')
@section('title', 'Users Page')
@section('content')
<header class="content__title">
    <h1>Users Page</h1>
</header>
<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">User Form</h2>
            </div>
            <form id="form-user">
                {{ csrf_field() }}
                <div class="card-block">
                    <div class="form-group">
                        <label class="form-control-label" for="name">Full Name</label>
                        <input name="name" id="name" type="text" class="form-control capitalize" required>
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="username">Username</label>
                        <input name="username" id="username" type="text" class="form-control" required>
                        <i class="form-group__bar"></i>
                    </div>                         
                    <div class="form-group">
                        <label class="form-control-label" for="password">Password</label>
                        <input name="password" id="password" type="password" class="form-control" required>
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="password_confirmation">Confirm Password</label>
                        <input name="password_confirmation" id="password_confirmation" type="password" class="form-control" data-parsley-equalto="#password" required>
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="contact">Contact</label>
                        <input name="contact" id="contact" type="text" class="form-control">
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="municipality">Municipality</label>
                        <select name="municipality" id="municipality" style="width: 100%" required>
                            <option></option>
                            <option value="Bani">Bani</option>
                            <option value="Mangatarem">Mangatarem</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="position">Position</label>
                        <select name="position" id="position" style="width: 100%" required>
                            <option></option>
                            <option value="Municipal Officer">Municipal Officer</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer float-right">
                    <button type="button" id="user-clear" class="btn btn-danger">Clear Form</button>
                    <button type="submit" id="user-add" class="btn btn-success">Create</button>
                </div>  
            </form>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">User List</h2>
            </div>
            <div class="card-block">
                <div class="table-responsive">
                    {!! $dataTable->table([
                        'id' => 'table-user',
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
<div id="modal-user-edit" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="modal-user-edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        </div>
    </div>
</div>
@push('scripts')
{!! $dataTable->scripts() !!}
@endpush
@endsection
