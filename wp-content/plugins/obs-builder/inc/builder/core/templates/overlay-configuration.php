<script type="text/html" id="tmpl-ttfobspgb-overlay-configuration">
<?php require( obspgb_get_plugin_directory() . '/inc/builder/core/templates/overlay-header.php' ); ?>
<?php require( obspgb_get_plugin_directory() . '/inc/builder/core/templates/overlay-footer.php' ); ?>
</div>
</script>

<script type="text/html" id="tmpl-ttfobspgb-settings-divider">
<span data-name="{{ data.name }}" class="{{ data.class }}">{{ data.label }}</span>
</script>

<script type="text/html" id="tmpl-ttfobspgb-settings-section_title">
<input placeholder="{{ data.label }}" type="text" value="" class="{{ data.class }}" autocomplete="off"">
</script>

<script type="text/html" id="tmpl-ttfobspgb-settings-select">
<label>{{ data.label }}</label>
<select class="{{ data.class }}" {{ data.disabled ? 'disabled' : '' }}>
	<# for( var o in data.options ) { #>
	<option value="{{ o }}">{{ data.options[o] }}</option>
	<# } #>
</select>
<# if ( data.description ) { #>
<div class="ttfobspgb-configuration-description">{{ data.description }}</div>
<# } #>
</script>

<script type="text/html" id="tmpl-ttfobspgb-settings-checkbox">
<label>{{ data.label }}</label>
<input type="checkbox" value="1" class="{{ data.class }}"<# if( data.disabled ) { #>{{ disabled="disabled" }}<# } #>>
<# if ( data.description ) { #>
<div class="ttfobspgb-configuration-description">{{{ data.description }}}</div>
<# } #>
</script>

<script type="text/html" id="tmpl-ttfobspgb-settings-text">
<label>{{ data.label }}</label>
<input type="text" value="" class="{{ data.class }}">
<# if ( data.description ) { #>
<div class="ttfobspgb-configuration-description">{{ data.description }}</div>
<# } #>
</script>

<script type="text/html" id="tmpl-ttfobspgb-settings-image">
<label>{{ data.label }}</label>
<div class="ttfobspgb-uploader">
	<div data-title="Set image" class="ttfobspgb-media-uploader-placeholder ttfobspgb-media-uploader-add {{ data.class }}"></div>
</div>
<# if ( data.description ) { #>
<div class="ttfobspgb-configuration-description">{{ data.description }}</div>
<# } #>
</script>

<script type="text/html" id="tmpl-ttfobspgb-settings-color">
<label>{{ data.label }}</label>
<input type="text" class="ttfobspgb-text-background-color ttfobspgb-configuration-color-picker {{ data.class }}" value="">
<# if ( data.description ) { #>
<div class="ttfobspgb-configuration-description">{{ data.description }}</div>
<# } #>
</script>

<script type="text/html" id="tmpl-ttfobspgb-settings-description">
<# if ( data.description ) { #>
<div class="ttfobspgb-configuration-description" style="margin-top: 0;">{{{ data.description }}}</div>
<# } #>
</script>

<script type="text/html" id="tmpl-ttfobspgb-media-frame-remove-image">
<div class="ttfobspgb-remove-current-image">
	<h3><?php esc_html_e( 'Current image', 'obspgb' ); ?></h3>
	<a href="#" class="ttfobspgb-media-frame-remove-image">
		<?php esc_html_e( 'Remove Current Image', 'obspgb' ); ?>
	</a>
</div>
</script>