<?php include("config.php"); ?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />
	<title><?php echo HP_TITLE; ?></title>

	<link rel="stylesheet" href="css/bootstrap.min.css" />
	<link rel="stylesheet" href="style.css" />

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</head>

<body>
	<!-- ====== NAV ====== -->
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-left" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<?php if(!$is_admin): ?>
					<button type="button" class="navbar-toggle collapsed" data-toggle="modal" data-target="#login-modal" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Admin log in</span>
						<span class="glyphicon glyphicon-log-in"></span>
					</button>
				<?php else: ?>
					<button type="button" name="logout-btn" class="navbar-toggle collapsed" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Log out</span>
						<span class="glyphicon glyphicon-log-out"></span>
					</button>
					<a role="button" class="btn navbar-toggle collapsed" href="<?php echo HP_ADMIN_URL; ?>" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Management page</span>
						<span class="glyphicon glyphicon-user"></span>
					</a>
				<?php endif; ?>
				<a role="button" class="navbar-brand" href="<?php echo HP_URL; ?>"><strong><?php echo HP_TITLE; ?></strong></a>
			</div>
			<div id="navbar-left" class="navbar-collapse collapse navbar-left">
				<ul class="nav navbar-nav">
					<li role="presentation" class="dropdown active">
						<a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false">ABOUT US <span class="caret"></span><span class="button-line"></span></a>
						<ul class="dropdown-menu" role="meur">
							<li class="divider"></li>
							<li class="active"><a href="services.php">SERVICES</a></li>
							<li class="divider"></li>
							<li><a href="staff.php">DOCTORS STAFF</a></li>
							<li class="divider"></li>
						</ul>
					</li>
					<li role="presentation" class="dropdown">
						<a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false">ONLINE RESERVATION <span class="caret"></span><span class="button-line"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li class="divider"></li>
							<li><a href="massage.php">Massage</a></li>
							<li class="divider"></li>
							<li><a href="acupuncture.php">Acupuncture</a></li>
							<li class="divider"></li>
							<li><a href="cancel.php">Cancel</a></li>
							<li class="divider"></li>
						</ul>
					</li>
				</ul>
			</div>
			<div id="navbar-right" class="navbar-collapse collapse navbar-right">
				<?php if(!$is_admin): ?>
					<button type="button" class="btn navbar-btn btn-default" data-toggle="modal" data-target="#login-modal">ADMIN LOGIN</button>
				<?php else: ?>
					<a role="button" href="<?php echo HP_ADMIN_URL; ?>" class="btn navbar-btn btn-default">MANAGEMENT PAGE</a>
					<button type="button" name="logout-btn" class="btn navbar-btn btn-default">LOGOUT</button>
				<?php endif; ?>
			</div>
		</div>
	</nav>
	<!-- ====== NAV END ====== -->

	<!-- ====== MAIN ====== -->
	<div class="container">
		<div class="row text-center border-bottom">
			<h1>About Us: Services</h1>
		</div>
		<div class="row text-center">
			<div class="col-sm-4 col-sm-offset-1 col-sm-right">
				<h2>ABOUT CLINIC</h2>
			</div>
			<div class="col-sm-6 col-sm-left">
				<article>
					<p>We concern with the need to eliminate the fundamental cause of illness, not simply remove the symptoms, and with the need to treat the whole person. </p>
				</article>
			</div>
		</div>
		<div class="row text-center">
			<div class="col-sm-4 col-sm-offset-1 col-sm-right">
				<h2>MASSAGE</h2>
			</div>
			<div class="col-sm-6 col-sm-left">
				<article>
					<p>&ldquo;Massage&rdquo; is ... </p>
					<br />
				</article>
			</div>
		</div>
		<div class="row text-center">
			<div class="col-sm-4 col-sm-offset-1 col-sm-right">
				<h2>ACUPUNCTURE</h2>
			</div>
			<div class="col-sm-6 col-sm-left">
				<article>
					<p>&ldquo;Acupuncture&rdquo; means the stimulation of a certain point or points on or near surface of the body by the insertion of needles to prevent or modify the perception of pain or to normalize physiological functions, including pain control for the treatment of certain diseases or dysfunction of the body and include the techniques of <a href="#electro-acu">electro acupuncture</a>, <a href="#cupping">cupping</a>, <a href="#moxibustion">moxibustion</a>. </p>
					<br />
				</article>
				<h4>PHOBIA: I'm afraid of needle.</h4>
				<p>Needle is 1/100 thinner than ur hair.</p>
			</div>
		</div>
		<div class="row text-center">
			<div class="col-sm-4 col-sm-offset-1 col-sm-right">
				<h2>OTHER SERVICES</h2>
			</div>
			<div class="col-sm-6 col-sm-left">
				<h4 id="electro-acu">ELECTRO ACUPUNCTURE</h4>
				<p>About electro acupuncture</p>
				<br />
				<h4 id="cupping">CUPPING &amp; GUA-SHA</h4>
				<p>About cupping &amp; gua-sha</p>
				<br />
				<h4 id="moxibustion">MOXIBUSTION</h4>
				<p>About moxibustion</p>
				<br />
				<h4>HERB INQUIRING</h4>
				<p>About inquiring</p>
				<br />
			</div>
		</div>
		<div class="row footer">
		</div>
	</div>
	<!-- ====== MAIN END ====== -->

	<!-- ====== MODAL ====== -->
	<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">ADMIN LOGIN</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="alert alert-danger" id="login-msg" role="alert"></div>
						<form role="form" id="login-form">
							<div class="form-group">
								<label for="admin-account">Account</label>
								<input type="text" class="form-control" id="admin-account" data-toggle="tooltip" data-placement="bottom" title="input your name" placeholder="account" />
							</div>
							<div class="form-group">
								<label for="admin-pw">Password</label>
								<input type="password" class="form-control" id="admin-pw" data-toggle="tooltip" data-placement="bottom" title="input your password" placeholder="password" />
							</div>
						</form>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" id="login-btn">LOGIN</button>
				</div>
			</div>
		</div>
	</div>
	<!-- ====== MODAL END ====== -->

	<!-- ====== JAVASCRIPT ====== -->
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
		$('*').on('click', function(e) {
			$('#login-msg').fadeOut('fast');
		});

		// slide
		$('a[href*=#]:not([href=#])').on('click', function(e) {
			var target = $(this.hash);
			$('html, body').animate({
				scrollTop: (target.offset().top - 80)
			}, "show");
			return false;
		});
	});
	</script>
	<!-- ====== JAVASCRIPT END ====== -->
</body>

</html>
