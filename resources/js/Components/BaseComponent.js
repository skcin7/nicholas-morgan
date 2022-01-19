import {Console} from './Console';

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
        Console.log('Loading ' + this.getComponentName() + ' component...');
    }

    loadEndMessage() {
        // console.log('Loaded ' + this.getComponentName() + ' component.');
        Console.log('Loaded ' + this.getComponentName() + ' component.');
    }
}

export {BaseComponent};
