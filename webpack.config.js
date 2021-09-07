const path = require( 'path' );
const CopyPlugin = require( 'copy-webpack-plugin' );

const config = require( '@wordpress/scripts/config/webpack.config.js' );


config.plugins.push(
  new CopyPlugin(
    {
      patterns: [
        {
          context: 'blocks',
          from: '*/block.json',
        },
        {
          context: 'blocks',
          from: '*/render.php',
          noErrorOnMissing: true,
        },
      ],
    }
  )
);

config.entry = {
  'links-a-botones/index': path.resolve( process.cwd(), 'blocks/links-a-botones', 'index.js' ),
  'red-socios-metabox/index': path.resolve( process.cwd(), 'blocks/red-socios-metabox', 'index.js' ),
  'red-socios-grilla-emprendimientos/index': path.resolve( process.cwd(), 'blocks/red-socios-grilla-emprendimientos', 'index.js' ),
};

module.exports = config;
