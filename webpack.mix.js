let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

module.exports = {
    resolve: {
        alias: {
            vue: '@vue/compat'
        },
    },
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader',
                options: {
                    compilerOptions: {
                        compatConfig: {
                            MODE: 2
                        }
                    }
                }
            }
        ]
    }
}

mix.js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .webpackConfig({
        output: {
            chunkFilename: 'js/chunks/[name].js?[chunkhash]',
            publicPath: '/',
        },
    })
    .vue({
        extractStyles: true,
        globalStyles: false
});
