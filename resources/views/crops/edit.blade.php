<div class="modal-header">
    <h5 class="modal-title pull-left">Crop Information</h5>
</div>
<form id="form-crop-edit">
    {{ csrf_field() }}
    <div class="modal-body">
        <div class="card-block">
            <div class="form-group">
                <label class="form-control-label" for="name_edit">Crop Name</label>
                <input name="name_edit" id="name_edit" type="text" class="form-control capitalize" value="{{ $crop->name }}" required>
                <i class="form-group__bar"></i>
            </div>
            <div class="form-group">
                <label class="form-control-label" for="description_edit">Description</label>
                <textarea name="description_edit" id="description_edit" type="text" rows="5" class="form-control capitalize-first-period">{{ $crop->description }}</textarea>
                <i class="form-group__bar"></i>
            </div>
            <div class="form-group">
                <label class="form-control-label" for="minimum_production_edit">Minimum Production Required <small>(Metric Ton)</small></label>
                <input name="minimum_production_edit" id="minimum_production_edit" type="number" class="form-control" value="{{ $crop->minimum_production }}" required>
                <i class="form-group__bar"></i>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" id="crop-update" value="{{ $crop->id }}" class="btn btn-success">Update</button>
    </div>
</form>