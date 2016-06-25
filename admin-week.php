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
							<li class="active"><a href="admin-week.php">Days Off a Week</a></li>
							<li class="divider"></li>
							<li><a href="admin-special.php">Special Leave</a></li>
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
			<h1>Setting: Days Off a Week</h1>
		</div>
		<div class="row text-left">
			<div class="col-md-8 col-md-offset-2">
				<table	id="week-table"
					data-id-field="index"
					data-url="json-week.php">
				</table>
			</div>
		</div>
		<div class="row footer">
		</div>
	</div>
	<!-- ====== MAIN END ====== -->

	<!-- ====== JAVASCRIPT ====== -->
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

		// Week Table 
		var $table = $('#week-table');
		$table.bootstrapTable({
			columns: [
				{
					title: '#',
					field: 'title',
					align: 'center',
					halign: 'center',
					cellStyle: glyphiconStyle,
				},
				{
					title: 'Sunday',
					field: 0,
					width: '13%',
					align: 'center',
					halign: 'center',
					formatter: 'glyphiconFormat',
					cellStyle: glyphiconStyle,
				},
				{
					title: 'Monday',
					field: 1,
					width: '13%',
					align: 'center',
					halign: 'center',
					formatter: 'glyphiconFormat',
					cellStyle: glyphiconStyle,
				},
				{
					title: 'Tuesday',
					field: 2,
					width: '13%',
					align: 'center',
					halign: 'center',
					formatter: 'glyphiconFormat',
					cellStyle: glyphiconStyle,
				},
				{
					title: 'Wednesday',
					field: 3,
					width: '13%',
					align: 'center',
					halign: 'center',
					formatter: 'glyphiconFormat',
					cellStyle: glyphiconStyle,
				},
				{
					title: 'Thursday',
					field: 4,
					width: '13%',
					align: 'center',
					halign: 'center',
					formatter: 'glyphiconFormat',
					cellStyle: glyphiconStyle,
				},
				{
					title: 'Friday',
					field: 5,
					width: '13%',
					align: 'center',
					halign: 'center',
					formatter: 'glyphiconFormat',
					cellStyle: glyphiconStyle,
				},
				{
					title: 'Saturday',
					field: 6,
					width: '13%',
					align: 'center',
					halign: 'center',
					formatter: 'glyphiconFormat',
					cellStyle: glyphiconStyle,
				},
				{
					field: 'index',
					visible: false
				}
			]
		});

		$table.on('click-cell.bs.table', function(field, row, value, $element) {
			glyphiconWeekEvents($table, row, value, $element);
		});
		// Week Table END
	});
	</script>
	<!-- ====== JAVASCRIPT END ====== -->
</body>

</html>
