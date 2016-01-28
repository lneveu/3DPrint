@extends('template')

@section('title')
    3DPaper - Mot de passe oublié
@stop

@section('header')

@stop

@section('body')

    @include('breadcrumbs', array('breadcrumb_title' => 'Mot de passe oublié', 'breadcrumb_list' => [['Accueil','/'], ['Mot de passe oublié','/password/email']]))

    <div class="container">
        <div class="row mar-b-50">
            @if(session()->has('status'))
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <h4 class="alert alert-success text-center">{{ session()->get('status') }}</h4>
                </div>
                <div class="col-md-2"></div>


            @else
                <form class="form-signin" method="POST" action="/password/email">

                    {!! csrf_field() !!}

                    <div class="login-wrap">
                        @if($errors->default->has('email'))<p class="error">{{ $errors->default->first('email') }}</p>@endif
                        <input type="email" class="form-control @if($errors->has('email')){{ "error-border" }}@endif" name="email" placeholder="E-mail" value="{{ old('email') }}">

                        <button class="btn btn-lg btn-login btn-block" type="submit">Réinitialiser le mot de passe</button>
                    </div>

                </form>
            @endif
        </div>
    </div>
@stop
