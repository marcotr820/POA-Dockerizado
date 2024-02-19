@extends('layouts.plantillabase')

@section('contenido')
    <select class="form-control" name="" id="select">

    </select>
@endsection

@section('js')
    <script>
        $('#select').select2({
            theme: 'bootstrap4',
            minimumResultsForSearch: -1,
            placeholder: '__Seleccione__',
            ajax: {
                url: '/data',
                type: "get",
                dataType: 'json',
                processResults: function(data) {
                    return {
                        results: $.map(data, function(obj) {
                            return {
                                id: obj.id,
                                text: obj.nombre_gerencia
                            };
                        })
                    };
                }
            }
        });
    </script>
@endsection
