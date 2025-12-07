const mix = require('laravel-mix');
const CopyWebpackPlugin = require('copy-webpack-plugin');

mix
  .js('resources/js/app.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css')
  .options({
    processCssUrls: false // важно для Font Awesome и изображений в SCSS
  })
  .webpackConfig({
    plugins: [
      new CopyWebpackPlugin({
        patterns: [
          {
            from: 'node_modules/@fortawesome/fontawesome-free/webfonts',
            to: 'fonts/fontawesome/[name].[ext]'
          }
        ]
      })
    ]
  })
  .version(); // для кэширования