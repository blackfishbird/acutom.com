<?php include("config.php"); ?>

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
			<h1>About: Contact Us</h1>
		</div>
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3">
				<table class="table-pricing">
					<thead>
						<tr>
							<th colspan="2">Clinic Office</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th>Phone</th>
							<td><?php echo ADMIN_PHONE; ?> </td>
						</tr>
<?php /*
						<tr>
							<th>Address</th>
							<td><?php echo ADMIN_ADDRESS; ?></td>
						</tr>
*/ ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="row footer">
		</div>
	</div>
	<!-- ====== MAIN END ====== -->

	<!-- ====== JAVASCRIPT ====== -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/form-check.js"></script>
	<script>
	$(function() {
		$('#li-abo').addClass('active');
		$('#li-abo-con').addClass('active');

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
		$('*').on('click', function(e) {
			$('#login-msg').fadeOut('fast');
		});
	});
	</script>
	<!-- ====== JAVASCRIPT END ====== -->
</body>

</html>
