$(document).ready(function () {
//        $('#birthdate').datetimepicker({
//            formainsert-order-formt: 'YYYY-MM-DD',
//            viewMode: 'years',
//            maxDate: moment(),
//            widgetPositioning: {
//                horizontal: 'left'
//            }
//        });

    $('#autosearch-form').validate({
        rules: {
            search_value: {required: true},
        },
        messages: {
            search_value: {required: langauge_var.common_autosearch_error},
        },
        showErrors: function (errorMap, errorList) {
            var error = [];
            $.each(errorMap, function (key, value) {
                error.push(value);
            });
            if (error.length != 0) {
                $.toast({
                    heading: langauge_var.common_error_header,
                    text: error,
                    icon: 'error',
                    hideAfter: 5000,
                    position: 'toast-bottom-right'
                });
            }
        },
        submitHandler: function (form) {
            form.submit();
        },
        onkeyup: false,
        focusInvalid: false
    });

    $('#profile').validate({
        rules: {
            name: {required: true},
            email: {required: true, email: true},
            password: {
                required: {
                    depends: function (element) {
                        if ($('#user_id').val() == '') {
                            return true;
                        }
                    }
                },
                minlength: 8,
                PASSWORD: true},
            confirmpassword: {equalTo: '#password'},
            mobile: {number: true, maxlength: 10, phoneUSCustom: true}
        },
        messages: {
            name: {required: langauge_var.common_first_name},
            email: {required: langauge_var.login_email, email: langauge_var.login_valid_email},
            password: {required: langauge_var.common_password, minlength: langauge_var.common_password_len8},
            confirmpassword: {required: langauge_var.common_confirm_password, equalTo: langauge_var.common_password_match},
            mobile: {number: langauge_var.valid_mobile_number, maxlength: langauge_var.mobile_length}
        },
        showErrors: function (errorMap, errorList) {
            var error = [];
            $.each(errorMap, function (key, value) {
                error.push(value);
            });
            if (error.length != 0) {
                $.toast({
                    heading: langauge_var.common_error_header,
                    text: error,
                    icon: 'error',
                    hideAfter: 5000,
                    position: 'toast-bottom-right'
                });
            }
        },
        onkeyup: false,
        focusInvalid: false
    });

    $('#size_with_price').validate({
        rules: {
            serial_name: {required: true},
            mobile: {number: true, maxlength: 10, phoneUSCustom: true}
        },
        messages: {
            serial_name: {required: langauge_var.common_serial_name},
            mobile: {number: langauge_var.valid_mobile_number, maxlength: langauge_var.mobile_length}
        },
        showErrors: function (errorMap, errorList) {
            var error = [];
            $.each(errorMap, function (key, value) {
                error.push(value);
            });
            if (error.length != 0) {
                $.toast({
                    heading: langauge_var.common_error_header,
                    text: error,
                    icon: 'error',
                    hideAfter: 5000,
                    position: 'toast-bottom-right'
                });
            }
        },
        submitHandler: function (form) {
            var size = $('#size_1').val();
            var price = $('#price_1').val();
            var kapad_id = $('#kapad_id_1_1').val();
            var use_kapad = $('#use_kapad_1_1').val();
            if (size == '') {
                $.toast({
                    heading: langauge_var.common_error_header,
                    text: langauge_var.common_size_name,
                    icon: 'error',
                    hideAfter: 5000,
                    position: 'toast-bottom-right'
                });
                return false;
            }
            if (price == '') {
                $.toast({
                    heading: langauge_var.common_error_header,
                    text: langauge_var.common_price_name,
                    icon: 'error',
                    hideAfter: 5000,
                    position: 'toast-bottom-right'
                });
                return false;
            }
            if (kapad_id == '' || kapad_id == undefined) {
                $.toast({
                    heading: langauge_var.common_error_header,
                    text: 'Please select kapad.',
                    icon: 'error',
                    hideAfter: 5000,
                    position: 'toast-bottom-right'
                });
                if (kapad_id == undefined) {
                    $('.add_average').trigger('click');
                }
                return false;
            }
            if (use_kapad == '' || use_kapad == undefined) {
                $.toast({
                    heading: langauge_var.common_error_header,
                    text: langauge_var.common_use_cloth_name,
                    icon: 'error',
                    hideAfter: 5000,
                    position: 'toast-bottom-right'
                });
                return false;
            }
            form.submit();
        },
        onkeyup: false,
        focusInvalid: false
    });

    $('#assign-kapad').validate({
        rules: {
            cloth_id: {required: true},
            cloth_meter: {required: true},
            assign_date: {required: true},
        },
        messages: {
            cloth_id: {required: langauge_var.common_cloth},
            cloth_meter: {required: langauge_var.common_cloth_meter},
            assign_date: {required: langauge_var.select_date},
        },
        showErrors: function (errorMap, errorList) {
            var error = [];
            $.each(errorMap, function (key, value) {
                error.push(value);
            });
            if (error.length != 0) {
                $.toast({
                    heading: langauge_var.common_error_header,
                    text: error,
                    icon: 'error',
                    hideAfter: 5000,
                    position: 'toast-bottom-right'
                });
            }
        },
        submitHandler: function (form) {
            form.submit();
        },
        onkeyup: false,
        focusInvalid: false
    });

    $('#insert-order-form').validate({
        rules: {
            customer_id: {required: true},
            serial_id: {required: true},
            order_date: {required: true},
        },
        messages: {
            customer_id: {required: langauge_var.common_customer},
            serial_id: {required: langauge_var.common_serial_number},
            order_date: {required: langauge_var.select_date},
        },
        showErrors: function (errorMap, errorList) {
            var error = [];
            $.each(errorMap, function (key, value) {
                error.push(value);
            });
            if (error.length != 0) {
                $.toast({
                    heading: langauge_var.common_error_header,
                    text: error,
                    icon: 'error',
                    hideAfter: 5000,
                    position: 'toast-bottom-right'
                });
            }
        },
        submitHandler: function (form) {
            var count = $('#count_size_with_price').val();
            var bill_id = $('#bill_id').val();
            var serial_id = $('#serial_id').val();
           
            var submit = 1;
            var size_data = [];
            var qty_data = [];
            
            if (count > 0) {
                for (var i = 1; i <= count; i++) {
                    var price = $('#order_price_' + i).val();
                    var qty = $('#order_qty_' + i).val();
                    var size = $('#order_size_' + i).val();
                    if (price > 0 && qty > 0) {
                        submit = 0;
                        size_data[i-1] = size;
                        qty_data[i-1] = qty;
                    }
                }
                if (submit) {
                    $.toast({
                        heading: langauge_var.common_error_header,
                        text: 'Please enter valid price and qty.',
                        icon: 'error',
                        hideAfter: 5000,
                        position: 'toast-bottom-right'
                    });
                    return false;
                }

            } else {
                return false;
            }
            var _token = $("#_token").val();
            
            $.ajax({
                type: "post",
                url: base_url + "check-valid-order",
                data: {'_token':_token ,'bill_id': bill_id, 'serial_id': serial_id, 'size_data':size_data, 'qty_data':qty_data},
                dataType: "json",
                success: function (data) {
                    if (data.flag) {
//                        console.log('success'); return false;
                        form.submit();
                    } else {
                        $.toast({
                            heading: langauge_var.common_error_header,
                            text: 'Please assign cloth to customer. You can not take order more than assign kapad.',
                            icon: 'error',
                            hideAfter: 5000,
                            position: 'toast-bottom-right'
                        });
                        return false;
                    }
                }
            });
        },
        onkeyup: false,
        focusInvalid: false
    });

    $(document).on('change', '.form-control-file', function (e) {
        var val = $(this).val();
        var file_size = this.files[0].size;
        var default_upload_size = 5 * 1000 * 1000;//10MB size
        var ext = val.substring(val.lastIndexOf('.') + 1).toLowerCase();

        switch (ext) {
            case 'gif':
            case 'jpg':
            case 'png':
            case 'jpeg' :

                $(this).parent().removeClass('has-error');
                break;
            default:
                $.toast({
                    heading: langauge_var.common_error_header,
                    text: langauge_var.common_invalid_file_format,
                    icon: 'error'
                });
                $(this).filestyle('clear');
                break;
        }
        //to validate the image size
        if (file_size > default_upload_size) {
            $.toast({
                heading: langauge_var.common_error_header,
                text: langauge_var.common_file_size_5mb,
                icon: 'error'
            });
            $(this).val('');
            $(this).filestyle('clear');
        }
    });

    $(document).on('change', '.get-size-price', function (e) {
        var serial_id = $(this).val();
        if (serial_id == '' || serial_id == 0) {
            $('.sizewithdata-html').html('');
            return false;
        }
        $.ajax({
            type: "get",
            url: base_url + "get-sizewithprice",
            data: {'serial_id': serial_id},
            dataType: "html",
            success: function (html) {
                $('.sizewithdata-html').html(html);
            }
        });

    });

    $(document).on('click', '.get-report', function (e) {
        var customer_id = $('#customer_id').val();
        $.ajax({
            type: "get",
            url: base_url + "report-html",
            data: {'customer_id': customer_id},
            dataType: "html",
            success: function (html) {
                $('.report_html').html(html);
            }
        });

    });

    $('#customer').validate({
        rules: {
            name: {required: true},
            mobile: {number: true, maxlength: 10, phoneUSCustom: true}
        },
        messages: {
            name: {required: langauge_var.common_first_name},
            mobile: {number: langauge_var.valid_mobile_number, maxlength: langauge_var.mobile_length}
        },
        showErrors: function (errorMap, errorList) {
            var error = [];
            $.each(errorMap, function (key, value) {
                error.push(value);
            });
            if (error.length != 0) {
                $.toast({
                    heading: langauge_var.common_error_header,
                    text: error,
                    icon: 'error',
                    hideAfter: 5000,
                    position: 'toast-bottom-right'
                });
            }
        },
        onkeyup: false,
        focusInvalid: false
    });
    $('#bill').validate({
        rules: {
            customer_id: {required: true},
            estimate_date: {required: true},
            cloth_id: {required: true},
        },
        messages: {
            customer_id: {required: langauge_var.common_customer},
            estimate_date: {required: langauge_var.esrtimate_date},
            cloth_id: {required: langauge_var.common_cloth},
        },
        showErrors: function (errorMap, errorList) {
            var error = [];
            $.each(errorMap, function (key, value) {
                error.push(value);
            });
            if (error.length != 0) {
                $.toast({
                    heading: langauge_var.common_error_header,
                    text: error,
                    icon: 'error',
                    hideAfter: 5000,
                    position: 'toast-bottom-right'
                });
            }
        },
        onkeyup: false,
        focusInvalid: false
    });

});

