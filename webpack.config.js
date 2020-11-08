const Encore = require('@symfony/webpack-encore');
const Dotenv = require('dotenv-webpack')

Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    // uncomment to create hashed filenames (e.g. app.abc123.css)
    // .enableVersioning(Encore.isProduction())
    .enableSingleRuntimeChunk()
    .enableSassLoader()
    .enableSassLoader()

    // uncomment to define the assets of the project
    .addEntry('js/app', './src/js/index.js')

    .enableReactPreset()
    .autoProvidejQuery()

    .addPlugin(new Dotenv({path: './.env.local', systemvars: true}))
;

module.exports = Encore.getWebpackConfig();
