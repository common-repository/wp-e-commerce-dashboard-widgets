<?php

	$ses_wpscd_query = "
		   SELECT pl.id,
	                  date_format(from_unixtime(pl.date), '%%d %%b %%Y'),
	                  c.quantity AS num_items,
	                  s.name
		     FROM {$table_prefix}wpsc_purchase_logs pl
		LEFT JOIN {$table_prefix}wpsc_cart_contents c
		       ON pl.id = c.purchaseid,
	                  {$table_prefix}wpsc_purchase_statuses s
	            WHERE pl.processed = s.id
	              AND pl.processed = 2
 		 ORDER BY pl.date DESC ";

	// Legacy filter support
	$ses_wpscd_query .= apply_filters('ses_wpscd_items_to_ship_limit', 
							apply_filters('ses_wpscd_orders_to_ship_limit', 'LIMIT 5'));

	output_order_list($ses_wpscd_query,Array('ID','Order Date','Items','Status'));

?>
