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
					<li role="presentation" id="li-res"><a href="admin-reserve.php">RESERVATION<span class="button-line"></span></a></li>
					<li role="presentation" class="dropdown" id="li-set">
						<a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false">SETTING <span class="caret"></span><span class="button-line"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li class="divider"></li>
							<li id="li-set-week"><a href="admin-week.php">Days Off a Week</a></li>
							<li class="divider"></li>
							<li id="li-set-spe"><a href="admin-special.php">Special Leave</a></li>
							<li class="divider"></li>
							<li id="li-set-oth"><a href="admin-other.php">Others</a></li>
							<li class="divider"></li>
						</ul>
					</li>
				</ul>
			</div>
			<div id="navbar_right" class="navbar-collapse collapse navbar-right">
				<button type="button" name="logout-btn" class="btn navbar-btn btn-default"><span class="glyphicon glyphicon-log-out"></span></button>
			</div>
		</div>
	</nav>
	<!-- ====== NAV END ====== -->
