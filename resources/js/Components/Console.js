import {BaseComponent} from './BaseComponent';
import {InvalidValueError} from '../Errors/InvalidValueError';

class Console {
    /**
     * Log a message to the console.
     *
     * @param message
     * @param logLevel
     */
    static log(message, logLevel) {
        logLevel = (typeof logLevel !== 'undefined') ? logLevel : '';

        switch(logLevel) {
            case 'debug':
                Console.debug(message);
                break;
            case 'info':
                Console.info(message);
                break;
            case 'warn':
                Console.warn(message);
                break;
            case 'error':
                Console.error(message);
                break;
            case '':
            default:
                //console.log(message)
                console.log('%c' + message, 'color: #626262; font-weight: bold; font-size: 14px;');
                break;
        }
    }

    /**
     * Log a debug message to the console.
     *
     * @param message
     */
    static debug(message) {
        console.debug('%c' + message, 'color: #626262; font-weight: bold; font-size: 14px; background-color: #c8c8c8; padding: 2px 6px;');
    }

    /**
     * Log an info message to the console.
     *
     * @param message
     */
    static info(message) {
        console.info('%c' + message, 'color: #1a74be; font-weight: bold; font-size: 14px; background-color: #dcedfa; padding: 2px 6px;');
    }

    /**
     * Log a warning message to the console.
     *
     * @param message
     */
    static warn(message) {
        console.warn('%c' + message, 'color: #978800; font-weight: bold; font-size: 14px; background-color: #f5f0bd; padding: 2px 6px;');
    }

    /**
     * Log an error message to the console.
     *
     * @param message
     */
    static error(message) {
        console.error('%c' + message, 'color: #ae1c17; font-weight: bold; font-size: 14px; background-color: #f5b8b6; padding: 2px 6px;');
    }

    /**
     * Log a huge message to the console.
     *
     * @param message
     */
    static huge(message) {
        console.log('%c' + message, `
            background: white;
            border: 3px solid #0066cc;
            color: #0066cc;
            font-size: 32px;
            padding: 5px 10px;
        `);
    }

    /**
     * Log a custom styled message to the console.
     *
     * @param message
     */
    static custom(message) {
        let spacing = '5px';
        let styles =
            `padding: ${spacing}; background-color: darkblue; color: white; font-style:
         italic; border: ${spacing} solid crimson; font-size: 2em;`;
        console.log('%c' + message, styles);
    }
}

export {Console};
