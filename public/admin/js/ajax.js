/*圖片alt*/
$("body").delegate('.open_modal_picname', 'click', function () {
	$('#imageName').html($(this).attr('data-filename'));
	
	$('#modalFileAlt').val('');
	$('#modalFileAlt').val( $(this).attr('data-alt') );
	$('#altBtn').attr('data-id',$(this).attr('data-id'));
	
});

$("body").delegate('#altBtn', 'click', function () {
	var _id = $(this).attr('data-id');
	
	
	var modalFileAlt = $('#modalFileAlt').val();
	$('input[id="'+_id+'"]').val(modalFileAlt);
	//$('.open_modal_picname').attr('data-id')
	$('.open_modal_picname[data-id="'+_id+'"]').attr('data-alt',modalFileAlt);
});

//搜尋bar
$("body").delegate('#sch_keyword', 'keyup', function () {
	$(".datatables").DataTable().draw();
});

$("body").delegate('.sch_select', 'change', function () {
	$(".datatables").DataTable().draw();
});


//批次修改
$("body").delegate(".changeStatus", "click", function() {
    var selID = '';
    var thisStatus = $(this).attr('data-value');
    $('._chkAll').each(function () {
        if($(this).prop("checked") === true) {
            selID += $(this).val() + ",";
            $('.status' + $(this).val()).html(thisStatus);
        }
    });

    if (selID === '') {
        swal({
            title: "系統資訊", text: "請選擇須執行批次動作的資料!", type: "warning",
            showCancelButton: false, confirmButtonText: "確定", closeOnConfirm: false
        });
        return false;
    } else {
        var valsTemp = new Array();
        var arr1 = new Object();
        arr1.name = 'selID';
        arr1.value = selID;
        valsTemp.push(arr1);

        var arr2 = new Object();
        arr2.name = 'chk';
        arr2.value = thisStatus;
        valsTemp.push(arr2);

        var arr3 = new Object();
        arr3.name = 'types';
        arr3.value = "chkAll";
        valsTemp.push(arr3);

        var vals = JSON.stringify(valsTemp);

        if (thisStatus === 'D') {
            swal({
                title: "是否確認刪除",
                text: "您將刪除選取內容，一但刪除將無法還原‧",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#e7505a",
                confirmButtonText: "確定!",
                closeOnConfirm: false,
                cancelButtonText: "取消"
            }, function () {
                useAjax('MULTI_DELETE', vals);
                return false;
            });
        } else {
            useAjax('MULTI_STATUS', vals);
        }
    }
});

/*刪除記錄*/
$('body').delegate('.delItem', 'click', function(e){
	var _guid = $(this).attr('data-guid');
	var _table = $(this).attr('data-tables');
    e.preventDefault();
    var $thisForm = $(this).parents('form');

	swal({
        title: "是否確認刪除",
        text: "您將刪除選取內容，一但刪除將無法還原",
        type: "info",
        showCancelButton: true,
        cancelButtonText: '取消',
        confirmButtonText: "確認",
        confirmButtonClass: "btn-danger",
        closeOnConfirm: false
    }, function(result) {
		if(result) {
            $thisForm.submit();
		}
	});
});



//修改狀態
$('#tableList').delegate(".badge-switch", "click", function(e){
    e.preventDefault();

    var $this = $(this);
    var url = $this.attr('data-url');
    var status = $this.attr('data-value');
    var id = $this.attr('data-id');
    var column = $this.attr('data-column');
    var switchTo = status == 1 ? 0 : 1;

    $.ajax({
        type: 'POST',
        url: url,
        data: {id:id,column:column,switchTo:switchTo},
        dataType:'json',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        beforeSend:function(){},
        success:function(result) {
            if(status == 1) {
                $this.attr('data-value' , 0);
                $this.removeClass("badge-danger");
                $this.addClass("badge-secondary");
                $this.html(result.newLabel);
            }
            if(status == 0) {
                $this.attr('data-value' , 1);
                $this.removeClass("badge-secondary");
                $this.addClass("badge-danger");
                $this.html(result.newLabel);
            }
        },
        error:function(){},
        complete:function(){}
    });

    return false;
});

//變更排序
$('#tableList').delegate(".updateSort", "click", function(e){
	e.preventDefault();

    var $this = $(this);
    var id = $this.attr('data-guid');
    var column = $this.attr('data-column');
    var index = parseInt($('#' + column + '_' + id).val());

    switch($this.attr('data-act')) {
        case 'up':
            $('#' + column + '_' + id).val(index - 1);
            break;
        case 'down':
            $('#' + column + '_' + id).val(index + 1);
            break;
    }

    $('#' + column + '_' + id).change();

	return false;
});

