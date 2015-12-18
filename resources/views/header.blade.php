<!--header start-->
<header class="head-section">
    <div class="navbar navbar-default navbar-static-top container">
        <div class="navbar-header">
            <button class="navbar-toggle" data-target=".navbar-collapse" data-toggle="collapse" type="button">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}"><span>3D</span>Print</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li>
                    <a href="{{ url('/') }}">Accueil</a>
                </li>
                <li>
                    <a href="{{ url('/') }}">Imprimer votre objet</a>
                </li>
                @if(Auth::check())
                    <li>
                        <a href="{{ url('/logout') }}"><b><span>Se déconnecter</span></b></a>
                    </li>
                @else
                    <li>
                        <a data-toggle="modal" href="#myModal">Se connecter</a>
                    </li>
                    <li>
                        <a href="{{ url('/register') }}"><b><span>S'inscrire</span></b></a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</header>
<!--header end-->