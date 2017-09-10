let Encore = require("@symfony/webpack-encore");

Encore
    .setOutputPath("public/build/")
    .setPublicPath("/build")
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    // .enableVersioning(Encore.isProduction())
    .autoProvidejQuery()
    .addEntry("js/app", "./assets/js/app.js")
    .addEntry("js/request", "./assets/js/request.js")
    .addStyleEntry("css/app", "./assets/css/app.scss")
    .enableSassLoader()
    .enablePostCssLoader()
;

module.exports = Encore.getWebpackConfig();