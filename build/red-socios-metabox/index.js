!function(){"use strict";var e=window.wp.element,t=window.wp.plugins,o=window.wp.editPost,n=window.wp.components,i=window.wp.data;const l=(0,window.wp.compose.compose)([(0,i.withSelect)((e=>({postMeta:e("core/editor").getEditedPostAttribute("meta"),postType:e("core/editor").getCurrentPostType()}))),(0,i.withDispatch)((e=>({setPostMeta(t){e("core/editor").editPost({meta:t})}})))])((({postType:t,postMeta:i,setPostMeta:l})=>"emprendimiento-red"!==t?null:(0,e.createElement)(o.PluginDocumentSettingPanel,{title:"Datos del Emprendimiento",icon:"dashicons-id-alt",initialOpen:"true"},(0,e.createElement)(n.PanelRow,null,(0,e.createElement)(n.TextControl,{label:"Sitio web",value:i.main_link,onChange:e=>l({main_link:e})})))));(0,t.registerPlugin)("red-socios-metabox",{render:()=>(0,e.createElement)(l,null)})}();