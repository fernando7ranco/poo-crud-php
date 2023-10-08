<!DOCTYPE html>
<html>

<head>
	<title>Imobiliária ERP</title>
	<?php echo view('includes/headLinks'); ?>
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
				request.setRequestHeader("Authorization", 'Bearer ' + getBearerToken());
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
			var urlImg = getUrl(`app/asserts/imgs/${imovel.tipo}.jpg`);
			var urlLink = getUrl('public/imovel/edit/' + imovel.id);
			return `
				<div class="card">
					<img class="card-img-top" src="${urlImg}" alt="Card image cap">
					<div class="card-body">
						<p>${imovel.tipo}</p>
						<p>R$ ${imovel.preco}</p>
						<p>${imovel.endereco}</p>
						<p>${imovel.status}</p>
						<a href="${urlLink}" target="_blank" class="card-link">Ver detalhes</a>
					</div>
				</div>`;
		}
	})
</script>