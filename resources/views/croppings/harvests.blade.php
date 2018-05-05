@extends('layouts.app')
@section('title', 'Harvest List Page')
@section('content')
<header class="content__title">
    <h1>Harvest List Page</h1>
</header>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-block">
                <div class="table-responsive">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="municipality">Municipality</label>
                                <select name="municipality" id="municipality" style="width: 100%" required>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Barangay</label>
                                 <select name="barangay" id="barangay" style="width: 100%" required>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Crop</label>
                                 <select name="crop" id="crop" style="width: 100%" required>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                         <div class="col-sm-3">
                            <div class="form-group">
                                <br>
                                <button type="button" id="cropping-list-clear" class="btn btn-info"><i class="zmdi zmdi-refresh"></i></button>
                            </div>
                        </div>
                    </div>
                    {!! $dataTable->table([
                        'id' => 'table-cropping',
                        'class' => 'table table-bordered dataTable table-hover',
                        'role' => 'grid',
                        'cellspacing' => '0',
                        'width' => '100%',
                        'style' => 'width:100%']
                    )!!}
                </div>
            </div>  
        </div>
    </div>
</div>
@endsection
@push('scripts')
{!! $dataTable->scripts() !!}
@endpush