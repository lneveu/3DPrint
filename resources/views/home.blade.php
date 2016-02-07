@extends('template')

@section('title')
    3DPaper
@stop

@section('header')

@stop

@section('body')
    @if(session()->has('status'))
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <p class="alert alert-success alert-dismissible alert-fade text-center">{{ session()->get('status') }}</p>
        </div>
        <div class="col-md-4"></div>

    @endif
    <!-- Sequence Modern Slider -->
    <div id="da-slider" class="da-slider">
      <!-- Slide 1 -->
      <div class="da-slide">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <h2>
                <i>IMPRIMER VOTRE OBJET</i>
                <br>
                <i>EN QUELQUES CLICS !</i>
              </h2>
              <p>
                <i>3DPaper est une plateforme simple d'utilisation qui vous permet d'imprimer tous vos modèles 3D en papier !</i>
              </p>
              <a href="{{ url('/upload-model') }}" class="btn btn-info btn-lg da-link">
                Imprimer mon objet
              </a>
              <div class="da-img">
                <img src="img/parallax-slider/images/img1.png" alt="image01" />
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Slide 1 end -->

      <!-- Slide 2 -->
      <div class="da-slide">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <h2>
                <i>3DPAPER VOUS PROPOSE</i>
                <br />
                <i>SON EXPERTISE</i>
              </h2>
              <p>
                <i>Des objets en très haute définition, avec des couleurs fidèles à la réalité !</i>
              </p>
              <a href="{{ url('/3dprint') }}" class="btn btn-info btn-lg da-link">
                En savoir plus
              </a>
              <div class="da-img">
                <img src="img/parallax-slider/images/img2.png" alt="image02" />
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Slide 2 end -->

      <!-- Slide 3 -->
      <div class="da-slide">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <h2>
                <i>UNE TECHNIQUE D'IMPRESSION</i>
                </br>
                <i>NOUVELLE GENERATION</i>
              </h2>
              <p>
                <i>Technologie MCor basée sur le procédé SDL</i>
              </p>
              <a href="{{ url('/expertise') }}" class="btn btn-info btn-lg da-link">
                En savoir plus
              </a>
              <div class="da-img">
                <img src="img/parallax-slider/images/img3.png" alt="image03" />
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Slide 3 end-->

      <nav class="da-arrows">
        <span class="da-arrows-prev">
        </span>
        <span class="da-arrows-next">
        </span>
      </nav>
    </div>

    <!-- Features block -->
    <div class="container">
        <div class="row mar-b-50">
            <div class="col-md-12">
                <div class="text-center feature-head wow fadeInDown">
                    <h1 class="">
                      La première plateforme d'impression 3D papier !
                    </h1>
                </div>

                <div class="feature-box">
                    <div class="col-md-4 col-sm-4 text-center wow fadeInUp">
                        <div class="feature-box-heading">
                            <em>
                                <img src="img/upload.png" alt="" width="100" height="100">
                            </em>
                            <h4>
                                <b>1. Dépôt du modèle</b>
                            </h4>
                        </div>
                        <p class="text-center">
                            Transférez votre modèle au format STL ou OBJ
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
                            Nous imprimons votre objet si celui-ci est conforme
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
                            Nous nous chargeons de l'envoi de votre commande
                        </p>
                    </div>
                </div>
                <!--feature end-->
            </div>
        </div>
    </div>
    <!-- Features block end -->

    <!-- Upload block -->
    <div class="upload_block_home gray-bg">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <h3>
              <strong>Déposez votre modèle dès maintenant !</strong>
            </h3>
            <h4>
              Une fois déposé, nous analyserons automatiquement et gratuitement le modèle pour vérifier sa faisabilité.
            </h4>
            <a href="{{ url('/upload-model') }}" class="btn btn-orange btn-lg btn-big">
              Déposer votre modèle
            </a>
          </div>
        </div>
      </div>
    </div>
    <!-- Upload block end -->

    <!-- Infos block -->
    <div class="infos_block_home">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <div class="col-lg-6 col_img">
              <div>
              <img src="img/mcor.png" alt="MCor Technologies">
            </div>
            </div>
            <div class="col-lg-6">
            <p>
              L'impression 3D est une technique de fabrication numérique dite additive. A partir d'un modèle numérique, l'imprimante est capable de créer un objet physique en 3 dimensions en additionnant une multitude de couches d'un matériau.
              <br/>3DPaper est une plateforme spécialisée dans l'impression d'objet en papier : l'imprimante que nous utilisons superpose des feuilles de papier clasiques, les colle entre elles puis les découpe suivant la forme de l'objet.
              <br/><br/>
              Envie d'en savoir plus ? Consulter <a href="{{ url('/3dprint') }}">notre page dédiée à l'impression 3D</a>.
            </p>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="col-lg-6">
              <p>

                Après avoir déposer votre modèle, nous vérifions automatiquement si celui-ci est conforme aux contraintes d'impression de notre imprimante.
                <br>Une fois validé, vous avez la possibilité de le visualiser en 3D et de l'éditer.
                Vous pourrez ensuite procéder à la commande de l'objet. Nous nous chargerons de l'imprimer et de vous l'expedier dans les plus bref délais.
                <br/><br/><br/><br/>
                Vous souhaitez plus de détails ? Consultez <a href="{{ url('/expertise') }}">notre page sur le processus de production</a>.
              </p>
            </div>
            <div class="col-lg-6 col_img">
              <img src="img/paperhand.jpg" alt="Main couleur en papier">
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Infos block end -->

    <!-- Newsletter block -->
    <div class="newsletter_block_home gray-bg">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <form class="form-inline" role="form">
              <div class="form-group">
              <h4>Inscrivez-vous à la newsletter pour être tenu informé des nouveautés</h4>
            </div>
              <div class="form-group">
                <label class="sr-only" for="input_email_newsletter">Adresse email</label>
                <input type="email" class="form-control" id="input_email_newsletter" placeholder="Votre email">
              </div>
              <button type="submit" class="btn btn-orange">S'inscrire</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Newsletter block end -->
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

            history.pushState("", document.title, window.location.pathname
                    + window.location.search);
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
