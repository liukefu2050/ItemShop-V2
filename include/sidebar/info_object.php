					<ul class="list-group">
						<li class="list-group-item">
							<center>
								<img src="<?php print $shop_url; ?>images/items/<?php print get_item_image($item[0]['vnum']); ?>.png">
								<h4><?php print $item_name; ?></h4>
							</center>
						</li>
						<?php
							if($item[0]['discount']>0) {
								$discount = date("Y-m-d H:i:s", $item[0]['discount_expire']);
						?>
							<li class="list-group-item">
								<center>
									<h3 class="text-danger font-weight-bold"><span class="badge badge-danger font-weight-bold strong">- <?php print $item[0]['discount']; ?>%</span></h3>
									<p class="text-danger font-weight-bold" data-countdown="<?php print $discount; ?>"></p>
								</center>
							</li>
						<?php } 
							if($item[0]['expire']>0) {
								$expire = date("Y-m-d H:i:s", $item[0]['expire']);
						?>
							<li class="list-group-item">
								<center><p class="text-danger font-weight-bold" data-countdown="<?php print $expire; ?>"></p></center>
							</li>
						<?php } 
						if($item[0]['count']>1) { ?>
							<li class="list-group-item">
								<center><p class="text-info"><b><?php print ucfirst(strtolower($lang_shop['quantity'])).': '.$item[0]['count']; ?></b></p></center>
							</li>
						<?php } ?>
						
							<?php is_get_item($get_item); ?>
											<?php
												if(check_item_sash($item[0]['vnum']))
													is_get_sash_bonuses($get_item);
												
												$lvl = get_item_lvl($item[0]['vnum']);
												if($lvl) {
											?>
						<li class="list-group-item">
											<center><p class="text-danger"><?php print $lang_shop['available_lvl']; ?> <b><?php print $lvl; ?></b></p></center>
						</li>
											<?php } if(check_item_sash($item[0]['vnum'])) { ?>
						<li class="list-group-item">
											<center><p class="text-warning"><?php print $lang_shop['bonus_absorption']; ?> <b><?php print is_get_sash_absorption($get_item); ?></b>%</p></center>
						</li>
											<?php } if(get_item_name($item[0]['socket0']))
														get_item_stones_market($get_item);
											
												if($item[0]['item_unique']==1 || $item[0]['item_unique']==2) { ?>
						<li class="list-group-item">
											<center><p class="text-info"><?php print $lang_shop['time_left']; ?>:</br> <b><?php is_get_item_time($get_item); ?></b></p></center>
						</li>
											<?php } ?>
						<li class="list-group-item">
											<?php if(is_loggedin()) { ?>
											<button type="button" class="btn btn-success btn-block<?php if(is_coins($item[0]['pay_type']-1)<$total) print ' disabled'; ?>" data-toggle="modal" data-target="#myModal">
												<img src="<?php print $shop_url; ?>images/<?php if($item[0]['pay_type']==1) print 'md'; else print 'jd'; ?>.png" title="MD"> 
												<?php
													print $lang_shop['buy'].' (';
													if($item[0]['discount']>0)
														print $total.' <span style="text-decoration: line-through;">'.$price1.'</span>';
													else print $price1;
													print ' '; if($item[0]['pay_type']==1) print 'MD'; else print 'JD'; ?>)
											</button>
											<?php } if(!is_loggedin()) { ?>
												<div class="alert alert-dismissible alert-danger">
												<button type="button" class="close" data-dismiss="alert">×</button>
												<strong>Info:</strong> <?php print $lang_shop['authentication_required']; ?> </div>
											<?php } ?>
						</li>
					</ul>