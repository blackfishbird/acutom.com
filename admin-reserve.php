<?php
include("config.php");

if(!$is_admin)  header("Location: ".HP_URL);
?>

<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="refresh" content="600; URL='admin-reserve.php'" />
	<?php include("page-header.php"); ?>

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
					url: 'json-reserve-service.php',
					type: 'POST',
					data: {
						service: 'Massage'
					}
				},
				{
					url: 'json-reserve-service.php',
					type: 'POST',
					data: {
						service: 'Acupuncture'
					}
				},
				{
					url: 'json-reserve-service.php',
					type: 'POST',
					data: {
						service: 'Other'
					}
				}
			],
			eventClick: reserveUpdate,
			dayClick: function(date, e, view) {
				if(view.type.indexOf("month") != -1) {
					calendar.fullCalendar('changeView', 'agendaDay');
					calendar.fullCalendar('gotoDate', date);
				} else if(e.target.classList.contains('fc-bgevent')) {
					$('#reserve_date').data('DateTimePicker').date(date);
					$('#reserve-modal').modal();
				}
			}
		});

		// Update Modal
		function reserveUpdate(e) {
			var reserve_id = e.id;
			var reserve;
			$.ajax({
				url: 'json-reserve-one.php',
				data: {
					reserve_id: reserve_id
				},
				type: 'POST',
				dataType: 'json',
				error: function(xhr) {
					window.location.reload();
				},
				success: function(res) {
					$('#update_id').val(res.id);
					$('#update_token').val(res.token);
					$('#update_name').val(res.name);
					$('#update_date').val(res.start);
					$('#update_email').val(res.email);
					$('#update_phone').val(res.phone);
					$('#update_service').val(res.service);
					$('#update_payment').val(res.payment);
					$('#update_note').val(res.note);
					if(res.status == -1)
						$('#is-canceled').show();
					else
						$('#is-canceled').hide();
					$('#update-modal').modal();
				},
				async: false
			});
		}
		// Update Modal END
	});
	</script>
</head>

