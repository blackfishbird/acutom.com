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
			<h1>Thank you for your reservation.</h1>
			<p>Please check your email: <span id="reserve_email"></span></p>
		</div>
		<div class="row text-center">
			<div class="col-sm-6">
				<a role="button" href="<?php echo HP_URL; ?>" class="btn btn-service" id="btn-homepage" title="<?php echo HP_TITLE; ?>">
					<h2>back to ACUTOM.com</h2>
				</a>
			</div>
			<div class="col-sm-6">
				<a role="button" href="<?php echo HP_URL."contact.php"; ?>" class="btn btn-service" id="btn-contact" title="Contact us">
					<h2>contact us</h2>
				</a>
			</div>
		</div>
	</div>
	<!-- ====== MAIN END ====== -->

	<!-- ====== JAVASCRIPT ====== -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/form-check.js"></script>
	<script>
	$(function() {
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

		function getParameterByName(name, url) {
			if(!url)  url = window.location.href;
			name = name.replace(/[\[\]]/g, "\\$&");
			var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)");
			var results = regex.exec(url);
			if(!results)  return null;
			if(!results[2])  return '';
			return decodeURIComponent(results[2].replace(/\+/g, " "));
		}
		document.getElementById("reserve_email").innerHTML = getParameterByName('reserve_email');

		$('*').on('click', function(e) {
			$('#login-msg').fadeOut('fast');
		});
	});
	</script>
	<!-- ====== JAVASCRIPT END ====== -->
</body>

</html>
