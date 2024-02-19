@extends('layouts.plantillabase')

@section('title', 'Cambio de Password')

@section('contenido')
    <div class="card border-dark" style="width: 35rem;">
        <div class="card-header border-dark">Cambio de Contraseña</div>
        <div class="card-body text-dark">
          <h6><strong>Usuario:</strong> {{$usuario->usuario}}</h6>
          <h6><strong>Trabajador:</strong> {{$usuario->trabajador->nombre}}</h6>
          <h6> <strong>Gerencia:</strong> {{ $usuario->trabajador->unidad->gerencia->nombre_gerencia }}</h6>
          <h6> <strong>Unidad:</strong> {{ $usuario->trabajador->unidad->nombre_unidad }}</h6>
          <form id="form" method="post" action="" class="mt-4">
            @csrf
            @method ('PUT')
            <div class="form-group">
                <label><strong>Nueva Contraseña</strong></label>
                <input type="password" class="form-control" id="password" name="password" data-error="input" autocomplete="off" required>
                {{-- <span class="text-danger" id="password-span" style="display: none">El campo no admite caracteres especiales</span> --}}
                <span class="text-danger" id="password-error" data-error="span"></span>
            </div>
            <div class="form-group">
                <label><strong>Confirmar contraseña</strong></label>
                <input type="password" class="form-control" id="password_confirm" data-error="input" name="password_confirm" autocomplete="off" required>
                <span class="text-danger" id="password_confirm-error" data-error="span"></span>
            </div>
            <button type="submit" class="boton blue btn-block">Guardar</button>
          </form>
        </div>
    </div>
@endsection

@section('js')
  <script>
    var usuario_uuid = "{!!$usuario->uuid!!}";
  </script>
  <script src="{{asset('libs/js/cambio_password.js')}}"></script>
@endsection