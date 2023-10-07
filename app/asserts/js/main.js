function loading(action) {
	if (action == 'close') {
		$('#pageLoading').remove();
		return;
	}
	$('body').append(`
		<div id="pageLoading">
			<div id="boxContentLoading">
				<div class="spinner-border" role="status">
					<span class="sr-only">Loading...</span>
				</div>
			</div>
		</div>
	`);
}

function buttonApplyLoad(id) {
	$('button#' + id).data('text-origin-loading', $('button#' + id).text());
	$('button#' + id).html(`
		<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
		Loading...
	`).prop('disabled', true);
}

function buttonRemoveLoad(id) {
	const textOrigin = $('button#' + id).data('text-origin-loading');
	if (textOrigin) {
		$('button#' + id).html(
			$('button#' + id).data('text-origin-loading')
		).prop('disabled', false);
		$('button#' + id).removeData('text-origin-loading');
	}
}

function formatNumberBRLToUSD(id) {
	const value = $('input#'+ id).val();
	if (!value) {
		return 0;
	}
	return Number(value.replace(/\.+/g, "").replace(/,+/g, "."));
}