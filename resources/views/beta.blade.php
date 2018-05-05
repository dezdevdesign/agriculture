@extends('layouts.app')
@section('title', 'Beta Testing')
@section('content')
<header class="content__title">
    <h1>Beta Testing</h1>
</header>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-block">
                <div class="table-responsive">
                    <div class="row">
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
                                <label>Age Of Farmer</label>
                                <input name="age" id="age" type="number" class="form-control">
                                <i class="form-group__bar"></i>
                            </div>
                        </div>
                    </div>
                    {!! $dataTable->table([
                        'id' => 'table-beta',
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
@push('scripts')
<script>
$(document).ready(function() {
    axios.get('/api/getCrops')
    .then(function(response) {
        $('#crop').empty().trigger('change');
        $('#crop').select2({
            placeholder: 'Select Crop',
            data: response.data,
            positionDropdown: true
        });        
        $('#crop').val('').trigger('change');
    })
    .catch(error => console.log(error));

    $('#age').on('keyup', function() {
        window.LaravelDataTables["table-beta"].draw();
    });
});
</script>
@endpush
