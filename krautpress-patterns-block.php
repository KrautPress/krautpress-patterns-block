<?php
/**
 * Plugin Name:     Patterns block
 * Description:     A block for faster inserting of block patterns.
 * Version:         1.0.0
 * Author:          Florian Brinkmann
 * License:         GPL-3.0-or-later
 * License URI:     https://www.gnu.org/licenses/gpl-3.0
 * Text Domain:     krautpress-patterns-block
 */

namespace KrautPress\PatternsBlock;

use WP_Block_Patterns_Registry;
use Error;

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Register script and style.
 */
add_action( 'init', function() {
    $script_asset_path = __DIR__ . '/build/index.asset.php';
    if ( ! file_exists( $script_asset_path ) ) {
        throw new Error(
            'You need to run `npm start` or `npm run build` first.'
        );
    }

	$script_asset = require( $script_asset_path );
    wp_register_script(
        'krautpress-patterns-block-editor',
        plugins_url( 'build/index.js', __FILE__ ),
        $script_asset['dependencies'],
        $script_asset['version']
	);
	
    wp_register_style(
        'krautpress-patterns-block-editor-style',
        plugins_url( 'build/index.css', __FILE__ ),
        [],
        $script_asset['version']
    );
} );

/**
 * Enqueue block script and style.
 */
add_action( 'enqueue_block_editor_assets', function() {
	wp_enqueue_script( 'krautpress-patterns-block-editor' );

	wp_enqueue_style( 'krautpress-patterns-block-editor-style' );

	// Get all patterns.
	$block_patterns = WP_Block_Patterns_Registry::get_instance()
		->get_all_registered();

	if ( empty( $block_patterns ) ) {
		return;
	}

	// Build variation array.
	$variation_data = [];

	/**
	 * Filter that allows to set a default variation.
	 * With that, the patterns block cannot be selected from the inserter,
	 * but only the variations.
	 * 
	 * @param string Name of the variation to use as default.
	 */
	$default_variation_name = (string) apply_filters(
		'krautpress_patterns_block_default_variation_name',
		''
	);

	foreach ( $block_patterns as $pattern ) {
		$variation_data[] = (object) [
			'name' => $pattern['name'],
			'title' => $pattern['title'],
			'isDefault' => $default_variation_name === $pattern['name'] ? true : false,
			'attributes' => (object) [
				'pattern' => $pattern['name'],
			],
		];
	}

	/**
	 * Filter the variations to show/use in the block.
	 * 
	 * @param array $variation_data {
	 * 		Array of variation data objects. Object looks like that:
	 * 		(object) [
	 * 			'name' => $pattern['name'], 
	 * 			'title' => $pattern['title'],
	 * 			'attributes' => (object) [
	 * 				'pattern' => $pattern['name'],
	 * 			],
	 * 		];
	 * 		
	 * 		$pattern['name'] must match the `name` of a pattern.
	 * 		$pattern['title'] is displayed to the user.
	 * }
	 */
	$variation_data = (array) apply_filters(
		'krautpress_patterns_block_variations_data',
		$variation_data
	);

	wp_localize_script(
		'krautpress-patterns-block-editor',
		'krautpressPatternsBlockVariationData',
		$variation_data
	);

	wp_localize_script(
		'krautpress-patterns-block-editor',
		'krautpressPatternsBlockStrings',
		[
			'title' => __( 'Patterns', 'krautpress-patterns-block' ),
			'variationPickerLabel' => __( 'Select pattern', 'krautpress-patterns-block' ),
			'variationPickerInstructions' => __( 'Choose the pattern you want to insert (it will replace this block).', 'krautpress-patterns-block' )
		]
	);
} );
