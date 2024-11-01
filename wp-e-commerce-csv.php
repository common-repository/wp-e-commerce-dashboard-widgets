<?php

/*
 This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, version 2.

 This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
*/

function parse_state ($country_state_array) {

	$data = unserialize ( $country_state_array['value'] ) ;

	if ( ! count ( $data ) )
	return $country_state_array['value'];

	$state = $data[1];

	if ( is_numeric($state) ) {

		return wpsc_get_region ($state);

	} else {

		return $state;

	}

}

$ses_wpscd_csv_fields_available = Array (
	'order-id' => Array (	'Title'=>'Order ID',
				'ShowOn' => 'Both',
				'QueryID'=>'$purchase["id"]'),
	'order-date' => Array (	'Title'=>'Order Date',
				'ShowOn' => 'Both',
				'QueryID'=>'$purchase["frmtdate"]'),
	'order-time' => Array (	'Title'=>'Order Time',
				'ShowOn' => 'Both',
				'QueryID'=>'$purchase["frmttime"]'),
	'tax-total' => Array (	'Title'=>'Total Order Tax',
				'ShowOn' => 'Orders',
				'QueryID'=>'$cart_data["tax"]'),
	'order-total' => Array ('Title'=>'Total Order Value',
				'ShowOn' => 'Orders',
				'QueryID'=>'$purchase["totalprice"]'),
	'discount-code' => Array ('Title'=>'Discount Code',
				'ShowOn' => 'Both',
				'QueryID'=>'$purchase["discount_data"]'),
	'discount-amt' => Array ('Title'=>'Discount Amount',
				'ShowOn' => 'Both',
				'QueryID'=>'$purchase["discount_value"]'),
	'order-status' => Array ('Title'=>'Order Status',
				'ShowOn' => 'Both',
				'QueryID'=>'$purchase["name"]'),
	'totalqty' => Array (	'Title'=>'Total Items',
				'ShowOn' => 'Orders',
				'QueryID'=>'$cart_data["qty"]'),
	'first-name' => Array (	'Title'=>'First Name',
				'ShowOn' => 'Both',
				'QueryID'=>'$assoc_checkout["billingfirstname"]["value"]'),
	'surname' => Array (	'Title'=>'Surname',
				'ShowOn' => 'Both',
				'QueryID'=>'$assoc_checkout["billinglastname"]["value"]'),
	'user-id' => Array (	'Title'=>'User ID',
				'ShowOn' => 'Both',
				'QueryID'=>'$purchase["user_ID"]'),
	'billing-address' => Array ('Title'=>'Address',
				'ShowOn' => 'Both',
				'QueryID'=>'$assoc_checkout["billingaddress"]["value"]'),
	'billing-city' => Array ('Title'=>'City',
				'ShowOn' => 'Both',
				'QueryID'=>'$assoc_checkout["billingcity"]["value"]'),
	'billing-country' => Array ('Title'=>'Country',
				'ShowOn' => 'Both',
				'QueryID'=>'$assoc_checkout["billingcountry"]["value"]'),
	'billing-pcode' => Array ('Title'=>'Postcode',
				'ShowOn' => 'Both',
				'QueryID'=>'$assoc_checkout["billingpostcode"]["value"]'),
	'billing-email' => Array ('Title'=>'Email',
				'ShowOn' => 'Both',
				'QueryID'=>'$assoc_checkout["billingemail"]["value"]'),
	'billing-phone' => Array ('Title'=>'Phone',
				'ShowOn' => 'Both',
				'QueryID'=>'$assoc_checkout["billingphone"]["value"]'),
	'shipping-name' => Array (	'Title'=>'Shipping First Name',
				'ShowOn' => 'Both',
				'QueryID'=>'$assoc_checkout["shippingfirstname"]["value"]'),
	'shipping-surname' => Array (	'Title'=>'Shipping Surname',
				'ShowOn' => 'Both',
				'QueryID'=>'$assoc_checkout["shippinglastname"]["value"]'),
	'shipping-address' => Array ('Title'=>'Shipping Address',
				'ShowOn' => 'Both',
				'QueryID'=>'$assoc_checkout["shippingaddress"]["value"]'),
	'shipping-city' => Array ('Title'=>'Shipping City',
				'ShowOn' => 'Both',
				'QueryID'=>'$assoc_checkout["shippingcity"]["value"]'),
	'shipping-state' => Array ('Title'=>'Shipping State',
				'ShowOn' => 'Both',
				'QueryID'=>'parse_state($assoc_checkout["shippingcountry"])'),
	'shipping-country' => Array ('Title'=>'Shipping Country',
				'ShowOn' => 'Both',
				'QueryID'=>'$assoc_checkout["shippingcountry"]["value"]'),
	'shipping-pcode' => Array ('Title'=>'Shipping Postcode',
				'ShowOn' => 'Both',
				'QueryID'=>'$assoc_checkout["shippingpostcode"]["value"]'),
	'shipping-module' => Array ('Title'=>'Shipping Module',
				'ShowOn' => 'Both',
				'QueryID'=>'$purchase["shipping_method"]'),
	'shipping-quote' => Array ('Title'=>'Chosen Shipping Rate',
				'ShowOn' => 'Both',
				'QueryID'=>'$purchase["shipping_option"]'),
	'shipping-quote-amt' => Array ('Title'=>'Shipping Rate Amount',
				'ShowOn' => 'Orders',
				'QueryID'=>'$purchase["base_shipping"]'),
	'per-line-shipping' => Array ('Title'=>'Per Item Shipping',
				'ShowOn' => 'Both',
				'QueryID'=>'$cart_data["pnp"]'),
	'orderline-sku' => Array ('Title'=>'Product SKU',
				'ShowOn' => 'Lines',
				'QueryID'=>'$cart_data["sku"]'),
	'orderline-product' => Array ('Title'=>'Product Description',
				'ShowOn' => 'Lines',
				'QueryID'=>'$cart_data["name"]'),
	'orderline-unitprice' => Array('Title'=>'Unit Price',
                                'ShowOn' => 'Lines',
                                'QueryID'=>'$cart_data["price"]'),
	'orderline-qty' => Array ('Title'=>'Item Qty',
				'ShowOn' => 'Lines',
				'QueryID'=>'$cart_data["quantity"]'),
	'orderline-lineprice' => Array ('Title'=>'Item Qty',
				'ShowOn' => 'Lines',
				'QueryID'=>'$cart_data["line_price"]'),
	'orderline-tax' => Array ('Title'=>'Total Line Tax',
				'ShowOn' => 'Lines',
				'QueryID'=>'$cart_data["line_tax"]'),
	'orderline-linetotal' => Array ('Title'=>'Total Line Value',
				'ShowOn' => 'Lines',
				'QueryID'=>'$cart_data["line_total"]'),
	);

