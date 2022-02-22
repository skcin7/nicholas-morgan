import {BaseComponent} from './BaseComponent';

class KeyboardComponent extends BaseComponent {
    /**
     * Keep track of the keys that are pressed.
     * 
     * @type {{}}
     */
    pressedKeys = {};

    /**
     * Create a new KeyboardComponent.
     */
    constructor() {
        super('KeyboardComponent');
    }

    load() {
        super.loadBeginMessage();

        let keyboardComponent = this;

        $(document).on('keyup', function(event) {
            keyboardComponent.pressedKeys[event.key] = false;
            console.log('keyup: ' + event.key);
        });

        $(document).on('keydown', function(event) {
            keyboardComponent.pressedKeys[event.key] = true;
            console.log('keydown: ' + event.key);
        });

        super.loadEndMessage();
    }

    /**
     * Determine if a key is currently pressed.
     *
     * @param key
     * @returns {*}
     */
    isKeyPressed(key) {
        return this.pressedKeys[key];
    }


}

export {KeyboardComponent};