$('.add_customer').click(function (e) {
    $('#add_customer').modal('show');
    return false;
});

$('.add_cloth').click(function (e) {
    $('#add_cloth').modal('show');
    return false;
});
$('.payment_customer').click(function (e) {
    $('#payment_customer').modal('show');
    return false;
});
$('.payment_details').click(function (e) {
    $('#payment_details').modal('show');
    return false;
});
$('.assign_kapad').click(function (e) {
    $('#assign_kapad').modal('show');
    var name = $(this).data('name');
    $('.cus_name').html(name);
    var customer_id = $(this).data('id');
    $('#customer_id').val(customer_id);
    return false;
});

$('.add_sizewithprice').click(function (e) {
    var oldCount = $("#addDetails").val();
    var newCount = parseInt(oldCount) + 1;
    var html = $('.sizewithprice_html').html();
    var new_html = html.replace(/\xxxx/g, newCount);
    var new_html = new_html.replace(/\_yyyy/g, '');
    $('.sizewithprice_append').append(new_html);
    $("#addDetails").val(newCount);
    return false;
});
$(document).on('click', '.add_average', function (e) {
    var x = $(this).data('id');
    var total_avg = $('#total_avg_' + x).val();
    var new_avg = parseInt(total_avg) + 1;
    var html = $('.average_hidden_html').html();
    var new_html = html.replace(/\xxxx/g, x);
    var new_html = new_html.replace(/\yyyy/g, new_avg);
    $('.sub_row_' + x).append(new_html);
    $('#total_avg_' + x).val(new_avg);
    return false;
});

