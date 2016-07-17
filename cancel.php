<?php
include("config.php");
?>

<!DOCTYPE html>
<html>

<head>
	<?php include("page-header.php"); ?>
</head>

<body>
	<?php include("page-navbar.php"); ?>
	<!-- ====== MAIN ====== -->
	<div class="container">
		<div class="row text-center border-bottom">
			<h1>Online Reservation: Cancel</h1>
			<p>Input your reservation password here.</p>
		</div>
		<div class="row">
			<div class="col-sm-4 col-sm-offset-4">
				<form role="form" id="token-form" class="text-center">
					<div class="form-group text-left">
						<label for="token-pw">Cancel Password</label>
						<input type="text" class="form-control" id="token-pw" data-toggle="tooltip" data-placement="bottom" title="input your cancel password" placeholder="cancel password" value="<?php echo $_GET['token']; ?>" />
					</div>
					<div class="form-group text-center">
						<button type="button" class="btn btn-notice" id="token-btn">Cancel</button>
					</div>
				</form>
			</div>
		</div>
		<div class="row footer">
		</div>
	</div>
	<!-- ====== MAIN END ====== -->

	<!-- ====== MODAL CANCEL ====== -->
	<div class="modal fade" id="cancel-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title text-notice">NOTICE</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="alert" id="cancel-msg" role="alert"></div>
						<p>若要取消預約，您的訂金將等待3-5個工作天由醫師退款，請問要繼續嗎？</p>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-notice" id="continue-btn">Yes, continue.</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">No, thanks</button>
				</div>
			</div>
		</div>
	</div>
	<!-- ====== MODAL CANCEL END ====== -->

	<!-- ====== JAVASCRIPT ====== -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/form-check.js"></script>
	<script>
	$(function() {
		$('#li-res').addClass('active');
		$('#li-res-can').addClass('active');

		isKeyEnter($('#login-form'), $('#login-btn'));
		$('#login-btn').on('click', function(e) {
			if(isFormValid($('#login-form'))) {
				$(e.target).attr('disabled', true);
				var account = $('#admin-account').val();
				var pw = $('#admin-pw').val();
				$.ajax({
					url: 'login-admin.php',
					type: 'POST',
					dataType: 'json',
					data: {
						account: account,
						pw: pw
					},
					error: function(xhr) {
						document.getElementById('login-msg').innerHTML = "<?php echo $error_msg['login']; ?>";
						$('#login-msg').fadeIn('fast');
					},
					success: function(res) {
						window.location.replace("<?php echo HP_ADMIN_URL; ?>");
					}
				});
				$(e.target).attr('disabled', false);
			}
		});
		$('button[name="logout-btn"]').on('click', function(e) {
			$(e.target).attr('disabled', true);
			$.ajax({
				url: 'logout.php',
				type: 'POST',
				error: function(xhr) {
				},
				success: function(res) {
					window.location.reload();
				}
			});
			$(e.target).attr('disabled', false);
		});

		// Cancel Modal
		$('#token-form').on('keyup keypress', function(e) {
			var keyCode = e.keyCode || e.which;
			if(keyCode === 13) {
				e.preventDefault();
				$('#token-btn').click();
			}
		});
		$('#token-btn').on('click', function(e) {
			if(isFormValid($('#token-form'))) {
				$('#cancel-modal').modal();
			}
		});
		$('#continue-btn').on('click', function(e) {
			$(e.target).attr('disabled', true);
			$.ajax({
				url: 'reserve-cancel.php',
				type: 'POST',
				data: {
					token: $('#token-pw').val()
				},
				dataType: 'json',
				error: function(xhr) {
					document.getElementById('cancel-msg').innerHTML = "取消失敗，請重新確認您的預約資訊。";
					$('#cancel-msg').removeClass().addClass("alert alert-danger").fadeIn('fast');
					$(e.target).attr('disabled', false);
				},
				success: function(res) {
					if(res == true) {
						document.getElementById('cancel-msg').innerHTML = "預約取消完成，稍後將跳轉至首頁。";
						$('#cancel-msg').removeClass().addClass("alert alert-info").fadeIn('fast');
						setTimeout(function() {
							window.location.replace("<?php echo HP_URL; ?>");
						}, 5000);
					}
				}
			});
		});
		// Cancel Modal END 

		$('*').on('click', function(e) {
			$('#login-msg').fadeOut('fast');
			$('#cancel-msg').fadeOut('fast');
		});
	});
	</script>
	<!-- ====== JAVASCRIPT END ====== -->
</body>

</html>
