<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>Play Contra</title>

    <link href="{{ mix('css/contra.css') }}" rel="stylesheet" type="text/css">
</head>
<body>
<header id="menu">
    <a class="menu-item mr-auto" href="{{ url('/') }}">‹ Back</a>
    <a class="menu-item" href="#" data-action="show_controls">Controls</a>
</header>
<div class="container" id="container">
    <canvas id="nes-canvas" width="256" height="240"/>
</div>

<div class="modal my-modal fade" id="controls_modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Controls</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">

                <p class="text-uppercase font-weight-bold">Will you destroy the Vile Red Falcon... and save the universe?</p>

                <table class="table table-bordered table-nonfluid table-sm table-responsive-sm">
                    <thead class="thead-dark">
                    <tr>
                        <th>Button</th>
                        <th>Player 1</th>
                        <th>Player 2 <span class="font-weight-normal">(Disabled)</span></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Left</td>
                        <td>Left</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Right</td>
                        <td>Right</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Up</td>
                        <td>Up</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Down</td>
                        <td>Down</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>A</td>
                        <td>S</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>B</td>
                        <td>A</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Start</td>
                        <td>Enter</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Select</td>
                        <td>Space</td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>

                <p class="mb-0 text-muted">Note: Sound works in all major browsers (but appears to not work in Safari). Make sure to click inside the canvas area to ensure the browser is focused on the game so that your input keys will be recognized.</p>
                <p class="mb-0 text-muted"><small><strong>Credit to <a href="https://github.com/bfirsh/jsnes" target="_blank">JSNES</a> for the awesome JavaScript-based NES emulator!</strong></small></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" data-dismiss="modal">Got It</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://unpkg.com/jsnes/dist/jsnes.min.js"></script>
<script src="{{ mix('js/contra.js') }}"></script>
{{--<script type="text/javascript" src="{{ url('nes/nes-embed.js') }}"></script>--}}
<script>
    window.onload = function() {

        var SCREEN_WIDTH = 256;
        var SCREEN_HEIGHT = 240;
        var FRAMEBUFFER_SIZE = SCREEN_WIDTH*SCREEN_HEIGHT;

        var canvas_ctx, image;
        var framebuffer_u8, framebuffer_u32;

        var AUDIO_BUFFERING = 512;
        var SAMPLE_COUNT = 4*1024;
        var SAMPLE_MASK = SAMPLE_COUNT - 1;
        var audio_samples_L = new Float32Array(SAMPLE_COUNT);
        var audio_samples_R = new Float32Array(SAMPLE_COUNT);
        var audio_write_cursor = 0, audio_read_cursor = 0;

        var nes = new jsnes.NES({
            onFrame: function(framebuffer_24){
                for(var i = 0; i < FRAMEBUFFER_SIZE; i++) framebuffer_u32[i] = 0xFF000000 | framebuffer_24[i];
            },
            onAudioSample: function(l, r){
                audio_samples_L[audio_write_cursor] = l;
                audio_samples_R[audio_write_cursor] = r;
                audio_write_cursor = (audio_write_cursor + 1) & SAMPLE_MASK;
            },
        });

        function onAnimationFrame(){
            window.requestAnimationFrame(onAnimationFrame);

            image.data.set(framebuffer_u8);
            canvas_ctx.putImageData(image, 0, 0);
            nes.frame();
        }

        function audio_remain(){
            return (audio_write_cursor - audio_read_cursor) & SAMPLE_MASK;
        }

        function audio_callback(event){
            var dst = event.outputBuffer;
            var len = dst.length;

            // Attempt to avoid buffer underruns.
            if(audio_remain() < AUDIO_BUFFERING) nes.frame();

            var dst_l = dst.getChannelData(0);
            var dst_r = dst.getChannelData(1);
            for(var i = 0; i < len; i++){
                var src_idx = (audio_read_cursor + i) & SAMPLE_MASK;
                dst_l[i] = audio_samples_L[src_idx];
                dst_r[i] = audio_samples_R[src_idx];
            }

            audio_read_cursor = (audio_read_cursor + len) & SAMPLE_MASK;
        }

        function keyboard(callback, event){
            var player = 1;
            switch(event.keyCode){
                case 38: // UP
                    callback(player, jsnes.Controller.BUTTON_UP); break;
                case 40: // Down
                    callback(player, jsnes.Controller.BUTTON_DOWN); break;
                case 37: // Left
                    callback(player, jsnes.Controller.BUTTON_LEFT); break;
                case 39: // Right
                    callback(player, jsnes.Controller.BUTTON_RIGHT); break;
                case 65: // 'a' - qwerty, dvorak
                case 81: // 'q' - azerty
                    callback(player, jsnes.Controller.BUTTON_A); break;
                case 83: // 's' - qwerty, azerty
                case 79: // 'o' - dvorak
                    callback(player, jsnes.Controller.BUTTON_B); break;
                case 32: // Space
                    callback(player, jsnes.Controller.BUTTON_SELECT); break;
                case 13: // Return
                    callback(player, jsnes.Controller.BUTTON_START); break;
                default: break;
            }
        }

        function nes_init(canvas_id){
            var canvas = document.getElementById(canvas_id);
            canvas_ctx = canvas.getContext("2d");
            image = canvas_ctx.getImageData(0, 0, SCREEN_WIDTH, SCREEN_HEIGHT);

            canvas_ctx.fillStyle = "black";
            canvas_ctx.fillRect(0, 0, SCREEN_WIDTH, SCREEN_HEIGHT);

            // Allocate framebuffer array.
            var buffer = new ArrayBuffer(image.data.length);
            framebuffer_u8 = new Uint8ClampedArray(buffer);
            framebuffer_u32 = new Uint32Array(buffer);

            // Setup audio.
            var AudioContext = window.AudioContext // Default
                || window.webkitAudioContext // Safari and old versions of Chrome
                || false;
            if(AudioContext) {
                // Do whatever you want using the Web Audio API
                var audio_ctx = new AudioContext;
                var script_processor = audio_ctx.createScriptProcessor(AUDIO_BUFFERING, 0, 2);
                script_processor.onaudioprocess = audio_callback;
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
        }

        function nes_boot(rom_data){
            nes.loadROM(rom_data);
            window.requestAnimationFrame(onAnimationFrame);
        }

        function nes_load_data(canvas_id, rom_data){
            nes_init(canvas_id);
            nes_boot(rom_data);
        }

        function nes_load_url(canvas_id, path) {
            nes_init(canvas_id);

            var req = new XMLHttpRequest();
            req.open("GET", path);
            req.overrideMimeType("text/plain; charset=x-user-defined");
            req.onerror = () => console.log(`Error loading ${path}: ${req.statusText}`);

            req.onload = function() {
                if (this.status === 200) {
                    nes_boot(this.responseText);
                } else if (this.status === 0) {
                    // Aborted, so ignore error
                } else {
                    req.onerror();
                }
            };

            req.send();
        }

        document.addEventListener('keydown', (event) => {keyboard(nes.buttonDown, event)});
        document.addEventListener('keyup', (event) => {keyboard(nes.buttonUp, event)});



        nes_load_url("nes-canvas", "{{ route('contra_rom', ['rom_filename' => $rom_filename]) }}");
    }
</script>
<script type="text/javascript">
    window.Contra.init({
        appData: {
            appUrl: '{{ env('APP_URL') }}',
        },
    });
</script>
</body>
</html>
