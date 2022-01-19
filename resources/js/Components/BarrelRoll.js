import {BaseComponent} from './BaseComponent';

class BarrelRoll extends BaseComponent {
    /**
     * The class name added to the body tag when a barrel roll is being performed.
     *
     * @param {string}
     */
    barrelRollClassName = 'brb_doing_a_barrel_roll_lol';

    /**
     * The class name added to the body tag when a reverse barrel roll is being performed.
     *
     * @param {string}
     */
    reverseBarrelRollClassName = 'brb_now_im_doing_a_reverse_barrel_roll_lol';

    /**
     * Create a new BarrelRoll.
     */
    constructor() {
        super('BarrelRoll');
    }

    /**
     * Load the BarrelRoll.
     */
    load() {
        super.loadBeginMessage();

        let component = this;
        // Create the event listener for the barrel roll.
        $('body').on('click', '[data-action=BARREL_ROLL]', function(event) {
            event.preventDefault();
            component.performBarrelRoll("FORWARD");
        });

        // Create the event listener for the reverse barrel roll.
        $('body').on('click', '[data-action=BARREL_ROLL_REVERSE]', function(event) {
            event.preventDefault();
            component.performBarrelRoll("REVERSE");
        });

        super.loadEndMessage();
    }

    /**
     * Perform the barrel roll.
     */
    performBarrelRoll(direction) {

        // Make sure direction is valid, or revert to a forward barrel roll if not.
        direction = (direction == 'FORWARD' || direction == 'REVERSE') ? direction : 'FORWARD';

        // Perform a forward barrel roll.
        if(direction === "FORWARD") {
            if(! $('body').hasClass(this.barrelRollClassName)) {
                $('body').addClass(this.barrelRollClassName);

                $('body').one("animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd", function() {
                    $('body').removeClass(this.barrelRollClassName);
                });
            }
            return;
        }

        // Perform a reverse barrel roll.
        if(direction === "REVERSE") {
            if(! $('body').hasClass(this.reverseBarrelRollClassName)) {
                $('body').addClass(this.reverseBarrelRollClassName);

                $('body').one("animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd", function() {
                    $('body').removeClass(this.reverseBarrelRollClassName);
                });
            }
            return;
        }
    };
}

export {BarrelRoll};
