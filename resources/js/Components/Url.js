import {BaseComponent} from './BaseComponent';

class Url extends BaseComponent {
    /**
     * The full hyperlink reference (href), unparsed, which is the full URL.
     *
     * @type {string}
     */
    href = '';

    /**
     * The hyperlink reference (href) individual parts, which together added up make up the full URL.
     * As defined at: https://dmitripavlutin.com/parse-url-javascript/
     *
     * • protocol - The protocol that the URL is using. Should be only 'http:' or 'https:'.
     * • username - The username in the URL. This will most likely always remain blank.
     * • password - The password in the URL. This will most likely always remain blank.
     * • hostname - The hostname in the URL. This is the 'website.com' part, and should be filled in upon component instantiation.
     * • port - The port in the URL. This will most likely always remain blank, and defaults to port 80.
     * • pathname - The full path name taken from the URL. This is the '/pa/th/2' part that comes after the hostname and port, and begins with a '/'.
     * • querystring - The query string taken from the URL. This is the '?q=val&r=val2' part that comes after the pathname, and begins with a '?'.
     * • querystringVars - The query string broken down into individual key/value pieces for each variable in the query string.
     * • hash - The hash taken from the URL. This is the '#hash' part that comes after the query string (if present), and begins with a '#'.
     *
     * @type {{protocol: string}}
     */
    hrefParts = {
        'protocol': '',
        'username': '',
        'password': '',
        'hostname': '',
        'port': '',
        'pathname': '',
        'querystring': '',
        'querystringVars': [],
        'hash': '',
    };

    /**
     * Create a new Url component.
     */
    constructor(url) {
        super('Url');

        // Set the hyperlink reference (href), which is the full unparsed URL.
        this.href = url;
        // this.setHref(url);

        this.parseHref();

        // this.load();
    }

    /**
     * Initialize the Console.
     */
    load() {
        super.loadBeginMessage();

        //

        super.loadEndMessage();
    }

    setHref(href) {
        this.href = href;
    }

    getHref() {
        return this.href;
    }

    /**
     * Parse the href to get all of the individual href parts.
     */
    parseHref() {
        // let url = new URL(this.href);
        //
        // this.hrefParts.hostname = url.hostname;
        // this.hrefParts.pathname = url.pathname;
        // this.hrefParts.querystring = url.search;
        // this.hrefParts.hash = url.hash;
    }

    getQueryStringParam(queryStringParam) {
        const url = new URL(this.href);

        return url.searchParams.get(queryStringParam);
    }
}

export {Url};