function updateSort(column, id) {
    var index = parseInt($('#' + column + '_' + id).val());
    if(index < 0) index = 0;
    var url = $('#' + column + '_' + id).attr('data-url');

    $.ajax({
        type: 'POST',
        url: url,
        data: {id:id,column:column,index:index},
        dataType:'json',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        beforeSend:function(){},
        success:function(result){
            $('#tableList').DataTable().draw();
            useDataTable(url.replace('/sort', '/datatables'), '');
        },
        complete:function(){},
        error:function(response){console.log(response);}
    });
}

//切換語系
$('body').delegate(".changInputLang", "click", function(e){
	
	//var _lang = $(this).attr('data-value');
	//$('#lang').val(_lang);
	
	$(this).addClass('selected').siblings().removeClass('selected');
	$('.editForm').hide();
	$('#editForm-' + $(this).attr('data-value')).show();
	
	//$('.vLay').hide();
	//$('.v_'+_lang).show();
});



//權限全選
$('body').delegate(".topLv", "change", function(e){
	
	var _topLv = $(this).val();	
	
	if($(this).is(':checked')){
		$('.a'+_topLv).prop("checked", true);
	}else {

		$('.n'+_topLv).prop("checked", true);
	}
	
});

/**
 * AJAX動作
 * @param ACT
 * @param needVal
 */
function useAjax(ACT , needVal) {
    switch (ACT) {
        case 'MULTI_DELETE':
            $.ajax({
                url: '/siteadmin/' + $('#model').val() + '/ajax/multi-delete',
                type: 'post',
                data: {data:encodeURI(needVal)},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType: 'json',
                success: function(json) {
                    $('#tableList').DataTable().draw();
                    swal("刪除完成!", "您的動作已完成", "success");
                    return false;
                }
            });
            break;
        case 'MULTI_STATUS':
            $.ajax({
                url: '/siteadmin/' + $('#model').val() + '/ajax/multi-status',
                type: 'post',
                data: {data:encodeURI(needVal)},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType: 'json',
                success: function(json) {
                    $('#tableList').DataTable().draw();
                    return false;
                }
            });
            break;
    }


	// $.ajax({
	// 	type: 'POST',
	// 	url: '/siteadmin/ajax/create',
	// 	data: {Func:ACT,Val:encodeURI(needVal)},
	// 	dataType:'json',
	// 	headers: {
	// 		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	// 	},
	// 	beforeSend:function(){
	// 	},
	// 	success:function(json){
	// 		switch(json.Func){
    //
	// 			case 'adminLogin':
	// 				if(json.re == 'N'){
	// 					//alert("登入失敗!");
	// 					swal("Error", "登入失敗!", "error");
	// 					$(':input[type="submit"]').prop('disabled', false);
	// 				}else if(json.re == 'codeErr'){
	// 					alert("請勾選驗證!");
	// 					$(':input[type="submit"]').prop('disabled', false);
	// 				}else{
	// 					window.location.href='/siteadmin/';
	// 				}
	// 			break;
	//
	//
	// 			case "saveForm":
	// 					//console.log(json); return false;
	// 					if(json.nextID != ''){
	// 						window.location.href='/siteadmin/list/'+json.types + '/' + json.nextID;
	// 					}else{
	//
	// 						if(json.reID != ''){
	// 							window.location.href='/siteadmin/edit/'+json.types+'/'+json.reID;
	// 						}else{
    //
	// 							window.location.href='/siteadmin/list/'+json.types;
	// 						}
    //
	// 					}
	// 			break;
	//
	// 			case 'delSingleRecord':
	//
	// 				if(json.re == "Y")
	// 				{
	// 					swal("刪除完成!", "您的動作已完成", "success");
	// 					//$('#row_'+json.reId).remove();
	// 					$('#tableList').DataTable().destroy();
	// 					useDataTable("");
    //
	// 					return false;
	// 				}
	// 				return false;
	// 			break;
	//
	// 			case 'changeIndex':
	// 				$('#sortIndex' + json.reID).val(json.re);
	// 				$('#vSortIndex' + json.reID).html(json.re);
	// 			break;
	//
	// 			case 'changeStatus':
	//
	// 				if(json.batch == 'Y'){
	// 					$('#tableList').DataTable().destroy();
	// 					useDataTable("");
	// 					return false;
	// 				}
	//
	// 				if(json.batch == 'D'){
	// 					$('#tableList').DataTable().destroy();
	// 					useDataTable("");
	// 					swal("刪除完成!", "您的動作已完成", "success");
    //
	// 					return false;
	// 				}
	// 			break;
    //
	//
	// 		}
    //
    //
	// 	},
	// 	complete:function(){
	// 		//生成分頁條
    //
	// 	},
	// 	error:function(){
	// 		//alert("讀取錯誤!");
	// 	}
	// });

}

