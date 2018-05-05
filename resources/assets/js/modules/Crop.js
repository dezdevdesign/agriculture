export default class Crop {
	constructor() {
		initElements();
		this.initEventListeners();
		console.log('Crop module initialized...');
	}

	initEventListeners() {
		// Farmer add form submit listener...
		$('#form-crop').on('submit', e => {
			e.preventDefault();
			axios.post('/crops', $('#form-crop').serialize())
		    .then(response => {
		    	helpers.showNotification('Successfully added new crop.', 'success', 'zmdi zmdi-check');
		    	clearForm();
	            $('#table-crop').DataTable().ajax.reload();
		    })
		    .catch(error => {
		    	helpers.displayErrors(error.response.data.errors, 'Failed to add crop', $('#form-crop'));
		    	console.log(error);
		    });    
		})

		// Farmer edit form submit listener...
		$('#modal-crop-edit').on('submit', '#form-crop-edit', e => {
	    	e.preventDefault()
			axios.put('/crops/' + $('#crop-update').val(), $('#form-crop-edit').serialize())
		    .then(response => {
		        swal({
		            title: 'Updated.',
		            text: 'Farmer has been successfully updated.',
		            type: 'success',
		            buttonsStyling: false,
		            confirmButtonClass: 'btn btn-primary'
		        }).then(function() {
		        	$('#modal-crop-edit').modal('hide');
		            $('#table-crop').DataTable().ajax.reload();
		        }).catch(error => console.log(error));
		    })
		    .catch(error => {
		    	helpers.displayErrors(error.response.data.errors, 'Failed to update crop', $('#form-crop-edit'));
		    	console.log(error);
		    });    
	    });

		// Farmer form clear click listener...
		$('#crop-clear').on('click', function() {
			clearForm();
			helpers.showNotification('Form successfully cleared.', 'info', 'zmdi zmdi-undo');
		});

		// Farmer edit button click listener...
		$('#table-crop').on('click', '#crop-edit', function() {
			$('#modal-crop-edit .modal-content').load('crops/' + $(this).val() + '/edit', function() {
		    	initEditElements();
		    	$('#modal-crop-edit').modal('show');
		    });
		});

		// Edit modal close event listener...
		$('#modal-crop-edit').on('hidden.bs.modal', function() {
			$('#modal-crop-edit .modal-content').html('');
		});
	}
}

function initElements() {
	$('.capitalize').on('keyup', function() {
		$(this).capitalizeInput();
	});

	$('.capitalize-first-period').on('keyup', function() {
		$(this).capitalizeFirstAndPeriod();
	})
	helpers.initParsley($('#form-crop'));
	helpers.trimInput('#form-crop input,textarea');
}

function initEditElements() {
	$('.capitalize').on('keyup', function() {
		$(this).capitalizeInput();
	});

	$('.capitalize-first-period').on('keyup', function() {
		$(this).capitalizeFirstAndPeriod();
	})
	
	helpers.initParsley($('#form-crop-edit'));
	helpers.trimInput('#form-crop-edit input,textarea');
}

function clearForm() {
	$('#form-crop')[0].reset();
	$('#form-crop').parsley().reset();
}