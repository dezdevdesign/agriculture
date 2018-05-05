export default class Farmer {
	constructor() {
		initElements();
		this.initEventListeners();
		console.log('Farmer module initialized...');
	}

	initEventListeners() {
		// Farmer add form submit listener...
		$('#form-farmer').on('submit', e => {
			e.preventDefault();
			axios.post('/farmers', $('#form-farmer').serialize())
		    .then(response => {
		    	helpers.showNotification('Successfully added new farmer.', 'success', 'zmdi zmdi-check');
		    	clearForm();
	            $('#table-farmer').DataTable().ajax.reload();
		    })
		    .catch(error => {
		    	helpers.displayErrors(error.response.data.errors, 'Failed to add farmer', $('#form-farmer'));
		    	console.log(error);
		    });    
		})

		// Farmer edit form submit listener...
		$('#modal-farmer-edit').on('submit', '#form-farmer-edit', e => {
	    	e.preventDefault()
			axios.put('/farmers/' + $('#farmer-update').val(), $('#form-farmer-edit').serialize())
		    .then(response => {
		        swal({
		            title: 'Updated.',
		            text: 'Farmer has been successfully updated.',
		            type: 'success',
		            buttonsStyling: false,
		            confirmButtonClass: 'btn btn-primary'
		        }).then(function() {
		        	$('#modal-farmer-edit').modal('hide');
		            $('#table-farmer').DataTable().ajax.reload();
		        }).catch(error => console.log(error));
		    })
		    .catch(error => {
		    	helpers.displayErrors(error.response.data.errors, 'Failed to update farmer', $('#form-farmer-edit'));
		    	console.log(error);
		    });    
	    });

		// Farmer form clear click listener...
		$('#farmer-clear').on('click', function() {
			clearForm();
			helpers.showNotification('Form successfully cleared.', 'info', 'zmdi zmdi-undo');
		});

		// Farmer edit button click listener...
		$('#table-farmer').on('click', '#farmer-edit', function() {
			$('#modal-farmer-edit .modal-content').load('farmers/' + $(this).val() + '/edit', function() {
		    	initEditElements();
		    	$('#modal-farmer-edit').modal('show');
		    });
		});

		// Edit modal close event listener...
		$('#modal-farmer-edit').on('hidden.bs.modal', function() {
			$('#modal-farmer-edit .modal-content').html('');
		});
	}
}

function initElements() {
	$('.capitalize').on('keyup', function() {
		$(this).capitalizeInput();
	});
	$('#contact').mask("(0000) 000-0000");
	helpers.initParsley($('#form-farmer'));
	helpers.trimInput('#form-farmer input');
}

function initEditElements() {
	$('.capitalize').on('keyup', function() {
		$(this).capitalizeInput();
	});
	$('#contact_edit').mask("(0000) 000-0000");
	helpers.initParsley($('#form-farmer-edit'));
	helpers.trimInput('#form-farmer-edit input');
}

function clearForm() {
	$('#form-farmer')[0].reset();
	$('#form-farmer').parsley().reset();
}