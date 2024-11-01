<?php

	$ses_wpscd_query = "
		   SELECT pl.id,
	                  date_format(from_unixtime(pl.date), '%%d %%b %%Y'),
	                  SUM(c.quantity) AS num_items,
	                  pl.totalprice,
	                  s.name
		     FROM {$table_prefix}wpsc_purchase_logs pl
		LEFT JOIN {$table_prefix}wpsc_cart_contents c
		       ON pl.id = c.purchaseid,
	                  {$table_prefix}wpsc_purchase_statuses s
	            WHERE pl.processed = s.id
	         GROUP BY pl.id
 		 ORDER BY pl.date DESC ";

    $ses_wpscd_query .= apply_filters('ses_wpscd_recent_orders_limit', "LIMIT 5");

	output_order_list($ses_wpscd_query);

?>