function csvescape($string) {

	if (stristr($string,'"')) {
		$string = str_replace('"','""',$string);
		$string = "\"$string\"";
		$doneescape = true;
	}
	$string = str_replace("\n",' ',$string);
	$string = str_replace("\r",' ',$string);
	if (stristr($string,',') && !$doneescape) {
		$string = "\"$string\"";
	}
	return $string;
}

function ses_wpscd_menu() {
	add_submenu_page('wpsc-sales-logs', 'CSV Export', 'CSV Export', 10, basename(__FILE__), 'ses_wpscd_csv_export');
}
add_action('wpsc_add_submenu', "ses_wpscd_menu");

function ses_wpscd_csv_export() {

	if ($_GET['action'] == 'config') {
		ses_wpscd_csv_export_config();
	} else {
		ses_wpscd_csv_export_form();
	}
}

function ses_wpscd_csv_download() {

	global $wpdb, $ses_wpscd_csv_fields_available;

	// Add custom checkout variables
	$ses_wpscd_csv_fields_available = apply_filters('ses-wpscd-csv-fields-available', $ses_wpscd_csv_fields_available);

	$ses_wpscd_csv_fields = get_option('ses_wpscd_csv_fields');
	if (!$ses_wpscd_csv_fields || $ses_wpscd_csv_fields == "" || !count($ses_wpscd_csv_fields)) {
		update_option ('ses_wpscd_csv_fields',Array ('order-id','order-date', 'order-time', 'tax-total', 'order-total', 'order-status', 'totalqty', 'orderline-sku', 'orderline-unitprice', 'orderline-qty', 'orderline-lineprice', 'orderline-tax', 'orderline-linetotal'));
		$ses_wpscd_csv_fields = get_option('ses_wpscd_csv_fields');
	}

	if ($_POST['linesororders'] == 'orders') {
		$filename="Purchase Orders - ";
	} else {
		$filename="Purchase Order Lines - ";
	}

	// First step is to build the query

	if (is_numeric($_POST['date'])) {
		$start_date = $_POST['date'];
		$month = date('n',$start_date);
		$year = date('Y',$start_date);
		if ($month > 11) {
			$month=1;
			$year++;
		} else {
			$month++;
		}
		$end_date = mktime (0,0,0,$month,1,$year) - 1;
		$date_filter = "date >= $start_date AND date <= $end_date";
		$filename .= " ".date('Y-m-d',$start_date)." to ".date('Y-m-d',$end_date);
	} elseif ( $_POST['date'] == 'Today' ) {
		$start_date = mktime(0,0,0,date('n'),date('j'),date('Y'));
		$end_date = mktime(23,59,59,date('n'),date('j'),date('Y'));
		$date_filter = "date >= $start_date AND date <= $end_date";
		$filename .= " ".date('Y-m-d', $start_date);
	} elseif ( substr ( $_POST['date'], 0, 6 ) == 'Since:' ) {
		$date_filter = "date >= ".substr ( $_POST['date'], 6, 999 );
		$filename .= " ".date('Y-m-d H:i:s', substr ( $_POST['date'], 6, 999 ) ) . " - " . date('Y-m-d H:i:s');
	} else {
		$date_filter = "1";
		$filename .= " All Time";
	}

	if (isset($_POST['status'])) {
		$cnt = 0;
		$status_filter = '`pl`.`processed` IN (';
		foreach(array_keys($_POST['status']) as $status_id) {
			if ($cnt) {
				$status_filter .= ',';
			}
			$status_filter .= $status_id;
			$cnt++;
		}
		$status_filter .= ')';
	} else {
		$status_filter = "0";
	}

	$sql = "SELECT `pl`.*,
	                DATE_FORMAT(FROM_UNIXTIME(`pl`.`date`),'%Y-%m-%d') as frmtdate,
	                DATE_FORMAT(FROM_UNIXTIME(`pl`.`date`),'%H:%i:%s') as frmttime,
	               `ps`.`name`
	          FROM `".WPSC_TABLE_PURCHASE_LOGS."` pl
	     LEFT JOIN `".WPSC_TABLE_PURCHASE_STATUSES."` ps
	            ON `pl`.`processed` = `ps`.`id`
	           AND `ps`.`active` = '1'
	         WHERE $date_filter
	           AND $status_filter
	      ORDER BY id DESC";

	setcookie('ses_wpscd_csv_download_time', time(), time()+60*60*24*365);
	$results = $wpdb->get_results($sql, ARRAY_A);

	// See what fields we need to output
	$ses_wpscd_csv_fields = get_option('ses_wpscd_csv_fields');
	if (!$ses_wpscd_csv_fields || $ses_wpscd_csv_fields == "" || !count($ses_wpscd_csv_fields)) {
		update_option ('ses_wpscd_csv_fields',Array ('order-id','order-date', 'order-time', 'tax-total', 'order-total', 'order-status', 'totalqty', 'orderline-sku', 'orderline-unitprice', 'orderline-qty', 'orderline-lineprice', 'orderline-tax', 'orderline-linetotal'));
		$ses_wpscd_csv_fields = get_option('ses_wpscd_csv_fields');
	}

	// Step through the results, and output the fields we need
	//header('Content-Type: text/plain');
	header('Content-Type: text/csv');
	header('Content-Disposition: attachment; filename="'.$filename.'.csv"');

	// Show heading line
	$done_first = 0;
	foreach ($ses_wpscd_csv_fields as $field) {

		if (    ($ses_wpscd_csv_fields_available[$field]['ShowOn'] == 'Both')
		     || ($_POST['linesororders'] == 'orders' &&
		         $ses_wpscd_csv_fields_available[$field]['ShowOn'] == 'Orders') 
                     || ($_POST['linesororders'] == 'lines' &&
		         $ses_wpscd_csv_fields_available[$field]['ShowOn'] == 'Lines'))
		{
			if ($done_first)
				echo ',';

			echo $ses_wpscd_csv_fields_available[$field]['Title'];
			$done_first=1;
		}

	}
	echo "\n";

	if (!count($results)) {
		die();
	}
	foreach ($results as $purchase) {

		$sql = "SELECT `fd`.`value`,
		               `cf`.`name`,
		               `cf`.`unique_name`
		          FROM `".WPSC_TABLE_SUBMITED_FORM_DATA."` fd
		     LEFT JOIN `".WPSC_TABLE_CHECKOUT_FORMS."` cf
		            ON `fd`.`form_id` = `cf`.`id`
		         WHERE `log_id` = '".$purchase['id']."'
		           AND `cf`.active = '1'";

		$checkout_data = $wpdb->get_results($sql, ARRAY_A);

		$assoc_checkout = Array();
		if (is_array($checkout_data) && count($checkout_data)) {
			foreach ($checkout_data as $checkout_field) {
				if ($checkout_field['unique_name'] != "") {
					$assoc_checkout[$checkout_field['unique_name']] = $checkout_field;
				} else {
					$assoc_checkout[$checkout_field['name']] = $checkout_field;
				}
			}
		}

		if ($_POST['linesororders'] == 'orders') {
			$cartsql = "SELECT SUM(quantity) AS qty,
			                   SUM(quantity*tax_charged) AS tax,
							   SUM(pnp) AS pnp
			              FROM `".WPSC_TABLE_CART_CONTENTS."`
			             WHERE `purchaseid`=".$purchase['id']."";
			$cart_data_lines = $wpdb->get_results($cartsql, ARRAY_A);

		} else {
			if (isset($_POST['product']) && is_numeric($_POST['product'])) {
					$product_where = '`cc`.prodid = '.$_POST['product'];
			} else {
					$product_where = '1';
			}

			$cartsql = "SELECT cc.*,
			                   pm.meta_value as sku,
			                   quantity*price as line_price,
			                   quantity*tax_charged as line_tax,
			                   (quantity*price) + (quantity*tax_charged) as line_total
			              FROM `".WPSC_TABLE_CART_CONTENTS."` cc
			         LEFT JOIN `".WPSC_TABLE_PRODUCTMETA."` pm
			                ON `cc`.`prodid` = `pm`.`product_id`
			               AND `pm`.`meta_key` = 'sku'
			             WHERE `cc`.`purchaseid`=".$purchase['id']."
			               AND $product_where";

			$cart_data_lines = $wpdb->get_results($cartsql, ARRAY_A);

		}

		if (count($cart_data_lines)) {
			foreach ($cart_data_lines as $cart_data) {
				reset($ses_wpscd_csv_fields);
				$done_first = 0;
				foreach ($ses_wpscd_csv_fields as $field) {
		
					if (    ($ses_wpscd_csv_fields_available[$field]['ShowOn'] == 'Both')
		     				|| ($_POST['linesororders'] == 'orders' &&
		         	    		$ses_wpscd_csv_fields_available[$field]['ShowOn'] == 'Orders') 
                     				|| ($_POST['linesororders'] == 'lines' &&
		         	    		$ses_wpscd_csv_fields_available[$field]['ShowOn'] == 'Lines'))
					{
						if ($done_first) 
							echo ',';
			
						eval ('$item'." = ".$ses_wpscd_csv_fields_available[$field]['QueryID'].";");
						$item = maybe_unserialize($item);
						if (is_array($item)) {
							echo csvescape($item[0]);
						} else {
							echo csvescape($item);
						}
						$done_first = 1;
			
					}
	
				}
		
				echo "\n";
			}

		}

	}
	die();
}

