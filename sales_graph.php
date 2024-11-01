<?php

/*
 This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, version 2.

 This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 */


	if (isset($_GET['x'])) {
		$ses_wpscd_x = $_GET['x'];
	} else {
		$ses_wpscd_x = 350;
	}
	if (isset($_GET['y'])) {
		$ses_wpscd_y = $_GET['y'];
	} else {
		$ses_wpscd_y = 250;
	}

	$ses_wpscd_from = date('Y-m-d',strtotime("- 63 day",time()));
	$ses_wpscd_to = time();

	$ses_wpscd_date_range_completed = ses_wpscd_dateRangeArray($ses_wpscd_from,$ses_wpscd_to);
	$ses_wpscd_date_range_pending = ses_wpscd_dateRangeArray($ses_wpscd_from,$ses_wpscd_to);

	$ses_wpscd_query = "
		   SELECT date_format(from_unixtime(pl.date),'%%Y-%%m-%%d') AS textcdate,
		          DATEDIFF(from_unixtime(pl.date), '%s') AS date_idx,
		          SUM(c.quantity) AS num_items,
	                  IF(pl.processed in (2,3,4), 'Complete','Pending') as status
		     FROM {$table_prefix}wpsc_purchase_logs pl
		LEFT JOIN {$table_prefix}wpsc_cart_contents c
		       ON pl.id = c.purchaseid
		    WHERE pl.date > unix_timestamp(STR_TO_DATE('%s','%%Y-%%m-%%d'))
 		 GROUP BY status, textcdate
 		 ORDER BY textcdate ASC";

 	$ses_wpscd_result_rows = $wpdb->get_results($wpdb->prepare($ses_wpscd_query, $ses_wpscd_from, $ses_wpscd_from),ARRAY_A);

	if (!$ses_wpscd_result_rows) {
		readfile(dirname(__FILE__)."/error.jpg");
		die();
	}

	foreach ($ses_wpscd_result_rows as $ses_wpscd_row) {
		if ($ses_wpscd_row['status'] == 'Complete') {
			$ses_wpscd_date_range_completed[$ses_wpscd_row['textcdate']]['value'] = $ses_wpscd_row['num_items'];
		} else {
			$ses_wpscd_date_range_pending[$ses_wpscd_row['textcdate']]['value'] = $ses_wpscd_row['num_items'];
		}
	}

 	// Dataset definition      
 	$ses_wpscd_dataset = new pData;     
	$ses_wpscd_dataset->SetSerieName("Number of Sales","Serie1");  
	$ses_wpscd_dataset->SetAbsciseLabelSerie("XLabel"); 
	$ses_wpscd_dataset->AddSerie("Serie1");
	//$ses_wpscd_dataset->AddSerie("Serie2");

	if (count($ses_wpscd_date_range_completed)) {
		while (list($ses_wpscd_date,$ses_wpscd_items) = each ($ses_wpscd_date_range_completed)) {
			$ses_wpscd_dataset->AddPoint($ses_wpscd_items['value'],"Serie1");
			$ses_wpscd_dataset->AddPoint($ses_wpscd_items['label'],"XLabel");
		}
	}
	if (count($ses_wpscd_date_range_pending)) {
		while (list($ses_wpscd_date,$ses_wpscd_items) = each ($ses_wpscd_date_range_pending)) {
			$ses_wpscd_dataset->AddPoint($ses_wpscd_items['label'],"Serie2");
		}
	}

	$ses_wpscd_font = dirname(__FILE__)."/Fonts/tahoma.ttf";

 	$ses_wpscd_graph = new pChart($ses_wpscd_x,$ses_wpscd_y);     
 	$ses_wpscd_graph->setFontProperties($ses_wpscd_font,7);
 	$ses_wpscd_graph->setGraphArea(45,10,$ses_wpscd_x-5,$ses_wpscd_y-55);     
 	$ses_wpscd_graph->drawGraphArea(255,255,255,TRUE);  
	
 	$ses_wpscd_graph->drawScale($ses_wpscd_dataset->GetData(),$ses_wpscd_dataset->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,45,1,FALSE,14);
	$ses_wpscd_graph->setColorPalette(0,82,124,148);  

 	$ses_wpscd_graph->setFontProperties($ses_wpscd_font,6);
 	$ses_wpscd_graph->drawTreshold(0,143,55,72,TRUE,TRUE);     
   	
 	$ses_wpscd_graph->drawLineGraph($ses_wpscd_dataset->GetData(),$ses_wpscd_dataset->GetDataDescription());     
   	
 	$ses_wpscd_graph->setFontProperties($ses_wpscd_font,10);

 	$ses_wpscd_graph->Stroke();

?>
