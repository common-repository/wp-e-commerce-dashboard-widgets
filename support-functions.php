<?php

/*
 This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, version 2.

 This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 */


	function print_a($subject){
		echo str_replace("=>","&#8658;",str_replace("Array","<font color=\"red\"><b>Array</b></font>",nl2br(str_replace(" "," &nbsp; ",print_r($subject,true)))));
	}

	function ses_wpscd_dateRangeArray($start, $end) {
		$range = array();

		if (is_string($start) === true) $start = strtotime($start);
		if (is_string($end) === true ) $end = strtotime($end);
		
		do {
			$range[date('Y-m-d', $start)] = Array ( "value" => 0,
			                                        "label" => date('d M Y',$start) );
			$start = strtotime("+ 1 day", $start);
		} while($start <= $end);

		return $range;
	}

	function output_order_list ($ses_wpscd_query, $headings = Array('ID','Order Date','Items','Total','Status')) {
	
		global $wpdb, $table_prefix;

 		$ses_wpscd_result_rows = $wpdb->get_results($wpdb->prepare($ses_wpscd_query),ARRAY_A);

		?>
			<table width="100%" class="ses-wpscd-table">
					<tr class="ses-wpscd-headerrow">
					<?php 
						foreach ($headings as $heading) {
							echo "<th>".htmlentities($heading)."</th>";
						}
					?>
					</tr>
		<?php
			if (!count($ses_wpscd_result_rows)) {
				echo "<td class=\"ses-wpscd-cell\" colspan=5>No Results</td>";
			} else {
				foreach ($ses_wpscd_result_rows as $row) {
					echo "<tr class=\"ses-wpscd-row\">";
					while (list($key,$value) = each($row)) {
						if ($key == 'id') {
							echo "<td class=\"ses-wpscd-cell\">";
							echo "<a href=\"admin.php?page=wpsc-sales-logs&purchaselog_id=".htmlentities($value)."\">";
							echo htmlentities($value)."</a></td>";
						} else {
							echo "<td class=\"ses-wpscd-cell\">".htmlentities($value)."</td>";
						}
					}
					echo "</tr>";
				}
			}
			echo "</table>";
		
	}

?>