add_action('wp_ajax_ses_wpscd_csvdownload','ses_wpscd_csv_download');

function ses_wpsc_csv_date_filter($selected) {

	global $wpdb;

	$output = '';

	$earliest_record_sql = "SELECT MIN(`date`) AS `date` FROM `".WPSC_TABLE_PURCHASE_LOGS."` WHERE `date`!=''";
	$earliest_record = $wpdb->get_results($earliest_record_sql,ARRAY_A) ;
	
	$current_timestamp = time();
	$earliest_timestamp = $earliest_record[0]['date'];
	
	$current_year = date("Y");
	$current_month = date("n");
	$earliest_year = date("Y",$earliest_timestamp);
	$earliest_month = date("n",$earliest_timestamp);

	for($year = $earliest_year; $year <= $current_year; $year++) {
		for($month = 1; $month <=12 ; $month++) {
			if ($year == $earliest_year && $month < $earliest_month)
				continue;
			if ($year == $current_year && $month > $current_month)
				break;
			$timestamp = mktime(0, 0, 0, $month, 1, $year);
			$option = "<option value=\"$timestamp\"";
			if ($timestamp == $selected)
				$option .= " selected=\"on\"";
			$option .= ">".date('F Y', $timestamp)."</option>";
			$output = $option . $output;
		}
	}

	if ( ! empty ( $_COOKIE['ses_wpscd_csv_download_time'] ) ) {
		$output = "<option value=\"Since:".$_COOKIE['ses_wpscd_csv_download_time']."\">Since last download (".date('d-M-Y H:i:s',$_COOKIE['ses_wpscd_csv_download_time']).")</option>" . $output;
	}

	
	return $output;

}

