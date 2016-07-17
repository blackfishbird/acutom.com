<?php include("config.php"); ?>

<!DOCTYPE html>
<html>

<head>
	<?php include("page-header.php"); ?>
</head>

<body id="top">
	<?php include("page-navbar.php"); ?>
	<!-- ====== MAIN ====== -->
	<div class="container">
		<div class="row text-center border-bottom">
			<h1>Services: Acupuncture</h1>
		</div>
		<div class="row text-center">
			<div class="col-sm-8 col-sm-offset-2 col-sm-left">
				<h3 id="what-is-massage">What is acupuncture?</h3>
				<article>
					<p>&ldquo;Acupuncture&rdquo; means the stimulation of a certain point or points on or near surface of the body by the insertion of needles to prevent or modify the perception of pain or to normalize physiological functions, including pain control for the treatment of certain diseases or dysfunction of the body and include the techniques of <strong>electro acupuncture</strong>, <strong>cupping</strong>, <strong>moxibustion</strong>. </p>
					<br />
				</article>
			</div>
		</div>
		<div class="row footer">
		</div>
	</div>
	<div class="go-top">
		<a class="btn btn-top" href="#top"><span class="glyphicon glyphicon-arrow-up"></span></a>
	</div>
	<!-- ====== MAIN END ====== -->

	<!-- ====== JAVASCRIPT ====== -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/form-check.js"></script>
	<script>
	$(function() {
		$('#li-ser').addClass('active');
		$('#li-ser-acu').addClass('active');
		$('#li-ser-acu-what').addClass('active');

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

		// slide
		var position = 80;
		$('a[href*=#]:not([href=#])').on('click', function(e) {
			var target = $(this.hash);
			$('html, body').animate({
				scrollTop: (target.offset().top - position)
			}, "show");
			return false;
		});
	});
	</script>
	<!-- ====== JAVASCRIPT END ====== -->
</body>

</html>
