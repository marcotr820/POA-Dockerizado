@extends('layouts.plantillabase')

@section('title', 'Index POA')

@section('contenido')
<style>
    .contenedor{
        display: flex;
        align-items: center;
        padding: 15px;
        background-color: #ddd;
        border: 1px solid;
        border-radius: 10px;
    }
    .contenedor .index-img{
        padding: 0 15px;
    }
    .contenedor .index-content{
        font-size: 30px;
    }
</style>
    <div class="contenedor">
        <div class="index-img">
            <img src="{{ asset('libs/img/logo_gota_agua.png') }}" alt="..." width="170px">
        </div>
        <div class="index-content">
            <h3>Plan Operativo Anual | ELAPAS</h3>
            <h3>Bienvenido.</h3>
            <h3>Iniciado Sesión como: <span class="badge badge-secondary">{{ ucwords(strtolower(auth('usuario')->user()->trabajador->nombre)) }}</span></h3>
            {{-- @foreach (auth('usuario')->user()->roles as $rol)
                {{ $rol->name }} <br>
            @endforeach --}}
        </div>
    </div>

@endsection

@section('js')
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "100",
            "hideDuration": "1000",
            "timeOut": "1000"
        }
        // toastr["success"]("My name is Inigo Montoya. You killed my father. Prepare to die!");
        // toastr["error"]("Are you the six fingered man?");
        // toastr["warning"]("Inconceivable!");
    </script>
@endsection
