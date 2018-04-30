@push('styles')
<link rel="stylesheet" href="{{asset('/admin/js/components/elFinder/css/elfinder.min.css')}}">
<link rel="stylesheet" href="{{asset('/admin/js/components/elFinder/css/theme.css')}}">
<link type="text/css" rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css"/>
<style>
    .file-img-list .card:not(.ui-sortable-helper){
        float: left;
        margin: 0px 6.5px 12px;
        cursor: pointer;
        -webkit-transition: all 0.2s linear;
        -moz-transition: all 0.2s linear;
        -ms-transition: all 0.2s linear;
        -o-transition: all 0.2s linear;
        transition: all 0.2s linear;
    }
</style>
@endpush

<!--圖片管理-->
<div class="modal fade bd-example-modal-lg" id="modal_file" tabindex="-1" role="dialog" aria-hidden="true">
    <input type="hidden" id="imgUseType" value="area" data-title="圖片置放位置" />
    <input type="hidden" id="imgUseField" value="area" data-title="圖片置放位置" />
    <input type="hidden" id="imgModelName" value="{{ $pageData->model }}" data-title="圖片置放位置" />
    <input type="hidden" id="nowTypes" value="images" data-title="圖片置放位置" />

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">媒體庫</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"></button><span aria-hidden="true">×</span>
            </div>
            <div class="modal-body" id="elfinder"></div>
            <div class="modal-footer"><button class="btn btn-secondary" type="button" data-dismiss="modal">取消</button></div>
        </div>
    </div>
</div>
<!--圖片管理-->

<!--圖片alt-->
<div class="modal fade bd-example-modal-lg" id="modal_picname" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">圖片標題</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"></button><span aria-hidden="true">×</span>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="picname">檔名<span class="text-danger ml-1"></span>
                    </label>
                    <div class="col-sm-10">
                        <div class="form-text" id="imageName">imagename.jpg</div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="picalt">圖片標題<span class="text-danger ml-1"></span>
                    </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="modalFileAlt" id="modalFileAlt">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">取消</button>
                <button class="btn btn-primary" type="button" data-dismiss="modal" id="altBtn" name="altBtn">送出</button>
            </div>
        </div>
    </div>
</div>
<!--圖片alt-->

