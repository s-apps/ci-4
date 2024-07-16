const base_url = "http://edgar.local/";

$(function () {
    $('#table').bootstrapTable({
        url: "package/list",
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
                sortable: true,
                formatter: function (value, row) {
                    return [
                        `${row.description} ${row.capacity} ${row.unit_measurement_description}`
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
                        window.location.href = `package/${row.package_id}/edit`;
                    },
                    "click .delete": function(e, value, row) {
                        window.location.href = `package/delete/${row.package_id}`;
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