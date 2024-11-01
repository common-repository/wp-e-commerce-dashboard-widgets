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

	$ses_wpscd_query = "SELECT find_us,
	                           COUNT(find_us) AS find_us_count
	                      FROM {$table_prefix}wpsc_purchase_logs
	                     WHERE find_us != ''
	                       AND date > unix_timestamp(STR_TO_DATE('%s','%%Y-%%m-%%d'))
	                  GROUP BY find_us";

 	$ses_wpscd_result_rows = $wpdb->get_results($wpdb->prepare($ses_wpscd_query, $ses_wpscd_from),ARRAY_A);

	if (!$ses_wpscd_result_rows) {
		readfile(dirname(__FILE__)."/error.jpg");
		die();
	}

 	// Dataset definition      
 	$ses_wpscd_dataset = new pData;     

	foreach($ses_wpscd_result_rows as $row) {
		$ses_wpscd_dataset->AddPoint($row['find_us_count'], "Serie1");
		$ses_wpscd_dataset->AddPoint($row['find_us'], "Serie2");
	}

	$ses_wpscd_dataset->AddAllSeries();
	$ses_wpscd_dataset->SetAbsciseLabelSerie("Serie2");

	$ses_wpscd_font = dirname(__FILE__)."/Fonts/tahoma.ttf";

 	$ses_wpscd_graph = new pChart($ses_wpscd_x,$ses_wpscd_y);     
 	$ses_wpscd_graph->setFontProperties($ses_wpscd_font,7);
 	$ses_wpscd_graph->setGraphArea(45,10,$ses_wpscd_x-5,$ses_wpscd_y-55);     
 	$ses_wpscd_graph->drawGraphArea(255,255,255,TRUE);  
	
	$ses_wpscd_graph->setColorPalette(0,82,124,148);  

	$ses_wpscd_graph->drawBasicPieGraph($ses_wpscd_dataset->GetData(),$ses_wpscd_dataset->GetDataDescription(),120,100,70,PIE_PERCENTAGE,255,255,218);  
	$ses_wpscd_graph->drawPieLegend(230,15,$ses_wpscd_dataset->GetData(),$ses_wpscd_dataset->GetDataDescription(),250,250,250); 
   	
 	$ses_wpscd_graph->setFontProperties($ses_wpscd_font,10);

 	$ses_wpscd_graph->Stroke();

?>
