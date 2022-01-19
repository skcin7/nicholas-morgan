import {BaseComponent} from './BaseComponent';
import {InvalidValueError} from '../Errors/InvalidValueError';

class Console extends BaseComponent {
    /**
     * The log level being used for writing messages to the log.
     *
     * @type {string}
     */
    static loggingLevel = 'DEBUG';

    /**
     * An array containing all the valid logging level names.
     * Not currently being used, but kept here anyway for posterity.
     *
     * @type {string[]}
     */
    //allLoggingLevelsArray = ['DEBUG', 'INFO', 'NOTICE', 'WARNING', 'ERROR', 'CRITICAL', 'ALERT', 'EMERGENCY'];

    /**
     * Specify all the valid logging levels here.
     * The logger provides the eight logging levels, which are defined in the RFC 5424 specification: https://datatracker.ietf.org/doc/html/rfc5424
     * DEBUG, INFO, NOTICE, WARNING, ERROR, CRITICAL, ALERT, and EMERGENCY
     *
     * @type {object[]}
     */
    static allLoggingLevels = [{
        'name': 'DEBUG',
        'levelValue': 1,
        'css': 'background: #222; color: #3a91cf;',
    }, {
        'name': 'INFO',
        'levelValue': 2,
        'css': 'background: #222; color: #bada55;',
    }, {
        'name': 'NOTICE',
        'levelValue': 3,
        'css': 'background: #222; color: #bada55;',
    }, {
        'name': 'WARNING',
        'levelValue': 4,
        'css': 'background: #222; color: #bada55;',
    }, {
        'name': 'ERROR',
        'levelValue': 5,
        'css': 'background: #222; color: #bada55;',
    }, {
        'name': 'CRITICAL',
        'levelValue': 6,
        'css': 'background: #222; color: #bada55;',
    }, {
        'name': 'ALERT',
        'levelValue': 7,
        'css': 'background: #222; color: #bada55;',
    }, {
        'name': 'EMERGENCY',
        'levelValue': 8,
        'css': 'background: #222; color: #bada55;',
    }];

    /**
     * Create a new Console object.
     */
    constructor(loggingLevel) {
        super('Console');
        // super(self.componentName);

        // Set the logging level. If none was specified, revert to the 'DEBUG' default.
        // loggingLevel = (typeof loggingLevel !== 'undefined') ? loggingLevel : 'DEBUG';
        // this.loggingLevel = loggingLevel;

        // console.log('Logging level set to ' + loggingLevel);

        // this.init();
    }

    // /**
    //  * Initialize the Console.
    //  */
    // load() {
    //     super.loadBeginMessage();
    //
    //     this.setLoggingLevel('DEBUG');
    //
    //     super.loadEndMessage();
    // }

    // /**
    //  * Set the logging level.
    //  *
    //  * @param newLoggingLevel
    //  */
    // setLoggingLevel(newLoggingLevel) {
    //     // First check to ensure the verbosity level being set is one of the valid verbosity level values.
    //     // If it's invalid, then output a message to the log explaining this, and exit.
    //     // if(! this.allLoggingLevels.includes(newLoggingLevel)) {
    //     //     console.error('The logging level ' + newLoggingLevel + ' is not valid.');
    //     //     return;
    //     // }
    //
    //     let newLoggingLevelIsValid = false;
    //     for(let i = 0; i < this.allLoggingLevels.length; i++) {
    //         if(this.allLoggingLevels[i].name === newLoggingLevel) {
    //             newLoggingLevelIsValid = true;
    //         }
    //     }
    //
    //     if(! newLoggingLevelIsValid) {
    //         console.error('The logging level ' + newLoggingLevel + ' is not valid.');
    //         return;
    //     }
    //
    //     this.loggingLevel = newLoggingLevel;
    // }

    /**
     * Get the details for the current logging level.
     *
     * @returns {Object}
     */
    static getLoggingLevelDetails(loggingLevel) {
        // Determine the logging level to get details for.
        // Use the function input parameter, but if none was specified, then use the current one set.
        loggingLevel = (typeof loggingLevel !== 'undefined') ? loggingLevel : Console.loggingLevel;

        // Loop through all the logging levels.
        // When one is found that matches the current logging level name, return the entire logging level object.
        for(let i = 0; i < Console.allLoggingLevels.length; i++) {
            if(Console.allLoggingLevels[i].name === Console.loggingLevel) {
                return Console.allLoggingLevels[i];
            }
        }

        //throw 'Could not get logging level details for ' + this.loggingLevel + ' logging level.';
        throw new InvalidValueError('Could not get logging level details for ' + this.loggingLevel + ' logging level.');
    }

    /**
     * Send a message to the log.
     *
     * @param logMessage
     * @param loggingLevel
     */
    static log(logMessage, loggingLevel) {
        // Determine the logging level to be used for output.
        // If no logging level is specified, revert to the current logging level of this object.
        //loggingLevel = (typeof loggingLevel !== 'undefined') ? loggingLevel : this.loggingLevel;

        // console.log(logMessage);
        // return;

        try {
            let loggingLevelDetails = Console.getLoggingLevelDetails(loggingLevel);

            console.log('%c' + logMessage, loggingLevelDetails.css);
        }
        catch(ex) {
            console.error(ex);
        }
    }

    /**
     * Send an error message to the log using the default 'console.log()' behavior.
     *
     * @param message
     */
    out(message) {
        console.log(message);
    }

    /**
     * Send an error message to the log using the default 'console.error()' behavior.
     *
     * @param errorText
     */
    error(errorText) {
        console.error(errorText);
    }
}

export {Console};
