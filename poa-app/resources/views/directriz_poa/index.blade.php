@extends('layouts.plantillabase')

@section('title', 'Generar Directriz')

@section('css')
@endsection

@section('contenido')
    <div class="card text-center">
        <h5 class="card-header bg-dark text-white">Generar Reporte Directriz</h5>
        <div class="card-body border border-dark">
            <form action="{{ route('directriz_pdf') }}" target="_blank">
                @csrf @method('get')
                <div class="form-group row d-flex justify-content-center">
                    <div class="col-xs-2">
                        <label>Seleccione la Gestión.</label>
                        <select class="form-control" name="gestion" id="" required>
                            <option value="">__ Seleccione __</option>
                            @foreach ($gestion_pilares as $g)
                                <option value="{{ $g->gestion_pilar }}">{{ $g->gestion_pilar }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit" class="boton blue">Enviar</button>
            </form>
        </div>
    </div>
@endsection

@section('js')
    {{-- <script src="{{asset('libs/js/admin_poa.js')}}"></script> --}}
@endsection