function ses_wpscd_order_status_filter() {

	global $wpdb;

	$sql = "SELECT name,id FROM ".WPSC_TABLE_PURCHASE_STATUSES;

	$results = $wpdb->get_results($sql, ARRAY_A);

	if (!$results) {
		return;
	}

	foreach($results as $status) {
		echo '<input type="checkbox" checked name="status[';
		echo $status['id'];
		echo ']"> ';
		echo htmlentities($status['name']);
		echo '<br/>';
	}

}

function ses_wpscd_product_filter() {

	global $wpdb;

	$sql = "SELECT id, name FROM ".WPSC_TABLE_PRODUCT_LIST;

	$results = $wpdb->get_results($sql, ARRAY_A);

	if (!$results) {
		return;
	}

	echo '<select name="product">';
	echo '  <option value="all">All Products</option>';
	foreach ($results as $product) {
		echo '<option value="'.$product['id'].'">'.htmlentities($product['name']).'</option>';
	}
	echo '</select>';
	echo '<br />';
}

function ses_wpscd_csv_export_form() {
?>
	<div class="wrap">
	<h2><?php _e("CSV Export"); ?></h2>
	<form method='post' action='admin-ajax.php?action=ses_wpscd_csvdownload'>
		<input type="hidden" name="action" value="download">
  	  	<div class='wpsc_purchaselogs_options'>
  			<?php /* View functions for purchlogs */?>
  			<label for='date'><?php _e('Date Range:'); ?></label><br/>
  			<select id='date' name='date'>
				<option value="All">All</option>
				<option value="Today">Today</option>
  				<?php echo ses_wpsc_csv_date_filter($_POST['view_purchlogs_by']); ?>
  			</select><br/>
  			<label for='linesororders'><?php _e('Download:'); ?></label><br/>
  			<select id='linesororders' name='linesororders'>
				<option value="orders">Orders</option>
				<option value="lines">Order Lines</option>
  			</select>
			<br />
  			<div id='ses-wpscd-product-filter'>
			<label for='product'><?php _e('Products:'); ?></label>
			<br />
			<?php ses_wpscd_product_filter(); ?>
			<br/></div>
  			<label for='statuses'><?php _e('Order Statuses:'); ?></label>
			<br />
			<?php ses_wpscd_order_status_filter(); ?><br />
			<a href="admin.php?page=wp-e-commerce-csv.php&action=config">Configure Fields</a><br/>
  			<input type="submit" value="Go" name="Submit" class="button-secondary action" />
			</form>
		</div>

	<script type="text/javascript">
		jQuery(document).ready(function(){
			if (jQuery('#linesororders').val() == 'orders') {
     				jQuery('#ses-wpscd-product-filter').hide();
			}
  			jQuery('#linesororders').change(function(){
				if (jQuery(this).val() == 'orders') {
     					jQuery('#ses-wpscd-product-filter').slideUp();
				} else {
					jQuery('#ses-wpscd-product-filter').slideDown();
				}
  			});
		});
	</script>

	<?php

	}


