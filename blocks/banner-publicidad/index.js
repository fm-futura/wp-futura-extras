import { registerBlockType } from '@wordpress/blocks';
import ServerSideRender from '@wordpress/server-side-render';
import { useBlockProps } from '@wordpress/block-editor';
import './style.scss';



const BLOCK_NAME = 'futura/banner-publicidad'



const Edit = (props) => {
  const blockProps = useBlockProps();
  return (
    <div { ...blockProps }>
      <ServerSideRender
        block={ BLOCK_NAME }
        attributes={ props.attributes }
      />
    </div>
  );
};


registerBlockType(BLOCK_NAME, {
  apiVersion: 2,
  edit: Edit,
});
