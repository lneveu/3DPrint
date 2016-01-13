@extends('template')

@section('title')
    3DPaper - Inscription
@stop

@section('header')

@stop

@section('body')
    <div class="container">
        <div class="row mar-b-50">
            <form class="form-signin" method="POST" action="{{ url('/register') }}">

                {!! csrf_field() !!}

                <div class="login-wrap">
                    @if($errors->default->has('name'))<p class="error">{{ $errors->default->first('name') }}</p>@endif
                    <input type="text" class="form-control @if($errors->default->has('name')){{ "error-border" }}@endif" name="name" placeholder="Nom" value="{{ old('name') }}" autofocus>

                    @if($errors->default->has('email') && !is_null(old('name')))<p class="error">{{ $errors->default->first('email') }}</p>@endif
                    <input type="email" class="form-control @if($errors->has('email') && !is_null(old('name'))){{ "error-border" }}@endif" name="email" placeholder="E-mail" value="{{ old('email') }}">

                    @if($errors->default->has('password') && !is_null(old('name')))<p class="error">{{ $errors->default->first('password') }}</p>@endif
                    <input type="password" class="form-control @if($errors->has('password') && !is_null(old('name'))){{ "error-border" }}@endif" name="password" placeholder="Mot de passe">
                    <input type="password" class="form-control @if($errors->has('password') && !is_null(old('name'))){{ "error-border" }}@endif" name="password_confirmation" placeholder="Confirmer le mot de passe">
                    <button class="btn btn-lg btn-login btn-block" type="submit">S'inscrire</button>
                </div>

            </form>
        </div>
    </div>
@stop


@section('script')

    @if(count($errors) > 0 && is_null(old('name')))
        <script>
            $(function() {
                $('#myModal').modal('show');
            });
        </script>
    @endif

@stop
