/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

// CKEDITOR.editorConfig = function( config ) {
	// // Define changes to default configuration here. For example:
	// // config.language = 'fr';
	// // config.uiColor = '#AADC6E';
// };
CKEDITOR.editorConfig = function( config )
{
	config.filebrowserBrowseUrl = 'plugins/kcfinder/browse.php?type=files';
	config.filebrowserImageBrowseUrl = 'plugins/kcfinder/browse.php?type=images';
	config.filebrowserFlashBrowseUrl = 'plugins/kcfinder/browse.php?type=flash';
	config.filebrowserUploadUrl = 'plugins/kcfinder/upload.php?type=files';
	config.filebrowserImageUploadUrl = 'plugins/kcfinder/upload.php?type=images';
	config.filebrowserFlashUploadUrl = 'plugins/kcfinder/upload.php?type=flash';

	config.extraPlugins = 'youtube';
	config.youtube_width = '640';
	config.youtube_height = '480';
	config.youtube_responsive = false;
	config.youtube_related = false;
	config.youtube_older = false;
	config.youtube_privacy = false;
	config.youtube_autoplay = false;
	config.youtube_controls = false;
	
	config.extraPlugins = 'video';
	
};