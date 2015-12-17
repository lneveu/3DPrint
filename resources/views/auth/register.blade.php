@extends('template')

@section('title')
    3D Print
@stop

@section('header')

@stop

@section('body')
    <div class="container">
        <div class="row mar-b-50">
            <form class="form-signin" method="POST" action="/register">

                {!! csrf_field() !!}

                <div class="login-wrap">
                    @if($errors->default->has('name'))<p class="error">{{ $errors->default->first('name') }}</p>@endif
                    <input type="text" class="form-control @if($errors->default->has('name')){{ "error-border" }}@endif" name="name" placeholder="Nom" value="{{ old('name') }}" autofocus>

                    @if($errors->default->has('email'))<p class="error">{{ $errors->default->first('email') }}</p>@endif
                    <input type="email" class="form-control @if($errors->has('email')){{ "error-border" }}@endif" name="email" placeholder="E-mail" value="{{ old('email') }}">

                    @if($errors->default->has('password'))<p class="error">{{ $errors->default->first('password') }}</p>@endif
                    <input type="password" class="form-control @if($errors->has('password')){{ "error-border" }}@endif" name="password" placeholder="Mot de passe">
                    <input type="password" class="form-control @if($errors->has('password')){{ "error-border" }}@endif" name="password_confirmation" placeholder="Confirmer le mot de passe">
                    <button class="btn btn-lg btn-login btn-block" type="submit">S'inscrire</button>
                </div>

            </form>
        </div>

        <!-- Connexion Modal -->
        <div aria-hidden="true" aria-labelledby="myModal" role="dialog" tabindex="-1" id="myModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Connexion</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-signin wow fadeInUp" method="POST" action="/login">
                            {!! csrf_field() !!}
                            <div class="login-wrap">
                                <input type="email" name="email" class="form-control has-error" placeholder="E-mail" autofocus>
                                <input type="password" name="password" class="form-control" placeholder="Mot de passe">
                                <label class="checkbox">
                                    <input type="checkbox" name="remember" value="remember"> Se souvenir de moi
                            <span class="pull-right">
                                <a data-toggle="modal" href="#myModal"> Mot de passe oublié ?</a>
                            </span>
                                </label>
                                <button class="btn btn-lg btn-login btn-block" type="submit">Se connecter</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!-- modal -->
    </div>
@stop


@section('script')

@stop