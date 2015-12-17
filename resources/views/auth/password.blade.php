@extends('template')

@section('title')
    3D Print
@stop

@section('header')

@stop

@section('body')
    <div class="container">
        <div class="row mar-b-50">
            @if(session()->has('status'))
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <h4 class="alert-success text-center">{{ session()->get('status') }}</h4>
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