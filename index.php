<?php
	@ob_start();
	include 'include/functions/header.php';
?>
<!DOCTYPE html>
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title><?php print $lang_shop['site_title'].' - '.$server_name; ?></title>

    <link rel="stylesheet" type="text/css" href="<?php print $shop_url; ?>assets/css/base.css" />
    <link rel="stylesheet" type="text/css" href="<?php print $shop_url; ?>assets/css/fonts.css" />
    <link rel="stylesheet" type="text/css" href="<?php print $shop_url; ?>assets/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php print $shop_url; ?>assets/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="<?php print $shop_url; ?>assets/css/master.css" />
    <link rel="stylesheet" type="text/css" href="<?php print $shop_url; ?>assets/css/animate.css" />

    <link rel="shortcut icon" type="image/x-icon" href="<?php print $shop_url; ?>assets/img/favicon.ico?">

    <!--[if lt IE 9]><script type="text/javascript" src="assets/js/html5.min.js"></script><![endif]-->

</head>

<body>
    <div class="header">
        <div class="container">
            <div class="navigation">
                <a href="<?php print $shop_url; ?>"><img class="logo pulse" style="padding-top: 48px;" src="<?php print $shop_url; ?>images/logo.png">
                </a>
              <!--  <a href="/"><img class="logo pulse" style="padding-top: 48px;" src="<?php /*print $shop_url; */?>images/logo1.png">
                </a>-->
                <ul>
                    <li>
                        <a href="/"><i class="fa fa-user fa-2x"></i><span><?php print $lang_shop['home']; ?></span></a>
                    </li>
                    <li>
                        <a href="<?php print $shop_url; ?>"><i class="fa fa-shopping-cart fa-2x"></i> <span><?php print $lang_shop['site_title']; ?></span></a>
                    </li>

					<?php /*if(!is_loggedin()) { */?><!--
                    <li>
                        <a href="<?php /*print $shop_url; */?>login"><i class="fa fa-user fa-2x"></i><span><?php /*print $lang_shop['login']; */?></span></a>
                    </li>
					<?php /*} else { */?>
                    <li>
                        <a href="<?php /*print $shop_url; */?>logout"><i class="fa fa-user-times fa-2x"></i><span><?php /*print $lang_shop['logout']; */?></span></a>
                    </li>
					<?php /*} if(is_loggedin() && is_paypal_list()) { */?>
                    <li>
                        <a href="<?php /*print $shop_url; */?>buy/coins"><i class="fa fa-money fa-2x"></i><span><?php /*print $lang_shop['pay']; */?></span></a>
                    </li>
					<?php /*} */?>
					<li class="nav-item dropdown">
						<a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="true"><i class="fa fa-language fa-2x"></i><span><?php /*print $language_codes[$language_code]; */?></span></a>
						<div class="dropdown-menu">
								<?php
