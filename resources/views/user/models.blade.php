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
                <p class="alert alert-success alert-dismissible alert-fade text-center">{{ session()->get('ok') }}</p>
            @endif

            <div id="models-table">

                <div class="col-md-12 filter">
                    <div class="row">
                        <div class="col-xs-5 col-md-2">
                            <select class="form-control select-filter">
                              <option value="0">Les + récents</option>
                              <option value="1">Les + anciens</option>
                            </select>
                        </div>
                        <div class="col-xs-7 col-md-10">
                            <input type="text" class="form-control search" placeholder="Rechercher un modèle..." />
                        </div>
                    </div>
                </div>

                <div class="col-md-12 list">
                    @foreach($models as $model)
                        <div class="col-md-3">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h3 class="name_model center">{{ $model->title }}</h3>
                                </div>
                                <img src="/img/default.png" alt="Default image">
                                <div class="caption">
                                    <p>{{ date_format($model->updated_at, 'd / m / Y') }}<span class="date_model hide">{{ $model->updated_at->timestamp }}</span><a href="/edit-model/{{ $model->id }}" class="btn btn-orange pull-right" role="button">Éditer</a></p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="footer-handler"></div>
@stop

@section('script')
    <script>
        // filter
        var options = {
          valueNames: [ 'name_model', 'date_model' ]
        };
        var modelsList = new List('models-table', options);
        modelsList.sort('date_model', { order: "desc" }); // sort desc by default
        $( ".select-filter" ).change(function()
        {
            var selected = $(this).find(":selected").val();
            switch (selected)
            {
                case "0":
                    modelsList.sort('date_model', { order: "desc" });
                    break;
                case "1":
                    modelsList.sort('date_model', { order: "asc" });
                    break;
                default:
                    break;
            }
        });
    </script>
@stop
