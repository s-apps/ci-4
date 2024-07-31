const base_url = "http://edgar.local";

$(function () {

    var $btn_add_product = $('#add');
    var $table = $("#table");
    var $alert = $(".alert");

    $(".btn-close").on("click", function(){
        $alert.hide();
    })

    $btn_add_product.on("click", function () {
        add_product();
    });

    $table.bootstrapTable({
        columns: [
            {
                field: "product_id",
                title: "ID",
                visible: false
            },
            { 
                field: "amount", 
                title: "Qtde", 
                align: "right",
                widthUnit: "%",
                width: 5,
            },
            {
                field: "description",
                title: "Descrição"
            },
            {
                field: "unitary_value",
                title: "Unitário",
                formatter: function unitaryValueFormatter(value) {
                    return [
                       parseFloat(value).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
                    ].join('')
                }
            },
            {
                field: "total",
                title: "Total",
                formatter: function totalValueFormatter(value) {
                    return [
                       parseFloat(value).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
                    ].join('')
                }
            },
            {
                field: "action",
                title: "Ações",
                align: "center",
                widthUnit: "%",
                width: 15,
                clickToSelect: false,
                formatter: function actionFormatter(value) {
                    return [
                        `<a class="quantify-add btn btn-primary btn-sm text-white me-2" href="javascript:" title="add quantify">
                            <svg class="icon">
                                <use href="${base_url}/assets/vendors/@coreui/icons/svg/free.svg#cil-plus"></use>
                            </svg>
                        </a>
                        <a class="quantify-subtract btn btn-warning btn-sm text-white me-2" href="javascript:" title="subtract quantify">
                            <svg class="icon">
                                <use href="${base_url}/assets/vendors/@coreui/icons/svg/free.svg#cil-minus"></use>
                            </svg>
                        </a>
                        <a class="delete btn btn-danger btn-sm text-white" href="javascript:" title="Delete Item">
                            <svg class="icon">
                                <use href="${base_url}/assets/vendors/@coreui/icons/svg/free.svg#cil-trash"></use>
                            </svg>
                        </a>                            
                        `
                    ].join('')
                },
                events: {
                    "click .quantify-add": function(e, value, row) {
                        $table.bootstrapTable('updateByUniqueId', {
                            id: row.product_id,
                            row: {
                              amount: (parseInt(row.amount) + 1).toString(),
                              total: ((parseInt(row.amount) + 1) * parseFloat(row.unitary_value)).toString()
                            }
                        });
                    },
                    "click .quantify-subtract": function(e, value, row) {
                        if (parseInt(row.amount) > 1) {
                            $table.bootstrapTable('updateByUniqueId', {
                                id: row.product_id,
                                row: {
                                  amount: (parseInt(row.amount) - 1).toString(),
                                  total: ((parseInt(row.amount) - 1) * parseFloat(row.unitary_value)).toString()
                                }
                            });
                        }
                    },
                    "click .delete": function(e, value, row) {
                        $table.bootstrapTable('remove', {
                            field: 'product_id', 
                            values: row.product_id
                        });
                    }
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
                            label: `${item.name} - ${item.type === 'resale' ? 'REVENDA' : 'VENDA'}`,
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


    function add_product() {
        const product_id = $("#product_id").val();
        const customer_id = $("#customer_id").val();
        const amount = $("#amount").val();

        /* if (($("#customer_id").val() == "") || ($("#product_id").val() == "") || ($("#amount").val() == "") || (parseInt($("#amount").val()) < 1)) {
            $alert.show();
            return;
        } */

        $.get({
            url: `${base_url}/order/add/product/${product_id}/${customer_id}/${amount}`,
            dataType: "json",
            success: function(data) {
                console.log(data)
                const tableData = $table.bootstrapTable("getData");
                const filteredData = tableData.filter(function(item) {
                    return item.product_id === product_id;
                });

                if (filteredData.length === 0) {
                    $table.bootstrapTable("insertRow", {
                        index: 0,
                        row: {
                            product_id: product_id,
                            amount: amount,
                            description: `${data.product.description} ${data.product.package_list_description}`,
                            unitary_value: data.product.unitary_value,
                            total: data.product.total
                        }
                    });
                }
            },    
            complete: function () {
                $("#amount").val("");
                $("#product_id").val("");
                $("#product").val("")
            }
        });
    }

});