$('.datepicker').datepicker();

$('.insert-customer').click(function (e) {
    var customer_name = $('#customer_name').val();
    var mobile = $('#customer_mobile').val();
    if (!customer_name) {
        $.toast({
            heading: langauge_var.common_error_header,
            showHideTransition: 'slide',
            text: 'Please enter customer name.',
            icon: 'error'
        });
    } else {
        var _token = $("#_token").val();
        $.ajax({
            type: "post",
            url: base_url + "add-customer",
            data: {'_token': _token, 'customer_name': customer_name, 'mobile': mobile},
            dataType: "json",
            success: function (data) {
                if (data.flag) {
                    if (data.count) {
                        var c_data = data.customer;
                        var opt = '<option>Select Customer</option>';
                        for (var a = 0; a < c_data.length; a++) {
                            opt += '<option value="' + c_data[a].id + '">' + c_data[a].name + '</option>';
                        }
                        $('#customer_id').html(opt);
                    }

                    $.toast({
                        heading: langauge_var.common_error_header,
                        showHideTransition: 'slide',
                        text: data.msg,
                        icon: 'success'
                    });
                    $('#add_customer').modal('hide');

                } else {
                    $.toast({
                        heading: langauge_var.common_error_header,
                        showHideTransition: 'slide',
                        text: data.msg,
                        icon: 'error'
                    });
                }
            }
        });
    }

});
$('.payment-to-customer').click(function (e) {
    var bill_id = $('#bill_id').val();
    var price = $('#price').val();
    var estimate_date = $('#estimate_date').val();

    if (bill_id == 0 || bill_id == '') {
        $.toast({
            heading: langauge_var.common_error_header,
            showHideTransition: 'slide',
            text: 'Please refresh page and try again.',
            icon: 'error'
        });
        return false;
    }
    if (price == 0 || price == '') {
        $.toast({
            heading: langauge_var.common_error_header,
            showHideTransition: 'slide',
            text: 'Please enter valid price.',
            icon: 'error'
        });
        return false;
    }
    var max_price = $('.max_payment').data('price');
    if (max_price < price) {
        $.toast({
            heading: langauge_var.common_error_header,
            showHideTransition: 'slide',
            text: 'You can not paid more than received order.',
            icon: 'error'
        });
        return false;
    }
    if (estimate_date == '') {
        $.toast({
            heading: langauge_var.common_error_header,
            showHideTransition: 'slide',
            text: 'Please select date.',
            icon: 'error'
        });
        return false;
    }
    $('#payment-customer').submit();

});

