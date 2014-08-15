define(function () {
    "use strict";

    var eventListener = function () {
        var events = {},
            bind,
            trigger;

        bind = function (eventName, callback) {
            if (typeof events[eventName] !== "object") {
                events[eventName] = [];
            }

            events[eventName].push(callback);
        };

        trigger = function (eventName) {
            var args = Array.prototype.slice.call(arguments, 0);

            if (typeof events[eventName] !== "object") {
                return;
            }

            for (var i = 0; i < events[eventName].length; i++) {
                events[eventName][i].apply(null, args.slice(1));
            }
        };

        return {
            trigger: trigger,
            bind: bind
        };
    }();

    return eventListener;
});
