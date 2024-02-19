
@if($status === '0') {{-- USAMOS EL STATUS PARA DE LA CONSULTA DEL DATATABLE PARA PODER CAMBIAR DE BOTON SEGUN EL STATUS --}}
    <div class="btn-group">
        <button class='btn btn-primary btn-sm px-3' data-edit=""><i class="fas fa-edit"></i></button>
        {{-- las variables que usamos en la consulta las podemos llamar para hacer condiciones --}}
        {{$resultado_esperado}}
    </div>
@elseif ($status ===  '1')
    <div class="btn-group">
        <button class='btn btn-primary btn-sm px-3' data-edit=""><i class="fas fa-edit"></i></button>
        <form action="" method="POST" class="d-inline" id="form_eliminar_corto_plazo_accion">
            @csrf
            <button class='btn btn-danger btn-sm px-3' data-delete=""><i class="fas fa-trash-alt"></i></button>
        </form>
        {{$resultado_esperado}}
    </div>
@elseif ($status ===  '2')
    <div class="btn-group">
        <button class="btn btn-success btn-sm" data-operaciones="">Operaciones</button>
        {{$resultado_esperado}}
    </div>
@elseif ($status ===  '3')
    <div class="btn-group">
        <button class='btn btn-danger btn-sm'>Monitoreo</button>
        {{$resultado_esperado}}
    </div>
@endif

