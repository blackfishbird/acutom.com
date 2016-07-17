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
					<li role="presentation"><a href="acupuncture-what-is-acupuncture.php"><span class="button-inline">WHAT IS ACUPUNCTURE<span class="button-line"></span></span></a></li>
					<li role="presentation" class="dropdown" id="li-ser">
						<a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false"><span class="button-inline">SERVICES<span class="button-line"></span></span> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li class="divider"></li>
							<li class="dropdown dropdown-submenu" id="li-ser-acu">
								<a class="dropdown-toggle" href="service-a.php" data-toggle="dropdown">Acupuncture</a>
								<ul class="dropdown-menu">
									<li class="divider"></li>
<?php /*
									<li><a href="acupuncture-im-afraid-of-needle.php">I'm afraid of needle.</a></li>
									<li class="divider"></li>
*/ ?>
									<li id="li-ser-acu-what"><a href="acupuncture-what-is-acupuncture.php">What is acupuncture?</a></li>
									<li class="divider"></li>
<?php /*
									<li><a href="acupuncture-electro-acupuncture.php">Electro Acupuncture</a></li>
									<li class="divider"></li>
*/ ?>
								</ul>
							</li>
							<li class="divider"></li>
<?php /*
							<li class="dropdown dropdown-submenu">
								<a class="dropdown-toggle" href="service-m.php" data-toggle="dropdown">Massage</a>
								<ul class="dropdown-menu">
									<li class="divider"></li>
									<li><a href="massage-what-is-massage.php">What is massage?</a></li>
									<li class="divider"></li>
								</ul>
							</li>
							<li class="divider"></li>
							<li class="dropdown dropdown-submenu">
								<a class="dropdown-toggle" href="service-other.php" data-toggle="dropdown">Other Services</a>
								<ul class="dropdown-menu">
									<li class="divider"></li>
									<li><a href="ohter-electro-acupuncture.php">Electro Acupuncture</a></li>
									<li class="divider"></li>
									<li><a href="other-cupping.php">Cupping</a></li>
									<li class="divider"></li>
									<li><a href="other-moxibustion.php">Moxibustion</a></li>
									<li class="divider"></li>
									<li><a href="other-herb-inquiring.php">Herb Inquiring</a></li>
									<li class="divider"></li>
								</ul>
							</li>
							<li class="divider"></li>
*/ ?>
						</ul>
					</li>
					<li role="presentation" id="li-pri"><a href="pricing.php"><span class="button-inline">PRICING<span class="button-line"></span></span></a></li>
					<li role="presentation" class="dropdown" id="li-res">
						<a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false"><span class="button-inline">ONLINE RESERVATION<span class="button-line"></span></span> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li class="divider"></li>
							<li id="li-res-mas"><a href="massage.php">Massage</a></li>
							<li class="divider"></li>
							<li id="li-res-acu"><a href="acupuncture.php">Acupuncture</a></li>
							<li class="divider"></li>
							<li id="li-res-can"><a href="cancel.php">Cancel</a></li>
							<li class="divider"></li>
						</ul>
					</li>
					<li role="presentation" class="dropdown" id="li-abo">
						<a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false"><span class="button-inline">ABOUT<span class="button-line"></span></span> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li class="divider"></li>
							<li id="li-abo-sta"><a href="staff.php">Doctor Staff</a></li>
							<li class="divider"></li>
							<li id="li-abo-con"><a href="contact.php">Contact Us</a></li>
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
