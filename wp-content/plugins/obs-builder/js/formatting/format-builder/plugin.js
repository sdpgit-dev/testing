/* global tinymce, jQuery, ObspgbFormatBuilder */
var ObspgbFormatBuilder = ObspgbFormatBuilder || {};

(function(tinymce, $, builder) {
	tinymce.PluginManager.add('ttfobspgb_format_builder', function (editor, url) {
		editor.addCommand('Obspgb_Format_Builder', function () {
			builder.open(editor);
		});

		editor.addButton('ttfobspgb_format_builder', {
			icon   : 'ttfobspgb-format-builder',
			tooltip: 'Format Builder',
			cmd    : 'Obspgb_Format_Builder'
		});

		editor.on('init', function () {
			$.each(builder.definitions, function (name, defs) {
				editor.formatter.register(name, defs);
			});
		});
	});
})(tinymce, jQuery, ObspgbFormatBuilder);