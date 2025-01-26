window.PDFJS_LOCALE = {
    pdfJsWorker: urljs+'assets/plugins/cuponera/js/pdf.worker.js'
};

$("#btnBuscar").click(function(){
    
    fetchGet("contribuyente/select-cuponera",function(res){
        if(res.status==0){
            $('#containercuponera').FlipBook({
                pdf: urljs+'files/bases_consurso_fiesta_peruana_2023.pdf',
                template: {
                    html: urljs+'assets/plugins/cuponera/default-book-view.html',
                    styles: [
                        urljs+'assets/plugins/cuponera/css/short-black-book-view.css'
                    ],
                    links: [
                        {
                            rel: 'stylesheet',
                            href: urljs+'assets/plugins/cuponera/css/font-awesome.min.css'
                        }
                    ],
                    script: urljs+'assets/plugins/cuponera/js/default-book-view.js',
                    sounds: {
                        startFlip: urljs+'assets/plugins/cuponera/sounds/start-flip.mp3',
                        endFlip: urljs+'assets/plugins/cuponera/sounds/end-flip.mp3'
                      }
                      
                },
                controlsProps: {
                    downloadURL: urljs+'files/bases_consurso_fiesta_peruana_2023.pdf'
                }
            });
        }else{
            $("#containercuponera").html(`<div class="row mt-3 justify-content-center">
                                            <div class="col-md-4">
                                                <div class="alert alert-info border-0  mb-0" role="alert">
                                                Estimado(a), no hemos encontrado su cuponera para el año seleccionado.
                                            </div>
                                        </div>        
                                </div>`);
        }
    });

    
})