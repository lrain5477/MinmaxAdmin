CKEDITOR.plugins.add('newplugin',
{
    init: function (editor) {
        var pluginName = 'newplugin';
        editor.ui.addButton('Newplugin',
            {
                label: '嵌入圖片',
                command: 'OpenWindow',
                icon: CKEDITOR.plugins.getPath('newplugin') + 'img.png'
            });
        var cmd = editor.addCommand('OpenWindow', { exec: showMyDialog });
    }
});

function showMyDialog(e) {
    //window.open('/Default.aspx', 'MyWindow', 'width=800,height=700,scrollbars=no,scrolling=no,location=no,toolbar=no');

   /* var valsTemp = new Array();
    var arr = new Object();
    arr.name = 'fileRoot';
    arr.value = "Upload/images";
    valsTemp.push(arr);

    var arr = new Object();
    arr.name = 'field';
    arr.value = "description";
    valsTemp.push(arr);


    var arr = new Object();
    arr.name = 'types';
    arr.value = "editor";
    valsTemp.push(arr);


    var vals = JSON.stringify(valsTemp);
  
    useAjax("getImages", vals);*/
	
    $("." + e.name).trigger("click");

}