$('.add_order').click(function (e) {
    $('#add_order').modal('show');
    return false;
});

$('.insert-order').click(function (e) {
    var customer_id = $('#customer_id').val();
    var serial_id = $('#serial_id').val();
    var valid_count = $('#count_size_with_price').val();

    if (customer_id == 0 || customer_id == '') {
        $.toast({
            heading: langauge_var.common_error_header,
            showHideTransition: 'slide',
            text: 'Please select customer name.',
            icon: 'error'
        });
        return false;
    }
    if (serial_id == 0 || serial_id == '') {
        $.toast({
            heading: langauge_var.common_error_header,
            showHideTransition: 'slide',
            text: 'Please select serial number.',
            icon: 'error'
        });
        return false;
    }
    if (valid_count == 0 || valid_count == '') {
        $.toast({
            heading: langauge_var.common_error_header,
            showHideTransition: 'slide',
            text: 'Size not available for selected serial number.',
            icon: 'error'
        });
        return false;
    }
    $('#add_order').submit();

});

$('.insert-cloth').click(function (e) {
    var cloth_name = $('#cloth_name').val();
    if (!cloth_name) {
        $.toast({
            heading: langauge_var.common_error_header,
            showHideTransition: 'slide',
            text: 'Please enter cloth type.',
            icon: 'error'
        });
    } else {
        var _token = $("#_token").val();
        $.ajax({
            type: "post",
            url: base_url + "add-cloth",
            data: {'_token': _token, 'cloth_name': cloth_name},
            dataType: "json",
            success: function (data) {
                if (data.flag) {
                    if (data.count) {
                        var c_data = data.cloth;
                        var opt = '<option value="">Select Cloth / Kapad</option>';
                        for (var a = 0; a < c_data.length; a++) {
                            opt += '<option value="' + c_data[a].id + '">' + c_data[a].name + '</option>';
                        }
                        $('#cloth_id').html(opt);
                    }

                    $.toast({
                        heading: langauge_var.common_error_header,
                        showHideTransition: 'slide',
                        text: data.msg,
                        icon: 'success'
                    });
                    $('#add_cloth').modal('hide');

                } else {
                    $.toast({
                        heading: langauge_var.common_error_header,
                        showHideTransition: 'slide',
                        text: data.msg,
                        icon: 'error'
                    });
                }
            }
        });
    }

});

$('.price_validate').keypress(function (event) {
    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
    if (($(this).val().indexOf('.') != -1) && ($(this).val().substring($(this).val().indexOf('.'), $(this).val().indexOf('.').length).length > 2)) {
        event.preventDefault();
    }
});
    
    function deleteconfirm(str){
    if(confirm(str)){
        return true;
    }
    return false;
}