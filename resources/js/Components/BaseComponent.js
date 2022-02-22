import {Console} from './ConsoleComponent';

class BaseComponent {
    componentName = '';

    constructor(componentName) {
        this.componentName = componentName;
    }

    setComponentName(componentName) {
        this.componentName = componentName;
    }

    getComponentName() {
        return this.componentName;
    }

    loadBeginMessage() {
        // console.log('Loading ' + this.getComponentName() + ' component...');
        Console.log('Loading Component: ' + this.getComponentName());
    }

    loadEndMessage() {
        // console.log('Loaded ' + this.getComponentName() + ' component.');
        Console.log('Loaded Component: ' + this.getComponentName());
    }
}

export {BaseComponent};
