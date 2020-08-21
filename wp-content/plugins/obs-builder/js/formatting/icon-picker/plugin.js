/* global tinymce, ObspgbIconPicker */
var ObspgbIconPicker = ObspgbIconPicker || {};

(function(tinymce, picker) {
	tinymce.PluginManager.add('ttfobspgb_icon_picker', function (editor, url) {
		editor.addCommand('Obspgb_Icon_Picker', function () {
			picker.open(editor, function(value, unicode) {
				if ('undefined' !== unicode) {
					var icon = ' <span class="ttfobspgb-icon mceNonEditable fa">&#x' + unicode + ';</span> ';
					editor.insertContent(icon);
				}
			});
		});

		editor.addButton('ttfobspgb_icon_picker', {
			icon   : 'ttfobspgb-icon-picker',
			tooltip: 'Insert Icon',
			cmd    : 'Obspgb_Icon_Picker'
		});
	});
})(tinymce, ObspgbIconPicker);