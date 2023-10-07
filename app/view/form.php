<!DOCTYPE html>
<html>

<head>
	<title>Imobiliária ERP</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sticky-footer/">
	<link href="https://getbootstrap.com/docs/4.0/examples/sticky-footer/sticky-footer.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
	<script src="http://localhost/poo-crud-php/app/asserts/js/main.js"></script>
	<link rel="stylesheet" href="http://localhost/poo-crud-php/app/asserts/css/main.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
	<div class="container">
		<!-- Begin page content -->
		<main role="main" class="container">
			<h1 class="mt-5">Imovel</h1>
			<p class="lead">Pin a fixed-height footer to the bottom of the viewport in desktop browsers with this custom HTML and CSS.</p>
			<p>Use <a href="../sticky-footer-navbar/">the sticky footer with a fixed navbar</a> if need be, too.</p>
		</main>
		<div class="alert alert-danger d-none" id="alertNotFound" role="alert">
			<h2 class="text-center">Imovel não localizado no sistema</h2>
		</div>
		<div class="card">
			<div class="card-body">
				<form>
					<input type="hidden" id="idImovel" value="<?php echo $idImovel ?? 0; ?>">
					<div class="form-group form-row">
						<div class="col">
							<label for="tipoImovel">Tipo</label>
							<select class="form-control" id="tipoImovel">
								<?php
								foreach ($typesImoveis as $type) {
									echo "<option value='{$type}'>" . ucwords($type) . "</option>";
								}
								?>
							</select>
							<small class="form-text text-muted">Tipos de imoveis diponiveis.</small>
						</div>
						<div class="col">
							<label for="statusImovel">Status</label>
							<select class="form-control" id="statusImovel">
								<?php
								foreach ($statusImoveis as $type) {
									echo "<option value='{$type}'>" . ucwords($type) . "</option>";
								}
								?>
							</select>
							<small class="form-text text-muted">Situação atual do imovel.</small>
						</div>
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1">Endereço</label>
						<input type="text" class="form-control" id="enderecoImovel" placeholder="Endereço">
						<small class="form-text text-muted">Endereço/localização do imovel.</small>
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1">Preço R$</label>
						<input type="text" class="form-control" id="precoImovel" placeholder="R$">
					</div>
					<button type="button" id="buttonFormImovel" class="btn btn-primary"></button>
					<button type="button" id="buttonShowDeleteImovel" class="btn btn-outline-danger float-right d-none" data-toggle="modal" data-target="#exampleModalLong">Delete</button>
				</form>
			</div>
		</div>
	</div>

	<br>
	<br>

	<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">Exclusão de imovel</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					Você deseja excluir o registro desse imovel ?
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
					<button type="button" class="btn btn-primary" id="buttonDeleteImovel">Excluir definitivamente</button>
				</div>
			</div>
		</div>
	</div>

	<footer class="footer">
		<div class="container">
			<span class="text-muted">Place sticky footer content here.</span>
		</div>
	</footer>
</body>

</html>

<script>
	$(document).ready(function() {
		$('input#precoImovel').mask('000.000.000.000.000,00', {
			reverse: true
		});

		$('#myModal').on('shown.bs.modal', function() {
			$('#myInput').trigger('focus')
		})

		loading();
		let actionForm = {
			'method': 'POST',
			'url': ''
		};
		const idImovel = $('input#idImovel').val();
		if (idImovel > 0) {
			$('button#buttonFormImovel').html('Editar Imóvel');

			$.ajax({
				beforeSend: function(request) {
					request.setRequestHeader("Authorization", 'Bearer tttt');
				},
				dataType: "json",
				url: '../' + idImovel,
				success: function(data) {
					const imovel = data;

					actionForm.method = 'PUT';
					actionForm.url = imovel.id + '/' + imovel.tipo;

					$('select#tipoImovel option[value="' + imovel.tipo + '"]').prop("selected", true);
					$('select#tipoImovel').prop("disabled", true);
					$('select#tipoImovel option[value!="' + imovel.tipo + '"]').remove();
					$('select#statusImovel option[value="' + imovel.status + '"]').prop("selected", true);
					$('input#enderecoImovel').val(imovel.endereco);
					$('input#precoImovel').val(new Intl.NumberFormat().format(imovel.preco));
					loading('close');

					$('button#buttonShowDeleteImovel').removeClass('d-none');
				},
				statusCode: {
					404: function() {
						$('#alertNotFound').removeClass('d-none');
						setTimeout(function() {
							window.location.href = '../../home';
						}, 3000);
					}
				}
			});
		} else {
			$('button#buttonFormImovel').html('Criar Imóvel');
			loading('close');
		}

		$('button#buttonFormImovel').click(function() {
			if (!validateDataFormImovel()) {
				return;
			}
			loading();
			buttonApplyLoad('buttonFormImovel');

			if (!actionForm.url) {
				actionForm.url = 'imovel/' + $('select#tipoImovel ').val()
			}

			$.ajax({
					beforeSend: function(request) {
						request.setRequestHeader("Authorization", 'Bearer tttt');
					},
					data: JSON.stringify(getDataFormImovel()),
					contentType: "application/json; charset=utf-8",
					traditional: true,
					method: actionForm.method,
					url: '../' + actionForm.url,
					success: function(data) {}
				}).fail(function() {})
				.always(function() {
					buttonRemoveLoad('buttonFormImovel');
					loading('close');
				});

		});

		$('#buttonDeleteImovel').click(function() {
			loading();
			$.ajax({
					beforeSend: function(request) {
						request.setRequestHeader("Authorization", 'Bearer tttt');
					},
					method: 'DELETE',
					url: '../' + actionForm.url,
					success: function(data) {
						window.location.href = '../../home';
					}
				})
				.fail(function() {})
				.always(function() {
					loading('close');
				});
		});

		function getDataFormImovel() {
			return {
				'status': $('select#statusImovel').val(),
				'endereco': $('input#enderecoImovel').val(),
				'preco': formatNumberBRLToUSD('precoImovel')
			};
		};

		function validateDataFormImovel() {
			let valid = true;
			let inputs = getDataFormImovel();
			if (!inputs.status.length) {
				$('select#statusImovel').addClass('is-invalid');
				valid = false;
			} else {
				$('select#statusImovel').removeClass('is-invalid');
			}
			if (!inputs.endereco.length) {
				$('input#enderecoImovel').addClass('is-invalid');
				valid = false;
			} else {
				$('input#enderecoImovel').removeClass('is-invalid');
			}
			if (!inputs.preco || inputs.preco < 0) {
				$('input#precoImovel').addClass('is-invalid');
				valid = false;
			} else {
				$('input#precoImovel').removeClass('is-invalid');
			}

			return valid;
		};
	});
</script>