/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
    config.toolbar = [
        ['Source'],
        ['Undo', 'Redo', '-', 'RemoveFormat'],
        ['Templates'],
        ['Format', 'Font', 'FontSize'],
        ['TextColor', 'BGColor'],
        ['Maximize', 'ShowBlocks'], '/',
        ['Bold', 'Italic', 'Underline', 'Strike', '-', 'Subscript', 'Superscript'],
        ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', 'CreateDiv'],
        ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
        ['Link', 'Unlink'],
        ['Image', 'Table', 'HorizontalRule', 'SpecialChar']
    ];

    config.allowedContent = true;
    config.disallowedContent = 'img{width,height};img[width,height]';
    config.baseFloatZIndex = 10000000;
    config.enterMode = CKEDITOR.ENTER_BR;
    config.shiftEnterMode = CKEDITOR.ENTER_P;
    config.htmlEncodeOutput = false;
    config.font_names = 'Open Sans;Roboto Slab;Rokkitt;Arial;Arial Black;Comic Sans MS;Courier New;Tahoma;Times New Roman;Verdana';
};
