# Patterns block

WordPress plugin that adds a block with variations for the registered block patterns in your installation. With that, you can add block patterns directly from the block inserter or with the `/` command.

When inserting the *Patterns* block, you can select the pattern you want from a list of all patterns.

## Filters

The plugin has two filters:

```php
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
```

```php
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
```
