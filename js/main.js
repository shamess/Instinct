require(['Instinct'], function (Instinct) {
    Instinct.loadCreatures();
    setInterval(Instinct.loadCreatures, 5000);
});
