<?php
include("config.php");

if(!$is_admin)  header("Location: ".HP_URL);
?>

<!DOCTYPE html>
<html>

<head>
	<?php include("page-header.php"); ?>
	<!-- Bootstrap Table -->
	<link rel="stylesheet" href="css/bootstrap-table.min.css" />
</head>

<body>
	<?php include("page-admin-navbar.php"); ?>
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
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/table-set.js"></script>

	<!-- Bootstrap Table -->
	<script src="js/bootstrap-table.min.js"></script>

	<script>
	$(function() {
		$('#li-set').addClass('active');
		$('#li-set-week').addClass('active');

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
