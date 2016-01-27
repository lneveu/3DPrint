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
                        <label class="col-md-1" for="scale">Unité</label>
                        <div class="col-md-5">
                            <div class="radio radio-info radio-inline">
                                <input type="radio" id="inlineRadio1" value="mm" name="radioInline" checked>
                                <label for="inlineRadio1"> mm </label>
                            </div>
                            <div class="radio radio-info radio-inline">
                                <input type="radio" id="inlineRadio2" value="cm" name="radioInline">
                                <label for="inlineRadio2"> cm </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3">
                            <label>Longueur</label>
                            <p class="form-control-static">{{ $model->length }} {{ $model->unit }}</p>
                        </div>

                        <div class="col-md-3">
                            <label>Largeur</label>
                            <p class="form-control-static">{{ $model->width }} {{ $model->unit }}</p>
                        </div>

                        <div class="col-md-3">
                            <label>Hauteur</label>
                            <p class="form-control-static">{{ $model->height }} {{ $model->unit }}</p>
                        </div>

                    </div>

                    <div class="form-group">
                        <div class="col-md-3">
                            <label>Surface</label>
                            <p class="form-control-static">{{ $model->surface }} {{ $model->unit }}²</p>
                        </div>

                        <div class="col-md-3">
                            <label>Volume</label>
                            <p class="form-control-static">{{ $model->volume }} {{ $model->unit }}³</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3">
                            <p class="form-control-static"><b class="black">Prix unitaire : {{ $model->price }} €</b></p>
                        </div>

                        <div class="col-md-3"></div>

                        <div class="col-md-3">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3">
                            <br/>
                            <a href="{{ url('/delete-model/'.$model->id) }}" class="btn btn-danger" role="button" id="delete"><span class="glyphicon glyphicon-remove white" aria-hidden="true"></span>  Supprimer</a>
                        </div>

                        <div class="col-md-3"></div>

                        <div class="col-md-3">
                            <br/>
                            <input type="submit" class="btn btn-lg btn-login" value="Imprimer">
                        </div>
                    </div>

                </form>

            </div>

            <div class="col-md-4">
                <div id="viewer" style="width:600px;height:400px"></div>
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
                min: 0.1,
                max: 7.5
            },
            pips: {
                mode: 'range',
                density: 3,
                format: wNumb({
                    decimals: 1
                })
            },
            format: wNumb({
                decimals: 1
            })
        });

        var inputFormat = document.getElementById('input-format');

        softSlider.noUiSlider.on('update', function( values, handle ) {
            inputFormat.value = values[handle];
        });

        inputFormat.addEventListener('change', function(e){
            softSlider.noUiSlider.set(this.value);
        });

        inputFormat.addEventListener('keypress', function(e){
            if (e.keyCode == 13) {
                softSlider.noUiSlider.set(this.value);
                e.preventDefault();
            }
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

        $('#delete').on('click',function(e){
            var answer=confirm('Voulez vous vraiment supprimer ce modèle ?');
            if(!answer){
                e.preventDefault();
            }
        });


        window.onload = function() {
            thingiurlbase = "/thingiview/javascripts";
            thingiview = new Thingiview("viewer");
            //thingiview.setObjectColor('#045FB4');
            thingiview.setBackgroundColor('#6E6E6E');
            //thingiview.setCameraZoom(4);
            thingiview.setShowPlane(false);
            //thingiview.setRotation(false);

            thingiview.initScene();
            thingiview.loadSTL(location.origin+"/file/"+$('#model-id').val());

        };


    </script>
@stop
