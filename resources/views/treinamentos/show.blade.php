{{-- resources/views/treinamentos/show.blade.php --}}
@extends('layouts.treinamento-layout') 
{{-- Se você tiver um layout específico para treinamentos, substitua pelo seu layout. --}}

@section('title', $treinamento->titulo)

@section('content')
<div class="container my-4">
    <h1>{{ $treinamento->titulo }}</h1>
    <p class="text-muted">{{ $treinamento->descricao }}</p>
    
    <!-- Se houver um campo "conteudo" no banco, você pode exibir aqui -->
    {{-- {!! $treinamento->conteudo !!} --}}
    
    <p>Aqui é a página interna do treinamento. Adicione o que precisar!</p>
</div>
@endsection
