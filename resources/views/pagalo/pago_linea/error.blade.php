<div class="row">
        <div class="col-lg-5 mx-auto">
            <div class="card">
                <div class="card-body p-0">
                    <div class="text-center p-3">
                        <a href="#" class="logo logo-admin">
                            <img src="{{ asset('assets/images/logo-dark.png') }}" height="50" alt="logo" class="auth-logo">
                        </a>
                        <h4 class="mt-3 mb-1 fw-semibold text-danger font-18">Oops! Lo sentimos, ocurrio un problema</h4>   
                        <p class=" mb-0">Realice el proceso nuevamente</p>  
                    </div>
                </div>
                <div class="card-body">
                    <div class="ex-page-content text-center">
                        <h1 class="mt-5 mb-4">500!</h1>  
                        <h5 class="font-16 text-muted mb-5">algo salió mal</h5>                                    
                    </div>            
                    <a class="btn bg-beanred w-100 waves-effect waves-light" href="{{ route('pago-en-linea') }}">Volver <i class="fas fa-redo ms-1"></i></a>                         
                </div>
            </div>
        </div>
    </div>