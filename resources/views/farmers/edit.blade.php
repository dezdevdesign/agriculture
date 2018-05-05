<div class="modal-header">
    <h5 class="modal-title pull-left">Farmer Information</h5>
</div>
<form id="form-farmer-edit">
    {{ csrf_field() }}
    <div class="modal-body">
        <div class="card-block">
            <div class="form-group">
                <label>Full Name</label>
                <input name="name_edit" id="name_edit" type="text" class="form-control capitalize" value="{{ $farmer->name }}" required>
            </div>
            <div class="form-group">
                <label>Age</label>
                <input name="age_edit" id="age_edit" type="number" min="0" class="form-control" value="{{ $farmer->age }}">
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input name="address_edit" id="address_edit" type="text" class="form-control capitalize" value="{{ $farmer->address }}" required>
            </div>
            <div class="form-group">
                <label>Contact</label>
                <input name="contact_edit" id="contact_edit" type="text" class="form-control" value="{{ $farmer->contact }}" required>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" id="farmer-update" value="{{ $farmer->id }}" class="btn btn-success">Update</button>
    </div>
</form>