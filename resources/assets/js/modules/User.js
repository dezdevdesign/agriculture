export default class Farmer {
	constructor() {
		initElements();
		this.initEventListeners();
		console.log('User module initialized...');
	}

	initEventListeners() {
		// Submit form to add new user...
		$('#form-user').on('submit', function(e) {
			e.preventDefault();
			let data = $("#form-user").serialize();
			axios.post('users', data)
		    .then(response => {
		    	helpers.showNotification('Successfully added new user.', 'success', 'zmdi zmdi-check');
		    	clearForm();
	            $('#table-user').DataTable().ajax.reload();
		    })
		    .catch(error => {
		    	helpers.displayErrors(error.response.data.errors, 'Failed to add user', $('#form-user'));
		    	console.log(error);
		    });    
		});

		// Show user information for editing...
	    $('#table-user').on('click', '#user-edit', function() {
		    $('#modal-user-edit .modal-content').load('users/' + $(this).val() + '/edit', function() {
		    	initModalElements();
		    	$('#modal-user-edit').modal('show');
		    });
	    });

	    $('#modal-user-edit').on('hidden.bs.modal', function() {
	    	$('#modal-user-edit .modal-content').html('');
	    });
	    
	    // Submit form to update user...
	    $('#modal-user-edit').on('submit', '#form-user-edit', function(e) {
	    	e.preventDefault()
	    	let id = $('#user-update').val();
	    	let data = $("#form-user-edit").serialize();
			axios.put('users/'+id, data)
		    .then(response => {
		        swal({
		            title: 'User updated.',
		            text: 'User has been successfully updated.',
		            type: 'success',
		            buttonsStyling: false,
		            confirmButtonClass: 'btn btn-primary'
		        }).then(function() {
		        	$('#modal-user-edit').modal('hide');
		            $('#table-user').DataTable().ajax.reload();
		        }).catch(function(){});
		    })
		    .catch(error => {
		    	helpers.displayErrors(error.response.data.errors, 'Failed to update user', $('#form-user-edit'));
		    	console.log(error);
		    });    
	    });

	    // Clear user form...
	    $('#user-clear').on('click', function() {
	    	clearForm();
			helpers.showNotification('Form successfully cleared.', 'info', 'zmdi zmdi-undo');
		});
	}
}
function initModalElements() {
	$('.capitalize').on('keyup', function() {
		$(this).capitalizeInput();
	});
	
	$('#form-user-edit select').on('select2:select', function() {
		$(this).parsley().validate();
	});

	helpers.initParsley($('#form-user-edit'));
	helpers.trimInput('#form-user-edit input');

	$('#form-user-edit #contact').mask("(0000) 000-0000");
 	$('#form-user-edit #municipality').select2({
        placeholder: 'Select Municipality',
        data: [{id: 'Bani', text: 'Bani'}, {id: 'Mangatarem', text: 'Mangatarem'}],
        positionDropdown: true
    });

    $('#form-user-edit #position').select2({
        placeholder: 'Select Position',
        data: [{id: 'Municipal Officer', text: 'Municipal Officer'}, {id: 'Admin', text: 'Admin'}],
        positionDropdown: true
    });
 	$('#form-user-edit #municipality').val($('#tmp_municipality').val()).trigger('change');
    $('#form-user-edit #position').val($('#tmp_position').val()).trigger('change');
}

function initElements() {
	$('.capitalize').on('keyup', function() {
		$(this).capitalizeInput();
	});

	$('select').on('select2:select', function() {
		$(this).parsley().validate();
	});

	helpers.initParsley($('#form-user'));
	helpers.trimInput('#form-user input');

	$('#contact').mask("(0000) 000-0000");
 	$('#municipality').select2({
        placeholder: 'Select Municipality',
        data: [{id: 'Bani', text: 'Bani'}, {id: 'Mangatarem', text: 'Mangatarem'}],
        positionDropdown: true
    });

    $('#position').select2({
        placeholder: 'Select Position',
        data: [{id: 'Municipal Officer', text: 'Municipal Officer'}, {id: 'Admin', text: 'Admin'}],
        positionDropdown: true
    });
}

function clearForm() {
	$('#form-user')[0].reset();
	$('#form-user select').val(null).trigger('change');
	$('#form-user').parsley().reset();
}