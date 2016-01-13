@extends('template')

@section('title')
    3DPaper - Réinitialisation du mot de passe
@stop

@section('header')

@stop

@section('body')

    @include('breadcrumbs', array('breadcrumb_title' => 'Réinitialisation du mot de passe'))

    <div class="container">
        <div class="row mar-b-50">
            <form class="form-signin" method="POST" action="/password/reset">
                {!! csrf_field() !!}

                <div class="login-wrap">
                    <input type="hidden" name="token" value="{{ $token }}">

                    @if($errors->default->has('email'))<p class="error">{{ $errors->default->first('email') }}</p>@endif
                    <input type="email" class="form-control @if($errors->has('email')){{ "error-border" }}@endif" name="email" placeholder="E-mail" value="{{ old('email') }}">

                    @if($errors->default->has('password'))<p class="error">{{ $errors->default->first('password') }}</p>@endif
                    <input type="password" class="form-control @if($errors->has('password')){{ "error-border" }}@endif" name="password" placeholder="Nouveau mot de passe">
                    <input type="password" class="form-control @if($errors->has('password')){{ "error-border" }}@endif" name="password_confirmation" placeholder="Confirmer le mot de passe">
                    <button class="btn btn-lg btn-login btn-block" type="submit">Changer le mot de passe</button>
                </div>

            </form>
        </div>
    </div>
@stop


@section('script')

@stop
