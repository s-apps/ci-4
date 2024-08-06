$(function(){
    var $table = $("#table-order-list");

    $table.bootstrapTable({
        url: `${base_url}/order/list`,
        sidePagination: "server",
        queryParamsType: "limit",
        queryParams: queryParams,
        search: true,
        pagination: true,
        paginationLoop: false,
        paginationParts: ['pageInfo', 'pageList'],
        pageSize: 50,
        sortName: "order_id",
        sortOrder: "desc",
        toolbar: "#table-toolbar",
        columns: [
            { 
                field: "request_date", 
                title: "Data",
                formatter: function request_dateFormatter(value) {
                    const [year, month, day] = value.split('-');
                    return [
                        `${day}/${month}/${year}`
                    ]
                }
            },
            {
                field: "number",
                title: "Número",
                searchable: true
            },
            {
                field: "customer_name",
                title: "Cliente"
            },
            {
                field: "customer_type",
                title: "Tipo",
                formatter: function customer_typeFormatter(value, row) {
                    return [
                        `${row.customer_type == 'resale' ? 'REVENDA' : 'VENDA'}`
                    ]
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
                        `
                        <button class="print btn btn-success btn-sm text-white me-2" type="button" title="Print Item">
                            <svg class="icon">
                                <use href="${base_url}/assets/vendors/@coreui/icons/svg/free.svg#cil-print"></use>
                            </svg>
                        </button>
                        <a class="edit btn btn-warning btn-sm text-white me-2" href="javascript:" title="Edit Item">
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
                    "click .print": function(e, value, row) {
                        //window.location.href = `order/${row.order_id}/print`;
                    },
                    "click .edit": function(e, value, row) {
                        window.location.href = `order/${row.order_id}/edit`;
                    },
                    "click .delete": function(e, value, row) {
                        window.location.href = `order/delete/${row.order_id}`;
                    }
                }
            }
        ],
        theadClasses: "table-light",
        classes: "table table-bordered table-sm table-hover",
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

});