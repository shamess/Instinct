var requirejs = require('requirejs');

requirejs.config({
    baseUrl: __dirname + '/../'
});

var eventListener = requirejs('EventListener');

exports.testCanBindEvent = function(test) {
    test.expect(2);

    eventListener.bind('testPing', function () {
        test.ok(true);
    });

    eventListener.bind('testPong', function () {
        test.ok(true);

        test.done();
    });

    eventListener.trigger('testPing');
    eventListener.trigger('testPong');
};

exports.testIsSingleton = function(test) {
    test.expect(1);

    eventListener.bind('blimp', function () {
        test.ok(true);

        test.done();
    });

    var secondEventListener = requirejs('EventListener');

    secondEventListener.trigger('blimp');
};

exports.testPassesThroughArguments = function (test) {
    test.expect(2);

    eventListener.bind('passargs', function (a, b) {
        test.equals('foo', a);
        test.equals('bar', b);

        test.done();
    });

    eventListener.trigger('passargs', 'foo', 'bar');
};
