@extends('template')

@section('title')
    3DPaper - Page introuvable
@stop

@section('header')

@stop

@section('body')

    <div class="container">

        <div class="row mar-b-50">
            <div class="container  error-inner wow flipInX">
                <h1>Page introuvable.</h1>
                <p class="text-center">Désolé, la page que vous recherchez est introuvable.</p>
                <a class="btn btn-orange" href="{{ url('/') }}">Retourner à l'accueil</a>
            </div>
        </div>
    </div>
@stop

@section('script')
<script>
    wow = new WOW(
      {
        boxClass:     'wow',      // default
        animateClass: 'animated', // default
        offset:       0          // default
      }
    )
    wow.init();
</script>
@stop
