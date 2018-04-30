/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	  config.toolbar = [['Source'],
                      ['Undo', 'Redo', '-', 'SelectAll', 'RemoveFormat'],
                      ['Format', 'Font', 'FontSize'],
                      ['TextColor', 'BGColor'],
                      ['Maximize', 'ShowBlocks', '-', 'About'], '/',
                      ['Bold', 'Italic', 'Underline', 'Strike', '-', 'Subscript', 'Superscript'],
                      ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', 'Blockquote', 'CreateDiv'],
                      ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
                      ['Link', 'Unlink', 'Anchor'],
                      ['Newplugin', 'Image', 'Table', 'HorizontalRule', 'SpecialChar'],
                      ['Code']];
    config.extraPlugins = 'newplugin';

    config.removeButtons = 'Anchor';
    config.allowedContent = true;
    config.disallowedContent = 'img{width,height};img[width,height]';
    config.baseFloatZIndex = 10000000;
    config.enterMode = CKEDITOR.ENTER_BR;
    config.shiftEnterMode = CKEDITOR.ENTER_P;
    config.htmlEncodeOutput = false;


    //config.filebrowserImageBrowseUrl = '/siteadmin/Files/Mag';
    config.font_names = 'Open Sans;Roboto Slab;Rokkitt;Arial;Arial Black;Comic Sans MS;Courier New;Tahoma;Times New Roman;Verdana';
};
