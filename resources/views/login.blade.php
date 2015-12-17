@extends('template')

@section('title')
    3D Print
@stop

@section('header')

@stop

@section('body')
        <!--container start-->
    <div class="login-bg">
        <div class="container">
            <div class="form-wrapper">
                <form class="form-signin wow fadeInUp" action="index.html">
                    <h2 class="form-signin-heading">Connexion</h2>
                    <div class="login-wrap">
                        <input type="text" class="form-control" placeholder="User ID" autofocus>
                        <input type="password" class="form-control" placeholder="Password">
                        <label class="checkbox">
                            <input type="checkbox" value="remember-me"> Se souvenir de moi
                            <span class="pull-right">
                                <a data-toggle="modal" href="#myModal"> Mot de passe oublié ?</a>
                            </span>
                        </label>
                        <button class="btn btn-lg btn-login btn-block" type="submit">Se conecter</button>
                    </div>

                    <!-- Modal -->
                    <div aria-hidden="true" aria-labelledby="myModal" role="dialog" tabindex="-1" id="myModal" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title">Mot de passe oublié ?</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Entrer votre adresse e-mail ci-dessous pour réinitialiser votre mot de passe.</p>
                                    <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">

                                </div>
                                <div class="modal-footer">
                                    <button data-dismiss="modal" class="btn btn-default" type="button">Annuler</button>
                                    <button class="btn btn-success" type="button">Envoyer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- modal -->

                </form>
            </div>
        </div>
    </div>
    <!--container end-->

@stop

@section('script')

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