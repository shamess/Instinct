define([], function () {
    var Instinct = {};

    Instinct.drawCreatures = function (creatures) {
        $('.creature').data('dead', true);

        creatures.forEach(function(creature) {
            this.drawCreature(creature);
        }, this);

        $('.creature')
            .filter(function () {
                return $(this).data('dead');
            })
            .removeClass('creature-dancing')
            .addClass('creature-dying');

        setTimeout(function () {
            $('.creature-dying').remove();
        }, 501);
    };

    Instinct.drawCreature = function (creature) {
        if ($('#creature' + creature.id).length) {
            $('#creature' + creature.id).data('dead', false);

            return;
        }

        var creatureDom = $('<div>')
            .addClass('creature creature-spawning')
            .attr('id', 'creature' + creature.id)
            .css('left', (creature.x * 50) + "px")
            .css('top', (creature.y * 50) + "px")
            .css('background-color', "rgb(" + creature.color.r + "," + creature.color.g + "," + creature.color.b + ")")
            .data('dead', false);

        $('.canvas').append(creatureDom);
        setTimeout(function () {
            creatureDom
                .removeClass('creature-spawning')
                .addClass('creature-dancing');
        }, 501);
    };

    Instinct.loadCreatures = function () {
        $.ajax({
            url: 'creature-positions.php',
            success: Instinct.drawCreatures,
            dataType: 'json',
            context: Instinct
        });
    };

    return Instinct;
});

