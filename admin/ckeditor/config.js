/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.extraPlugins = 'video, lineheight, youtube';
	config.contentsCss = '../css/fonts.css';
	config.font_names = 'RobotoMedium/RobotoMedium;RobotoRegular/RobotoRegular;RobotoBold/RobotoBold;RobotoLight/RobotoLight;' + config.font_names;
	config.line_height="1.0;1.1;1.2;1.3;1.4;1.5;1.5;1.6;1.7;1.8;1.9;2.0;2.5;3.0;3.5;4.0;4.5;5.0" ;
	config.fontSize_sizes = '8/8px;9/9px;10/10px;11/11px;12/12px;13/13px;14/14px;15/15px;16/16px;18/18px;20/20px;22/22px;24/24px;25/25px;26/26px;27/27px;28/28px;30/30px;';
};