/*									foreach($language_codes as $key => $value)
										print '<a href="'.$shop_url.'?lang='.$key.'" data-toggle="tooltip" data-placement="right" title="" data-original-title="'.$value.'"><img src="'.$shop_url.'assets/img/language/'.$key.'.png" style="width: 50px;"></a>';
								*/?>
						</div>
					</li>-->
                </ul>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-<?php if(is_loggedin() || $current_page=='item') print 9; else print 12; ?>">
                <div class="homepage-content" style="background: #fff; padding: 20px 10px;">
					<?php
						switch ($current_page) {
							case 'home':
								include 'pages/shop/home.php';
								break;
							case 'items':
								include 'pages/shop/items.php';
								break;
							case 'item':
								include 'pages/shop/item.php';
								break;
							case 'login':
								include 'pages/shop/login.php';
								break;
							case 'logout':
								include 'pages/shop/logout.php';
								break;
							case 'categories':
								include 'pages/admin/is_categories.php';
								break;
							case 'add_items':
								include 'pages/admin/add_items.php';
								break;
							case 'add_items_bonus':
								include 'pages/admin/add_items_bonus.php';
								break;
							case 'settings':
								include 'pages/admin/settings.php';
								break;
							case 'paypal':
								include 'pages/admin/paypal.php';
								break;
							case 'coins':
								include 'pages/shop/coins.php';
								break;
							case 'pay':
								include 'pages/shop/pay.php';
								break;
							default:
								include 'pages/shop/home.php';
						}

						if(!is_loggedin() && $current_page!='login')
						{
					?>
					<div class="jumbotron">
						<!--<form action="<?php /*print $shop_url; */?>login" method="post" class="form-inline justify-content-center">
							<label class="sr-only" for="inlineFormInput"><?php /*print $lang_shop['name_login']; */?></label>
							<input class="form-control mb-4 mr-sm-4 mb-sm-0" name="username" id="username" pattern=".{5,64}" maxlength="64" placeholder="<?php /*print $lang_shop['name_login']; */?>" required="" type="text" autocomplete="off">

							<label class="sr-only" for="inlineFormInputGroup"><?php /*print $lang_shop['password']; */?></label>
							<input class="form-control input-group mb-4 mr-sm-4 mb-sm-0" name="password" id="password" pattern=".{5,16}" maxlength="16" placeholder="<?php /*print $lang_shop['password']; */?>" required="" type="password">

							<button type="submit" class="btn btn-primary"><?php /*print $lang_shop['login2']; */?></button>
						</form>-->
					</div>
					<?php } ?>
                </div>
            </div>
			<?php
				if(is_loggedin()|| $current_page=='item') {
			?>
            <div class="col-md-3">
                <div class="sidebar">
				<?php
					$padding_md='';

					$donate = false;

					if(is_paypal_list())
					{
						print '<a href="'.$shop_url.'buy/coins" data-toggle="tooltip" data-placement="left" title="" data-original-title="'.$lang_shop['pay'].'">';
						$padding_md = ' style="padding-top:11px;"';
					}
					if(is_loggedin()) {
				?>
                    <div class="info-coins-button">
						<img src="<?php print $shop_url; ?>images/md.png" data-toggle="tooltip" data-placement="right" title="" data-original-title="MD"<?php print $padding_md; ?>> <?php print number_format(is_coins(), 0, '', '.'); ?>
						<br/>
						<img src="<?php print $shop_url; ?>images/jd.png" data-toggle="tooltip" data-placement="right" title="" data-original-title="JD"<?php print $padding_md; ?>> <?php print number_format(is_coins(1), 0, '', '.'); ?>
					</div>
				<?php
					}
					if($padding_md!='')
						print '</a>';

					if($current_page=='item')
						include 'include/sidebar/info_object.php';

					if(is_loggedin()) {
				?>
					<ul class="list-group">
						<li class="list-group-item">
							<center><p style="color: white;"><?php print get_account_name(); ?></p></center>
						</li>
					</ul>
				<?php } print '<div style="margin-bottom: 30px;"></div>'; if(is_loggedin() && web_admin_level()>=9) { ?>
                    <div class="action-box">
                        <a href="<?php print $shop_url; ?>settings"><i class="fa fa-cogs"></i>Admin</a>
                        <a class="color" href="<?php print $shop_url; ?>admin/paypal"><i class="fa fa-money"></i>PayPal</a>
                        <div class="clear"></div>
                    </div>
				<?php } if(is_loggedin()) include 'include/sidebar/last_bought.php'; ?>
                </div>
            </div>
			<?php } ?>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="footer">
        <div class="container">
            <div class="copyright">
				<div class="col-md-12 p-info">
					<p class="pull-left">
							&copy; Copyright <?php
													$copyright_year = date('Y');
													if($copyright_year > 2017)
														print '2017 - '.$copyright_year;
													else print $copyright_year;
													print ' '.$server_name;
												?>
					</p>

				</div>
            </div>
        </div>
    </div>

</body>
    <script src="<?php print $shop_url; ?>assets/js/jquery.js"></script>
    <script src="<?php print $shop_url; ?>assets/js/tether.min.js"></script>
    <script src="<?php print $shop_url; ?>assets/js/bootstrap.min.js"></script>

	<?php include 'include/functions/js.php'; ?>
</html>
