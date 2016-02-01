@extends('template')

@section('title')
    3DPaper - Expertise
@stop

@section('header')

@stop

@section('body')
    @include('breadcrumbs', array('breadcrumb_title' => 'Notre expertise', 'breadcrumb_list' => [['Accueil','/'], ['Notre expertise','/expertise']]))

    <div class="container">
        <div class="row mar-b-50 expertise">
            <h2>Du dépôt de votre modèle à la réception de votre objet</h2>
            <p> &nbsp; </p>
            <h3>A propos de "3DPaper"<h3>
            <p> &nbsp; </p>
            <h3>Principe de la plateforme</h3>
            <p> &nbsp; </p>
            <h3>Points forts</h3>
            <p> &nbsp; </p>
            <h3>Processus de production</h3>
            <p> &nbsp; </p>
        </div>
    </div>
    <div class="footer-handler"></div>
@stop
