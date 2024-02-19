<div class="btn-group">
    <div class="wrapper">
        <div class="tip_btn">Editar</div>
        <button class='btn btn-warning btn-xm mr-2' data-edit=""><i class="fas fa-edit"></i></button>
    </div>

    <div class="wrapper">
        <div class="tip_btn">Eliminar</div>
        <form action="" method="POST" class="d-inline" id="form_delete">
            @csrf
            <button class='btn btn-danger btn-xm' data-delete=""><i class="fas fa-trash-alt"></i></button>
        </form>
    </div>
    
</div>