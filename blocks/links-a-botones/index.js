import { registerBlockType } from '@wordpress/blocks';
import './style.scss';

import Edit from './edit';
import save from './save';

registerBlockType('futura/links-a-botones', {
  edit: Edit,
  save,
  attributes: {
    color: {
      type: 'string',
      default: '#f6aec5',
    },
    textColor: {
      type: 'string',
      default: '#222222',
    },
  },
});
