import {
  InnerBlocks,
  ColorPalette,
  InspectorControls,
  useBlockProps,
} from '@wordpress/block-editor';

import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
  const props = useBlockProps();
  const parentClasses = props.className || '';
  const className = `futura-round-link-wrapper ${parentClasses}`;
  const style = {
    '--button-color': attributes.color,
    '--button-text-color': attributes.textColor,
  };

  return (
    <div className="wp-block-futura-button-links-editor">
      <InspectorControls key="setting">
        <div>
          <fieldset>
            <legend className="blocks-base-control__label">
              Color de los botones
            </legend>
            <ColorPalette
              value={attributes.color}
              onChange={(color) => setAttributes({ color })}
            />
          </fieldset>
          <fieldset>
            <legend className="blocks-base-control__label">
              Color del texto en los botones
            </legend>
            <ColorPalette
              value={attributes.textColor}
              onChange={(textColor) => setAttributes({ textColor })}
            />
          </fieldset>
        </div>
      </InspectorControls>

      <div {...{ ...props, className, style }}>
        <InnerBlocks />
      </div>
    </div>
  );
}
