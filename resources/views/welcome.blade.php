@extends('layouts.layout')

@section('page')
<div class="wide" id="all">
        <!-- HERO SLIDER SECTION-->
      <section class="text-white bg-cover bg-center primary-overlay overlay-dense">
        <div class="overlay-content py-5">
          <div class="container py-4">

              <h1 class="text-uppercase">Gesundheits-Datenbank für das ReLa der Region Zürich</h1>
              <ul class="list-unstyled text-uppercase fw-bold mb-0">
                <li class="mb-2">Zur sicheren und einfachen Verwaltung der Gesundheitsblätter von Teilnehmer und Helfer.</li>
              </ul>
          </div>
        </div>
      </section>
      <!-- SERVICES SECTION-->
      <section class="py-5">
        <div class="container py-4">
          {!! Form::open(['method' => 'GET', 'action'=>'HealthFormController@edit']) !!}
            <div class="card-body">
              @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
              @if (session()->has('success'))
                  <div class="alert alert-dismissable alert-success">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                      <strong>
                          {!! session()->get('success') !!}
                      </strong>
                  </div>
              @endif
              <div class="form-row">
                  <div class="form-group col-md-6">
                      {!! Form::label('ahv', 'AHV Nummer:') !!}
                      {!! Form::text('ahv', null, ['class' => 'form-control', 'placeholder' => '756.1234.1234.12', 'required']) !!}
                  </div>
                  <div class="form-group col-md-6">
                      {!! Form::label('birthday', 'Geburtstag:') !!}
                      {!! Form::date('birthday', null, ['class' => 'form-control'], 'required') !!}
                  </div>
              </div>
            </div>
            <div class="text-right">
              {!! Form::submit('Suchen', ['class' => 'btn btn-primary'])!!}
            </div>
          {!! Form::close()!!}
        </div>
      </section>
</div>
@endsection
