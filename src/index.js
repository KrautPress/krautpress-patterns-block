/* global krautpressBlockPatterns */
// WordPress dependencies.
import {
	registerBlockType,
} from '@wordpress/blocks';
import {
	__experimentalBlockVariationPicker,
} from '@wordpress/block-editor';

// Editor stylesheet.
import './index.css';

registerBlockType( 'krautpress/patterns', {
	title: krautpressPatternsBlockStrings.title,
	category: 'layout',
	attributes: {
		pattern: {
			type: 'string',
			default: '',
		}
	},
	variations: krautpressPatternsBlockVariationData,
	edit: ( props )  => {
		const {
			attributes: {
				pattern
			}
		} = props;
		
		function replaceBlockWithPattern( patternName, clientId ) {
			// Get all block patterns.
			const { __experimentalBlockPatterns } = wp.data.select( 'core/block-editor' ).getSettings();
			
			// Get block pattern object.
			const blockPattern = __experimentalBlockPatterns.find( blockPattern => blockPattern.name === patternName );
		
			// Parse blocks.
			const blocks = wp.blocks.parse( blockPattern.content );
		
			// Replace current block with blocks from pattern.
			wp.data.dispatch( 'core/block-editor' ).replaceBlock( clientId, blocks );
		}

		if ( pattern !== '' ) {
			replaceBlockWithPattern( pattern, props.clientId );
		}

		return (
			<div>
				<__experimentalBlockVariationPicker
					label={ krautpressPatternsBlockStrings.variationPickerLabel }
					instructions={ krautpressPatternsBlockStrings.variationPickerInstructions }
					variations={ krautpressPatternsBlockVariationData }
					onSelect={ ( variation ) => {
						replaceBlockWithPattern( variation.name, props.clientId );
					} }
				/>
			</div>
		)
	}
} );
