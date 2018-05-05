<div class="modal-header">
    <h5 class="modal-title pull-left">User Information</h5>
</div>
<form id="form-user-edit">
    {{ csrf_field() }}
    <div class="modal-body">
        <div class="card-block">
            <div class="form-group">
                <label class="form-control-label" for="name">Full Name</label>
                <input name="name" id="name" type="text" class="form-control capitalize" value="{{ $user->name }}" required>
                <i class="form-group__bar"></i>
            </div>
            <div class="form-group">
                 <label class="form-control-label" for="username">User Name</label>
                <input name="username" id="username" type="text" class="form-control" value="{{ $user->username }}" required readonly>
                <i class="form-group__bar"></i>
            </div>
            <div class="form-group">
                 <label class="form-control-label" for="contact">Contact</label>
                <input name="contact" id="contact" type="text" class="form-control" value="{{ $user->contact }}">
                <i class="form-group__bar"></i>
            </div>
            <div class="form-group">
                 <label class="form-control-label" for="municipality">Municipality</label>
                <select name="municipality" id="municipality" style="width: 100%" required>
                    <option></option>
                </select>
                <i class="form-group__bar"></i>
            </div>
            <div class="form-group">
                 <label class="form-control-label" for="position">Position</label>
                <select name="position" id="position" style="width: 100%" required>
                    <option></option>
                </select>
                <i class="form-group__bar"></i>
            </div>
            <input type="text" id="tmp_municipality" value="{{ $user->municipality }}" hidden disabled>
            <input type="text" id="tmp_position" value="{{ $user->position }}" hidden disabled>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" id="user-update" value="{{ $user->id }}" class="btn btn-success">Update</button>
    </div>
</form>