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
            <form class="form-signin" method="POST" action="{{ url('/upload-model') }}">

                {!! csrf_field() !!}

                <div class="login-wrap">
                    <input type="file" name="file" id="file">
                    <button class="btn btn-lg btn-login btn-block" type="submit">Valider le modèle</button>
                </div>

            </form>
        </div>
    </div>
@stop