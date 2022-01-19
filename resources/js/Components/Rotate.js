import {BaseComponent} from './BaseComponent';

class Rotate extends BaseComponent {
    /**
     * The current rotation amount in degrees (it only increments in 90 degree amounts).
     *
     * @type {string}
     */
    currentRotationAmount = '0';

    /**
     * Create a new Rotate.
     */
    constructor() {
        super('Rotate');
    }

    /**
     * Load the Rotate.
     */
    load() {
        super.loadBeginMessage();

        let component = this;
        // Create the event listener to rotate the page.
        $('body').on('click', '[data-action=ROTATE]', function(event) {
            event.preventDefault();

            // Rotate the page.
            component.rotatePage();
        });

        super.loadEndMessage();
    }

    /**
     * Rotate the page.
     */
    rotatePage() {
        if(this.currentRotationAmount === '0') {
            this.currentRotationAmount = '90';
        }
        else if(this.currentRotationAmount === '90') {
            this.currentRotationAmount = '180';
        }
        else if(this.currentRotationAmount === '180') {
            this.currentRotationAmount = '270';
        }
        else {
            this.currentRotationAmount = '0';
        }

        $('body').removeClass('rotate_0 rotate_90 rotate_180 rotate_270');
        $('body').addClass('rotate_' + this.currentRotationAmount);
    };
}

export {Rotate};
