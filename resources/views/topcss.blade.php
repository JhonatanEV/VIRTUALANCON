        <script src="{{ asset('assets/js/jquery.min.js') }}"></script> 
        <!-- App css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="modo-normal" />
        <link href="{{ asset('assets/css/bootstrap-dark.min.css') }}" rel="stylesheet" type="text/css" id="modo-oscuro" disabled />

        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/metisMenu.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="appmodo-normal" />
        <link href="{{ asset('assets/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="appmodo-oscuro" disabled/>

        <link href="{{ asset('assets/plugins/toastr/build/toastr.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- <link href="{{ asset('assets/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" /> -->
        <link href="{{ asset('assets/plugins/sweet-alert2/borderless.css') }}" rel="stylesheet" type="text/css" />
        
@php
        if(isset($header_css)){
                foreach($header_css as $item){
@endphp
                        <link href="{{ asset('assets/') }}/@php echo $item @endphp" rel="stylesheet" type="text/css" />
@php
                }
        }
@endphp
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />
        