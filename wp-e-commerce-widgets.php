<?php

/*
 This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, version 2.

 This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 */

/***********************************************************
** Graph of sales volumes
***********************************************************/

function ses_wpscd_sales_graph() {

	global $wpdb, $table_prefix;
	if (current_user_can('manage_options')) {
		include("sales_graph.php");
	}
	die();

}

function ses_wpscd_sales_widget() {

	echo '<div id="ses-wpscd-sales-graph">';
	echo '<img src="admin-ajax.php?action=ses-wpscd-sales-graph" alt="Sales Graph">';
	echo '</div>';
?>
<script type="text/javascript">
	jQuery(window).smartresize(function(){ses_wpscd_resize('#ses-wpscd-sales-graph');});
	jQuery(window).resize(function() {
		jQuery('#ses-wpscd-sales-graph').children("img").attr('width',jQuery('#ses-wpscd-sales-graph').width());
		jQuery('#ses-wpscd-sales-graph').children("img").attr('height',jQuery('#ses-wpscd-sales-graph').height());
	});
	jQuery(document).ready(function(){ses_wpscd_resize('#ses-wpscd-sales-graph');});
</script>
<?php

} 

add_action('wp_ajax_ses-wpscd-sales-graph','ses_wpscd_sales_graph');

/***********************************************************
** Graph of financial purchase volumes
***********************************************************/

function ses_wpscd_revenue_graph() {

	global $wpdb, $table_prefix;
	if (current_user_can('manage_options')) {
		include("revenue_graph.php");
	}
	die();

}

function ses_wpscd_revenue_widget() {

	echo '<div id="ses-wpscd-revenue-graph">';
	echo '<img src="admin-ajax.php?action=ses-wpscd-revenue-graph" alt="Revenue Graph">';
	echo '</div>';
?>
<script type="text/javascript">
	jQuery(window).smartresize(function(){ses_wpscd_resize('#ses-wpscd-revenue-graph');});
	jQuery(window).resize(function() {
		jQuery('#ses-wpscd-revenue-graph').children("img").attr('width',jQuery('#ses-wpscd-revenue-graph').width());
		jQuery('#ses-wpscd-revenue-graph').children("img").attr('height',jQuery('#ses-wpscd-revenue-graph').height());
	});
	jQuery(document).ready(function(){ses_wpscd_resize('#ses-wpscd-revenue-graph');});
</script>
<?php

} 

add_action('wp_ajax_ses-wpscd-revenue-graph','ses_wpscd_revenue_graph');

/***********************************************************
** Graph of how people found the site
***********************************************************/

function ses_wpscd_find_us_pie() {

	global $wpdb, $table_prefix;
	if (current_user_can('manage_options')) {
       		include("find_us_pie.php");
	}
	die();

}

function ses_wpscd_find_us_widget() {

       echo '<div id="ses-wpscd-find-us-pie">';
       echo '<img src="admin-ajax.php?action=ses-wpscd-find-us-pie" alt="How did you find us?">';
       echo '</div>';
?>
<script type="text/javascript">
       jQuery(window).smartresize(function(){ses_wpscd_resize('#ses-wpscd-find-us-pie');});
       jQuery(window).resize(function() {
               jQuery('#ses-wpscd-find-us-pie').children("img").attr('width',jQuery('#ses-wpscd-find-us-pie').width());
               jQuery('#ses-wpscd-find-us-pie').children("img").attr('height',jQuery('#ses-wpscd-find-us-pie').height());
       });
       jQuery(document).ready(function(){ses_wpscd_resize('#ses-wpscd-find-us-pie');});
</script>
<?php

}

add_action('wp_ajax_ses-wpscd-find-us-pie','ses_wpscd_find_us_pie');

/***********************************************************
** List of recent orders
***********************************************************/

function ses_wpscd_recent_orders_widget() {

	global $wpdb, $table_prefix;

	include("recent_orders.php");
}

/***********************************************************
** List of orders to ship
***********************************************************/

function ses_wpscd_items_to_ship_widget() {

	global $wpdb, $table_prefix;

	include("items_to_ship.php");
}

/***********************************************************
** List of recent product ratings
***********************************************************/

function ses_wpscd_recent_product_ratings() {

	global $wpdb, $table_prefix;

	include ("recent_product_ratings.php");

}

/***********************************************************
** List of per-product sales
***********************************************************/

include ("product_sales.php");

function ses_wpscd_product_sales() {

	global $wpdb, $table_prefix;

	ses_wpscd_ps_ajax();
	ses_wpscd_ps_selector();

}
add_action('wp_ajax_ses_wpscd_ps_ajax','ses_wpscd_ps_ajax');

?>
