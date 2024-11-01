<?php

	$ses_wpscd_query = "SELECT DATE_FORMAT(FROM_UNIXTIME(pr.time), '%%d %%b %%y') as rating_date,
	                           pr.ipnum,
	                           pl.name,
	                           pr.rated
	                      FROM {$table_prefix}wpsc_product_rating pr
	                 LEFT JOIN {$table_prefix}wpsc_product_list pl
	                        ON pr.productid = pl.id
	                  ORDER BY time DESC ";

	$ses_wpscd_query .= apply_filters('ses_wpscd_recent_product_ratings_limit', "LIMIT 5");

	$ses_wpscd_result_rows = $wpdb->get_results($wpdb->prepare($ses_wpscd_query),ARRAY_A);

	?>
	<table width="100%" class="ses-wpscd-table">
	<tr class="ses-wpscd-headerrow"><th>Date</th><th>IP Address</th><th>Item</th><th>Rating</th></tr>
<?php
	if (!count($ses_wpscd_result_rows)) {
		echo "<td class=\"ses-wpscd-cell\" colspan=4>No Ratings Yet</td>";
	} else {
		foreach ($ses_wpscd_result_rows as $row) {
			echo "<tr class=\"ses-wpscd-row\">";
			while (list($key,$value) = each($row)) {
				echo "<td class=\"ses-wpscd-cell\">".htmlentities($value)."</td>";
			}
			echo "</tr>";
		}
	}
	echo "</table>";
		
?>
