require.config({
    shim: {
        handlebars: {
            exports: 'Handlebars'
        }
    }
});

require(['Instinct'], function (Instinct) {
    Instinct.loadCreatures();
    setInterval(Instinct.loadCreatures, 5000);
});
