<!-- Connexion Modal -->
<div aria-hidden="true" aria-labelledby="login" role="dialog" tabindex="-1" id="login" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Connexion</h4>
            </div>
            <div class="modal-body">
                <form class="form-signin wow fadeInUp" method="POST" action="{{ url('/login') }}">

                    {!! csrf_field() !!}
                    <div class="login-wrap">
                        <a href="{{ url('/login/facebook') }}" class="btn btn-block btn-social btn-facebook">
                            <i class="fa fa-facebook"></i> Se connecter avec Facebook
                        </a><br/>

                        <a href="{{ url('/login/google') }}" class="btn btn-block btn-social btn-google">
                            <i class="fa fa-google-plus"></i> Se connecter avec Google
                        </a><br/>

                        <input type="hidden" name="login" value="1">
                        @if($errors->default->has('email') && (array_key_exists('remember', old()) || old('login')))<p class="error">{{ $errors->default->first('email') }}</p>@endif
                        <input type="email" class="form-control @if($errors->has('email') && (array_key_exists('remember', old()) || old('login'))){{ "error-border" }}@endif" name="email" placeholder="E-mail" value="{{ old('email') }}">

                        @if($errors->default->has('password') && old('login'))<p class="error">{{ $errors->default->first('password') }}</p>@endif
                        <input type="password" name="password" class="form-control @if($errors->default->has('password') && old('login')){{ "error-border" }}@endif" placeholder="Mot de passe">


                        <div class="checkbox">
                            <input type="checkbox" id="c1" name="remember" value="remember">
                            <label for="c1">Se souvenir de moi</label>
                            <span class="pull-right">
                                <a data-toggle="modal" href="{{ url('password/email') }}"> Mot de passe oublié ?</a>
                            </span>
                        </div>
                        <div class="margin-bottom">
                            Pas encore inscrit ?
                            <span class="pull-right">
                                 <a href="{{ url('/register') }}">Créer un compte gratuitement</a>
                            </span>
                        </div>
                        <button class="btn btn-lg btn-login btn-block" type="submit">Se connecter</button>

                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
<!-- modal -->

@if(old('login') || array_key_exists('remember', old()) || session('login'))
    <script>
        $(function() {
            $('#login').modal('show');
        });
    </script>
@endif
