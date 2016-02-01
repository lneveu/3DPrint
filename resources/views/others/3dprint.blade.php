@extends('template')

@section('title')
    3DPaper - Impression 3D
@stop

@section('header')

@stop

@section('body')
    @include('breadcrumbs', array('breadcrumb_title' => 'Impression 3D', 'breadcrumb_list' => [['Accueil','/'], ['Impression 3D','/3dprint']]))

    <div class="container">
        <div class="row mar-b-50 paperprint">
            <h2>L'impression 3D papier, qu'est-ce que c'est ?</h2>
            <p> &nbsp; </p>
            <h3>Qu’est-ce que l’impression 3D en général ?</h3>
            <p> &nbsp; </p>
            <h3>Pourquoi choisir le papier ?</h3>
            <p> &nbsp; </p>
            <h3>Fonctionnement et procédés utilisés</h3>
            <p> &nbsp; </p>
            <a href="{{ url('/upload-model') }}" class="btn btn-orange btn-lg">
              Déposer votre modèle
            </a>
        </div>
    </div>
    <div class="footer-handler"></div>
@stop
