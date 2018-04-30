

$.extend($.fn.dataTable.defaults, {
    processing: true,
    serverSide: true,
    searching: false,
    responsive: true,
    bAutoWidth: false,
    dom: 'rt<"row mt-3"<"col-md-6 text-center text-md-left"li><"col-md-6 text-center text-md-right"p>>',
    ajax: {
        method: 'POST',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    },
    language: {
        url: '/admin/js/lang/tw/datatables.json'
    },
    buttons: [{
        extend: 'print',
        className: 'btn dark btn-outline'
    }, {
        extend: 'copy',
        className: 'btn red btn-outline'
    }, {
        extend: 'pdf',
        className: 'btn green btn-outline'
    }, {
        extend: 'excel',
        className: 'btn yellow btn-outline'
    }, {
        extend: 'csv',
        className: 'btn purple btn-outline'
    }, {
        extend: 'colvis',
        className: 'btn dark btn-outline',
    }],
    lengthMenu: [
        [10, 20, 50, 100, 150, -1],
        [10, 20, 50, 100, 150, 'ALL']
    ],
    pageLength: 20,
    columnDefs: [{
        targets: 'nosort',
        orderable: false
    }],
    initComplete: function() {
        let $datatable = $(this);

        $('tbody tr .checkboxes input[type=checkbox]', $datatable).change(function () {
            $(this).parents('tr').toggleClass('active');
            if($(this).prop('checked') === false) {
                $('.datatables .group-checkable').prop('checked', false);
            }
        });
    }
});

$(document).ready(function() {
    /* datatables - 全選*/
    $('.datatables .group-checkable').each(function() {
        let $checkbox = $(this);
        $checkbox.change(function() {
            $($checkbox.attr('data-set')).each(function() {
                ($checkbox.is(':checked'))
                    ? ($(this).prop('checked', !0), $(this).parents('tr').addClass('active'))
                    : ($(this).prop('checked', !1), $(this).parents('tr').removeClass('active'))
            })
        });
    });

    /* datatables -輸出按鈕*/
    $("#datatableTools a.tool-action").on('click', function() {
        $('.datatables').DataTable().button($(this).attr('data-action')).trigger();
    });
});
