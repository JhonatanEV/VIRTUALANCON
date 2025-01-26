<div class="row justify-content-center">
    <div class="col-md-12 ">
        <div class="containercuponera" id="containercuponera"></div>
    </div>
</div>
<script src="{{ asset('assets/plugins/cuponera/js/libs/jquery.min.js') }}"></script>
<script src="{{ asset('assets/plugins/cuponera/js/libs/html2canvas.min.js') }}"></script>
<script src="{{ asset('assets/plugins/cuponera/js/libs/three.min.js') }}"></script>
<script src="{{ asset('assets/plugins/cuponera/js/libs/pdf.min.js') }}"></script>
<script src="{{ asset('assets/plugins/cuponera/js/dist/3dflipbook.js') }}"></script>
<script src="{{ asset('assets/plugins/cuponera/js/pdf.worker.js') }}"></script>

<script type="text/javascript">

    window.PDFJS_LOCALE = {
        pdfJsWorker: urljs+'assets/plugins/cuponera/js/pdf.worker.js'
    };
</script>
    <script type="text/javascript">
        $('#containercuponera').FlipBook({
            pdf: '<?php echo $url_file; ?>',
            template: {
                html: '{{ asset("assets/plugins/cuponera/default-book-view.html") }}',
                styles: [
                    '{{ asset("assets/plugins/cuponera/css/short-black-book-view.css") }}'
                ],
                links: [
                    {
                        rel: 'stylesheet',
                        href: '{{ asset("assets/plugins/cuponera/css/font-awesome.min.css") }}'
                    }
                ],
                script: '{{ asset("assets/plugins/cuponera/js/default-book-view.js") }}',
                sounds: {
                    startFlip: '{{ asset("assets/plugins/cuponera/sounds/start-flip.mp3") }}',
                    endFlip: '{{ asset("assets/plugins/cuponera/sounds/end-flip.mp3") }}'
                  }
                  
            },
            controlsProps: {
                downloadURL: '<?php echo $url_file; ?>'
            }
        });
    </script>
<style>
    body {            
            background-color: rgba(29,44,72,0.08) !important;
            margin: 0;
            padding: 0;
        }

        .containercuponera {
            height: 55rem;
            width: 95%;
            /* margin: 20px auto; */
        }

        .fullscreen {
            background-color: #333;
        }
        iframe{
            height: 87%!important;
        }
</style>