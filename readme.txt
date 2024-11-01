=== Plugin Name ===
Contributors: leewillis77
Donate link: http://www.leewillis.co.uk/wordpress-plugins/?utm_source=wordpress&utm_medium=www&utm_campaign=wp-e-commerce-dashboard-widgets
Tags: e-commerce, reporting, dashboard
Requires at least: 2.9
Tested up to: 3.1
Stable tag: 1.5.1

== Description ==

A selection of admin dashboard widgets showing key information about your WP e-Commerce store, including sales graphs, revenue graphs and other useful information. Makes available the following widgets in the WP dashboard:
* Recent Orders
* Orders to ship
* Recent product ratings
* Sales graph
* Revenue Graph

Also features a fully customisable CSV download for orders, and order lines.

NOTE: THIS IS NOT COMPATIBLE WITH WP E-COMMERCE 3.8 - FOR MORE INFORMATION [SEE HERE](http://www.leewillis.co.uk/wordpress-plugins/#wpecd)

	WP e-Commerce Dashboard
== Installation ==

*You Must* already have the following plugins installed:

1. [WP e-Commerce](http://wordpress.org/extend/plugins/wp-e-commerce/) (Up to version 3.7)
2. Upload the plugin to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Head to your dashboard, and turn off any widgets not required
5. Drag n' drop widgets where you want them

== Frequently Asked Questions ==

= Can I remove the {XXXXXX} report from my dashboard? =

Yes. Just click on "Screen Options" on your dashboard, and unselect the report.

= The E-commerce Product Sales module only displays 5 item - where are the rest? =

Most of the modules only show 5 results by default to avoid clogging up the dashboard. If you want to change it there's a WordPress filter that allows you to change it to whatever you want. So, just add something like this to your WordPress theme's functions.php file:

<code>function my-adjustment-to-product-sales($current_limit) {
	    return 999;
}
add_filter('ses_wpscd_product_sales_limit','my-adjustment-to-product-sales');</code>

There are similar filters for other modules, e.g.

"Orders to ship": ses_wpscd_orders_to_ship_limit
"Recent Orders": ses_wpscd_recent_orders_limit
"Recent Product Rating": ses_wpscd_recent_product_ratings_limit

= What version of WP e-Commerce does this work with? =

This plugin is compatible with WP e-Commerce 3.6.x or 3.7.x. It isn't yet compatible with WP e-Commerce 3.8.x

== Screenshots ==

1. Example of sales graph
2. Example of revenue graph
3. Recent orders list
4. Orders paid for, but not shipped

== Changelog ==

= 1.5.1 = 
Improved state handling with 3.7

= 1.5.0 =
Rename "Orders to ship" to "Items to ship" to more accurately reflect the information shown
Add "Today" as a CSV download option
Add "Since last download" as a CSV download option

= 1.4.7 = 
Fix for tax total on order export - (Thanks to Drew Neilson)

= 1.4.6 =
Added Shipping Rate Amount and Per Item Shipping to the export

= 1.4.5 = 
Added discount code, and discount amount to the export

= 1.4.4 =
= 1.4.3 = 
Allow shipping state to be exported in the CSV
Allow shipping method, and chosen rate to be exported in the CSV

= 1.4.2 = 
Fix for pending orders where PayPal Pro is in use
Allow custom date range in Product Sales widget

= 1.4.1 = 
Exclude pending orders from product sales report - props @jghazally
maybe_unserialize() data before outputting. May fix bogus country data
Better support for custom checkout field sets

= 1.4.0 =
Add additional fields to CSV download options (Billing address, and shipping address)
