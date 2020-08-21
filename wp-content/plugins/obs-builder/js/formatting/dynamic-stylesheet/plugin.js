/* global tinymce, ObspgbDynamicStylesheet */
var ObspgbDynamicStylesheet = ObspgbDynamicStylesheet || {};

(function(tinymce, DynamicStylesheet) {
	if (DynamicStylesheet.tinymce) {
		tinymce.PluginManager.add('ttfobspgb_dynamic_stylesheet', function (editor, url) {
			editor.on('init', function () {
				DynamicStylesheet.tinymceInit(editor);
			});

			editor.addCommand('Obspgb_Reset_Dynamic_Stylesheet', function () {
				DynamicStylesheet.resetStylesheet();
			});
		});
	}
})(tinymce, ObspgbDynamicStylesheet);