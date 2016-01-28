@extends('template')

@section('title')
    3DPaper - Édition du modèle
@stop

@section('header')

@stop

@section('body')

    @include('breadcrumbs', array('breadcrumb_title' => 'Édition du modèle', 'breadcrumb_list' => [['Accueil','/'], ['Dépôt du modèle','/upload-model'], ['Édition du modèle','/edit-model']]) )

    <div class="container">

        <div class="row mar-b-50">
            <div class="col-md-8">
                <form role="form" class="form-horizontal" method="POST" action="{{ url('/register') }}">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                    <input type="hidden" id="model-id" value="{{ $model->id }}">
                    <input type="hidden" id="minscale" value="{{ $model->scale_min }}">
                    <input type="hidden" id="maxscale" value="{{ $model->scale_max }}">
                    <input type="hidden" id="scale" value="{{ $model->scale }}">
                    <input type="hidden" id="file" value="{{ $model->file }}">



                    <div class="form-group">
                        <div class="col-md-6">
                            <p><i>Dernière modification : le {{ $dateUpdate['day'] }} {{ $dateUpdate['month'] }} {{ $dateUpdate['year'] }} à {{ $model->updated_at->toTimeString() }}</i></p>
                        </div>
                    </div>

                    @if(session()->has('resize'))
                        <div class="form-group">
                            <div class="col-md-6">
                                <p class="error">{{ session('resize') }}</p>
                            </div>
                        </div>
                    @endif

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
                        <div class="col-md-2">
                            <input type="number" id="input-format" class="form-control" name="scale" value="{{ $model->scale }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-1" for="scale">Unité</label>
                        <div class="col-md-5">
                            <div class="radio radio-info radio-inline">
                                <input type="radio" id="inlineRadio1" value="mm" name="unit" @if($model->unit == "mm"){{"checked"}}@endif>
                                <label for="inlineRadio1"> mm </label>
                            </div>
                            <div class="radio radio-info radio-inline">
                                <input type="radio" id="inlineRadio2" value="cm" name="unit" @if($model->unit == "cm"){{"checked"}}@endif>
                                <label for="inlineRadio2"> cm </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3">
                            <label>Longueur</label>
                            <p class="form-control-static"><span id="length">{{ $model->length }}</span> <span class="unit">{{ $model->unit }}</span></p>
                        </div>

                        <div class="col-md-3">
                            <label>Largeur</label>
                            <p class="form-control-static"><span id="width">{{ $model->width }}</span> <span class="unit">{{ $model->unit }}</span></p>
                        </div>

                        <div class="col-md-3">
                            <label>Hauteur</label>
                            <p class="form-control-static"><span id="height">{{ $model->height }}</span> <span class="unit">{{ $model->unit }}</span></p>
                        </div>

                    </div>

                    <div class="form-group">
                        <div class="col-md-3">
                            <label>Surface</label>
                            <p class="form-control-static"><span id="surface">{{ $model->surface }}</span> <span class="unit">{{ $model->unit }}</span>²</p>
                        </div>

                        <div class="col-md-3">
                            <label>Volume</label>
                            <p class="form-control-static"><span id="volume">{{ $model->volume }}</span> <span class="unit">{{ $model->unit }}</span>³</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3">
                            <p class="form-control-static"><b class="black">Prix unitaire : <span id="price">{{ $model->price }}</span> €</b></p>
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
                <div id="viewer" style="width:400px;height:400px"></div>
            </div>
        </div>

    </div>
@stop

@section('script')
    <script>
        var softSlider = document.getElementById('soft');

        var scale = parseFloat($('#scale').val());
        var scale_min = parseFloat($('#minscale').val());
        var scale_max = parseFloat($('#maxscale').val());
        var file = $('#file').val();

        createSlider(scale, scale_min, scale_max);

        function createSlider(scale, scalemin, scalemax){
            noUiSlider.create(softSlider, {
                start: scale,
                range: {
                    min: scalemin,
                    max: scalemax
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

            softSlider.noUiSlider.on('set', function( values, handle ) {
                checkDimensions(function(data){
                    scale_min = data.minscale;
                    scale_max = data.maxscale;
                    updateModel();
                });

            });

            inputFormat.addEventListener('change', function(e){
                softSlider.noUiSlider.set(this.value);
                checkDimensions(function(data){
                    scale_min = data.minscale;
                    scale_max = data.maxscale;
                    updateModel();
                });

            });

            inputFormat.addEventListener('keypress', function(e){
                if (e.keyCode == 13) {
                    softSlider.noUiSlider.set(this.value);
                    checkDimensions(function(data){
                        scale_min = data.minscale;
                        scale_max = data.maxscale;
                        updateModel();
                    });

                    e.preventDefault();
                }
            });

        }

        $('input[name=unit]').on('click', function(){

            checkDimensions(function(data){
                scale_min = data.minscale;
                scale_max = data.maxscale;
                softSlider.noUiSlider.destroy();
                createSlider(data.opts.scale, data.minscale, data.maxscale);
                updateModel();
            });


        });

        $('#input-title').on('change keyup', function(){
            updateModel();
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
            thingiview.setObjectColor('#045FB4');
            thingiview.setBackgroundColor('#6E6E6E');
            //thingiview.setCameraZoom(4);
            thingiview.setShowPlane(false);
            //thingiview.setRotation(false);

            thingiview.initScene();
            thingiview.loadSTL(location.origin+"/file/"+$('#model-id').val());

        };

        function checkDimensions(cb)
        {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "/check-dimensions",
                data: JSON.stringify({'id': $('#model-id').val(), 'file': file, 'opts' : {'scale' : parseFloat($('#input-format').val()), 'unit' : $('input[name=unit]:checked').val()}}),
                dataType: "json",
                contentType: "application/json; charset=UTF-8"
            })
            .done(function( result ) {
                $('#length').text(result.data.dimensions.length);
                $('#height').text(result.data.dimensions.height);
                $('#width').text(result.data.dimensions.width);
                $('#surface').text(result.data.dimensions.area);
                $('#volume').text(result.data.dimensions.volume);
                $('#price').text(result.data.price);
                $('.unit').text(result.data.opts.unit);

                cb(result.data);
            });
        }

        function updateModel()
        {
            var data = JSON.stringify({
                        'id': $('#model-id').val(),
                        'title' : $('#input-title').val(),
                        'scale' : parseFloat($('#input-format').val()),
                        'unit' : $('input[name=unit]:checked').val(),
                        'scalemin' : scale_min,
                        'scalemax' : scale_max,
                        'price' : parseFloat($('#price').val())
                    });
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "/edit-model",
                data: data,
                dataType: "json",
                contentType: "application/json; charset=UTF-8"
            })
            .done(function( data ) {
                $('#update-title').text('Modifications enregistrées')
            });
        }


    </script>
@stop
