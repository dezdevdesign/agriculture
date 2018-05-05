export default class helpers {
    constructor() {
        this.capitalizeInput();
        this.capitalizeFirstAndPeriod();
    }

    //Capitalize inputs...
    capitalizeInput() {
        $.fn.capitalizeInput = function () {
            $.each(this, function () {
                var split = this.value.split(' ');
                for (var i = 0, len = split.length; i < len; i++) {
                    split[i] = split[i].charAt(0).toUpperCase() + split[i].slice(1).toLowerCase();
                }
                this.value = split.join(' ');
            });
            return this;
        };
    }

    //Capitalize first inputs...
    capitalizeFirstAndPeriod() {
        $.fn.capitalizeFirstAndPeriod = function () {
            $.each(this, function () {
                var split = this.value.split('. ');
                for (var i = 0, len = split.length; i < len; i++) {
                    split[i] = split[i].charAt(0).toUpperCase() + split[i].slice(1).toLowerCase();
                }
                this.value = split.join('. ');
            });
            return this;
        };
    }

    initParsley(form) {
        form.parsley({
            excluded: "input[type=hidden], [disabled], :hidden",
            successClass: "has-success",
            errorClass: "has-danger",
            classHandler: function(e) {
                return e.$element.closest('.form-group');
            },
            errorsWrapper: "<div class='invalid-feedback'></div>",
            errorTemplate: "<span></span>"
        });
    }

    // Trim spaces from inputs...
    trimInput(element) {
        $(element).blur(function () {
            $(this).val($.trim($(this).val()));
        });
    }

    // Select2 data population helper...
    loadSelect(url, element, placeholder) {
        axios.get(url)
        .then(function(response) {
            element.empty();
            element.select2({
                placeholder: 'Select ' + placeholder,
                data: response.data,
                positionDropdown: true
            });        
            element.val('').trigger('change');
        })
        .catch(error => console.log(error));
    }

    // Bootstrap Notify options helper...
    showNotification(message, type, icon) {
        $.notify({
            icon: icon,
            message: message,
            url: ''
        },{
            element: 'body',
            type: type,
            allow_dismiss: true,
            placement: {
                from: "bottom",
                align: "right"
            },
            offset: {
                x: 20,
                y: 20
            },
            spacing: 10,
            z_index: 9999,
            delay: 1500,
            timer: 1500,
            mouse_over: false,
            animate: {
                enter: "animated flipInX",
                exit: "animated flipOutX"
            },
            template:   
            '<div data-notify="container" class="alert alert-dismissible alert-{0} alert--notify" role="alert">' +
            '<span data-notify="icon"></span> ' +
            '<span data-notify="message">{2}</span>' +
            '<div class="progress" data-notify="progressbar">' +
            '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
            '</div>' +
            '<button type="button" aria-hidden="true" data-notify="dismiss" class="alert--notify__close"><i class="zmdi zmdi-close-circle"></i></button>' +
            '</div>'
        });
    }

    // Form error on php validation helper...
    displayErrors(response, message, form) {
        let html = '<ul>';
        $.each(response, function (key, item) {
            html += '<li>' + item + '</li>'
        });
        html += '</ul>'
        this.showNotification('<strong>' + message + '.</strong><br>' + html, 'danger', '');
    }
}
