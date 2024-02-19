<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{asset('libs/css/plantilla_style.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <title>poa1</title>
</head>
<body class="antialiased">
<form id="form">
    <input type="text" name="uno"><br>
    <input type="text" name="dos"><br>
    <input type="text" name="tres"><br>
    <button type="submit">enviar</button>
</form>

<div class="custom-control custom-switch" id="ids">
  <input type="checkbox" class="custom-control-input" id="key" data-switch="">
  <label class="custom-control-label" for="key">Toggle this switch element</label>
</div>
<div class="custom-control custom-switch">
  <input type="checkbox" class="custom-control-input" id="key1" data-switch="">
  <label class="custom-control-label" for="key1">Toggle this switch element</label>
</div>
<div class="custom-control custom-switch">
  <input type="checkbox" class="custom-control-input" id="key2" data-switch="">
  <label class="custom-control-label" for="key2">Toggle this switch element</label>
</div>
<br>

<!-- Button trigger modal -->
<button type="button" id="boton" class="btn btn-primary" data-toggle="modal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" data-checkbox="" value="" id="defaultCheck1">
            <label class="form-check-label" for="defaultCheck1">
              Default 1
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" data-checkbox="" value="" id="defaultCheck2">
            <label class="form-check-label" for="defaultCheck2">
              Default 2
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" data-checkbox="" value="" id="defaultCheck3">
            <label class="form-check-label" for="defaultCheck3">
              Default 3
            </label>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script src="{{asset('libs/datatables/jquery-3.6.0.min.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

<script>
  const d = document;
  d.addEventListener('change', (e)=>{
    if(e.target.matches('[data-switch]')){
      alert('cambio de status');
      console.log('cambio');
    }
  });
</script>

<script type="text/javascript">
    //recorrer objeto con for of
// for (let [key, value] of data) {
// console.log(key);
// console.log(value);
// }
</script>

<script>
document.getElementById('form').addEventListener('submit', (e)=>{
    e.preventDefault();
    let form = document.getElementById('form');
    let data = new FormData(form);
    console.log(data);

    //recorrer objeto con foreach
    data.forEach((value,key) => {
          console.log(key+"//"+value)
    });

    //recorrer objeto con for of
    // for (let [key, value] of data) {
    //     console.log(key+":"+value);
    // }
    for (let [key, value] of data) {
        console.log(key);
        console.log(value);
    }

    console.log(new URLSearchParams(data).toString());

    let datosform = $('#form').serializeArray();
    console.log(datosform);
})
</script>

<script>
  // checkbox checked
  // console.log(document.querySelectorAll('input[type="checkbox"]'));
  
  document.addEventListener('click', (e) => { //evento que sirve para que al cargar la pantalla se ejecute mas rapido
    if(e.target.matches('#boton'))
    {
      $('#modal').modal('show');
      console.log(document.querySelectorAll('[data-checkbox]'));
      let $checkbox = document.querySelectorAll('[data-checkbox]');
      $checkbox.forEach((el)=>{
        if(el.id == 'defaultCheck1' || el.id == 'defaultCheck2' || el.id == 'defaultCheck3'){
          el.setAttribute('checked', true);
        }
      });
    }     
  });
</script>
    
</body>
</html>
