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

	<!-- Bootstrap Table -->
	<link rel="stylesheet" href="css/bootstrap-table.min.css" />
	<script src="js/bootstrap-table.min.js"></script>
	<script src="js/bootstrap-table-toolbar.min.js"></script>

	<!-- Moment -->
	<script src="js/moment.min.js"></script>

	<!-- Datetimepicker -->
	<link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css" />
	<script src="js/bootstrap-datetimepicker.min.js"></script>
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
							<li class="active"><a href="admin-special.php">Special Leave</a></li>
							<li class="divider"></li>
							<li><a href="admin-other.php">Others</a></li>
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
			<h1>Setting: Special Leave</h1>
		</div>
		<div class="row">
			<div id="special-toolbar">
				<button type="button" class="btn btn-default" data-toggle="modal" data-target="#add-modal">Add new special leave</button>
			</div>
			<div class="col-md-12">
				<table	id="special-table"
					data-id-field="index"
					data-url="json-special.php"
					data-toolbar="#special-toolbar">
				</table>
			</div>
		</div>
		<div class="row footer">
		</div>
	</div>
	<!-- ====== MAIN END ====== -->

	<!-- ====== MODAL TRASH ====== -->
	<div class="modal fade" id="trash-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
						<form role="form" id="trash-form">
							<div id="trash-msg"></div>
							<input type="hidden" id="trash-date" />
						</form>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-notice" id="trash-btn">Yes</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
				</div>
			</div>
		</div>
	</div>
	<!-- ====== MODAL TRASH END ====== -->

	<!-- ====== MODAL ADD ====== -->
	<div class="modal fade" id="add-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">ADD NEW SPECIAL LEAVE</h4>
				</div>
				<div class="modal-body">
					<form role="form" id="add-form">
						<div class="row border-bottom-gray">
							<div class="form-group">
								<label for="add-date">Date: </label>
								<input type="text" class="form-control" id="add-date" data-toggle="tooltip" data-placement="bottom" title="date" placeholder="date" />
							</div>
						</div>
						<div class="row border-bottom-gray">
							<div class="col-md-12"><label>Open: </label></div>
							<div class="radio-inline">
								<label><input type="radio" value="1" name="open-all" checked />open</label>
							</div>
							<div class="radio-inline">
								<label><input type="radio" value="0" name="open-all" />close</label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12"><label>Open time: </label></div>
							<div class="col-md-4">
								<div class="checkbox">
									<label><input type="checkbox" value="8" checked>08:00</label>
								</div>
								<div class="checkbox">
									<label><input type="checkbox" value="9">09:00</label>
								</div>
								<div class="checkbox">
									<label><input type="checkbox" value="10">10:00</label>
								</div>
								<div class="checkbox">
									<label><input type="checkbox" value="11">11:00</label>
								</div>
							</div>
							<div class="col-md-4">
								<div class="checkbox">
									<label><input type="checkbox" value="12">12:00</label>
								</div>
								<div class="checkbox">
									<label><input type="checkbox" value="13">13:00</label>
								</div>
								<div class="checkbox">
									<label><input type="checkbox" value="14">14:00</label>
								</div>
								<div class="checkbox">
									<label><input type="checkbox" value="15">15:00</label>
								</div>
								<div class="checkbox">
									<label><input type="checkbox" value="16">16:00</label>
								</div>
								<div class="checkbox">
									<label><input type="checkbox" value="17">17:00</label>
								</div>                                                
							</div>
							<div class="col-md-4">
								<div class="checkbox">                                
									<label><input type="checkbox" value="18">18:00</label>
								</div>                                                
								<div class="checkbox">                                
									<label><input type="checkbox" value="19">19:00</label>
								</div>                                                
								<div class="checkbox">                                
									<label><input type="checkbox" value="20">20:00</label>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-notice" id="add-btn">Add it</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
	<!-- ====== MODAL TRASH END ====== -->

	<!-- ====== JAVASCRIPT ====== -->
	<script src="js/form-check.js"></script>
	<script src="js/table-set.js"></script>
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

		// Special Table
		var $table = $('#special-table');
		$table.bootstrapTable({
			columns: [
				{
					title: 'date',
					field: 'date_day',
					align: 'right',
					halign: 'right',
					formatter: function(value, row) {
						return [row['date'], ' (', dayStringGet(row['day']), ')'].join('');
					},
					cellStyle: {
						classes: 'text-strong'
					}
				},
				{
					title: 'open',
					field: 'open',
					align: 'center',
					halign: 'center',
					formatter: 'glyphiconFormat',
					events: 'glyphiconSpecialEvents',
					cellStyle: {
						classes: 'bt-dbline-r'
					}
				},
				{
					title: '8',
					field: 8,
					align: 'center',
					halign: 'center',
					formatter: 'glyphiconFormat',
					events: 'glyphiconSpecialEvents',
				},
				{
					title: '9',
					field: 9,
					align: 'center',
					halign: 'center',
					formatter: 'glyphiconFormat',
					events: 'glyphiconSpecialEvents',
				},
				{
					title: '10',
					field: 10,
					align: 'center',
					halign: 'center',
					align: 'center',
					halign: 'center',
					formatter: 'glyphiconFormat',
					events: 'glyphiconSpecialEvents',
				},
				{
					title: '11',
					field: 11,
					formatter: 'glyphiconFormat',
					align: 'center',
					halign: 'center',
					events: 'glyphiconSpecialEvents',
					cellStyle: {
						classes: 'bt-dbline-r'
					}
				},
				{
					title: '12',
					field: 12,
					align: 'center',
					halign: 'center',
					formatter: 'glyphiconFormat',
					events: 'glyphiconSpecialEvents',
				},
				{
					title: '13',
					field: 13,
					align: 'center',
					halign: 'center',
					formatter: 'glyphiconFormat',
					events: 'glyphiconSpecialEvents',
				},
				{
					title: '14',
					field: 14,
					align: 'center',
					halign: 'center',
					formatter: 'glyphiconFormat',
					events: 'glyphiconSpecialEvents',
				},
				{
					title: '15',
					field: 15,
					align: 'center',
					halign: 'center',
					formatter: 'glyphiconFormat',
					events: 'glyphiconSpecialEvents',
				},
				{
					title: '16',
					field: 16,
					align: 'center',
					halign: 'center',
					formatter: 'glyphiconFormat',
					events: 'glyphiconSpecialEvents',
				},
				{
					title: '17',
					field: 17,
					formatter: 'glyphiconFormat',
					align: 'center',
					halign: 'center',
					events: 'glyphiconSpecialEvents',
					cellStyle: {
						classes: 'bt-dbline-r'
					}
				},
				{
					title: '18',
					field: 18,
					align: 'center',
					halign: 'center',
					formatter: 'glyphiconFormat',
					events: 'glyphiconSpecialEvents',
				},
				{
					title: '19',
					field: 19,
					align: 'center',
					halign: 'center',
					formatter: 'glyphiconFormat',
					events: 'glyphiconSpecialEvents',
				},
				{
					title: '20',
					field: 20,
					align: 'center',
					halign: 'center',
					formatter: 'glyphiconFormat',
					events: 'glyphiconSpecialEvents',
				},
				{
					field: null,
					align: 'center',
					halign: 'center',
					formatter: 'glyphiconTrashFormat',
					events: 'glyphiconTrashEvents'
				}
			]
		});
		window.glyphiconSpecialEvents = {
			'click .switch': function(e, value, row, index) {
				var	table = $table.data('bootstrap.table'),
					$element = $(this).parent(),
					$tr = $element.parent(),
					row = table.data[$tr.data('index')],
					cellIndex = $element[0].cellIndex,
					$headerCell = table.$header.find('th:eq(' + cellIndex + ')'),
					field = $headerCell.data('field');
				glyphiconSpecialSwitch($table, value, row, index, field);
			}
		}
		window.glyphiconTrashEvents = {
			'click .trash': function(e, value, row, index) {
				$('#trash-date').val(row.date);
				document.getElementById('trash-msg').innerHTML = '<p>即將刪除 ' + row.date + ' 的營業時段設定</p><p>確定要刪除嗎？</p>';
				$('#trash-modal').modal();
			}
		}
		$('#trash-btn').on('click', function(e) {
			$(e.target).attr('disabled', true);
			$.ajax({
				url: 'special-delete.php',
				type: 'POST',
				data: {
					date: $('#trash-date').val()
				},
				error: function(xhr) {
				},
				success: function(res) {
					$table.bootstrapTable('refresh');
				}
			});
			$(e.target).attr('disabled', false);
		});
		// Special Table END

		// Datetimepicker
		function getDisabledDates() {
			var disabledDates;
			$.ajax({
				url: 'json-special-date.php',
				dataType: 'json',
				error: function(xhr) {
					disabledDates = null;
				},
				success: function(res) {
					disabledDates = res;
				},
				async: false
			});
			return disabledDates;
		}
		$('#add-date').datetimepicker({
			format: 'YYYY-MM-DD',
			minDate: moment().add(1, 'day'),
			disabledDates: getDisabledDates()
		});
		// Datetimepicker END

		// Add Modal
		$('input[name="open-all"]').on('change', function(e) {
			if($(this).val() == 1) {
				$(':checkbox:first')[0].checked = true;
				$(':checkbox').attr('disabled', false);
			} else {
				$(':checkbox').attr('checked', false).attr('disabled', true);
			}
		});
		$('#add-btn').on('click', function(e) {
			if(isFormValid($('#add-form'))) {
				$(e.target).attr('disabled', true);
				var add = [];
				var open = $(':radio:checked').val();
				if(open == 1) {
					var $checked = $(':checkbox:checked');
					var n = $checked.length;
					for(var i = 0; i < n; i++)  add[i] = $checked[i].value;
				}
				$.ajax({
					url: 'special-add.php',
					type: 'POST',
					data: {
						date: $('#add-date').val(),
						add: add,
						open: open
					},
					error: function(xhr) {
					},
					success: function(res) {
						$table.bootstrapTable('refresh');
					}
				});
				$(e.target).attr('disabled', false);
			}
		});
		// Add Modal END
	});
	</script>
</body>

</html>
