import { registerPlugin } from '@wordpress/plugins';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { PanelRow, TextControl } from '@wordpress/components';
import { withSelect, withDispatch } from '@wordpress/data';
import { compose } from '@wordpress/compose';

const RedSociosMetaboxBase = ({ postType, postMeta, setPostMeta }) => {
  if (postType !== 'emprendimiento-red') {
    return null;
  }

  return (
    <PluginDocumentSettingPanel
      title="Datos del Emprendimiento"
      icon="dashicons-id-alt"
      initialOpen="true"
    >
      <PanelRow>
        <TextControl
          label="Sitio web"
          value={postMeta.main_link}
          onChange={(value) => setPostMeta({ main_link: value })}
        />
      </PanelRow>
    </PluginDocumentSettingPanel>
  );
};

const RedSociosMetabox = compose([
  withSelect((select) => {
    return {
      postMeta: select('core/editor').getEditedPostAttribute('meta'),
      postType: select('core/editor').getCurrentPostType(),
    };
  }),
  withDispatch((dispatch) => {
    return {
      setPostMeta(meta) {
        dispatch('core/editor').editPost({ meta });
      },
    };
  }),
])(RedSociosMetaboxBase);

registerPlugin('red-socios-metabox', {
  render() {
    return <RedSociosMetabox />;
  },
});
