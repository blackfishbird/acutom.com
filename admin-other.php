<?php
include("config.php");

if(!$is_admin)  header("Location: ".HP_URL);
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
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar_left" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<button type="button" name="logout-btn" class="navbar-toggle collapsed" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">log out</span>
					<span class="glyphicon glyphicon-log-out"></span>
				</button>
				<a class="navbar-brand" href="."><strong><?php echo HP_TITLE; ?></strong></a>
			</div>
			<div id="navbar_left" class="navbar-collapse collapse navbar-left">
				<ul class="nav navbar-nav">
					<li role="presentation"><a href="admin-reserve.php">RESERVATION<span class="button-line"></span></a></li>
					<li role="presentation" class="dropdown active">
						<a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false">SETTING <span class="caret"></span><span class="button-line"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li class="divider"></li>
							<li><a href="admin-week.php">Days Off a Week</a></li>
							<li class="divider"></li>
							<li><a href="admin-special.php">Special Leave</a></li>
							<li class="divider"></li>
							<li class="active"><a href="admin-other.php">Others</a></li>
							<li class="divider"></li>
						</ul>
					</li>
				</ul>
			</div>
			<div id="navbar_right" class="navbar-collapse collapse navbar-right">
				<button type="button" name="logout-btn" class="btn navbar-btn btn-default">LOGOUT</button>
			</div>
		</div>
	</nav>
	<!-- ====== NAV END ====== -->

	<!-- ====== MAIN ====== -->
	<div class="container">
		<div class="row text-center border-bottom">
			<h1>Setting: Others</h1>
			<p>Admin account: <?php echo $_SESSION[$session]['adminAccount']; ?></p>
		</div>
		<div class="row">
			<div class="col-sm-4 col-sm-offset-4">
				<form role="form" id="after-form">
					<div class="form-group">
						<label for="after-days">最晚預約日: </label>
						<input type="number" class="form-control" id="after-days" data-toggle="tooltip" data-placement="bottom" title="input a number between 1 and 90" placeholder="number" value="<?php echo $final_date; ?>" />
					</div>
					<div class="text-right">
						<button type="button" class="btn btn-notice" id="after-btn">Update</button>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4 col-sm-offset-4">
				<form role="form" id="payment-form">
					<div class="form-group">
						<label for="payment">Payment (USD): </label>
						<input type="number" class="form-control" id="payment" data-toggle="tooltip" data-placement="bottom" title="input a number" placeholder="payment" value="<?php echo $payment; ?>" />
					</div>
					<div class="text-right">
						<button type="button" class="btn btn-notice" id="payment-btn">Update</button>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4 col-sm-offset-4">
				<form role="form" id="pw-update-form">
					<div class="form-group">
						<label for="old-pw">Old Password: </label>
						<span id="pw-old-check" aria-hidden="true"></span>
						<input type="password" class="form-control" id="old-pw" data-toggle="tooltip" data-placement="bottom" title="input the old password" placeholder="old password" />
					</div>
					<div class="form-group">
						<label for="new-pw">New Password: </label>
						<input type="password" class="form-control" id="new-pw" data-toggle="tooltip" data-placement="bottom" title="input the new password" placeholder="new password" />
					</div>
					<div class="form-group">
						<label for="new-pw-2">New Password Again: </label>
						<span id="pw-new-check" aria-hidden="true"></span>
						<input type="password" class="form-control" id="new-pw-2" data-toggle="tooltip" data-placement="bottom" title="input the new password again" placeholder="new password" />
					</div>
					<div class="text-right">
						<span id="pw-check" aria-hidden="true"></span>
						<button type="button" class="btn btn-notice" id="pw-update-btn">Update</button>
					</div>
				</form>
			</div>
		</div>
		<div class="row footer">
		</div>
	</div>
	<!-- ====== MAIN END ====== -->

	<!-- ====== JAVASCRIPT ====== -->
	<script src="js/form-check.js"></script>
	<script>
	$(function() {
		$('button[name="logout-btn"]').on('click', function(e) {
			$(e.target).attr('disabled', true);
			$.ajax({
				url: 'logout.php',
				type: 'POST',
				error: function(xhr) {
				},
				success: function(res) {
					window.location.replace("<?php echo HP_URL; ?>");
				}
			});
			$(e.target).attr('disabled', false);
		});

		// Sets Form
		$('#after-form').on('keyup keypress', function(e) {
			var keyCode = e.keyCode || e.which;
			if(keyCode === 13) {
				e.preventDefault();
				$('#after-btn').click();
			}
		});
		$('#after-btn').on('click', function(e) {
			setsUpdate($('#after-days'), 1, 1, 90, e);
		});
		$('#payment-form').on('keyup keypress', function(e) {
			var keyCode = e.keyCode || e.which;
			if(keyCode === 13) {
				e.preventDefault();
				$('#payment-btn').click();
			}
		});
		$('#payment-btn').on('click', function(e) {
			setsUpdate($('#payment'), 2, 0, 127, e);
		});

		function setsUpdate($input, item, min, max, e) {
			if(isInputValid($input) && isInputBetween($input, min, max)) {
				$(e.target).attr('disabled', true);
				$.ajax({
					url: 'sets-update.php',
					type: 'POST',
					data: {
						sets_item: item,
						sets_status: $input.val()
					},
					error: function(xhr) {
					},
					success: function(res) {
						window.location.reload();
					}
				});
				$(e.target).attr('disabled', false);
			}
		}
		// Sets Form END

		// PW Update Form
		var pwOld = false, pwNew = false;
		$('#new-pw').on('blur', pwBlur);
		$('#new-pw-2').on('blur', pwBlur);
		function pwBlur(e) {
			if(isInputValid($(this)) && $('#new-pw').val() === $('#new-pw-2').val())  pwNew = true;
			else  pwNew = false;
			pwCheckShow($('#pw-new-check'), pwNew);
			pwCheckShow($('#pw-check'), (pwOld && pwNew));
		}
		function pwCheckShow($pwCheck, pw) {
			if(pw === true)  $pwCheck.removeClass().addClass('glyphicon glyphicon-ok text-info').show();
			else  $pwCheck.removeClass().addClass('glyphicon glyphicon-remove text-danger').show();
		}
		$('#pw-update-form').find('input, textarea').each(function() {
			$(this).keyup(function(e) {
				if(e.keyCode == 13) {
					$('#pw-update-btn').click();
				}
			});
		});
		$('#old-pw').on('blur', function(e) {
			if(isInputValid($(this))) {
				$.ajax({
					url: 'admins-check.php',
					type: 'POST',
					data: {
						old_pw: $('#old-pw').val()
					},
					error: function(xhr) {
						pwOld = false;
					},
					success: function(res) {
						if(res)  pwOld = true;
						else  pwOld = false;
					},
					async: false
				});
			} else  pwOld = false;
			pwCheckShow($('#pw-old-check'), pwOld);
			pwCheckShow($('#pw-check'), (pwOld && pwNew));
		});
		$('#pw-update-btn').on('click', function(e) {
			if(isFormValid($('#pw-update-form')) && pwOld && pwNew) {
				$(e.target).attr('disabled', true);
				$.ajax({
					url: 'admin-update.php',
					type: 'POST',
					data: {
						old_pw: $('#old-pw').val(),
						new_pw: $('#new-pw').val()
					},
					error: function(xhr) {
					},
					success: function(res) {
						window.location.reload();
					}
				});
				$(e.target).attr('disabled', false);
			}
		});
		// PW Update Form END
	});
	</script>
	<!-- ====== JAVASCRIPT END ====== -->
</body>

</html>
