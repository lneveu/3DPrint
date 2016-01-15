@extends('template')

@section('title')
    3DPaper - Imprimer votre objet
@stop

@section('header')

@stop

@section('body')

    @include('breadcrumbs', array('breadcrumb_title' => 'Dépôt du modèle'))

    <div class="container">

        <div class="row mar-b-50">
            @if(session()->has('status'))
                <p class="alert alert-success text-center">{{ session()->get('status') }}</p>
            @endif
            <h4 class="center">Veuillez selectionner un modèle sur votre ordinateur. Nous acceptons les formats <b>OBJ</b> et <b>STL</b>.</h4>
            <form class="form-signin" method="POST" action="{{ url('/upload-model') }}" enctype="multipart/form-data">

                {!! csrf_field() !!}
                <div class="login-wrap">
                    @if($errors->default->has('file'))<p class="error">{{ $errors->default->first('file') }}</p>@endif
                    <input type="file" name="file" id="file">
                    <br/>
                    <button class="btn btn-lg btn-login btn-block" type="submit">Envoyer</button>
                </div>
            </form>
            <h5 class="center">En déposant des fichiers sur <b>3DPaper</b>, vous acceptez nos <a href="{{ url('/') }}">conditions générales d'utilisation</a>.</h5>
        </div>
    </div>
@stop