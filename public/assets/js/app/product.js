$("#cost_value, #sale_value, #resale_value").inputmask({
    alias:          "decimal",
    groupSeparator: ".",
    autoGroup:      true, 
    digits:         2,
    digitsOptional: false,
    radixPoint: ",",
    placeholder:    "0,00",
    allowMinus: false
 });

$(function () {
    $('#table').bootstrapTable({
        url: `${base_url}/register/product/list`,
        sidePagination: "server",
        queryParamsType: "limit",
        queryParams: queryParams,
        search: true,
        pagination: true,
        paginationLoop: false,
        paginationParts: ['pageInfo', 'pageList'],
        pageSize: 50,
        sortName: "description",
        sortOrder: "asc",
        toolbar: "#table-toolbar",
        columns: [
            {
                field: 'description',
                title: 'Descrição',
                sortable: true
            },
            {
                field: 'package',
                title: 'Embalagem',
                formatter: function(value, row) {
                    return `${row.package_description} ${row.capacity} ${row.unit_measurement_description}`
                }
            },
            {
                field: 'cost_value',
                title: 'Custo',
                formatter: function cost_valueFormatter(value) {
                    return [
                       parseFloat(value).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
                    ].join('')
                }
            },
            {
                field: 'sale_value',
                title: 'Venda',
                formatter: function sale_valueFormatter(value) {
                    return [
                       parseFloat(value).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
                    ].join('')
                }
            },
            {
                field: 'resale_value',
                title: 'Revenda',
                formatter: function resale_valueFormatter(value) {
                    return [
                       parseFloat(value).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
                    ].join('')
                }
            },
            {
                field: "action",
                title: "Ações",
                align: "center",
                width: 120,
                clickToSelect: false,
                formatter: function actionFormatter(value) {
                    return [
                        `<a class="edit btn btn-warning btn-sm text-white me-2" href="javascript:" title="Edit Item">
                            <svg class="icon">
                                <use href="${base_url}/assets/vendors/@coreui/icons/svg/free.svg#cil-pencil"></use>
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
                    "click .edit": function(e, value, row) {
                        window.location.href = `${base_url}/register/product/${row.product_id}/edit`;
                    },
                    "click .delete": function(e, value, row) {
                        window.location.href = `${base_url}/register/product/delete/${row.product_id}`;
                    }
                }
            }
        ],
        theadClasses: "table-light",
        classes: "table table-bordered table-sm table-hover",
    });
});

function queryParams(params) {
    return {
        sort: params.sort,
        order: params.order,
        limit: params.limit,
        offset: params.offset,
        search: params.search
    };
}