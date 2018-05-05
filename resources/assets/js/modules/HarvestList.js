if(window.location.pathname.includes('/croppings/harvests')) {
     $(document).ready(function() {
        helpers.loadSelect('/api/loadMunicipalities', $('#municipality'), 'Municipality');
        helpers.loadSelect('/api/getCrops', $('#crop'), 'Crop');
        
        $('#barangay').select2({placeholder: 'Select Barangay'});

         // Municipality select event listener...
        $('#municipality').on('select2:select', function() {
            helpers.loadSelect('/api/loadBarangays/' + $(this).val(), $('#barangay'), 'Barangay');
            window.LaravelDataTables["table-cropping"].draw();
        });

        $('#barangay').on('select2:select', function() {
            window.LaravelDataTables["table-cropping"].draw();
        });

        $('#crop').on('select2:select', function() {
            console.log($(this).val());
            window.LaravelDataTables["table-cropping"].draw();
        });

        $('#cropping-list-clear').on('click', function() {
            clear();
            window.LaravelDataTables["table-cropping"].draw();
        });
    });

    function clear() {
        $('#municipality').val('').trigger('change');
        $('#crop').val('').trigger('change');
        $('#barangay').empty().trigger('change');
    }
}