define(['handlebars'], function (Handlebars) {
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

            this.updateCreature(creature);

            return;
        }

        var creatureDom = $('<div>')
            .addClass('creature creature-spawning')
            .attr('id', 'creature' + creature.id)
            .css('left', (creature.x * 50) + "px")
            .css('top', (creature.y * 50) + "px")
            .css('background-color', "rgb(" + creature.color.r + "," + creature.color.g + "," + creature.color.b + ")")
            .data('dead', false)
            .data('rawData', creature)
            .click($.proxy(function (event) {
                this.displaySidebar($(event.target).data('rawData'));
            }, this));

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

    Instinct.updateCreature = function (creature) {
        var creatureDom = $('#creature' + creature.id);

        if (creature.x != creatureDom.data('rawData').x || creature.y != creatureDom.data('rawData').y) {
            creatureDom
                .animate({
                    left: (creature.x * 50) + "px",
                    top: (creature.y * 50) + "px"
                }, 500);
        }

        creatureDom.data('rawData', creature);
    };

    Instinct.displaySidebar = function (creatureData) {
        var creatureSidebarHtml = $('#sidebar-creature').text(),
            creatureSidebarTemplate = Handlebars.compile(creatureSidebarHtml);

        $('#sidebar')
            .html(creatureSidebarTemplate(creatureData))
            .show();
    };

    return Instinct;
});

