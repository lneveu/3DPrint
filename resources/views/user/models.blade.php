@extends('template')

@section('title')
    3DPaper - Mes modèles
@stop

@section('header')
@stop

@section('body')

    @include('breadcrumbs', array('breadcrumb_title' => 'Mes modèles', 'breadcrumb_list' => [['Accueil','/'], ['Mon compte','/account'], ['Mes modèles','/models']]))

    <div class="container">

        <div class="row">
            @if(session()->has('ok'))
                <p class="alert alert-success text-center">{{ session()->get('ok') }}</p>
            @endif

            @foreach($models as $model)
                <div class="col-md-3">
                    <div class="thumbnail">
                        <div class="caption">
                            <h3 class="center">{{ $model->title }}</h3>
                        </div>
                        <img src="/img/default.png" alt="Default image">
                        <div class="caption">
                            <p>{{ date_format($model->updated_at, 'Y / m / d') }}<a href="/edit-model/{{ $model->id }}" class="btn btn-primary pull-right" role="button">Éditer</a></p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@stop

@section('script')
    <script>

    </script>

@stop
