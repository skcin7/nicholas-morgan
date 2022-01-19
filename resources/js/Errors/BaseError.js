class BaseError {
    /**
     * The message of this error is stored here.
     * A generic default one is hard-coded, which should be over-written when the Error object is created.
     *
     * @type {string}
     */
    message = 'An error has occurred.';

    /**
     * Create the new Error.
     *
     * @param message
     */
    constructor(message) {
        // If the message is not set at class instantiation, revert to a default message to be used.
        message = (typeof message !== 'undefined') ? message : 'An unknown error has occurred.';

        // Update the default message with the message to be used for the specific error.
        this.message = message;

        //this.name = "Error";
        //this.stack = <call stack>; // non-standard, but most environments support it
    }

    /**
     * Set the error message.
     *
     * @param message
     */
    setMessage(message) {
        this.message = message;
    }

    /**
     * Get the error message.
     *
     * @returns {string}
     */
    getMessage() {
        return this.message;
    }
}

export {BaseError};
