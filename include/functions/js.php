<?php
	if(($current_page=='item' && $item[0]['expire']>0) || ($current_page=='item' && $item[0]['discount']>0) || $current_page=='items')
	{
?>
    <script src="<?php print $shop_url; ?>assets/js/jquery.countdown.min.js"></script>
    <script src="<?php print $shop_url; ?>assets/js/moment-with-locales.min.js"></script>
    <script src="<?php print $shop_url; ?>assets/js/moment-timezone-with-data.js"></script>
	
	<script type="text/javascript">
		$('[data-countdown]').each(function() {
		  var $this = $(this), finalDate = $(this).data('countdown');

		  var finalDate = moment.tz(finalDate, "Europe/Bucharest");
		  
		  $this.countdown(finalDate.toDate(), function(event) {
			$this.html(event.strftime('%D <?php print $lang_shop['days']; ?> %H:%M:%S'));
		  });
		});
	</script>
<?php 
	}
	
	if($current_page=='item' && $item[0]['type']==3)
	{
?>
	<script>
		var used = [];

		function isset(variable) {
			return typeof variable !== typeof undefined;
		}

		function use(select) {
			var parent = select.parentNode;

			for (var i = 0; i < parent.children.length; ++i)
				if (parent.children[i].value != '')
					used[parent.children[i].value] = 0;
			
			var selects = $('select');
			
			for (var i = 0; i < selects.length; ++i)
				for (var j = 0; j < selects[i].length; ++j)
					if(selects[i][j].selected)
					{
						selects[i][j].hidden = false;
						selects[i][j].disabled = false;
					}
					else if(isset(used[selects[i][j].value]))
					{
						selects[i][j].hidden = true;
						selects[i][j].disabled = true;
					}
					else
					{
						selects[i][j].hidden = false;
						selects[i][j].disabled = false;
					}
			used = [];
		}
	</script>
<?php } ?>
	<script type="text/javascript">
		$(document).ready(function() {
			$("body").tooltip({ selector: '[data-toggle=tooltip]' });
		});
	</script>