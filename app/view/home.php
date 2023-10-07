<!DOCTYPE html>
<html>

<head>
	<title>Imobiliária ERP</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sticky-footer/">
	<link href="https://getbootstrap.com/docs/4.0/examples/sticky-footer/sticky-footer.css" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body>
	<div style="width:80%; margin:5px auto">
		<div>
			<div class="row">
				<div class="col">
					<!-- Begin page content -->
					<main role="main">
						<h1 class="mt-5">Lista de imoveis</h1>
						<p class="lead">Pin a fixed-height footer to the bottom of the viewport in desktop browsers with this custom HTML and CSS.</p>
						<p>Use <a href="../sticky-footer-navbar/">the sticky footer with a fixed navbar</a> if need be, too.</p>
					</main>
				</div>
			</div>

			<div class="row">
				<div class="col">
					<a href="imovel/new" target="_blank">
						<button type="button" class="btn btn-outline-primary float-right">Adicionar novo imovel</button>
					</a>
				</div>
			</div>
			<div class="row mb-5"></div>
		</div>

		<div class="card-columns" id="listImovel">
		</div>

	</div>
	<br>
	<br>
	<footer class="footer mt-2">
		<div class="container">
			<span class="text-muted">Place sticky footer content here.</span>
		</div>
	</footer>
</body>

</html>

<script>
	$(document).ready(function() {
		$.ajax({
			beforeSend: function(request) {
				request.setRequestHeader("Authorization", 'Bearer tttt');
			},
			dataType: "json",
			url: 'imovel',
			success: function(data) {
				if (!data.length) {
					$('div#listImovel').html('<p class="lead">Nenhum imovel registrado no sistema.</p>');
					return;
				}
				data.forEach((imovel) => {
					$('div#listImovel').prepend(addCardImovel(imovel));
				})
			}
		});

		function addCardImovel(imovel) {
			const formatNumber = new Intl.NumberFormat()
			imovel.preco = formatNumber.format(imovel.preco);
			return `
				<div class="card">
					<img class="card-img-top" src="http://localhost/poo-crud-php/app/asserts/imgs/${imovel.tipo}.jpg" alt="Card image cap">
					<div class="card-body">
						<p>R$ ${imovel.preco}</p>
						<p>${imovel.endereco}</p>
						<p>${imovel.status}</p>
						<a href="http://localhost/poo-crud-php/public/imovel/edit/${imovel.id}" target="_blank" class="card-link">Ver detalhes</a>
					</div>
				</div>`;
		}
	})
</script>