<div class="btn-group">
    <div class="wrapper">
        <div class="tip_btn">Editar</div>
        <button class='btn btn-primary btn-sm mr-2' data-edit=""><i class="fas fa-pen"></i></button>
    </div>

    <div class="wrapper">
        <div class="tip_btn">Eliminar</div>
        <form action="" method="POST" class="d-inline" id="form_delete">
            @csrf
            <button class="btn btn-danger btn-sm" data-delete=""><i class="fas fa-trash-alt"></i></button>
        </form>
    </div>
</div>