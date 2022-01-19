import {BaseError} from './BaseError';

class InvalidValueError extends BaseError {
    name = "InvalidValueError";

    constructor(message) {
        // If the message is not set at class instantiation, revert to a default message to be used.
        message = (typeof message !== 'undefined') ? message : 'Invalid value error.';

        super(message);
        // this.name = "InvalidValueError";
    }
}

export {InvalidValueError};
