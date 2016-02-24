@extends('template')

@section('title')
    3DPaper - Édition du modèle
@stop

@section('header')

@stop

@section('body')

    @include('breadcrumbs', array('breadcrumb_title' => 'Édition du modèle', 'breadcrumb_list' => [['Accueil','/'], ['Dépôt du modèle','/upload-model'], ['Édition du modèle','/edit-model']]) )

    <div class="container">

        <div class="row">
            <div class="col-md-6">
                <form id="form-new-order" role="form" class="form-horizontal" method="POST" action="{{ url('/order/new') }}">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                    <input type="hidden" id="model-id" name="model-id" value="{{ $model->id }}">
                    <input type="hidden" id="state" name="state" value="{{ $model->state }}">
                    <input type="hidden" id="minscale" value="{{ $model->scale_min }}">
                    <input type="hidden" id="maxscale" value="{{ $model->scale_max }}">
                    <input type="hidden" id="scale" value="{{ $model->scale }}">
                    <input type="hidden" id="file" value="{{ $model->file }}">
                    <input type="hidden" id="ext" value="{{ $model->extension }}">
                    <input type="hidden" id="img" value="{{ $model->img }}">

                    @if(session()->has('resize'))
                        <div class="error alert alert-danger alert-dismissible text-center">
                            {{ session('resize') }}
                        </div>
                    @endif

                    @if($errors->first->has('state'))
                        <div class="error alert alert-danger alert-dismissible text-center">
                            {{ $errors->first->get('state') }}
                        </div>
                    @endif

                    <div class="form-group">
                        <div class="col-md-12">
                            <p><i>Dernière modification : le {{ $dateUpdate['day'] }} {{ $dateUpdate['month'] }} {{ $dateUpdate['year'] }} à {{ $model->updated_at->toTimeString() }}</i></p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2" for="title">Titre</label>
                        <div class="col-md-5">
                            <input type="text" id="input-title" class="form-control" name="title" placeholder="Titre" value="{{ $model->title }}" min="5" autofocus>
                        </div>
                        <div class="col-md-5">
                            <div id="update_popup" class="alert alert-success text-center" style="display:none;">Modifications enregistrées</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 col-sm-12 col-xs-12" for="scale">Échelle</label>
                        <div class="col-md-5 col-xs-9">
                            <div id="soft" class="noUi-target noUi-ltr noUi-horizontal noUi-background"></div><br/><br/><br/>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <input type="number" id="input-format" class="form-control" step="0.01" name="scale" value="{{ $model->scale }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 col-sm-12" for="scale">Unité</label>
                        <div class="col-md-5 col-sm-12">
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
                        <div class="col-md-4 col-xs-4">
                            <label>Longueur</label>
                            <p class="form-control-static"><span id="length">{{ $model->length }}</span> <span class="unit">{{ $model->unit }}</span></p>
                        </div>

                        <div class="col-md-4 col-xs-4">
                            <label>Largeur</label>
                            <p class="form-control-static"><span id="width">{{ $model->width }}</span> <span class="unit">{{ $model->unit }}</span></p>
                        </div>

                        <div class="col-md-4 col-xs-4">
                            <label>Hauteur</label>
                            <p class="form-control-static"><span id="height">{{ $model->height }}</span> <span class="unit">{{ $model->unit }}</span></p>
                        </div>

                    </div>

                    <div class="form-group">
                        <div class="col-md-4 col-xs-4">
                            <label>Surface</label>
                            <p class="form-control-static"><span id="surface">{{ $model->surface }}</span> <span class="unit">{{ $model->unit }}</span>²</p>
                        </div>

                        <div class="col-md-4 col-xs-4">
                            <label>Volume</label>
                            <p class="form-control-static"><span id="volume">{{ $model->volume }}</span> <span class="unit">{{ $model->unit }}</span>³</p>
                        </div>
                    </div>
                </form>

            </div>

            <div class="col-md-6">
                <div id="viewer"></div>
                    <!-- warning -->
                    @if($model->state == "1" && !session()->has('resize'))
                        <div class="alert alert-danger text-center warning-msg">
                            Attention, votre modèle a été redimensionné car il est trop grand.<br> Nous vous conseillons de le modifier puis de le re-déposer sur notre site.
                        </div>
                    @elseif($model->state == "2" && !session()->has('resize'))
                        <div class="alert alert-danger text-center warning-msg">
                            Attention, votre objet est peut-être trop petit ou trop fin pour être imprimer.<br> Veuillez modifier son échelle ou re-déposer votre modèle une fois modifié.
                        </div>
                    @else
                        <div class="alert alert-danger text-center warning-msg hide">
                        </div>
                    @endif
                    <!-- end warning -->
            </div>
        </div>

        <div class="row mar-b-50 row-eq-height">
            <div class="col-md-6 col-xs-5">
                <a href="" class="btn btn-danger delete_model_btn" data-toggle="modal" data-target="#delete-model-modal" id="delete"><span class="glyphicon glyphicon-remove white" aria-hidden="true"></span>  Supprimer</a>

            </div>
            <div class="col-md-6 col-xs-7">
                <div class="pull-right">
                    <p class="form-control-static"><b class="black">Prix unitaire : <span id="price">{{ $model->price }}</span> €</b></p>
                    <br>
                    <input type="submit" class="btn btn-lg btn-print" form="form-new-order" value="Imprimer">
                </div>
            </div>
        </div>

    </div>
    <div class="footer-handler"></div>

    <!-- delete modale modal -->
    <div aria-hidden="true" aria-labelledby="delete-model-modal" role="dialog" tabindex="-1" id="delete-model-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Supprimer</h4>
                </div>
                <div class="modal-body">
                    <form id="delete-model-form" class="form-signin wow fadeInUp" method="GET" action="{{ url('/delete-model/'.$model->id) }}">
                            <p>Voulez-vous vraiment supprimer ce modèle ?</p>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button form="delete-model-form" class="btn btn-danger" type="submit">Supprimer</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script src="/js/paperviewer/three.min.js"></script>
    <script src="/js/paperviewer/NormalControls.js"></script>
    <script src="/js/paperviewer/OBJLoader.js"></script>
    <script src="/js/paperviewer/STLLoader.js"></script>
    <script src="/js/paperviewer/paperviewer.js"></script>

    <script>
        var softSlider = document.getElementById('soft');

        var scale = parseFloat($('#scale').val());
        var scale_min = parseFloat($('#minscale').val());
        var scale_max = parseFloat($('#maxscale').val());
        var file = $('#file').val();
        var timerTyping = null;

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
                        decimals: 2
                    })
                },
                format: wNumb({
                    decimals: 2
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

        $('#input-title').keydown(function(){
               clearTimeout(timerTyping);
               timerTyping = setTimeout(updateModel, 700)
        });

        $( document ).ready(function()
        {
            // load viewer
            var viewer = new PaperViewer();
            viewer.init("viewer", location.origin+"/file/"+$('#model-id').val(), $('#ext').val(), function()
            {
                if( $("#img").val() === "" )
                {
                    var dataurl = viewer.takeScreenshot();
                    // save image
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        url: "/save-image",
                        data: JSON.stringify({'id': $('#model-id').val(), 'img': dataurl}),
                        dataType: "json",
                        contentType: "application/json; charset=UTF-8"
                    });
                }
            });

        });

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
                $('#state').val(result.data.code);
                $('.unit').text(result.data.opts.unit);

                // show warning if needed
                if(result.data.code === 2)
                {
                    $(".warning-msg").html("");
                    $(".warning-msg").html("Attention, votre objet est peut-être trop petit ou trop fin pour être imprimer.<br> Veuillez modifier son échelle ou re-déposer votre modèle une fois modifié.");
                    $(".warning-msg").removeClass("hide");
                }
                else if(result.data.code === 1)
                {
                    $(".warning-msg").html("");
                    $(".warning-msg").html("Attention, votre modèle a été redimensionné car il est trop grand.<br> Veuillez modifier son échelle ou re-déposer votre modèle une fois modifié.");
                    $(".warning-msg").removeClass("hide");
                }
                else
                {
                    $(".warning-msg").removeClass("hide").addClass("hide");
                    $(".warning-msg").html("");
                }
                cb(result.data);
            });
        }

        var update_popup = "<div class=\"alert alert-success alert-dismissible alert-fade text-center update_popup \">Modifications enregistrées</div>";

        function updateModel()
        {
            var data = JSON.stringify({
                        'id': $('#model-id').val(),
                        'title' : $('#input-title').val(),
                        'scale' : parseFloat($('#input-format').val()),
                        'unit' : $('input[name=unit]:checked').val(),
                        'scalemin' : scale_min,
                        'scalemax' : scale_max,
                        'price' : parseFloat($('#price').text()),
                        'length' : parseFloat($('#length').text()),
                        'width' : parseFloat($('#width').text()),
                        'height' : parseFloat($('#height').text()),
                        'volume' : parseFloat($('#volume').text()),
                        'surface' : parseFloat($('#surface').text()),
                        'state' : $('#state').val()
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
                if( !$('#update_popup').is(':visible'))
                {
                    $('#update_popup').show();
                    setTimeout(function()
                    {
                        $('#update_popup').fadeOut(500);
                    }, 2000);
                }
            });
        }


    </script>
@stop