function ses_wpscd_csv_export_config() {

	global $ses_wpscd_csv_fields_available;

	// Add custom checkout variables
	$ses_wpscd_csv_fields_available = apply_filters('ses-wpscd-csv-fields-available', $ses_wpscd_csv_fields_available);

	if ( isset($_POST['submit']) ) {
		if (!current_user_can( 'manage_options' ))
			die(__( 'You cannot edit the options.' ));
                check_admin_referer( 'ses-wpscd-updatesettings' );
		
		if ($_POST['ses_wpscd_csv_fields'] != "") {
			update_option('ses_wpscd_csv_fields', array_keys($_POST['ses_wpscd_csv_fields']));
		}

		echo '<div id="message" class="updated"><p>'.__('Settings updated.').'</p></div>';

	}


	$ses_wpscd_csv_fields = get_option('ses_wpscd_csv_fields');
	if (!$ses_wpscd_csv_fields || $ses_wpscd_csv_fields == "" || count($ses_wpscd_csv_fields) < 1) {
		update_option ('ses_wpscd_csv_fields',Array ('order-id','order-date', 'order-time', 'tax-total', 'order-total', 'order-status', 'totalqty', 'orderline-sku', 'orderline-unitprice', 'orderline-qty', 'orderline-lineprice', 'orderline-tax', 'orderline-linetotal'));
		$ses_wpscd_csv_fields = get_option('ses_wpscd_csv_fields');
	}

	?>
	<div class="wrap">
		<h2><?php _e("CSV Export"); ?></h2>
		<form action="" method="post" id="ses-wpscd-csv-settings">
			Choose which fields are included in Purchase Log exports
			<?php
				if (function_exists('wp_nonce_field')) { wp_nonce_field('ses-wpscd-updatesettings');}
				while (list($key,$item) = each($ses_wpscd_csv_fields_available)) {

					$stringname = $item['ShowOn'];
					if ($stringname == "Both")
						$stringname = "Orders";

					$$stringname .= '<input type="checkbox" name="ses_wpscd_csv_fields[';
					$$stringname .= htmlentities($key);
					$$stringname .= ']" value="';
					$$stringname .= $item['Title'].'" ';
					if (is_array($ses_wpscd_csv_fields) && in_array($key,$ses_wpscd_csv_fields))
						$$stringname .= 'checked'; 
					$$stringname .= '>';
					$$stringname .= htmlentities($item['Title']);
					$$stringname .= '<br />';
				}
				echo "<h4>Order Export Fields</h4>";
				echo $Orders;
				echo "<h4>Order Line Export Fields</h4>";
				echo $Lines;
			?>
				</tr>

			<br/>
			<span class="submit" style="border: 0;"><input type="submit" name="submit" value="<?php _e("Save Settings"); ?>" /></span>
		</form>
	</div>
<?php

}

