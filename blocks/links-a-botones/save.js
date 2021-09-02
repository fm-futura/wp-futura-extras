import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';

export default function save({ attributes }) {
  const props = useBlockProps.save();
  const parentClasses = props.className || '';
  const className = `futura-round-link-wrapper ${parentClasses}`;
  const style = {
    '--button-color': attributes.color,
    '--button-text-color': attributes.textColor,
  };

  return (
    <div {...{ ...props, className, style }}>
      <InnerBlocks.Content />
    </div>
  );
}
