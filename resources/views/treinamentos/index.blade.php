@extends('layouts.treinamento-layout')

@section('title', 'Dashboard de Treinamentos')

@section('content')
<div class="container">
  <h1 class="mb-4">Bem-vindo à Área de Treinamentos</h1>
  <div class="row">
    @foreach($treinamentos as $treinamento)
      <div class="col-md-4 mb-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">{{ $treinamento->titulo }}</h5>
            <p class="card-text">{{ $treinamento->descricao }}</p>
            <a href="{{ route('treinamentos.show', $treinamento->id) }}" class="btn btn-primary">Ver Treinamento</a>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>
@endsection
