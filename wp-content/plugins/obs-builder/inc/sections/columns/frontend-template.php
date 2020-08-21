<?php
/**
 * @package Obspgb Builder
 */
echo '<section id="'.ttfobspgb_get_section_html_id().'" class="'.esc_attr( ttfobspgb_get_section_html_class() ).'" style="'.esc_attr( ttfobspgb_get_section_html_style() ).'">';
	$title = ttfobspgb_get_section_field( 'title' );
    $columns_container = ttfobspgb_get_section_field( 'columns-container' );
    echo $columns_container == 'yes' ? '<div class="builder-container">' : '';
	if ( '' !== $title ) : 
    echo '<h3 class="builder-text-section-title">';
        echo apply_filters( 'the_title', $title ); 
    echo '</h3>';
    endif;
    echo '<div class="builder-section-content">';
        $columns = ttfobspgb_get_section_field( 'columns' );
        $columns_number = intval( ttfobspgb_get_section_field( 'columns-number' ) );
        
        $rows = array_chunk( $columns, $columns_number );
        foreach( $rows as $r => $row ) : 
            
			echo '<div class="builder-text-row">';
			foreach( $row as $i => $column ):
				echo '<div class="builder-text-column builder-text-column-'.(( $r * $columns_number ) + $i + 1).'" id="'.esc_attr( ttfobspgb_get_section_html_id() ).'-column-'.($i + 1).'">';
					echo '<div class="builder-text-content">';
						/**
						 * Filters the output of the column content.
						 *
						 * @since 1.0.0.
						 *
						 * @param string   $content      The column content.
						 * @param array    $column       The column item data.
						 *
						 * @return string                The filtered content.
						 */
						echo apply_filters( 'obspgb_filter_column_content', ttfobspgb_get_content( $column['content'] ), $column );
					echo '</div>';
	            echo '</div>';
			endforeach;
			echo '</div>';
    	endforeach;
    echo '</div>';
    echo $columns_container == 'yes' ? '</div>' : '';
    if ( absint( ttfobspgb_get_section_field( 'darken' ) ) ) :
        echo '<div class="builder-section-overlay"></div>';
	endif;
echo '</section>';