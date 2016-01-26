@extends('template')

@section('title')
    3DPaper
@stop

@section('header')

@stop

@section('body')

    @include('breadcrumbs', array('breadcrumb_title' => 'Édition du modèle'))

    <div class="container">

        <div class="row mar-b-50">
            @if(session()->has('ok'))
                <p class="alert alert-success text-center">{{ session()->get('ok') }}</p>
            @endif
            <div class="col-md-8">
                <form role="form" class="form-horizontal" method="POST" action="{{ url('/register') }}">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label class="col-md-1" for="title">Titre</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="title" placeholder="Titre" value="{{ $model->title }}" min="5" autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6">
                            <p><i>Dernière modification : le {{ $dateUpdate['day'] }} {{ $dateUpdate['month'] }} {{ $dateUpdate['year'] }} à {{ $model->updated_at->toTimeString() }}</i></p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2" for="scale">Échelle (%)</label>
                        <div class="col-md-4">
                            <div id="soft" class="noUi-target noUi-ltr noUi-horizontal noUi-background"></div><br/><br/><br/>
                        </div>
                        <div class="col-md-2" style="width:15%">
                            <input type="number" id="input-format" class="form-control" name="scale">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3">
                            <label>Longueur</label>
                            <p class="form-control-static">{{ $model->length }} cm</p>
                        </div>

                        <div class="col-md-3">
                            <label>Largeur</label>
                            <p class="form-control-static">{{ $model->width }} cm</p>
                        </div>

                        <div class="col-md-3">
                            <label>Hauteur</label>
                            <p class="form-control-static">{{ $model->height }} cm</p>
                        </div>

                    </div>

                    <div class="form-group">
                        <div class="col-md-3">
                            <label>Épaisseur</label>
                            <p class="form-control-static">{{ $model->thickness }} cm</p>
                        </div>

                        <div class="col-md-3">
                            <label>Surface</label>
                            <p class="form-control-static">{{ $model->surface }} cm²</p>
                        </div>

                        <div class="col-md-3">
                            <label>Volume</label>
                            <p class="form-control-static">{{ $model->volume }} cm³</p>
                        </div>

                    </div>

                </form>

            </div>

            <div class="col-md-4">
            </div>

        </div>
    </div>
@stop

@section('script')
    <script>
        var softSlider = document.getElementById('soft');

        noUiSlider.create(softSlider, {
            start: 50,
            range: {
                min: 0,
                max: 100
            },
            pips: {
                mode: 'values',
                values: [20, 80],
                density: 10
            }
        });

        softSlider.noUiSlider.on('change', function ( values, handle ) {
            if ( values[handle] < 20 ) {
                softSlider.noUiSlider.set(20);
            } else if ( values[handle] > 80 ) {
                softSlider.noUiSlider.set(80);
            }
        });

        softSlider.noUiSlider.on('set', function ( values, handle ) {
            if ( values[handle] < 20 ) {
                softSlider.noUiSlider.set(20);
            } else if ( values[handle] > 80 ) {
                softSlider.noUiSlider.set(80);
            }
        });

        var inputFormat = document.getElementById('input-format');

        softSlider.noUiSlider.on('update', function( values, handle ) {
            inputFormat.value = values[handle];
        });

        inputFormat.addEventListener('change', function(){
            softSlider.noUiSlider.set(this.value);
        });

    </script>
@stop