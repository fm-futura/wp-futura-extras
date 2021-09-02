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
      ],
    }
  )
);

config.entry = {
  'links-a-botones/index': path.resolve( process.cwd(), 'blocks/links-a-botones', 'index.js' ),
};

module.exports = config;
