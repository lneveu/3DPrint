@extends('template')

@section('title')
    3DPaper - Nous contacter
@stop

@section('header')

@stop

@section('body')
    @include('breadcrumbs', array('breadcrumb_title' => 'Nous contacter', 'breadcrumb_list' => [['Accueil','/'], ['Nous contacter','/contact']]))

    <div class="container">
        <div class="row">
          <div class="col-lg-5 col-sm-5 address">
            <section class="contact-infos">
              <h4 class="title custom-font text-black">
                ADRESSE
              </h4>
              <address>
                JOUVE
                <br>
                11, boulevard Sébastopol
                <br>
                75001 Paris
                <br>
              </address>
            </section>
          </div>
          <div class="col-lg-7 col-sm-7 address">
            @if(session()->has('ok'))
                <div class="alert alert-success alert-dismissible alert-fade text-center">
                  {{ session()->get('ok') }}
                </div>
            @endif
            <div class="contact-form">
              <form role="form" method="POST" action="{{ url('/contact') }}">
                  {!! csrf_field() !!}

                <div class="form-group">
                  <label for="name">
                    * Nom
                  </label>
                  @if($errors->default->has('name'))<span class="error">{{ $errors->default->first('name') }}</span>@endif
                  <input type="text" placeholder="" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                  <label for="email">
                    * Email
                  </label>
                  @if($errors->default->has('email'))<span class="error">{{ $errors->default->first('email') }}</span>@endif
                  <input type="email" placeholder="" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                  <label for="phone">
                    Téléphone
                  </label>
                  @if($errors->default->has('phone'))<span class="error">{{ $errors->default->first('phone') }}</span>@endif
                  <input type="tel" name="phone" class="form-control" pattern="^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$">
                </div>
                <div class="form-group">
                  <label for="message">
                    * Message
                  </label>
                  @if($errors->default->has('message'))<span class="error">{{ $errors->default->first('message') }}</span>@endif
                  <textarea placeholder="" rows="5" name="message" class="form-control contact-message-area" required></textarea>
                </div>
                <button class="btn btn-orange" type="submit">
                  Envoyer
                </button>
              </form>

            </div>
          </div>
        </div>
    </div>
    <div class="footer-handler"></div>
@stop
