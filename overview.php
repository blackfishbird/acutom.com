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

<body id="top">
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
						<span class="glyphicon glyphicon-cog"></span>
					</a>
				<?php endif; ?>
				<a role="button" class="navbar-brand" href="<?php echo HP_URL; ?>"><strong><?php echo HP_TITLE; ?></strong></a>
			</div>
			<div id="navbar-left" class="navbar-collapse collapse navbar-left">
				<ul class="nav navbar-nav">
					<li role="presentation"><a href="service-a.php"><span class="button-inline">WHAT IS ACUPUNCTURE<span class="button-line"></span></span></a></li>
					<li role="presentation" class="dropdown">
						<a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false"><span class="button-inline">SERVICES<span class="button-line"></span></span> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li class="divider"></li>
							<li><a href="service-m.php">Massage</a></li>
							<li class="divider"></li>
							<li><a href="service-a.php">Acupuncture</a></li>
							<li class="divider"></li>
							<li><a href="service-other.php">Other Services</a></li>
							<li class="divider"></li>
						</ul>
					</li>
					<li role="presentation"><a href="pricing.php"><span class="button-inline">PRICING<span class="button-line"></span></span></a></li>
					<li role="presentation" class="dropdown">
						<a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false"><span class="button-inline">ONLINE RESERVATION<span class="button-line"></span></span> <span class="caret"></span></a>
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
					<li role="presentation" class="dropdown active">
						<a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false"><span class="button-inline">ABOUT<span class="button-line"></span></span> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li class="divider"></li>
							<li class="active"><a href="overview.php">Clinic Overview</a></li>
							<li class="divider"></li>
							<li><a href="staff.php">Doctor Staff</a></li>
							<li class="divider"></li>
							<li><a href="contact.php">Contact Us</a></li>
							<li class="divider"></li>
						</ul>
					</li>
				</ul>
			</div>
			<div id="navbar-right" class="navbar-collapse collapse navbar-right">
				<?php if(!$is_admin): ?>
					<button type="button" class="btn navbar-btn btn-default" data-toggle="modal" data-target="#login-modal"><span class="glyphicon glyphicon-log-in"></span></button>
				<?php else: ?>
					<a role="button" href="<?php echo HP_ADMIN_URL; ?>" class="btn navbar-btn btn-default"><span class="glyphicon glyphicon-cog"></span></a>
					<button type="button" name="logout-btn" class="btn navbar-btn btn-default"><span class="glyphicon glyphicon-log-out"></span></button>
				<?php endif; ?>
			</div>
		</div>
	</nav>
	<!-- ====== NAV END ====== -->

	<!-- ====== MAIN ====== -->
	<div class="container">
		<div class="row text-center border-bottom">
			<h1>About: Clinic Overview</h1>
		</div>
		<div class="row text-center">
			<div class="col-sm-3 col-sm-offset-1">
				<ul class="service-items col-sm-left">
					<li><a href="#about-clinic">About Clinic</a></li>
					<li><a href="#what-else">What else we do?</a></li>
				<ul>
			</div>
			<div class="col-sm-7 col-sm-left col-sm-border">
				<h3 id="about-clinic">About Clinic</h3>
				<article>
					<p>We concern with the need to eliminate the fundamental cause of illness, not simply remove the symptoms, and with the need to treat the whole person. </p>
					<br />
				</article>
				<h3 id="what-else">What else we do?</h3>
				<article>
					<p>We are alse... </p>
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
