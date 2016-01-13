<!--header start-->
<header class="head-section">
    <div class="navbar navbar-default navbar-static-top container">
        <div class="navbar-header">
            <button class="navbar-toggle" data-target=".navbar-collapse" data-toggle="collapse" type="button">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}"><span>3D</span>Paper</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li>
                    <a href="{{ url('/') }}">Accueil</a>
                </li>
                <li>
                    <a href="{{ url('/') }}">Notre expertise</a>
                </li>
                <li>
                    <a href="{{ url('/') }}"><span>Imprimer votre objet</span></a>
                </li>
                @if(Auth::check())
                    <li class="dropdown">
                      <a class="dropdown-toggle" data-close-others="false" data-delay="0" data-hover="dropdown" data-toggle="dropdown" href="{{ url('/') }}">
                        Mon compte <i class="fa fa-angle-down"></i>
                      </a>
                      <ul class="dropdown-menu">
                        <li>
                          <a href="{{ url('/') }}">Mes informations personnelles</a>
                        </li>
                        <li>
                          <a href="{{ url('/') }}">Mes modèles</a>
                        </li>
                        <li>
                          <a href="{{ url('/') }}">Mes commandes</a>
                        </li>
                        <li>
                          <a href="{{ url('/logout') }}">Se déconnecter</a>
                        </li>
                      </ul>
                    </li>
                @else
                    <li>
                        <a data-toggle="modal" href="#modal_connexion">Se connecter</a>
                    </li>
                    <li>
                        <a href="{{ url('/register') }}"><b>S'inscrire</b></a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</header>
<!--header end-->
