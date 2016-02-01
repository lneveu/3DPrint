@extends('template')

@section('title')
    3DPaper - Mes commandes
@stop

@section('header')
@stop

@section('body')

    @include('breadcrumbs', array('breadcrumb_title' => 'Mes commandes', 'breadcrumb_list' => [['Accueil','/'], ['Mon compte','/account'], ['Mes commandes','/orders']]))

    <div class="container">

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <table class="table table-striped table-bordered sortable orders-table">
                    <tr>
                        <th>N° de commande</th>
                        <th>Date</th>
                        <th>Détails</th>
                        <th>Montant</th>
                        <th>Statut</th>
                    </tr>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ date_format($order->updated_at, 'd / m / Y') }}</td>
                            <td>{{ $order->model->title }}</td>
                            <td>{{ $order->total }} €</td>
                            <td><span class="pull-left">{{ $order->state }}</span><a href="/order/{{ $order->id }}" class="btn btn-orange pull-right" role="button">Voir</a></td>
                        </tr>
                    @endforeach
                </table>
                <div class="center">{!! $orders->render() !!}</div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
    <div class="footer-handler"></div>
@stop

@section('script')
    <script>

    </script>

@stop
