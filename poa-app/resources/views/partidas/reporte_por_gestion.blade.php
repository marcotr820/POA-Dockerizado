@extends('layouts.plantillabase')

@section('title', 'Reporte Por Gestión Partida')

@section('contenido')
<div class="card">
    <h5 class="card-header bg-dark text-white">Generar Reporte POA Partidas</h5>
    <div class="card-body border border-dark" style="height: 20em;">
        {{-- <form action="{{ route('pdf_partidas_grupo') }}" target="_blank">
            @csrf @method('get')
            <div class="form-group row d-flex justify-content-center">
                <div class="col-xs-2">
                    <label>Seleccione la Gestión.</label>
                    <select class="form-control" name="gestion" required>
                        <option value="">__Seleccione__</option>
                        @foreach ($gestiones as $gestion)
                            <option value="{{ $gestion->gestion_pilar }}">{{ $gestion->gestion_pilar }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="boton blue">Enviar</button>
        </form> --}}

        <div class="row">
            <div class="col-4">
                <div class="list-group border border-dark" id="list-tab" role="tablist">
                    <a class="list-group-item list-group-item-action active" id="list-area1-list" data-toggle="list"
                        href="#list-area1" role="tab" aria-controls="area1">Partidas Por Grupos</a>
                    <a class="list-group-item list-group-item-action" id="list-area2-list" data-toggle="list"
                        href="#list-area2" role="tab" aria-controls="area2">Partidas Por SubGrupos</a>
                    <a class="list-group-item list-group-item-action" id="list-area3-list" data-toggle="list"
                        href="#list-area3" role="tab" aria-controls="area3">Partidas Gerencia Por Grupos</a>
                    <a class="list-group-item list-group-item-action" id="list-area4-list" data-toggle="list"
                        href="#list-area4" role="tab" aria-controls="area4">Partidas Gerencia Por SubGrupos</a>
                </div>
            </div>
            <div class="col-8">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="list-area1" role="tabpanel" aria-labelledby="list-area1-list">
                        <div class="card border-dark" style="width: 100%;">
                            <div class="card-body text-center">
                                <form action="{{ route('pdf_partidas_grupo') }}" target="_blank">
                                    @csrf @method('get')
                                    <div class="form-group row d-flex justify-content-center">
                                        <div class="col-xs-2">
                                            <label>Seleccione la Gestión.</label>
                                            <select class="form-control" name="gestion" required>
                                                <option value="">__Seleccione__</option>
                                                @foreach ($gestiones as $gestion)
                                                    <option value="{{ $gestion->gestion_pilar }}">{{ $gestion->gestion_pilar }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="boton blue">Enviar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="list-area2" role="tabpanel" aria-labelledby="list-area2-list">
                        <div class="card border-dark" style="width: 100%;">
                            <div class="card-body text-center">
                                <form action="{{ route('pdf_sub_grupos_partidas') }}" target="_blank">
                                    @csrf @method('get')
                                    <div class="form-group row d-flex justify-content-center">
                                        <div class="col-xs-2">
                                            <label>Seleccione la Gestión.</label>
                                            <select class="form-control" name="gestion" id="" required>
                                                <option value="">__ Seleccione __</option>
                                                @foreach ($gestiones as $gestion)
                                                    <option value="{{ $gestion->gestion_pilar }}">{{ $gestion->gestion_pilar }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="boton blue">Enviar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="list-area3" role="tabpanel" aria-labelledby="list-area3-list">
                        <div class="card border-dark" style="width: 100%;">
                            <div class="card-body text-center">
                                <form action="{{ route('pdf_gerencia_grupo_partidas') }}" target="_blank">
                                    @csrf @method('get')
                                    <div class="form-group row d-flex justify-content-center">
                                        <div class="col-6">
                                            <label>Seleccione la Gerencia.</label>
                                            <select class="form-control" name="gerencia_uuid" id="" required>
                                                <option value="">__ Seleccione __</option>
                                                @foreach ($gerencias as $gerencia)
                                                    <option value="{{ $gerencia->uuid }}">{{ $gerencia->nombre_gerencia }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row d-flex justify-content-center">
                                        <div class="col-3">
                                            <label>Seleccione la Gestión.</label>
                                            <select class="form-control" name="gestion" id="" required>
                                                <option value="">__ Seleccione __</option>
                                                @foreach ($gestiones as $gestion)
                                                    <option value="{{ $gestion->gestion_pilar }}">{{ $gestion->gestion_pilar }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="boton blue">Enviar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="list-area4" role="tabpanel" aria-labelledby="list-area4-list">
                        <div class="card border-dark" style="width: 100%;">
                            <div class="card-body text-center">
                                <form action="{{ route('pdf_gerencia_subgrupo_partidas') }}" target="_blank">
                                    @csrf @method('get')
                                    <div class="form-group row d-flex justify-content-center">
                                        <div class="col-6">
                                            <label>Seleccione la Gerencia.</label>
                                            <select class="form-control" name="gerencia_uuid" id="" required>
                                                <option value="">__ Seleccione __</option>
                                                @foreach ($gerencias as $gerencia)
                                                    <option value="{{ $gerencia->uuid }}">{{ $gerencia->nombre_gerencia }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row d-flex justify-content-center">
                                        <div class="col-3">
                                            <label>Seleccione la Gestión.</label>
                                            <select class="form-control" name="gestion" id="" required>
                                                <option value="">__ Seleccione __</option>
                                                @foreach ($gestiones as $gestion)
                                                    <option value="{{ $gestion->gestion_pilar }}">{{ $gestion->gestion_pilar }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="boton blue">Enviar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('js')
@endsection