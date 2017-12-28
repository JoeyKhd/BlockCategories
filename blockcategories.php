<?php
/*
Plugin Name: Block Categories
Plugin URI: http://github.com/JoeyKhd/BlockCategories
description: Displays categories in a sleek block design.
Version: 1.0
Author: Joey Kheireddine
Author URI: ttp://github.com/JoeyKhd
*/

function createBlocks($attributes) {

	$a = shortcode_atts( array(
		'text-color' => '',
	), $attributes );

	$get_featured_cats = array(
		'taxonomy'   => 'product_cat',
		'orderby'    => 'name',
		'hide_empty' => '0',
		'include'    => $cat_array
	);
	$all_categories    = get_categories( $get_featured_cats );
	$j                 = 1;

	echo '<div class="container"><div class="row">';


	foreach ( $all_categories as $cat ) {

		$cat_id   = $cat->term_id;
		$cat_link = get_term_link( $cat_id, 'product_cat' );


		$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
		$image        = wp_get_attachment_url( $thumbnail_id );


		echo '<div class="col-xs-3">';
		echo '<a href="' . $cat_link .'"><div class="category-card">';

        if ($image){
        echo '<img src="' . $image . '"/>';
        } else if(!$image){
            echo '<img src="http://placehold.it/400x275"/>';
        }
        echo '<p style="color:' . $a['text-color'] . '">' . $cat->name;
        echo '</p></div></a></div>';

		$j ++;
	}

	echo '</div>';

	wp_reset_query();
	
}

add_shortcode( 'blockcategories', 'createBlocks' );

/**
 * Includes Bootstrap & its own CSS
 */
function load_css() {
	wp_register_style( 'blockcategories_bootstrap_css', plugin_dir_url( __FILE__ ) . 'css/bootstrap-grid.css' );
	wp_enqueue_style( 'blockcategories_bootstrap_css' );

	wp_register_style( 'blockcategories_css', plugin_dir_url( __FILE__ ) . 'css/blockcategories.css' );
	wp_enqueue_style( 'blockcategories_css' );
}

add_action( 'wp_enqueue_scripts', 'load_css' );

?>
