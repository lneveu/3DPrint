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

            Titre : {{ $model->title }}
        </div>
    </div>
@stop