function ses_wpscd_merge_custom_checkout_fields ($ses_wpscd_csv_fields_available) {

	global $wpdb, $table_prefix;

	$sql = "SHOW COLUMNS FROM {$table_prefix}wpsc_checkout_forms LIKE 'checkout_set'";

	$checkout_set_exists = $wpdb->get_results($sql,ARRAY_A);

	if ($checkout_set_exists) {
		$checkout_set_orderby = "ORDER BY checkout_set";
	} else {
		$checkout_set_orderby = "";
	}

	$sql = "SELECT name 
	          FROM {$table_prefix}wpsc_checkout_forms
	         WHERE unique_name = ''
	           AND type != 'heading'
			       $checkout_set_orderby";

	$fields = $wpdb->get_results($sql, ARRAY_A);

	if (!count($fields)) {
		return $ses_wpscd_csv_fields_available;
	}

	foreach ($fields as $field) {
		
		$newfield = Array ('Title'  => $field['name'],
		                   'ShowOn' => 'Both',
		                   'QueryID'=> '$assoc_checkout["'.$field['name'].'"]["value"]');

		$ses_wpscd_csv_fields_available[$field['name']] = $newfield;
	}
	
	return $ses_wpscd_csv_fields_available;
}
add_filter('ses-wpscd-csv-fields-available', ses_wpscd_merge_custom_checkout_fields);

?>
