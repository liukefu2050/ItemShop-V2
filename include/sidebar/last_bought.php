                    <div class="list-table">
                        <h3 class="title"><?php print $lang_shop['last_bought']; ?></h3>
                        <table>
							<?php
								foreach(last_bought() as $last) {
							?>
                            <tr>
                                <td class="border-right"><a href="<?php print $shop_url.'item/'.$last['id'].'/'; ?>" style="color: white;"><?php if(!$item_name_db) print get_item_name($last['vnum']); else print get_item_name_locale_name($last['vnum']); ?></a></td>
                                <td><a href="<?php print $shop_url.'item/'.$last['id'].'/'; ?>" style="color: white;"><?php print $last['coins'].' '; if($last['pay_type']==1) print 'MD'; else print 'JD'; ?></a></td>
                            </tr>
								<?php } ?>
                        </table>
                    </div>