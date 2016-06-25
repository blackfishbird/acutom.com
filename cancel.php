<?php
include("config.php");
?>

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
				<?php if(!$is_admin): ; ?>
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
					<li role="presentation"><a href="staff.php">DOCTORS STAFF<span class="button-line"></span></a></li>
					<li role="presentation" class="active dropdown">
						<a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false">ONLINE RESERVATION <span class="caret"></span><span class="button-line"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li class="divider"></li>
							<li><a href="massage.php">Massage</a></li>
							<li class="divider"></li>
							<li><a href="acupuncture.php">Acupuncture</a></li>
							<li class="divider"></li>
							<li class="active"><a href="cancel.php">Cancel</a></li>
							<li class="divider"></li>
						</ul>
					</li>
				</ul>
			</div>
			<div id="navbar-right" class="navbar-collapse collapse navbar-right">
				<?php if(!$is_admin): ; ?>
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
