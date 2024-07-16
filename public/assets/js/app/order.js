const base_url = "http://edgar.local";

$(function () {

    $("#table").bootstrapTable({
        columns: [
            { 
                field: "selected", 
                checkbox: true 
            },
            { 
                field: "amount", 
                title: "Qtde", 
                align: "right" 
            },
            {
                field: "description",
                title: "Descrição"
            }
        ],
        theadClasses: "table-light",
        classes: "table table-bordered table-sm table-hover",
    });

    $("#request_date").inputmask("datetime", {
        inputFormat: "dd/mm/yyyy",
        placeholder: 'dd/mm/aaaa',
        clearIncomplete: true
    });

    $("#due_date").inputmask("datetime", {
        inputFormat: "dd/mm/yyyy",
        placeholder: 'dd/mm/aaaa',
        clearIncomplete: true
    });

    $("#customer").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: `${base_url}/order/create_customer_list`,
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.name,
                            value: item.customer_id
                        };
                    }));
                }
            });            
        },
        focus: function(event, ui) {
            $("#customer").val(ui.item.label);
            return false;
        },
        select: function(event, ui) {
            $("#customer").val(ui.item.label);
            $("#customer_id").val(ui.item.value);
            return false;
        }
    });

    $("#product").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: `${base_url}/order/create_product_list`,
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.description,
                            value: item.product_id
                        };
                    }));
                }
            });            
        },
        focus: function(event, ui) {
            $("#product").val(ui.item.label);
            return false;
        },
        select: function(event, ui) {
            $("#product").val(ui.item.label);
            $("#product_id").val(ui.item.value);
            $("#amount").focus();
            return false;
        }
    });

});