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

	<!-- Moment -->
	<script src="js/moment.min.js"></script>

	<!-- Fullcalendar -->
	<link rel="stylesheet" href="css/fullcalendar.css" />
	<link rel="stylesheet" href="css/fullcalendar.print.css" media="print" />
	<script src="js/fullcalendar.min.js"></script>

	<!-- Datetimepicker -->
	<link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css" />
	<script src="js/bootstrap-datetimepicker.min.js"></script>

	<!-- Calendar Setting -->
	<script>
	$(function() {
		var calendar = $('#calendar');
		calendar.fullCalendar({
			header: {
				left: 'prev today',
				center: 'title',
				right: 'month, agendaWeek, agendaDay, next'
			},
			views: {
				month: {
					titleFormat: 'MMMM YYYY'
				},
				agendaWeek: {
					titleFormat: 'MMMM YYYY'
				}
			},
			weekMode: 'fixed',
			defaultView: 'month',
			height: 'auto',
			minTime: '08:00:00',
			maxTime: '21:00:00',
			allDaySlot: false,
			allDayDefault: false,
			eventSources: [
				{
					url: 'json-opening.php',
					type: 'POST'
				},
				{
					url: 'json-reserve-all.php',
					type: 'POST'
				}
			],
			dayClick: function(date, e, view) {
				if(view.type.indexOf("month") != -1) {
					calendar.fullCalendar('changeView', 'agendaDay');
					calendar.fullCalendar('gotoDate', date);
				} else if(e.target.classList.contains('fc-bgevent')) {
					$('#item_number').data('DateTimePicker').date(date);
					$('#reserve-modal').modal();
				}
			}
		});
	});
	</script>
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
					<li role="presentation" class="dropdown active">
						<a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false"><span class="button-inline">ONLINE RESERVATION<span class="button-line"></span></span> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li class="divider"></li>
							<li><a href="massage.php">Massage</a></li>
							<li class="divider"></li>
							<li class="active"><a href="acupuncture.php">Acupuncture</a></li>
							<li class="divider"></li>
							<li><a href="cancel.php">Cancel</a></li>
							<li class="divider"></li>
						</ul>
					</li>
					<li role="presentation" class="dropdown">
						<a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false"><span class="button-inline">ABOUT<span class="button-line"></span></span> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li class="divider"></li>
							<li><a href="overview.php">Clinic Overview</a></li>
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
			<h1>Online Reservation: Acupuncture</h1>
			<p>Select the time you want to reserve. Our clinic is opening at the white time. </p>
			<p><strong><span class="text-notice">Payment</span>: $<?php echo $payment; ?> with <a href="http://www.paypal.com">PayPal</a></strong></p>
		</div>
		<div class="row text-center">
			<div id="calendar" class="calendar-default"></div>
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

	<!-- ====== MODAL RESERVE ====== -->
	<div class="modal fade" id="reserve-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">RESERVATION</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<form role="form" id="reserve-form" action="<?php echo PAYPAL_ACTION; ?>" method="post" target="_top">
							<div class="form-group">
								<input type="hidden" name="cmd" value="_xclick" />
								<input type="hidden" name="charset" value="utf-8" />
								<input type="hidden" name="business" value="<?php echo PAYPAL_BUSINESS; ?>" />
								<input type="hidden" name="amount" value="<?php echo $payment; ?>" />
								<input type="hidden" name="currency_code" value="USD" />
								<input type="hidden" name="button_subtype" value="services" />
								<input type="hidden" name="no_note" value="0" />
								<input type="hidden" name="cn" value="NOTE: " />
								<input type="hidden" name="no_shipping" value="1" />
								<input type="hidden" name="return" value="" />
								<input type="hidden" name="cbt" value="Return to ACUTOM.com" />
								<input type="hidden" name="cancel_return" value="<?php echo HP_URL; ?>" />
								<input type="hidden" name="tax_rate" value="0.000" />
								<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG_wCUP.gif:NonHosted">
								<input type="hidden" name="notify_url" value="<?php echo PAYPAL_NOTIFY_URL; ?>" />
								<input type="hidden" name="item_name" value="Acupuncture" />
								<input type="hidden" id="custom" name="custom" />
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label for="reserve_name">Name</label>
										<input type="text" class="form-control" id="reserve_name" name="reserve_name" data-toggle="tooltip" data-placement="bottom" title="input your name" placeholder="name" />
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="item_number">Date &amp; Time</label>
										<input type="text" class="form-control" id="item_number" name="item_number" data-toggle="tooltip" data-placement="bottom" title="select a right time" placeholder="datetime" readonly />
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="reserve_email">Email</label>
										<input type="text" class="form-control" id="reserve_email" name="reserve_email" data-toggle="tooltip" data-placement="bottom" title="input your email" placeholder="email" />
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="reserve_phone">Phone</label>
										<input type="text" class="form-control" id="reserve_phone" name="reserve_phone" data-toggle="tooltip" data-placement="bottom" title="input your phone" placeholder="phone" />
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<label for="" class="text-notice">Notice</label>
							<p>If late more than <span class="text-notice">15 minutes</span> appointment will cancels. </p>
							<?php if($payment != 0): ?>
								<p>And will be charged <span class="text-notice">$<?php echo $payment; ?></span> for fee. </p>
							<?php endif; ?>
							<p>Do you agree with it? </p>
							<p><span id="timeout" class="text-notice"></span></p>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="form-group">
						<?php if($payment == 0): ?>
							<button type="button" class="btn btn-notice" id="reserve-nopaypal-btn">Yes, I agree.</button>
						<?php else: ?>
							<button type="button" class="btn btn-notice" id="reserve-btn">Yes, I agree and pay with PayPal.</button>
						<?php endif; ?>
						<button type="button" class="btn btn-default" data-dismiss="modal">No, thanks.</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- ====== MODAL RESERVE END ====== -->

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

		// Reservation Modal
		$('#reserve-form').find('input, textarea').each(function() {
			$(this).keyup(function(e) {
				if(e.keyCode == 13) {
					<?php if($payment == 0): ?>
						$('#reserve-nopaypal-btn').click();
					<?php else: ?>
						$('#reserve-btn').click();
					<?php endif; ?>
				}
			});
		});
		$('#reserve-nopaypal-btn').on('click', function(e) {
			if(isInputValid($('#reserve_name')) && isInputValid($('#reserve_email')) && isInputValid($('#reserve_phone'))) {
				$(e.target).attr('disabled', true);
				$.ajax({
					url: 'reserve-add.php',
					type: 'POST',
					data: {
						name: $('#reserve_name').val(),
						date: $('#item_number').val(),
						email: $('#reserve_email').val(),
						phone: $('#reserve_phone').val(),
						service: 'Acupuncture'
					},
					error: function(xhr) {
					},
					success: function(res) {
						if(res == false)
							$('#item_number').tooltip('show').closest('div').addClass('error');
						else
							window.location.reload();
					}
				});
				$(e.target).attr('disabled', false);
			}
		});
		$('#reserve-btn').on('click', function(e) {
			var custom = 'reserve_name=' + $('#reserve_name').val() + '&reserve_email=' + $('#reserve_email').val() + '&reserve_phone=' + $('#reserve_phone').val();
			$('#custom').val(custom);
			var url = "<?php echo PAYPAL_RETURN; ?>" + '?reserve_email=' + encodeURIComponent($('#reserve_email').val());
			$('input[name="return"]').val(url);
			if(isFormValid($('#reserve-form'))) {
				$(e.target).attr('disabled', true);
				$.ajax({
					url: 'json-reserve-check.php',
					type: 'POST',
					dataType: 'json',
					error: function(xhr) {
					},
					success: function(res) {
						var reserve = new Date($('#item_number').val());
						var reserve_date = getDateFormat(reserve);
						var reserve_time = reserve.getHours();
						try {
							if(res[reserve_date][reserve_time]) {
								$('#item_number').tooltip('destroy').closest('div').removeClass('error');
								$('#reserve-form').submit();
							} else {
								$('#item_number').tooltip('show').closest('div').addClass('error');
							} 
						} catch(err) {
							$('#item_number').tooltip('show').closest('div').addClass('error');
						}
					}
				});
				$(e.target).attr('disabled', false);
			}
		});
		function getDateFormat(date) {
			var y = date.getFullYear();
			var m = date.getMonth() + 1;
			var d = date.getDate();
			return y + '-' + (m < 10 ? '0' : '') + m + '-' + (d < 10 ? '0' : '') + d;
		}
		// Reservation Modal END

		// Datetimepicker Setting
		$('#item_number').datetimepicker({
			format: 'YYYY-MM-DD HH:mm',
			stepping: 60
		});
		// Datetimepicker Setting END

		$('*').on('click', function(e) {
			$('#login-msg').fadeOut('fast');
		});

		// Timeout
		var start = 600;
		var loop;
		function timedCount() {
			document.getElementById('timeout').innerHTML = '(This page will be reloaded after ' + start + ' seconds.)';
			start--;
			loop = setTimeout(timedCount, 1000);
			if(start < 0)
				window.location.reload();
		}
		timedCount();
		// Timeout END
	});
	</script>
	<!-- ====== JAVASCRIPT END ====== -->
</body>

</html>
