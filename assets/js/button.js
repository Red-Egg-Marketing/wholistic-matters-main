import { addFilter } from '@wordpress/hooks';
import { createHigherOrderComponent } from '@wordpress/compose';
import { Fragment } from '@wordpress/element';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, Notice } from '@wordpress/components';

const GENERIC = ['learn more','read more','click here','view more','download','download pdf','more','go'];

addFilter('blocks.registerBlockType', 'red-egg/button-a11y-attr', (settings, name) => {
	if (name !== 'core/button') return settings;
	settings.attributes = { ...settings.attributes, accessibleLabel: { type: 'string', default: '' } };
	return settings;
});

const withA11yLabel = createHigherOrderComponent((BlockEdit) => (props) => {
	if (props.name !== 'core/button') return <BlockEdit {...props} />;
	const { attributes, setAttributes } = props;
	const text = (attributes.text || '').replace(/<[^>]*>/g, '').trim();
	const needsLabel = GENERIC.includes(text.toLowerCase()) && !attributes.accessibleLabel;

	return (
		<Fragment>
			<BlockEdit {...props} />
			<InspectorControls>
				<PanelBody title="Accessibility" initialOpen={needsLabel}>
					{needsLabel && (
						<Notice status="warning" isDismissible={false}>
							“{text}” doesn’t say where this link goes. Either rename the button, or fill in the destination below.
						</Notice>
					)}
					<TextControl
						label="Link destination (for screen readers)"
						help='Just the destination — e.g. “the radish characterization report”. It’s read as “{button text}: {your text}”.'
						value={attributes.accessibleLabel || ''}
						onChange={(val) => setAttributes({ accessibleLabel: val })}
					/>
				</PanelBody>
			</InspectorControls>
		</Fragment>
	);
}, 'withA11yLabel');

addFilter('editor.BlockEdit', 'red-egg/button-a11y-field', withA11yLabel);