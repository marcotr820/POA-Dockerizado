@extends('layouts.plantillabase')

@section('title', 'Lista POA')

@section('css')
<style>
    table {
        margin: 6px 0;
        font-size: 0.65rem;
        font-weight: 600;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        text-align: center;
    }
    table th,
    td {
        border: 0.5px solid #808080;
        padding: 4px;
    }
</style>
    {{-- para usar las funcionalidades de livewire se debe agregar los stylos --}}
    @livewireStyles
@endsection

@section('contenido')
    {{-- para llamar un componente livewire usamos la etiqueta blade --}}
    @livewire('ver-poas.ver-poas-component')
@endsection

@section('js')
    {{-- para usar las funcionalidades de livewire se debe agregar los js --}}
    @livewireScripts
@endsection
