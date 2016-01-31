@extends('template')

@section('title')
    3DPaper - Commande
@stop

@section('header')
@stop

@section('body')

    @include('breadcrumbs', array('breadcrumb_title' => 'Commande', 'breadcrumb_list' =>
    [['Accueil','/'], ['Dépôt du modèle','/upload-model'], ['Édition du modèle','/edit-model/'.$model->id], ['Commande','/order/'.$order->id]]))

    <div class="container">

        <div class="row mar-b-50">

            <form role="form" class="form-horizontal" action="#">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="col-md-6">
                            <h4>Ma commande</h4>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <table class="table bordered">
                                <tr>
                                    <td colspan="2">{{ $model->title }}</td>
                                </tr>
                                <tr class="bd-top">
                                    <td><img src="/img/default.png" alt="Default image" height="125" width="125"></td>
                                    <td>
                                        <table>
                                        <tr>
                                            <td>
                                                <b>Prix</b>
                                            </td>
                                             <td>
                                                 <div class="col-md-6">
                                                     <span id="price">{{ $model->price }}</span> €
                                                 </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Quantité</b>
                                            </td>
                                            <td>
                                                <div class="col-md-6">
                                                    <input type="number" id="quantity" class="form-control" name="quantity" value="{{ $order->quantity }}" min="1">
                                                </div>
                                            </td>
                                        </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr class="bd-top">
                                    <td><b>Sous-total</b></td>
                                    <td><span id="sub-total">{{ $order->sub_total }}</span> €</td>
                                </tr>
                                <tr>
                                    <td><b>Frais de port</b></td>
                                    <td>{{ $order->shipping_costs }}</td>
                                </tr>
                                <tr class="bd-top">
                                    <td><b>Total</b></td>
                                    <td><span id="total">{{ $order->total }}</span> €</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <h4>Paiement</h4>
                            <div class="radio radio-info">
                                <input type="radio" name="radio1" id="radio1" value="option1" checked>
                                <label for="radio1">Méthode 1</label>
                            </div>
                            <div class="radio radio-info">
                                <input type="radio" name="radio1" id="radio2" value="option2">
                                <label for="radio2">Méthode 2</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>

                <div class="col-md-4">
                    <div class="form-group">
                        <div class="col-md-6">
                            <h4>Addresse d'envoi</h4>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-group">
                            <div class="col-md-12">
                                <label>Nom</label>
                                <input type="text" class="form-control" name="name" placeholder="Nom" value="{{ $user->name }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <label>Prénom</label>
                                <input type="text" class="form-control" name="firstname" placeholder="Prénom" value="{{ $user->firstname }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <label>Adresse</label>
                                <input type="text" class="form-control" name="address" placeholder="Adresse" value="{{ $user->address }}"><br/>
                                <input type="text" class="form-control" name="address_cpl" placeholder="Complément d'adresse" value="{{ $user->address_cpl }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <label>Code postal</label>
                                <input type="text" class="form-control" name="cp" placeholder="Code postal" value="{{ $user->cp }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <label>Ville</label>
                                <input type="text" class="form-control" name="city" placeholder="Ville" value="{{ $user->city }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <label>Téléphone</label>
                                <input type="text" class="form-control" name="phone" placeholder="Téléphone" value="{{ $user->phone }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <br/>
                                <input type="submit" class="btn btn-lg btn-login pull-right disabled" value="Comfirmer">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>

        $('#quantity').on('change input keypress', function(e){
            updatePrices();
            if (e.keyCode == 13) {
                e.preventDefault();
            }
        });

        function updatePrices()
        {
            var price = parseFloat($('#price').text());
            var quantity = $('#quantity').val();

            var subTotal = (quantity * price).toFixed(2);

            $('#sub-total').text(subTotal);
            $('#total').text(subTotal);
        }

    </script>

@stop