@push('scripts')
<!--檔案管理-->
<script src="{{ asset('admin/js/elfinder/js/elfinder.full.js') }}"></script>
<script src="{{ asset('admin/js/elfinder/js/i18n/elfinder.zh_TW.js') }}"></script>
<script src="{{ asset('admin/js/elfinder/js/jquery-ui-1.11.4.min.js') }}"></script>
<!--檔案管理 END-->
<script>
$(document).ready(function(){
    /* 圖片排序 */
    $('.file-img-list').sortable({
        disabled: false,
        items: '.card',
        zIndex: 9999,
        opacity: 0.7,
        forceHelperSize: false,
        helper: 'clone',
        change: function(event, div) {
            div.placeholder.css({visibility: 'visible', background: '#cc0000', opacity: 0.2})
        },
        stop : function(event, div) {
            var sortList = '';
        },
    });

    $('.file-img-list').disableSelection();


    /* 取得圖片 */
    $("body").delegate(".getImages", "click", function () {
        if ($(this).attr('class').indexOf('editorUse') != -1) {
            $('#imgUseType').val('editor');
        } else {
            $('#imgUseType').val('area');
        }

        $('#imgUseField').val($(this).attr('data-field'));
        $('#nowTypes').val('images');
    });

    /* 取得檔案 */
    $("body").delegate(".getFiles", "click", function () {
        $('#imgUseType').val('file');
        $('#imgUseField').val($(this).attr('data-field'));
        $('#nowTypes').val('files');
    });

    // 檔案管理器 Start
    $('#elfinder').each(function () {
        elFinder.prototype.i18.zh_TW.messages['cmdimportBut'] = '嵌入';
        elFinder.prototype._options.commands.push('importBut');
        elFinder.prototype.commands.importBut = function () {
            this.exec = function (hashes) {
                //do whatever
                var file = this.files(hashes);

                //圖檔直接加入
                if (file[0].mime != 'directory') {
                    for (var p = 0; p < file.length; p++) {
                        if (file[p].mime != 'directory') {
                            var hash = file[p].hash;
                            var fm = this.fm;
                            var url = fm.url(hash);
                            var addImg = "";
                            var i = 1;

                            if ($('#imgUseType').val() == "area") {
                                var _imgLeng = $('#'+$('#imgUseField').val()+'_img > div.card').length;

                                addImg += '<div class="card ml-2 ui-sortable-handle" id="' + $('#imgUseField').val() + _imgLeng + '"><a class="thumb" href="' + url + '" data-fancybox=""><span class="imgFill imgLiquid_bgSize imgLiquid_ready" style="background-image: url(&quot;' + url + '&quot;); background-size: cover; background-position: center center; background-repeat: no-repeat;"><img src="'+url+'" class="imgData" style="display: none;"></span></a>';
                                addImg += '<div class="btn-group btn-group-sm justify-content-center">';
                                addImg += '<input type="hidden" class="imgData" id="'+$('#imgUseField').val()+_imgLeng+'" name="'+$('#imgModelName').val()+'['+$('#imgUseField').val()+'][]" value="' + url + '">';
                                addImg += '<input type="hidden" class="altData" id="'+$('#imgUseField').val()+'_alt'+_imgLeng+'" name="'+$('#imgModelName').val()+'['+$('#imgUseField').val()+'_alt][]" value="">';
                                addImg += '<button class="btn btn-outline-default open_modal_picname" type="button" title="設定" data-target="#modal_picname" data-toggle="modal" data-access="alt_' + $('#imgUseField').val() + '_' + $('#imgUseField').val() + '_img' + hash + '" data-filename="' + url + '" data-alt="" data-id="'+$('#imgUseField').val()+'_alt'+_imgLeng+'"><i class="icon-wrench"></i></button>';
                                addImg += '<button class="btn btn-outline-default delFiles imgSeetAlert delBtn" type="button" data-guid="" data-field=\"' + $('#imgUseField').val() + '\" data-filename="' + url + '" data-title="是否確認刪除" data-message="您將刪除此檔案" data-type="info" data-show-confirm-button="true" data-confirm-button-class="btn-danger" data-show-cancel-button="true" data-cancel-button-class="btn-outline-default" data-close-on-confirm="false" data-confirm-button-text="確認" data-cancel-button-text="取消" data-popup-title-success="刪除完成" data-popup-message-success="您的項目已丟進垃圾桶區" data-id="'+$('#imgUseField').val()+'_alt'+_imgLeng+'"><i class="icon-trash2"></i></button>';
                                addImg += '</div>';
                                addImg += '</div>';

                                $('#' + $('#imgUseField').val() + "_img").append(addImg);

                            } else if($('#imgUseType').val() == "file") {
                                var _imgLeng = $('#'+$('#imgUseField').val()+'_img > div.card').length;

                                addImg += '<div class="card ml-2 ui-sortable-handle" id="' + $('#imgUseField').val() + _imgLeng + '"><a class="thumb" href="' + url + '" target="_blank" title="' + url + '"><span class="imgFill imgLiquid_bgSize imgLiquid_ready" style="background-image: url(&quot;/admin/images/file.png&quot;); background-size: cover; background-position: center center; background-repeat: no-repeat;"><img src="'+url+'" class="imgData" style="display: none;"></span></a>';
                                addImg += '<div class="btn-group btn-group-sm justify-content-center">';
                                addImg += '<input type="hidden" class="imgData" id="'+$('#imgUseField').val()+_imgLeng+'" name="'+$('#imgModelName').val()+'['+$('#imgUseField').val()+'][]" value="' + url + '">';
                                addImg += '<button class="btn btn-outline-default delFiles imgSeetAlert delBtn" type="button" data-guid="" data-field=\"' + $('#imgUseField').val() + '\" data-filename="' + url + '" data-title="是否確認刪除" data-message="您將刪除此檔案" data-type="info" data-show-confirm-button="true" data-confirm-button-class="btn-danger" data-show-cancel-button="true" data-cancel-button-class="btn-outline-default" data-close-on-confirm="false" data-confirm-button-text="確認" data-cancel-button-text="取消" data-popup-title-success="刪除完成" data-popup-message-success="您的項目已丟進垃圾桶區" data-id="'+$('#imgUseField').val()+'_alt'+_imgLeng+'"><i class="icon-trash2"></i></button>';
                                addImg += '</div>';
                                addImg += '</div>';

                                $('#' + $('#imgUseField').val() + "_img").append(addImg);

                            } else {
                                addImg = '<img src="' + url + '"  >';

                                var oEditor = CKEDITOR.instances[$('#imgUseField').val()];
                                var html = addImg;

                                var newElement = CKEDITOR.dom.element.createFromHtml(html, oEditor.document);
                                oEditor.insertElement(newElement);
                            }
                        } else {
                            this.exec('quicklook');//開啟資料夾
                        }
                    }
                } else {
                    this.exec('quicklook');//開啟資料夾
                }
            }
            this.getstate = function () {
                //return 0 to enable, -1 to disable icon access
                return 0;
            }
        };

        var myCommands = elFinder.prototype._options.commands;

        var disabled = ['extract', 'archive', 'help', 'select'];
        $.each(disabled, function (i, cmd) {
            (idx = $.inArray(cmd, myCommands)) !== -1 && myCommands.splice(idx, 1);
        });
        var selectedFile = null;
        var options = {
            url:'/admin/js/elfinder/php/connector.minimal.php',
            commands: myCommands,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            lang: 'zh_TW',
            uiOptions: {
                toolbar: [
                    ['back', 'forward'],
                    ['reload'],
                    ['home', 'up'],
                    ['mkdir', 'mkfile', 'upload'],
                    ['open', 'download'],
                    ['info'],
                    ['quicklook'],
                    ['copy', 'cut', 'paste'],
                    ['rm'],
                    ['duplicate', 'rename', 'edit', 'resize'],
                    ['view', 'sort','importBut']
                ]
            },
            contextmenu: {
                // current directory file menu
                files: [
                    'open', 'quicklook', 'sharefolder', '|', 'download', '|', 'copy', 'cut', 'paste', 'rm', '|', 'rename', '|', 'importBut', '|', 'info'
                ]
            },
            reloadClearHistory: true,
            rememberLastDir: false,
            resizable: false,
            height: '500px',
            handlers: {
                select: function (event, elfinderInstance) {
                    if (event.data.selected.length == 1) {
                        var item = $('#' + event.data.selected[0]);
                        if (!item.hasClass('directory')) {
                            selectedFile = event.data.selected[0];

                            $('#elfinder-selectFile').show();
                            return;
                        }
                    }
                    $('#elfinder-selectFile').hide();
                    selectedFile = null;
                },
                //判斷點選兩下時
                dblclick: function (event, elfinderInstance) {
                    event.preventDefault();
                    elfinderInstance.exec('importBut');
                    return false;
                }
            }
        };
        $('#elfinder').elfinder(options).elfinder('instance');

        $('#elfinder-selectFile').click(function () {
            if (selectedFile != null){
                $.post('files/selectFile', { target: selectedFile }, function (response) {
                    alert(response);
                });
            }
        });
    });
    // 檔案管理器 End
});
</script>
@endpush