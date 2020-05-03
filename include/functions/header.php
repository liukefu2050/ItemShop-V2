<?php
	session_start();
	header('Cache-control: private');
	include 'config.php';
	
	if (substr($shop_url, -1)!='/')
		$shop_url.='/';
	
	include 'include/functions/language.php';
	
	$offline = 0;
	require_once("include/classes/user.php");
	$database = new USER($host, $user, $password);
	
	include 'include/functions/get_item_image.php';
	include 'include/functions/basic.php';
	
	if($offline)
		die("The Connection to the database of game is not available.");
		
	$item_name_db = get_settings_time(4);
	
	$current_page = isset($_GET['p']) ? $_GET['p'] : null;
	
	if($current_page=='items' || $current_page=='add_items' || $current_page=='add_items_bonus')
		$get_category = isset($_GET['category']) ? $_GET['category'] : 1;
	
	if($current_page=='item' || $current_page=='buy')
	{
		$get_item = isset($_GET['id']) ? $_GET['id'] : 1;
		
		$item = array();
		$item = is_item_select($get_item);
		
		if($item[0]['type']==3) {
			$bonuses_name = is_get_bonuses_new_name();
			$bonuses = is_get_bonus_selection($get_item);
			
			$count = $bonuses['count'];

			$available_bonuses = array();
			foreach($bonuses as $key => $bonus)
				if($key[0]=='b' && $bonus!=0)
					$available_bonuses[intval(str_replace("bonus","", $key))] = $bonus;
		}
			
		if(is_loggedin() && web_admin_level()>=9 && isset($_POST['add_discount']))
		{
			$discount_expire = 0;
			if($_POST['discount_months']>0 || $_POST['discount_days']>0 || $_POST['discount_hours']>0 || $_POST['discount_minutes']>0)
				$discount_expire = strtotime("now +".intval($_POST['discount_months'])." month +".intval($_POST['discount_days'])." day +".intval($_POST['discount_hours'])." hours +".intval($_POST['discount_minutes'])." minute - 1 hour UTC");
			is_set_item_discount($get_item, intval($_POST['discount_value']), $discount_expire);
			redirect($shop_url.'item/'.$get_item.'/');
		}
	
		if($current_page=='buy' && is_coins($item[0]['pay_type']-1)<$item[0]['coins'])
			redirect($shop_url.'category/'.$item[0]['category']);
		else {
			$price1 = $total = $item[0]['coins'];
			if($item[0]['discount']>0)
			{
				$x = $item[0]['discount'] * $total / 100;
				$total-=$x;
				$total = round($total);
			}
		}
	}
	
	if($current_page=='items' && is_loggedin() && web_admin_level()>=9) // minim_web_admin_level = 9
	{
		$remove = isset($_GET['remove']) ? $_GET['remove'] : 0;
		$remove_category = isset($_GET['category']) ? $_GET['category'] : 0;
		if($remove)
		{
			is_delete_item($remove);
			if($remove_category)
				redirect($shop_url.'category/'.$remove_category.'/');
		}
	}
	
	if(($current_page=='items' || $current_page=='add_items' || $current_page=='add_items_bonus') && !is_check_category($get_category))
		redirect($shop_url);

	if(($current_page=='item' || $current_page=='buy') && !is_check_item($get_item))
		redirect($shop_url);
	
	redirect_shop($current_page);
	
	autoDeletePromotions();
	
	if($current_page=='coins')
	{	
		$list = array();
		$list = is_paypal_list();
		
		if(isset($_POST["id"]))
		{
			if(is_check_paypal($_POST["id"]))
			{
				$return_url = $shop_url."buy/coins/success";
				$cancel_url = $shop_url."buy/coins/cancelled";
				$notify_url = $shop_url."index.php?p=pay";

				$querystring = '';
				$querystring .= "?business=".urlencode($paypal_email)."&";
				
				$item_name = is_get_coins($_POST["id"]). ' MD';
				$querystring .= "item_name=".urlencode($item_name)."&";
				$querystring .= "amount=".urlencode(is_get_price($_POST["id"]))."&";
				
				$querystring .= "cmd=".urlencode(stripslashes("_xclick"))."&";
				$querystring .= "no_note=".urlencode(stripslashes("1"))."&";
				$querystring .= "currency_code=".urlencode(stripslashes("EUR"))."&";
				$querystring .= "bn=".urlencode(stripslashes("PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest"))."&";
				$querystring .= "first_name=".urlencode(stripslashes(get_account_name()))."&";
				
				$querystring .= "return=".urlencode(stripslashes($return_url))."&";
				$querystring .= "cancel_return=".urlencode(stripslashes($cancel_url))."&";
				$querystring .= "notify_url=".urlencode($notify_url)."&";
				$querystring .= "item_number=".urlencode($_POST["id"])."&";
				$querystring .= "custom=".urlencode($_SESSION['id']);
				
				//redirect('https://www.sandbox.paypal.com/cgi-bin/webscr'.$querystring);
				redirect('https://www.paypal.com/cgi-bin/webscr'.$querystring);
				exit();
			}
		}
	}
?>