<!DOCTYPE html>
<html>
<head>
	<title>Login Poa</title>
	<!--bootstrap-->
	<link rel="stylesheet" href="{{asset('css/app.css')}}">

	<!--asset nos posiciona en la carpeta public-->
	<link rel="stylesheet" type="text/css" href="{{asset('libs/css/login/style.css')}}">
	
	<!--fontawezome-->
    <link rel="stylesheet" href="{{asset('libs/fontawesome/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('libs/fontawesome/fontawesome.min.css')}}">
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<style>
	.is-invalid {
		border: 1px solid #dc3545 !important;
	}
</style>
<body>
	<div class="contenedor">
		<div style="display: none" id="alertError" class="alert alert-danger alert-dismissible fade show border border-danger m-0" role="alert"></div>

		<div class="caja">
			<div class="caja-header">
				<img src="{{asset('libs/css/login/img/login_elapas.png')}}" alt="">
			</div>
			<div class="caja-body">
				<form action="" method="POST" id="form" autocomplete="off">
					@csrf
					<div class="form-group mb-2">
						<label>Documento / CI</label>
						<input type="number" data-error="input" id="usuario" name="usuario" placeholder="Documento">
						<span class="text-danger" data-error="span" id="usuario-error"></span>
					</div>
					<div class="form-group mb-2">
						<label>Contraseña</label>
						<input type="password" data-error="input" id="password" name="password" placeholder="Contraseña">
						<span class="text-danger" data-error="span" id="password-error"></span>
					</div>
					<button type="submit" class="btn btn-primary btn-block mt-3" id="btn-login">Ingresar</button>
				</form>
			</div>
		</div>
	</div>

	<!--script bootstrap-->
	<script>
      const app_url = "{{ config('app.url') }}";
	</script>

	<script src="{{asset('js/app.js')}}"></script>

	<script src="{{asset('libs/js/validacionform/login.js')}}"></script>

	
</body>
</html>
