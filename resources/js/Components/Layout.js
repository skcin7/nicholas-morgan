import {BaseComponent} from './BaseComponent';

class Layout extends BaseComponent {

    /**
     * Create a new BarrelRoll.
     */
    constructor() {
        super('Layout');
    }

    /**
     * Load the BarrelRoll.
     */
    load() {
        super.loadBeginMessage();

        // The scrolling behavior for the avatar in the header.
        $(document).on('scroll', function(event) {
            if($(this).scrollTop() > 76) {
                $('#avatar').css({
                    position: 'fixed',
                    top: '1rem'
                });
            }
            else {
                $('#avatar').css({
                    position: 'absolute',
                    top: '76px'
                });
            }
        });

        // $(document).scroll(function() {
        //     if($(this).scrollTop() > 76) {
        //         $('#avatar').css({
        //             position: 'fixed',
        //             top: '1rem'
        //         });
        //     }
        //     else {
        //         $('#avatar').css({
        //             position: 'absolute',
        //             top: '76px'
        //         });
        //     }
        // });
    }
}

export {Layout};
