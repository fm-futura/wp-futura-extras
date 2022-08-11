import { registerPlugin } from '@wordpress/plugins';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { DatePicker, PanelRow, TextControl } from '@wordpress/components';
import { withSelect, withDispatch } from '@wordpress/data';
import { compose } from '@wordpress/compose';
import moment from 'moment';


const BannerPublicidadMetaboxBase = ({ postType, postMeta, setPostMeta }) => {
  if (postType !== 'banner-publicidad') {
    return null;
  }

  const today = moment().format('Y-MM-DDTHH:mm:ss');

  if (!postMeta.start_date) {
    setPostMeta({ start_date: today });
  }

  if (!postMeta.end_date) {
    setPostMeta({ end_date: today });
  }

  return (
    <PluginDocumentSettingPanel
      title="Datos del Banner"
      icon="dashicons-id-alt"
      opened="true"
    >

      <PanelRow>
        <TextControl
          label="Sitio web"
          value={postMeta.main_link}
          onChange={(value) => setPostMeta({ main_link: value })}
        />
      </PanelRow>

      <hr />
      Fecha Inicio
      <PanelRow>
        <DatePicker
          currentDate={postMeta.start_date || today}
          onChange={(value) => setPostMeta({ start_date: value })}
        />
      </PanelRow>

      <hr />
      Fecha finalización
      <PanelRow>
        <DatePicker
          currentDate={postMeta.end_date || today}
          onChange={(value) => setPostMeta({ end_date: value })}
        />
      </PanelRow>

    </PluginDocumentSettingPanel>
  );
};

const BannerPublicidadMetabox = compose([
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
])(BannerPublicidadMetaboxBase);

registerPlugin('banner-publicidad-metabox', {
  render() {
    return <BannerPublicidadMetabox />;
  },
});
