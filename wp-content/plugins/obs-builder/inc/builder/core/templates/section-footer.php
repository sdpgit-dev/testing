<?php
/**
 * @package Obspgb Builder
 */
?>

	<textarea name="ttfobspgb-section-json-{{ data.get('id') }}" class="ttfobspgb-section-json" style="display: none;">{{ JSON.stringify( data.toJSON() ) }}</textarea>
</div>