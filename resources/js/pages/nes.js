;(function(app, $, jsnes, undefined) {
    app.appPages.push({
        pageName: 'nes',

        SCREEN_WIDTH: 256,
        SCREEN_HEIGHT: 240,
        FRAMEBUFFER_SIZE: this.SCREEN_WIDTH * this.SCREEN_HEIGHT,

        canvas_ctx: null,
        image: null,

        framebuffer_u8: null,
        framebuffer_u32: null,

        AUDIO_BUFFERING: 512,
        SAMPLE_COUNT: 4*1024,
        SAMPLE_MASK: this.SAMPLE_COUNT - 1,
        audio_samples_L: new Float32Array(this.SAMPLE_COUNT),
        audio_samples_R: new Float32Array(this.SAMPLE_COUNT),
        audio_write_cursor: 0,
        audio_read_cursor: 0,

        nes: new jsnes.NES({
            onFrame: function(framebuffer_24) {
                for(let i = 0; i < this.FRAMEBUFFER_SIZE; i++) {
                    this.framebuffer_u32[i] = 0xFF000000 | framebuffer_24[i];
                }
            },
            onAudioSample: function(l, r) {
                this.audio_samples_L[this.audio_write_cursor] = l;
                this.audio_samples_R[this.audio_write_cursor] = r;
                this.audio_write_cursor = (this.audio_write_cursor + 1) & this.SAMPLE_MASK;
            },
        }),

        onAnimationFrame: function() {
            window.requestAnimationFrame(onAnimationFrame);

            this.image.data.set(this.framebuffer_u8);
            this.canvas_ctx.putImageData(this.image, 0, 0);
            this.nes.frame();
        },

        audio_remain: function() {
            return (this.audio_write_cursor - this.audio_read_cursor) & this.SAMPLE_MASK;
        },

        audio_callback: function(event) {
            let dst = event.outputBuffer;
            let len = dst.length;

            // Attempt to avoid buffer underruns.
            if(this.audio_remain() < this.AUDIO_BUFFERING) {
                this.nes.frame();
            }

            let dst_l = dst.getChannelData(0);
            let dst_r = dst.getChannelData(1);
            for(let i = 0; i < len; i++) {
                let src_idx = (this.audio_read_cursor + i) & this.SAMPLE_MASK;
                dst_l[i] = this.audio_samples_L[src_idx];
                dst_r[i] = this.audio_samples_R[src_idx];
            }

            this.audio_read_cursor = (this.audio_read_cursor + len) & this.SAMPLE_MASK;
        },

        keyboard: function(callback, event) {
            let player = 1;
            switch(event.keyCode){
                case 38: // UP
                    callback(player, jsnes.Controller.BUTTON_UP);
                    break;
                case 40: // Down
                    callback(player, jsnes.Controller.BUTTON_DOWN);
                    break;
                case 37: // Left
                    callback(player, jsnes.Controller.BUTTON_LEFT);
                    break;
                case 39: // Right
                    callback(player, jsnes.Controller.BUTTON_RIGHT);
                    break;
                case 65: // 'a' - qwerty, dvorak
                case 81: // 'q' - azerty
                    callback(player, jsnes.Controller.BUTTON_A);
                    break;
                case 83: // 's' - qwerty, azerty
                case 79: // 'o' - dvorak
                    callback(player, jsnes.Controller.BUTTON_B);
                    break;
                case 32: // Space
                    callback(player, jsnes.Controller.BUTTON_SELECT);
                    break;
                case 13: // Return
                    callback(player, jsnes.Controller.BUTTON_START);
                    break;
                default:
                    break;
            }
        },

        nes_init: function(canvas_id) {
            let canvas = document.getElementById(canvas_id);
            this.canvas_ctx = canvas.getContext("2d");
            this.image = this.canvas_ctx.getImageData(0, 0, this.SCREEN_WIDTH, this.SCREEN_HEIGHT);

            this.canvas_ctx.fillStyle = "black";
            this.canvas_ctx.fillRect(0, 0, this.SCREEN_WIDTH, this.SCREEN_HEIGHT);

            // Allocate framebuffer array.
            let buffer = new ArrayBuffer(this.image.data.length);
            this.framebuffer_u8 = new Uint8ClampedArray(buffer);
            this.framebuffer_u32 = new Uint32Array(buffer);

            // Setup audio.
            let AudioContext = window.AudioContext // Default
                || window.webkitAudioContext // Safari and old versions of Chrome
                || false;
            if(AudioContext) {
                // Do whatever you want using the Web Audio API
                let audio_ctx = new AudioContext;
                let script_processor = audio_ctx.createScriptProcessor(this.AUDIO_BUFFERING, 0, 2);
                script_processor.onaudioprocess = this.audio_callback;
                script_processor.connect(audio_ctx.destination);
            } else {
                // Web Audio API is not supported
                // Alert the user
                console.log("Sorry, but the Web Audio API is not supported by your browser. Please, consider upgrading to the latest version or downloading Google Chrome or Mozilla Firefox");
            }


            // var audio_ctx = new window.AudioContext();
            // var script_processor = audio_ctx.createScriptProcessor(AUDIO_BUFFERING, 0, 2);
            // script_processor.onaudioprocess = audio_callback;
            // script_processor.connect(audio_ctx.destination);
        },

        nes_boot: function(rom_data) {
            let page = this;
            page.nes.loadROM(rom_data);
            window.requestAnimationFrame(page.onAnimationFrame);
        },

        nes_load_data: function(canvas_id, rom_data) {
            this.nes_init(canvas_id);
            this.nes_boot(rom_data);
        },

        nes_load_url: function(canvas_id, path) {
            let page = this;

            this.nes_init(canvas_id);

            let req = new XMLHttpRequest();
            req.open("GET", path);
            req.overrideMimeType("text/plain; charset=x-user-defined");
            req.onerror = () => console.log(`Error loading ${path}: ${req.statusText}`);

            req.onload = function() {
                if(this.status === 200) {
                    page.nes_boot(this.responseText);
                }
                else if(this.status === 0) {
                    // Aborted, so ignore error
                }
                else {
                    req.onerror();
                }
            };

            req.send();
        },

        /**
         * Set the page's configuration.
         *
         * @param config
         * @returns {setConfig}
         */
        setConfig: function(config) {
            let page = this;

            // document.addEventListener('keydown', (event) => {this.keyboard(this.nes.buttonDown, event)});
            // document.addEventListener('keyup', (event) => {this.keyboard(this.nes.buttonUp, event)});
            //
            // let rom_url = app.url('storage/NES/Contra.nes');
            // this.nes_load_url("nes_screen", rom_url);


            $(window).on('resize', function(event) {
                // let $pageContentElem = $(this);
                console.log('here');
                // let page_content_height = $(document).height() - ($('#header').height() - $('#footer').height());
                // $('#nes_screen_container').css('height', page_content_height + 'px');
                // $('#nes_screen').css('height', page_content_height + 'px');
            });

            return page;
        },

        /**
         * Initialize the page.
         *
         * @param config
         */
        init: function(config) {
            let page = this;

            //

            return page;
        },

    });
})(window.NicksFuckinAwesomeWebsite, window.jQuery, window.Jsnes);
