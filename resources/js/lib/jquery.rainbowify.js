(function($) {

    let current_color = {
        "red": 255,
        "green": 0,
        "blue": 0,
    };

    getHexColor = function() {
        let hex_color = "#";
        hex_color += current_color.red.toString(16).padStart(2, '0');
        hex_color += current_color.green.toString(16).padStart(2, '0');
        hex_color += current_color.blue.toString(16).padStart(2, '0');
        return hex_color;
    };

    $.fn.rainbowify = function() {

        // this.each(function() {
        //     let $element = $(this);
        //     // $element.append( " (" + link.attr( "href" ) + ")" );
        //     // $element.css("background-color", getHexColor());
        //     // $element.css("background-color", "\"" + getHexColor() + "\"");
        //     $element.attr("style", "background-color: " + getHexColor() + ";");
        // });

        let that = this;

        window.setInterval(function() {
            /// call your function here

            // It must cycle through the rainbow:
            // ff0000 red
            // ffff00 yellow
            // 00ff00 green
            // 00ffff cyan
            // 0000ff blue
            // ff00ff purple

            // if(current_color.red < 255) {
            //     current_color.red = current_color.red + 1;
            // }
            // else if(current_color.green < 255) {
            //     current_color.green = current_color.green + 1;
            // }
            // else if(current_color.blue < 255) {
            //     current_color.blue = current_color.blue + 1;
            // }

            that.each(function() {
                let $element = $(this);
                // $element.append( " (" + link.attr( "href" ) + ")" );
                // $element.css("background-color", getHexColor());
                // $element.css("background-color", "\"" + getHexColor() + "\"");
                $element.attr("style", "background-color: " + getHexColor() + ";");
            });
        }, 10);

        return that;

    };

}(jQuery));
