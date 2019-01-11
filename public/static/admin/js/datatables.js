/**
 * Datatable base defined
 */
$.extend($.fn.dataTable.defaults, {
    processing: true, serverSide: true, searching: false, responsive: true, bAutoWidth: false,
    dom: 'rt<"row mt-3"<"col-md-6 text-center text-md-left"li><"col-md-6 text-center text-md-right"p>>',
    ajax: {method: 'POST', headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}},
    language: {url: '/admin/js/lang/tw/datatables.json'},
    buttons: [
        {extend: 'print', className: 'btn dark btn-outline'},
        {extend: 'copy', className: 'btn red btn-outline'},
        {extend: 'pdf', className: 'btn green btn-outline'},
        {extend: 'excel', className: 'btn yellow btn-outline'},
        {extend: 'csv', className: 'btn purple btn-outline'},
        {extend: 'colvis', className: 'btn dark btn-outline',}
    ],
    lengthMenu: [[10, 20, 50, 100, 150, -1], [10, 20, 50, 100, 150, 'ALL']],
    pageLength: 20,
    columnDefs: [{targets: 'nosort', orderable: false}],
    initComplete: function() {
        $('tbody tr .checkboxes input[type=checkbox]', $(this)).change(function () {
            $(this).parents('tr').toggleClass('active');
            if($(this).prop('checked') === false) {
                $('.datatables .group-checkable').prop('checked', false);
            }
        });
    }
});

$(function() {
    /**
     * Datatable - Select all
     */
    $('.datatables .group-checkable').each(function() {
        var $checkbox = $(this);
        $checkbox.change(function() {
            $($checkbox.attr('data-set')).each(function() {
                if ($checkbox.is(':checked')) {
                    $(this).prop('checked', !0); $(this).parents('tr').addClass('active');
                } else {
                    $(this).prop('checked', !1); $(this).parents('tr').removeClass('active');
                }
            })
        });
    });
});
