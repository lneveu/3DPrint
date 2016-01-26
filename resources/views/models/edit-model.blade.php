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
            <div class="col-md-8">
                <form role="form" class="form-horizontal" method="POST" action="{{ url('/register') }}">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                    <input type="hidden" id="model-id" value="{{ $model->id }}">

                    <div class="form-group">
                        <div class="col-md-6">
                            <p><i>Dernière modification : le {{ $dateUpdate['day'] }} {{ $dateUpdate['month'] }} {{ $dateUpdate['year'] }} à {{ $model->updated_at->toTimeString() }}</i></p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-1" for="title">Titre</label>
                        <div class="col-md-5">
                            <input type="text" id="input-title" class="form-control" name="title" placeholder="Titre" value="{{ $model->title }}" min="5" autofocus>
                        </div>

                        <div class="col-md-3">
                            <p id="update-title"></p>
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="col-md-1" for="scale">Échelle</label>
                        <div class="col-md-5">
                            <div id="soft" class="noUi-target noUi-ltr noUi-horizontal noUi-background"></div><br/><br/><br/>
                        </div>
                        <div class="col-md-2" style="width:15%">
                            <input type="number" id="input-format" class="form-control" name="scale" value="{{ $model->scale }}">
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
                <div id="viewer" style="width:400px;height:400px"></div>
            </div>

        </div>
    </div>
@stop

@section('script')
    <script>
        var softSlider = document.getElementById('soft');

        noUiSlider.create(softSlider, {
            start: $('#input-format').val(),
            range: {
                min: 0,
                max: 2
            },
            pips: {
                mode: 'values',
                values: [0.1, 2],
                density: 10
            }
        });

        softSlider.noUiSlider.on('change', function ( values, handle ) {
            if ( values[handle] < 0.1 ) {
                softSlider.noUiSlider.set(0.1);
            }
        });

        softSlider.noUiSlider.on('set', function ( values, handle ) {
            if ( values[handle] < 0.1 ) {
                softSlider.noUiSlider.set(0.1);
            }
        });

        var inputFormat = document.getElementById('input-format');

        softSlider.noUiSlider.on('update', function( values, handle ) {
            inputFormat.value = values[handle];
        });

        inputFormat.addEventListener('change', function(){
            softSlider.noUiSlider.set(this.value);
        });

        $('#input-title').on('change keyup', function(){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "/edit-model/edit-title",
                data: JSON.stringify({'id': $('#model-id').val(), 'title' : $('#input-title').val()}),
                dataType: "json",
                contentType: "application/json; charset=UTF-8"
            })
            .done(function( data ) {
                $('#update-title').text('Modifications enregistrées')
            });
        });


        window.onload = function() {
            thingiurlbase = "/thingiview/javascripts";
            thingiview = new Thingiview("viewer");
            thingiview.setObjectColor('#045FB4');
            thingiview.setBackgroundColor('#6E6E6E');
            //thingiview.setCameraZoom(4);
            thingiview.setShowPlane(false);
            //thingiview.setRotation(false);

            thingiview.initScene();
            thingiview.loadSTL(location.origin+"/file/"+$('#model-id').val());

        };


    </script>
@stop