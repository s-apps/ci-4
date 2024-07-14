const base_url = "http://edgar.local/";

$(function () {
    $('#table').bootstrapTable({
        url: "customer/list",
        sidePagination: "server",
        queryParamsType: "limit",
        queryParams: queryParams,
        search: true,
        pagination: true,
        paginationLoop: false,
        paginationParts: ['pageInfo', 'pageList'],
        pageSize: 50,
        sortName: "name",
        sortOrder: "asc",
        toolbar: "#table-toolbar",
        columns: [
            {
                field: "name",
                title: "Nome",
                sortable: true
            },
            {
                field: "nickname",
                title: "Apelido",
                sortable: true
            },
            {
                field: "cell_phone",
                title: "Celular"
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
                        window.location.href = `customer/${row.customer_id}/edit`;
                    },
                    "click .delete": function(e, value, row) {
                        window.location.href = `customer/delete/${row.customer_id}`;
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