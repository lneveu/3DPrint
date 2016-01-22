@extends('template')

@section('title')
    3DPaper
@stop

@section('header')
    <script src="/js/spin.min.js"></script>
@stop

@section('body')

    @include('breadcrumbs', array('breadcrumb_title' => 'Dépôt du modèle'))

    <div class="container">

        <div class="row mar-b-50">
            @if(session()->has('error'))
                <p class="alert alert-danger text-center">{{ session()->get('error') }}</p>
            @endif
            <h4 class="center">Veuillez selectionner un modèle sur votre ordinateur. Nous acceptons les formats <b>OBJ</b> et <b>STL</b>.</h4>
            <form class="form-signin" method="POST" action="{{ url('/upload-model') }}" enctype="multipart/form-data">

                {!! csrf_field() !!}
                <div class="login-wrap">
                    @if($errors->default->has('file'))<p class="error">{{ $errors->default->first('file') }}</p>@endif
                    <input type="file" name="file" id="file">
                    <br/>
                    <button class="btn btn-lg btn-login btn-block" type="submit" id="send">Envoyer</button>
                </div>
                <div class="row">
                    <div class="col-md-4" id="spinArea"></div>
                </div>
                <div class="row">
                    <h5 class="center">En déposant des fichiers sur <b>3DPaper</b>, vous acceptez nos <a href="{{ url('/') }}">conditions générales d'utilisation</a>.</h5>
                </div>
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        var opts = {
            lines: 13 // The number of lines to draw
            , length: 28 // The length of each line
            , width: 14 // The line thickness
            , radius: 42 // The radius of the inner circle
            , scale: 1 // Scales overall size of the spinner
            , corners: 1 // Corner roundness (0..1)
            , color: '#000' // #rgb or #rrggbb or array of colors
            , opacity: 0.25 // Opacity of the lines
            , rotate: 0 // The rotation offset
            , direction: 1 // 1: clockwise, -1: counterclockwise
            , speed: 1 // Rounds per second
            , trail: 60 // Afterglow percentage
            , fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
            , zIndex: 2e9 // The z-index (defaults to 2000000000)
            , className: 'spinner' // The CSS class to assign to the spinner
            , top: '50%' // Top position relative to parent
            , left: '50%' // Left position relative to parent
            , shadow: false // Whether to render a shadow
            , hwaccel: false // Whether to use hardware acceleration
            , position: 'absolute' // Element positioning
        };
        var target = document.getElementById('spinArea');
        var spinner = new Spinner(opts);

        $('#send').on('click', function(){
            spinner.spin(target);
        })
    </script>

@stop