<?php
/*
 Plugin Name: WP E-Commerce Dashboard
 Plugin URI: http://www.leewillis.co.uk/wordpress-plugins/?utm_source=wordpress&utm_medium=www&utm_campaign=wp-e-commerce-dashboard-widgets
 Description: Reports on WP E-Commerce stores
 Version: 1.5.1
 Author: Lee Willis
 Author URI: http://www.leewillis.co.uk/?utm_source=wordpress&utm_medium=www&utm_campaign=wp-e-commerce-dashboard-widgets
 */

/*
 This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, version 2.

 This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 */

// If not in admin area just drop straight out
if (is_admin()) {

	include ("pChart/pData.class");     
	include ("pChart/pChart.class");     
	include ("pChart/pCache.class");     

	include ("support-functions.php");     
	include ("wp-e-commerce-widgets.php");

	include ("wp-e-commerce-csv.php");

	function ses_wpscd_add_dashboard_widgets() {
		if (current_user_can('manage_options')) {
			wp_add_dashboard_widget('ses_wpscd_sales_widget', 'E-Commerce Sales', 'ses_wpscd_sales_widget');	
			wp_add_dashboard_widget('ses_wpscd_revenue_widget', 'E-Commerce Revenue', 'ses_wpscd_revenue_widget');
			wp_add_dashboard_widget('ses_wpscd_recent_orders_widget', 'E-Commerce Recent Orders', 'ses_wpscd_recent_orders_widget');
			wp_add_dashboard_widget('ses_wpscd_items_to_ship_widget', 'E-Commerce Items To Ship', 'ses_wpscd_items_to_ship_widget');
			wp_add_dashboard_widget('ses_wpscd_recent_product_ratings', 'E-Commerce Recent Ratings', 'ses_wpscd_recent_product_ratings');
			wp_add_dashboard_widget('ses_wpscd_product_sales', 'E-Commerce Product Sales', 'ses_wpscd_product_sales');
			//wp_add_dashboard_widget('ses_wpscd_find_us_widget', 'E-Commerce - Where did you find us', 'ses_wpscd_find_us_widget');
			wp_enqueue_style('ses-wpscd-styles',WP_PLUGIN_URL.'/wp-e-commerce-dashboard-widgets/ses-wpscd-styles.css');
		}
	} 

	add_action('wp_dashboard_setup', 'ses_wpscd_add_dashboard_widgets' );



	function ses_wpscd_init() {
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-debounce-resize', get_bloginfo('wpurl').'/wp-content/plugins/wp-e-commerce-dashboard-widgets/jquery-debounce-resize.js');
	}

	add_action('init','ses_wpscd_init');



	function ses_wpscd_activation_hook() {

		if ( ! defined ( 'WPSC_VERSION' ) || WPSC_VERSION >= 3.8 ) {
			exit ( __( 'This plugin is not compatible with WP e-Commerce 3.8 or above. Please <a target="_blank" href="http://www.leewillis.co.uk/wordpress-plugins/#wpecd">see here</a>' ) );
		}

	}

	register_activation_hook ( __FILE__, 'ses_wpscd_activation_hook' );

}

?>
