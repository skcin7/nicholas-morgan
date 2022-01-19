import {BaseComponent} from './BaseComponent';

class Mirror extends BaseComponent {
    //static componentName = 'Mirror';

    /**
     * Create a new Mirror.
     */
    constructor() {
        // super(self.componentName);
        super('Mirror');
        // this.init();
    }

    /**
     * Load the Mirror.
     */
    load() {
        super.loadBeginMessage();

        let component = this;
        // Create the event listener to mirror the page.
        $('body').on('click', '[data-action=MIRROR]', function(event) {
            event.preventDefault();

            // Toggle the page mirroring.
            component.toggleMirror();
        });

        super.loadEndMessage();
    }

    /**
     * Toggle whether or not the page is mirrored.
     */
    toggleMirror() {
        if($('body').hasClass('mirror')) {
            $('body').removeClass('mirror');
        }
        else {
            $('body').addClass('mirror');
        }
    }
}

export {Mirror};
