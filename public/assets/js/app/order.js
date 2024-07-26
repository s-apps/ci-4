const base_url = "http://edgar.local";

$(function () {

    var $btn_add = $('#add');
    var $table = $("#table");
    var $alert = $(".alert");

/*     var products_list = $(".products-list");
    var customer_id = $("#customer_id");

    console.log(customer_id)

    products_list.hide(); 
 */

    $(".btn-close").on("click", function(){
        $alert.hide();
    })

    $btn_add.on("click", function () {
        if (($("#customer_id").val() == "") || ($("#product_id").val() == "") || ($("#amount").val() == "")) {
            $alert.show();
            return;
        }

        $.get({
            url: `${base_url}/product/get/${$("#product_id").val()}`,
            dataType: "json",
            success: function(data) {
                const product_id = data.product.product_id;
                
                const tableData = $table.bootstrapTable("getData");
                console.log(tableData)
      /* tableData.forEach(row => {
        console.log('ID:', row.product_id);
      }); */
                
                
                $table.bootstrapTable("insertRow", {
                    index: 0,
                    row: {
                        product_id: data.product.product_id,
                        amount: $("#amount").val(),
                        description: `${data.product.description} ${data.product.package_description} ${data.product.capacity} ${data.product.unit_measurement_description}`,
                        sale_value: data.product.sale_value
                    }
                });
            },
            complete: function () {
                $("#amount").val("");
                $("#product_id").val("");
                $("#product").val("")
            }
        });
    });


    $table.bootstrapTable({
        columns: [
            { 
                field: "selected", 
                checkbox: true
            },
            {
                field: "product_id",
                title: "ID",
                visible: false
            },
            { 
                field: "amount", 
                title: "Qtde", 
                align: "right" 
            },
            {
                field: "description",
                title: "Descrição"
            },
            {
                field: "sale_value",
                title: "Unitário"
            },
            {
                field: "total_value",
                title: "Total",
                formatter: function(value, row) {
                    return row.amount * row.sale_value
                }
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
            $.get({
                url: `${base_url}/order/create_customer_list`,
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.name,
                            value: item.customer_id,
                            type: item.type
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
            $("#customer_type").val(ui.item.type);
            return false;
        },
        response: function( event, ui ) {
            if (! ui.content.length) {
                $("#customer-help").text("Cliente não encontrado");
            }    
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
                    console.log(data)
                    response($.map(data, function(item) {
                        return {
                            label: `${item.description} ${item.package_list_description}`,
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
        },
        response: function( event, ui ) {
            if (! ui.content.length) {
                $("#product-help").text("Produto não encontrado");
            }
        }
    });

    $("#customer").on("input", function(){
        $("#customer_id").val("");
        $("#customer_type").val("");
        $("#customer-help").text("");
    });

    $("#product").on("input", function(){
        $("#product_id").val("");
        $("#product-help").text("");
    });

});