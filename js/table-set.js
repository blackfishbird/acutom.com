//var column = 0;
function glyphiconFormat(value, row, index) {
//	var name = column;
//	if(row.title.toString().indexOf('open') != -1)
//		name = 'open-' + name;
//	else  name = "all-hour-" + name;
//	column++;
//	if(column == 7)  column = 0;
	if(value === 0) {
		return [
			'<div class="switch" name="bt-btn-close">',
			'<i class="glyphicon glyphicon-remove text-danger"></i>',
			'</div>'
		].join('');
	} else if(value === 1) {
		return [
			'<div class="switch" name="bt-btn-open">',
			'<i class="glyphicon glyphicon-ok text-info"></i>',
			'</div>'
		].join('');
	} else {
		return value;
	}
}
function glyphiconTrashFormat(value, row, index) {
	return [
		'<div class="trash" name="bt-btn-trash">',
		'<i class="glyphicon glyphicon-trash text-gray"></i>',
		'</div>'
	].join('');
}
function glyphiconWeekEvents($table, row, value, $element) {
	if($.isNumeric(row)) {
		var day = row;
		var hour = $element.title;
		var index = $element.index;

		// Change the cell
		var update = [];
		if(value === 0) {
			update[day] = 1;
		} else {
			update[day] = 0;
		}
		$table.bootstrapTable('updateRow', {
			index: index,
			row: update
		});
		weekUpdate(day, hour, update[day]);

		// If all day close
		if(index === 0) {  // Set 8 am = open
			hour = 8;
			update[day] = 1;
			index = 1;
		} else {  // Set all day = close
			hour = 'open';
			update[day] = 0;
			index = 0;
		}
		if(calumnCheck($table, day)) {
			$table.bootstrapTable('updateRow', {
				index: index,
				row: update
			})
			weekUpdate(day, hour, update[day]);
		}
	}
}
function glyphiconStyle(value, row, index) {
	if(index === 0) {
		if(value.toString().indexOf('bt-btn-close') != -1) {
			return {
				classes: 'bt-close bt-dbline-b'
			}
		} else {
			return {
				classes: 'bt-dbline-b'
			}
		}
	} else if(index === 4 || index === 10) {
		return {
			classes: 'bt-dbline-b'
		}
	}
	return {};
}
function calumnCheck($table, row) {
	var table = $table.bootstrapTable('getData');
	var allFalse = true;
	for(var i = 1; i < table.length; i++) {
		if(table[i][row] === 1) {
			allFalse = false;
		}
	}
	return allFalse;
}
function weekUpdate(day, hour, value) {
	$.ajax({
		url: 'week-update.php',
		type: 'POST',
		data: {
			day: day,
			hour: hour,
			value: value
		},
		error: function(xhr) {
			return false;
		},
		success: function(res) {
			return true;
		}
	});
	return false;
}

function dayStringGet(day) {
	var weekday = new Array(7);
	weekday[0] = "Sun.";
	weekday[1] = "Mon.";
	weekday[2] = "Tue.";
	weekday[3] = "Wed.";
	weekday[4] = "Thu.";
	weekday[5] = "Fri.";
	weekday[6] = "Sat.";

	return weekday[day];
}
function glyphiconSpecialSwitch($table, value, row, index, hour) {
//console.dir(value);
//console.dir(row);
//console.dir(index);
//console.dir(hour);

	var update = [];
	if(value === 0)  update[hour] = 1;
	else  update[hour] = 0;
	$table.bootstrapTable('updateRow', {
		index: index,
		row: update
	});
	specialUpdate(row.date, hour, update[hour]);

	if(hour.toString().indexOf('open') != -1) {
		hour = 8;
		update[hour] = 1;
	} else {
		hour = 'open';
		update[hour] = 0;
	}
	if(rowCheck(row)) {
		$table.bootstrapTable('updateRow', {
			index: index,
			row: update
		});
		specialUpdate(row.date, hour, update[hour]);
	}
}
function rowCheck(row) {
	var allFalse = true;
	for(var i = 8; i < 21; i++) {
		if(row[i] === 1)  {
			allFalse = false;
			break;
		}
	}
	return allFalse;
}
function specialUpdate(date, hour, value) {
	$.ajax({
		url: 'special-update.php',
		type: 'POST',
		data: {
			date: date,
			hour: hour,
			value: value
		},
		error: function(xhr) {
			return false;
		},
		success: function(res) {
			return true;
		}
	});
	return false;
}
