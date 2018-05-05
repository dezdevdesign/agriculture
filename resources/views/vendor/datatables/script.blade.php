(function(window,$) {
	var dataTableButtons =  '<div class="dataTables_buttons hidden-sm-down actions">' +
	                            '<span class="actions__item zmdi zmdi-print" data-table-action="print" />' +
	                            '<span class="actions__item zmdi zmdi-fullscreen" data-table-action="fullscreen" />' +
	                            '<div class="dropdown actions__item">' +
	                                '<i data-toggle="dropdown" class="zmdi zmdi-download" />' +
	                                '<ul class="dropdown-menu dropdown-menu-right">' +
	                                    '<a href="" class="dropdown-item" data-table-action="excel">Excel (.xlsx)</a>' +
	                                    '<a href="" class="dropdown-item" data-table-action="csv">CSV (.csv)</a>' +
	                                '</ul>' +
	                            '</div>' +
	                        '</div>';
	window.LaravelDataTables = window.LaravelDataTables||{};
	window.LaravelDataTables["%1$s"] = $("#%1$s").DataTable(%2$s);	
    
    $('.dataTables_filter input[type=search]').focus(function () {
        $(this).closest('.dataTables_filter').addClass('dataTables_filter--toggled');
    });

    $('.dataTables_filter input[type=search]').blur(function () {
        $(this).closest('.dataTables_filter').removeClass('dataTables_filter--toggled');
    });

    $('body').on('click', '[data-table-action]', function (e) {
        e.preventDefault();
        var exportFormat = $(this).data('table-action');

        if(exportFormat === 'excel') {
            $(this).closest('.dataTables_wrapper').find('.buttons-excel').trigger('click');
        }
        if(exportFormat === 'csv') {
            $(this).closest('.dataTables_wrapper').find('.buttons-csv').trigger('click');
        }
        if(exportFormat === 'print') {
            $(this).closest('.dataTables_wrapper').find('.buttons-print').trigger('click');
        }
        if(exportFormat === 'fullscreen') {
            var parentCard = $(this).closest('.card');

            if(parentCard.hasClass('card--fullscreen')) {
                parentCard.removeClass('card--fullscreen');
                $('body').removeClass('data-table-toggled');
            }
            else {
                parentCard.addClass('card--fullscreen')
                $('body').addClass('data-table-toggled');
            }
        }
    });
})(window,jQuery);