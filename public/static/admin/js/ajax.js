var $ajaxBody = $("body");

/**
 * Switch form data language
 */
$ajaxBody.on('click', '.form-local-option', function() {
    var $this = $(this);
    $.ajax({
        url: $this.attr('data-url'), type: 'PUT', data: {language: $this.attr('data-code')},
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function() { window.location.reload(true); }
    });
});

/**
 * Datatable search field events
 */
$ajaxBody
    .on('keyup', '#sch_keyword', function() { $(".datatables").DataTable().draw(); })
    .on('change', '#sch_column', function() { $(".datatables").DataTable().draw(); })
    .on('change', '.sch_select', function() { $(".datatables").DataTable().draw(); });

/**
 * Datatable bind event actions
 * - switch status
 * - change sort (after change number call update sort function)
 * - delete row
 */
$('#tableList')
    .on('click', '.badge-switch', function(e) {
        e.preventDefault();

        var $this = $(this);
        var url = $this.attr('data-url'),
            status = parseInt($this.attr('data-value')),
            id = $this.attr('data-id'),
            column = $this.attr('data-column');
        var switchTo = status === 1 ? 0 : 1;

        $.ajax({
            url: url, type: 'PATCH', dataType:'json',
            data: {id:id,column:column,oriValue:status,switchTo:switchTo},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function(result) {
                $this.attr('data-value', switchTo);
                if (result.hasOwnProperty('oriClass')) $this.removeClass(result.oriClass);
                if (result.hasOwnProperty('newClass')) $this.addClass(result.newClass);
            },
            complete:function(){$('#tableList').DataTable().draw(false);}
        });
        return false;
    })
    .on('click', '.updateSort', function(e) {
        e.preventDefault();

        var $this = $(this);
        var id = $this.attr('data-guid'), column = $this.attr('data-column');
        var $input = $('#' + column + '_' + id);
        var index = parseInt($input.val());

        switch($this.attr('data-act')) {
            case 'up':
                $input.val(index - 1); break;
            case 'down':
                $input.val(index + 1); break;
        }
        $input.change();
        return false;
    })
    .on('click', '.delItem', function(e) {
        e.preventDefault();

        var $thisForm = $(this).parents('form');

        swal({
            title: getLanguage(sweetAlertLanguage, 'single_delete.title'),
            text: getLanguage(sweetAlertLanguage, 'single_delete.text'),
            type: "info",
            cancelButtonText: getLanguage(sweetAlertLanguage, 'single_delete.cancelButtonText'),
            confirmButtonText: getLanguage(sweetAlertLanguage, 'single_delete.confirmButtonText'),
            confirmButtonClass: "btn-danger",
            showCancelButton: true,
            closeOnConfirm: false
        }, function(result) {
            if(result) $thisForm.submit();
        });
    });

/**
 * Datatable single row update sort
 * @param {string} column
 * @param {*} id
 */
function updateSort(column, id) {
    var $input = $('#' + column + '_' + id);
    var url = $input.attr('data-url'), index = parseInt($input.val());
    if(index < 0) index = 0;

    $.ajax({
        url: url, type: 'PATCH', dataType:'json',
        data: {id:id,column:column,index:index},
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success:function(){$('#tableList').DataTable().draw(false);},
        error:function(response){console.log(response);}
    });
}

/**
 * Datatable batch delete rows
 * @param {string} url
 * @param {string} column
 * @param {*} status
 */
function multiSwitch(url, column, status) {
    var checkedSet = [];
    $('#tableList tbody .checkboxes input').each(function() {
        if ($(this).prop('checked')) checkedSet.push($(this).val());
    });
    if (checkedSet.length > 0) {
        swal({
            title: getLanguage(sweetAlertLanguage, 'multi_switch.title'),
            text: getLanguage(sweetAlertLanguage, 'multi_switch.text'),
            type: "info",
            showCancelButton: true,
            cancelButtonText: getLanguage(sweetAlertLanguage, 'multi_switch.cancelButtonText'),
            confirmButtonText: getLanguage(sweetAlertLanguage, 'multi_switch.confirmButtonText'),
            confirmButtonClass: "btn-danger",
            closeOnConfirm: false
        }, function(result) {
            if(result) {
                $.ajax({
                    url: url, type: 'PATCH', dataType:'json',
                    data: {selected:checkedSet,column:column,switchTo:status},
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success:function(result) {
                        $('#tableList').DataTable().draw(false);
                        swal.close();
                    },
                    error:function(response) {
                        swal(getLanguage(sweetAlertLanguage, 'multi_switch.error_title'),
                            getLanguage(sweetAlertLanguage, 'multi_switch.error_text'),
                            'error');
                    }
                });
            }
        });
    } else {
        swal(getLanguage(sweetAlertLanguage, 'selected_none.title'),
            getLanguage(sweetAlertLanguage, 'selected_none.text'),
            'error');
    }
}

/**
 * Datatable batch delete rows
 * @param url
 */
function multiDelete(url) {
    var checkedSet = [];
    $('#tableList tbody .checkboxes input').each(function() {
        if ($(this).prop('checked')) checkedSet.push($(this).val());
    });
    if (checkedSet.length > 0) {
        swal({
            title: getLanguage(sweetAlertLanguage, 'multi_delete.title'),
            text: getLanguage(sweetAlertLanguage, 'multi_delete.text'),
            type: "info",
            showCancelButton: true,
            cancelButtonText: getLanguage(sweetAlertLanguage, 'multi_delete.cancelButtonText'),
            confirmButtonText: getLanguage(sweetAlertLanguage, 'multi_delete.confirmButtonText'),
            confirmButtonClass: "btn-danger",
            closeOnConfirm: false
        }, function(result) {
            if(result) {
                $.ajax({
                    url: url, type: 'DELETE', dataType:'json',
                    data: {selected:checkedSet},
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success:function(result){
                        $('#tableList').DataTable().draw(false);
                        swal.close();
                    },
                    error:function(response){
                        swal(getLanguage(sweetAlertLanguage, 'multi_delete.error_title'),
                            getLanguage(sweetAlertLanguage, 'multi_delete.error_text'),
                            'error');
                    }
                });
            }
        });
    } else {
        swal(getLanguage(sweetAlertLanguage, 'selected_none.title'),
            getLanguage(sweetAlertLanguage, 'selected_none.text'),
            'error');
    }
}

/* 圖片 Alt */
$ajaxBody
    .delegate('.open_modal_picname', 'click', function () {
        $('#imageName').html($(this).attr('data-filename'));
        $('#modalFileAlt').val('').val($(this).attr('data-alt'));
        $('#altBtn').attr('data-id', $(this).attr('data-id'));
    })
    .delegate('#altBtn', 'click', function () {
        var _id = $(this).attr('data-id'), modalFileAlt = $('#modalFileAlt').val();
        $('input[id="'+_id+'"]').val(modalFileAlt);
        //$('.open_modal_picname').attr('data-id');
        $('.open_modal_picname[data-id="'+_id+'"]').attr('data-alt', modalFileAlt);
    });
