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
                                <tr>
                                    <td><img src="/img/default.png" alt="Default image" height="42" width="42"></td>
                                    <td>
                                        <div class="form-group">
                                            <label class="col-md-1" for="title">Prix</label>
                                            <div class="col-md-2">
                                                <p class="form-control-static">{{ $model->price }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-1" for="title">Quantité</label>
                                            <div class="col-md-2">
                                                <input type="number" id="quantity" class="form-control" name="quantity" value="{{ $order->quantity }}">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Sous-total</td>
                                    <td>{{ $order->sub_total }}</td>
                                </tr>
                                <tr>
                                    <td>Frais de port</td>
                                    <td>{{ $order->shipping_costs }}</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td>{{ $order->total }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <h4>Paiement</h4>
                            <div class="radio">
                                <input type="radio" name="radio1" id="radio1" value="option1" checked>
                                <label for="radio1">Méthode 1</label>
                            </div>
                            <div class="radio">
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

    </script>

@stop
