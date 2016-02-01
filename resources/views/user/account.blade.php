@extends('template')

@section('title')
    3DPaper - Mon compte
@stop

@section('header')
@stop

@section('body')

    @include('breadcrumbs', array('breadcrumb_title' => 'Mon compte', 'breadcrumb_list' => [['Accueil','/'], ['Mon compte','/account']]))

    <div class="container">

        <div class="row mar-b-50">

            <div class="col-md-8">
                <form role="form" class="form-horizontal" method="POST" action="{{ url('/account') }}">
                    {!! csrf_field() !!}

                    @if(session()->has('ok'))
                    <div class="alert alert-success alert-dismissible alert-fade text-center">
                        {{ session()->get('ok') }}
                    </div>
                    @endif

                    <div class="form-group">
                        <div class="col-md-4">
                            <h4>Informations personnelles</h4>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-2">
                            <label>Civilité</label>
                            <select class="form-control" name="civility">
                                <option value="M.">M.</option>
                                <option value="Mme" @if($user->civility == "Mme"){{ "selected" }}@endif>Mme</option>
                                <option value="Mlle" @if($user->civility == "Mlle"){{ "selected" }}@endif>Mlle</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label>Nom</label>
                            @if($errors->default->has('name'))<span class="error">{{ $errors->default->first('name') }}</span>@endif
                            <input type="text" class="form-control @if($errors->default->has('name')){{ "error-border" }}@endif" name="name" placeholder="Nom" value="{{ $user->name }}" required>
                        </div>

                        <div class="col-md-4">
                            <label>Prénom</label>@if($errors->default->has('firstname'))<span class="error">{{ $errors->default->first('firstname') }}</span>@endif
                            <input type="text" class="form-control @if($errors->default->has('firstname')){{ "error-border" }}@endif" name="firstname" placeholder="Prénom" value="{{ $user->firstname }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-4">
                            <label>Email</label>
                            @if($errors->default->has('email'))<span class="error">{{ $errors->default->first('email') }}</span>@endif
                            <input type="email" class="form-control @if($errors->default->has('email')){{ "error-border" }}@endif" name="email" placeholder="Email" value="{{ $user->email }}" required>
                        </div>

                        <div class="col-md-4">
                            <label>Téléphone</label>
                            @if($errors->default->has('phone'))<span class="error">{{ $errors->default->first('phone') }}</span>@endif
                            <input type="tel" class="form-control @if($errors->default->has('phone')){{ "error-border" }}@endif" name="phone" placeholder="Téléphone" value="{{ $user->phone }}" pattern="^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-4">
                            <h4>Adresse de livraison</h4>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-10">
                            <label>Adresse</label>
                            @if($errors->default->has('address'))<span class="error">{{ $errors->default->first('address') }}</span>@endif
                            <input type="text" class="form-control @if($errors->default->has('address')){{ "error-border" }}@endif" name="address" placeholder="Adresse" value="{{ $user->address }}"><br/>
                            @if($errors->default->has('address_cpl'))<span class="error">{{ $errors->default->first('address_cpl') }}</span>@endif
                            <input type="text" class="form-control @if($errors->default->has('address_cpl')){{ "error-border" }}@endif" name="address_cpl" placeholder="Complément d'adresse" value="{{ $user->address_cpl }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-2">
                            <label>Code postal</label>
                            @if($errors->default->has('cp'))<span class="error">{{ $errors->default->first('cp') }}</span>@endif
                            <input type="text" class="form-control @if($errors->default->has('cp')){{ "error-border" }}@endif" name="cp" placeholder="Code postal" value="{{ $user->cp }}">
                        </div>

                        <div class="col-md-3">
                            <label>Ville</label>
                            @if($errors->default->has('city'))<span class="error">{{ $errors->default->first('city') }}</span>@endif
                            <input type="text" class="form-control @if($errors->default->has('city')){{ "error-border" }}@endif" name="city" placeholder="Ville" value="{{ $user->city }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                        <input type="submit" class="btn btn-lg btn-login float-right" value="Enregister">
                        </div>
                    </div>

                </form>
            </div>
            <div class="col-md-4">
                <div class="well">
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/models') }}">Mes modèles</a></li>
                        <li><a href="{{ url('/orders') }}">Mes commandes</a></li>
                        <li><a href="{{ url('/password/change') }}">Changer mon mot de passe</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>

    </script>

@stop
