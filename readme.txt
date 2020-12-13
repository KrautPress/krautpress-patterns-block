=== Patterns block ===
Contributors: FlorianBrinkmann
Requires at least: 5.6
Tested up to: 5.6
Stable tag: 1.0.0
Requires PHP: 7.3
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0

== Description ==

Plugin that adds a block with variations for the registered block patterns in your installation. With that, you can add block patterns directly from the block inserter or with the `/` command.

When inserting the *Patterns* block, you can select the pattern you want from a list of all patterns.

[Plugin development happens on GitHub](https://github.com/KrautPress/krautpress-patterns-block/)

= Filters =

The plugin has two filters:

`
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
`

`
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
`

== Installation ==

* Install plugin.
* Activate it.
* You should be able to add patterns directly from the inserter.

== Changelog ==

=== 0.1.0 ===

Initial release
