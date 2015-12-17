@extends('template')

@section('title')
    3D Print
@stop

@section('header')

@stop

@section('body')
    <div class="container">
        <div class="row mar-b-50">
            <div class="col-md-12">
                @if(session()->has('status'))
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <p class="alert-success text-center">{{ session()->get('status') }}</p>
                    </div>
                    <div class="col-md-4"></div>

                @endif
                <div class="text-center feature-head wow fadeInDown">
                    <h1 class="">
                        Bienvenue sur 3D Print
                    </h1>

                </div>


                <div class="feature-box">
                    <div class="col-md-4 col-sm-4 text-center wow fadeInUp">
                        <div class="feature-box-heading">
                            <em>
                                <img src="img/upload.png" alt="" width="100" height="100">

                            </em>
                            <h4>
                                <b>1. Transférer votre modèle</b>
                            </h4>
                        </div>
                        <p class="text-center">
                            Vous nous envoyer votre modèle d'objet au format STL, OBJ ou VRML.
                        </p>
                    </div>
                    <div class="col-md-4 col-sm-4 text-center wow fadeInUp">
                        <div class="feature-box-heading">
                            <em>
                                <img src="img/printing.png" alt="" width="100" height="100">
                            </em>
                            <h4>
                                <b>2. Impression</b>
                            </h4>
                        </div>
                        <p class="text-center">
                            Nous imprimons votre modèle 3D s'il celui-ci est conforme.
                        </p>
                    </div>
                    <div class="col-md-4 col-sm-4 text-center wow fadeInUp">
                        <div class="feature-box-heading">
                            <em>
                                <img src="img/colis.png" alt="" width="100" height="100">
                            </em>
                            <h4>
                                <b>3. Envoi</b>
                            </h4>
                        </div>
                        <p class="text-center">
                            Nous vous envoyons votre objet par colis.
                        </p>
                    </div>
                </div>

                <!--feature end-->
            </div>
        </div>
    </div>



    <div id="home-services">

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>
                        Des trucs à rajouter
                    </h2>
                </div>

                <div class="col-md-4">
                    <div class="h-service">
                        <div class="icon-wrap ico-bg round-fifty wow fadeInDown">
                            <i class="fa fa-question">
                            </i>
                        </div>
                        <div class="h-service-content wow fadeInUp">
                            <h3>
                                ...
                            </h3>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna aliqua. Ut enim  laborum.
                                <br>
                                <a href="#">
                                    Learn more
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="h-service">
                        <div class="icon-wrap ico-bg round-fifty wow fadeInDown">
                            <i class="fa fa-h-square">
                            </i>
                        </div>
                        <div class="h-service-content wow fadeInUp">
                            <h3>
                                ...
                            </h3>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna aliqua. Ut enim  laborum.
                                <br>
                                <a href="#">
                                    Learn more
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="h-service">
                        <div class="icon-wrap ico-bg round-fifty wow fadeInDown">
                            <i class="fa fa-users">
                            </i>
                        </div>
                        <div class="h-service-content wow fadeInUp">
                            <h3>
                                ...
                            </h3>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna aliqua. Ut enim  laborum.
                                <br>
                                <a href="#">
                                    Learn more
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /row -->

        </div>
        <!-- /container -->

    </div>
    <!-- service end -->
    <div class="hr">
        <span class="hr-inner"></span>
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
                            @if($errors->default->has('email'))<p class="error">{{ $errors->default->first('email') }}</p>@endif
                            <input type="email" class="form-control @if($errors->has('email')){{ "error-border" }}@endif" name="email" placeholder="E-mail" value="{{ old('email') }}">

                            @if($errors->default->has('password'))<p class="error">{{ $errors->default->first('password') }}</p>@endif
                            <input type="password" name="password" class="form-control @if($errors->has('password')){{ "error-border" }}@endif" placeholder="Mot de passe">


                            <label class="checkbox">
                                <input type="checkbox" name="remember" value="remember"> Se souvenir de moi
                            <span class="pull-right">
                                <a data-toggle="modal" href="{{ url('password/email') }}"> Mot de passe oublié ?</a>
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

@stop

@section('script')

    @if(count($errors) > 0)
        <script>
            $(function() {
                $('#myModal').modal('show');
            });
        </script>
    @endif

    <script>
        $('a.info').tooltip();

        $(window).load(function() {
            $('.flexslider').flexslider({
                animation: "slide",
                start: function(slider) {
                    $('body').removeClass('loading');
                }
            });
        });

        $(document).ready(function() {

            $("#owl-demo").owlCarousel({

                items : 4

            });

        });

        jQuery(document).ready(function(){
            jQuery('ul.superfish').superfish();
        });

        new WOW().init();


    </script>

@stop