<body>
	<?php include("page-admin-navbar.php"); ?>
	<!-- ====== MAIN ====== -->
	<div class="container">
		<div class="row text-center border-bottom">
			<h1>Reservation</h1>
			<div class="form-inline">
				<label for="search-id">Reservation Search:&nbsp;</label>
				<input type="text" class="form-control" id="search-id" name="search-id" data-toggle="tooltip" data-placement="bottom" title="input the ID number" placeholder="ID number" />
				<button type="button" class="btn btn-default" id="search-btn">Search</button>
			</div>
		</div>
		<div class="row text-center">
			<div id="calendar" class="calendar-default calendar-admin"></div>
			<div id="reserve_calendar" class="calendar-default"></div>
		</div>
		<div class="row footer">
		</div>
	</div>
	<!-- ====== MAIN END ====== -->

	<!-- ====== MODAL RESERVE ====== -->
	<div class="modal fade" id="reserve-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">ADD NEW RESERVATION</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<form role="form" id="reserve-form">
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label for="reserve_name">Name</label>
										<input type="text" class="form-control" id="reserve_name" name="reserve_name" data-toggle="tooltip" data-placement="bottom" title="input the name" placeholder="name" />
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="reserve_date">Date &amp; Time</label>
										<input type="text" class="form-control" id="reserve_date" name="reserve_date" data-toggle="tooltip" data-placement="bottom" title="select a right time" placeholder="datetime" readonly />
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="reserve_email">Email</label>
										<input type="text" class="form-control" id="reserve_email" name="reserve_email" data-toggle="tooltip" data-placement="bottom" title="input the email" placeholder="email" />
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="reserve_phone">Phone</label>
										<input type="text" class="form-control" id="reserve_phone" name="reserve_phone" data-toggle="tooltip" data-placement="bottom" title="input the phone" placeholder="phone" />
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group">
										<label for="reserve_service">Service</label>
										<select class="form-control" id="reserve_service">
											<option value="Massage">Massage</option>
											<option value="Acupuncture">Acupuncture</option>
											<option value="Other">Other</option>
										</select>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="modal-footer">
					<div class="form-group">
						<button type="button" class="btn btn-notice" id="reserve-btn">Reserve</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- ====== MODAL RESERVE END ====== -->

	<!-- ====== MODAL UPDATE ====== -->
	<div class="modal fade" id="update-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">UPDATE RESERVATION<span id="is-canceled" class="text-notice">(CANCELED)</span></h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<form role="form" id="update-form">
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label for="update_id">ID</label>
										<input type="number" class="form-control" id="update_id" name="update_id" data-toggle="tooltip" data-placement="bottom" title="input the id number" placeholder="ID" readonly />
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="update_token">Cancel Password</label>
										<input type="text" class="form-control" id="update_token" name="update_token" data-toggle="tooltip" data-placement="bottom" title="input the token" placeholder="token" readonly />
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="update_name">Name</label>
										<input type="text" class="form-control" id="update_name" name="update_name" data-toggle="tooltip" data-placement="bottom" title="input the name" placeholder="name" readonly />
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="update_date">Date &amp; Time</label>
										<input type="text" class="form-control" id="update_date" name="update_date" data-toggle="tooltip" data-placement="bottom" title="select a right time" placeholder="datetime" />
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="update_email">Email</label>
										<input type="text" class="form-control" id="update_email" name="update_email" data-toggle="tooltip" data-placement="bottom" title="input the email" placeholder="email" />
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="update_phone">Phone</label>
										<input type="text" class="form-control" id="update_phone" name="update_phone" data-toggle="tooltip" data-placement="bottom" title="input the phone" placeholder="phone" />
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="update_service">Service</label>
										<select class="form-control" id="update_service">
											<option value="Massage">Massage</option>
											<option value="Acupuncture">Acupuncture</option>
											<option value="Other">Other</option>
										</select>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="update_payment">Payment</label>
										<input type="text" class="form-control" id="update_payment" name="update_payment" data-toggle="tooltip" data-placement="bottom" placeholder="payment" readonly />
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group">
										<label for="update_note">Note</label>
										<input type="text" class="form-control" id="update_note" name="update_note" data-toggle="tooltip" data-placement="bottom" title="input the note" placeholder="note" />
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="modal-footer">
					<div class="form-group">
						<button type="button" class="btn btn-notice" id="update-btn">Update</button>
						<button type="button" class="btn btn-notice" id="delete-btn">Delete</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- ====== MODAL UPDATE END ====== -->

	<!-- ====== MODAL MSG ====== -->
	<div class="modal fade" id="update-msg-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title text-notice">NOTICE</h4>
				</div>
				<div class="modal-body">
					<div class="row text-center">
						<p>資料即將被更新，確定要繼續嗎？<p>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-notice" id="update-msg-btn">Yes</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="delete-msg-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title text-notice">NOTICE</h4>
				</div>
				<div class="modal-body">
					<div class="row text-center">
						<p>資料即將被刪除，確定要繼續嗎？<p>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-notice" id="delete-msg-btn">Yes</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
				</div>
			</div>
		</div>
	</div>
	<!-- ====== MODAL MSG END ====== -->

	<!-- ====== JAVASCRIPT ====== -->
	<script src="js/form-check.js"></script>
	<script>
	$(function() {
		$('#li-res').addClass('active');

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
		$('#search-id').on('keyup keypress', function(e) {
			var keyCode = e.keyCode || e.witch;
			if(keyCode === 13) {
				e.preventDefault();
				$('#search-btn').click();
			}
		});
		$('#search-btn').on('click', function(e) {
			var id = $('#search-id').val()
			$.ajax({
				url: 'json-reserve-one.php',
				data: {
					reserve_id: id
				},
				type: 'POST',
				dataType: 'json',
				error: function(xhr) {
					window.location.reload();
				},
				success: function(res) {
					if(res) {
						$('#update_id').val(res.id);
						$('#update_token').val(res.token);
						$('#update_name').val(res.name);
						$('#update_date').val(res.start);
						$('#update_email').val(res.email);
						$('#update_phone').val(res.phone);
						$('#update_service').val(res.service);
						$('#update_payment').val(res.payment);
						$('#update_note').val(res.note);
						if(res.status == -1)
							$('#is-canceled').show();
						else
							$('#is-canceled').hide();
						$('#update-modal').modal();
					}
				},
				async: false
			});
		});

		// Reservation Modal
		isKeyEnter($('#reserve-form'), $('#reserve-btn'));
		$('#reserve-btn').on('click', function(e) {
			if(isInputValid($('#reserve_name')) && isInputValid($('#reserve_date'))) {
				$(e.target).attr('disabled', true);
				$.ajax({
					url: 'reserve-add.php',
					type: 'POST',
					data: {
						name: $('#reserve_name').val(),
						date: $('#reserve_date').val(),
						email: $('#reserve_email').val(),
						phone: $('#reserve_phone').val(),
						service: $('#reserve_service').val()
					},
					error: function(xhr) {
						$(e.target).attr('disabled', false);
					},
					success: function(res) {
						window.location.reload();
					}
				});
			}
		});
		function getDateFormat(date) {
			var y = date.getFullYear();
			var m = date.getMonth() + 1;
			var d = date.getDate();
			return y + '-' + (m < 10 ? '0' : '') + m + '-' + (d < 10 ? '0' : '') + d;
		}
		// Reservation Modal END

		// Update Modal
		$('#update-btn').on('click', function(e) {
			$('#update-msg-modal').modal();
		});
		$('#update-msg-btn').on('click', function(e) {
			$(e.target).attr('disabled', true);
			$.ajax({
				url: 'reserve-update.php',
				type: 'POST',
				data: {
					id: $('#update_id').val(),
					date: $('#update_date').val(),
					email: $('#update_email').val(),
					phone: $('#update_phone').val(),
					service: $('#update_service').val(),
					note: $('#update_note').val()
				},
				error: function(xhr) {
				},
				success: function(res) {
					window.location.reload();
				}
			});
			$(e.target).attr('disabled', false);
		});

		$('#delete-btn').on('click', function(e) {
			$('#delete-msg-modal').modal();
		});
		$('#delete-msg-btn').on('click', function(e) {
			$(e.target).attr('disabled', true);
			$.ajax({
				url: 'reserve-cancel.php',
				type: 'POST',
				data: {
					token: $('#update_token').val()
				},
				error: function(xhr) {
				},
				success: function(res) {
					window.location.reload();
				}
			});
			$(e.target).attr('disabled', false);
		});
		// Update Modal END

		// Datetimepicker Setting
		$('#reserve_date').datetimepicker({
			format: 'YYYY-MM-DD HH:mm',
			stepping: 60
		});
		$('#update_date').datetimepicker({
			format: 'YYYY-MM-DD HH:mm',
			stepping: 60,
			minDate: moment()
		});
		// Datetimepicker Setting END
	});
	</script>
	<!-- ====== JAVASCRIPT END ====== -->
</body>

</html>
