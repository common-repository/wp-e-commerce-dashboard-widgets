<?php

	function ses_wpscd_ps_period() {

		if (isset($_GET['period'])) {
			$period = $_GET['period'];
			if ($period != 'custom') {
				setcookie('ses_wpscd_product_sales_period', $period, time()+(86400*30));
			}
			$exit = TRUE;
		} elseif (isset($_COOKIE['ses_wpscd_product_sales_period'])) {
			$period = $_COOKIE['ses_wpscd_product_sales_period'];
		} else {
			$period = 'thismonth';
		}

		return $period;
	}

	function ses_wpscd_ps_ajax() {

		global $wpdb, $table_prefix;

		$period = ses_wpscd_ps_period();
		if (isset($_GET['period'])) {
			$exit = TRUE;
		}

		switch($period) {
			case "7days":
				// Actually today + 6 previous days
				$mindate = mktime(0,0,0,date('n'),date('j'),date('Y')) - 6*60*60*24;
				$maxdate = mktime(23,59,59,date('n'),date('j'),date('Y'));
				break;

			case "today":
				$mindate = mktime(0,0,0,date('n'),date('j'),date('Y'));
				$maxdate = mktime(23,59,59,date('n'),date('j'),date('Y'));
				break;

			case "lastmonth":
				if (date('n') == 1) {
					$mindate = mktime(0,0,0,12,date('j'),date('Y')-1);
				} else {
					$mindate = mktime(0,0,0,date('n')-1,date('j'),date('Y'));
				}
				$maxdate = mktime(0,0,0,date('n'),0,date('Y'));
				break;

			case "thisyear":
				$mindate = mktime(0,0,0,1,1,date('Y'));
				$maxdate = mktime(23,59,59,12,31,date('Y'));
				break;

			case "custom":
				$mindate = mktime(0,0,0,substr($_GET['start'],4,2),substr($_GET['start'],6,2),substr($_GET['start'],0,4));
				$maxdate = mktime(23,59,59,substr($_GET['end'],4,2),substr($_GET['end'],6,2),substr($_GET['end'],0,4));
				break;

			case "thismonth":
			default:
				$mindate = mktime(0,0,0,date('n'),1,date('Y'));
				if (date('n') == 12) {
					$maxdate = mktime(0,0,0,1,date('j'),date('Y')+1)-1;
				} else {
					$maxdate = mktime(0,0,0,date('n')+1,date('j'),date('Y'))-1;
				}
				break;

		}
		if ($period != "alltime") {
			$ses_wpscd_query_date_range = "pl.date BETWEEN $mindate AND $maxdate";
		} else {
			$ses_wpscd_query_date_range = "1";
		}
		$ses_wpscd_query = "SELECT p.name,
	                                   SUM(c.quantity) AS num_items,
	                                   SUM(c.quantity * c.price) AS product_revenue
		                      FROM {$table_prefix}wpsc_product_list p
		                 LEFT JOIN {$table_prefix}wpsc_cart_contents c
		                        ON p.id = c.prodid
                                 LEFT JOIN {$table_prefix}wpsc_purchase_logs pl
	                                ON c.purchaseid = pl.id
	                             WHERE $ses_wpscd_query_date_range
								   AND pl.processed in (2,3,4)
	                          GROUP BY p.id
 		                  ORDER BY product_revenue DESC, num_items DESC ";

		$ses_wpscd_query .= apply_filters('ses_wpscd_product_sales_limit', "LIMIT 5");

		$ses_wpscd_result_rows = $wpdb->get_results($wpdb->prepare($ses_wpscd_query),ARRAY_A);

		?>
		<div id="ses-wpscd-product-sales">
			<table width="100%" class="ses-wpscd-table">
			<tr class="ses-wpscd-headerrow"><th class="ses-wpscd-left">Product</th><th>Units</th><th class="ses-wpscd-right">Revenue</th></tr>
			<?php
			if (!count($ses_wpscd_result_rows)) {
				echo "<td class=\"ses-wpscd-cell\" colspan=3>No Sales In Selected Period</td>";
			} else {
				foreach ($ses_wpscd_result_rows as $row) {
					echo "<tr class=\"ses-wpscd-row\">";
					echo "<td class=\"ses-wpscd-cell ses-wpscd-left\">".htmlentities($row['name'])."</td>";
					echo "<td class=\"ses-wpscd-cell\">".htmlentities($row['num_items'])."</td>";
					echo "<td class=\"ses-wpscd-cell ses-wpscd-right\">".htmlentities($row['product_revenue'])."</td>";
					echo "</tr>";
				}
			}
			?>
			</table>
		</div>
		<?php
		if ($exit) {
			// This is an AJAX update - so exit()
			exit();
		} 
		
	}

	function ses_wpscd_ps_selector() {

		$period = ses_wpscd_ps_period();
	?>

	<div width="100%" class="ses-wpscd-right">
		<form method="POST" action="#">
		    <input type="text" name="ses-wpscd-product-sales-start-date" id="ses-wpscd-product-sales-start-date" size="8">&nbsp;
		    <input type="hidden" name="ses-wpscd-product-sales-start-date-internal" id="ses-wpscd-product-sales-start-date-internal">
		    <input type="text" name="ses-wpscd-product-sales-end-date" id="ses-wpscd-product-sales-end-date" size="8">
		    <input type="hidden" name="ses-wpscd-product-sales-end-date-internal" id="ses-wpscd-product-sales-end-date-internal">
		    <input type="button" id="ses-wpscd-product-sales-custom-submit" value="Go">
			<select id="ses-wpscd-product-sales-period" name="ses-wpscd-product-sales-period">
				<option value="today"<?php if($period=="today") echo " selected"; ?>>Today</option>
				<option value="7days"<?php if($period=="7days") echo " selected"; ?>>Last 7 Days</option>
				<option value="thismonth"<?php if($period=="thismonth") echo " selected"; ?>>This Month</option>
				<option value="lastmonth"<?php if($period=="lastmonth") echo " selected"; ?>>Last Month</option>
				<option value="thisyear"<?php if($period=="thisyear") echo " selected"; ?>>This Year</option>
				<option value="alltime"<?php if($period=="alltime") echo " selected"; ?>>All Time</option>
				<option value="custom"<?php if($period=="custom") echo " selected"; ?>>Custom</option>
			</select>
		</form>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery('#ses-wpscd-product-sales-period').change(function() {
						if (jQuery(this).val() == 'custom') {
							jQuery("#ses-wpscd-product-sales-start-date").show();
							jQuery("#ses-wpscd-product-sales-end-date").show();
							jQuery("#ses-wpscd-product-sales-custom-submit").show();
						} else {
							jQuery("#ses-wpscd-product-sales-start-date").val("");
							jQuery("#ses-wpscd-product-sales-end-date").val("");
							jQuery("#ses-wpscd-product-sales-start-date").hide();
							jQuery("#ses-wpscd-product-sales-end-date").hide();
							jQuery("#ses-wpscd-product-sales-custom-submit").hide();
							jQuery.ajax( { url: "admin-ajax.php?action=ses_wpscd_ps_ajax&period="+jQuery(this).val(),
											success: function(data) { jQuery("#ses-wpscd-product-sales").html(data); }
									}
								)
						}
					}
				);
				jQuery('#ses-wpscd-product-sales-custom-submit').click(function() {
						var startDate = jQuery("#ses-wpscd-product-sales-start-date-internal").val();
						var endDate = jQuery("#ses-wpscd-product-sales-end-date-internal").val();
						jQuery.ajax( { url: "admin-ajax.php?action=ses_wpscd_ps_ajax&period=custom&start="+startDate+"&end="+endDate,
										success: function(data) { jQuery("#ses-wpscd-product-sales").html(data); }
							}
						)
				});
				jQuery("#ses-wpscd-product-sales-start-date").hide();
				jQuery("#ses-wpscd-product-sales-end-date").hide();
				jQuery("#ses-wpscd-product-sales-custom-submit").hide();
				jQuery("#ses-wpscd-product-sales-start-date").datepicker({ altField : "#ses-wpscd-product-sales-start-date-internal",
																		   altFormat : 'yymmdd',
																	       dateFormat: 'dd-M-yy'});
				jQuery("#ses-wpscd-product-sales-end-date").datepicker({ altField : "#ses-wpscd-product-sales-end-date-internal",
                                                                         altFormat : 'yymmdd',
												                         dateFormat: 'dd-M-yy'});
				}
			);
		</script>
	</div>
	<?php
	}
