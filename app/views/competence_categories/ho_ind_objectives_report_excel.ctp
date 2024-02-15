<?php 
 $output = '	<style>
 table {border-collapse:collapse; table-layout:fixed; width:100%;}
 table th { word-wrap:break-word; padding: 5px;}
 tr td{text-align: center; padding: 5px;}
 </style><h1 align="center"><img src="http://10.1.85.11/AbayERP/app/webroot/img/logo.png" /></h1>			
 <h4>&nbsp;</h4>
 <h2 align="center">Head Office Performance report</h2>
 <h4 align="center"></h4>';

if ($is_branch == 0){
    
    $output.= '<table width="100%" border="1">';
    $output.= '<tr><td style = "border: 1px solid grey" colspan = "1">	EMPLOYEE NAME:</td><td colspan = "7" style = "border: 1px solid grey">'. $full_name.'</td></tr>';
    $output.=  '<tr><td style = "border: 1px solid grey" colspan = "2">	ID NO:</td><td colspan = "8" style = "border: 1px solid grey">'. $emp_id.'</td></tr>';
    $output.= '<tr><td style = "border: 1px solid grey" colspan = "2">	POSITION:</td><td colspan = "8" style = "border: 1px solid grey">'.$position_name. '</td></tr>';
    $output.= '<tr><td style = "border: 1px solid grey" colspan = "2">	DEPARTMENT / DISTRICT:</td><td colspan = "8" style = "border: 1px solid grey">'. $dept_name.'</td></tr>' ;
    $output.= '<tr><td style = "border: 1px solid grey" colspan = "2">	APPRAISAL PERIOD:</td><td colspan = "8" style = "border: 1px solid grey">'.$appraisal_period. '</td></tr>' ;
    $output.= '<tr style = "background: #3498db; color: #fff; height: 40px;"><td style = "border: 1px solid grey; padding: 10px;">Perspective</td><td style = "border: 1px solid grey; padding: 10px;">Goal/Objective</td><td style = "border: 1px solid grey; padding: 10px;">KPIs</td><td style = "border: 1px solid grey; padding: 10px; ">Measure</td><td style = "border: 1px solid grey; padding: 10px;">Weight</td>';
    $output.= '<td style = "border: 1px solid grey; padding: 10px;"> Plan</td><td style = "border: 1px solid grey; padding: 10px;">Actual</td><td style = "border: 1px solid grey; padding: 10px;">% Accomplishment</td><td style = "border: 1px solid grey; padding: 10px;">Total Score</td>';
    $output.= '<td style = "border: 1px solid grey; padding: 10px;">Final Score</td></tr>';
    
    for($i = 0; $i < count($objective_table); $i++){
        
    $output.= '<tr>';
    $output.= '<td style = "border: 1px solid grey">'. $objective_table[$i]['perspective'].'</td>';
    $output.=  '<td style = "border: 1px solid grey">'.  $objective_table[$i]['objective']. '</td><td style = "border: 1px solid grey">'. $objective_table[$i]['kpis']. '</td>';
    $output.=  '<td style = "border: 1px solid grey">'. $objective_table[$i]['measure'].'</td><td style = "border: 1px solid grey">'. $objective_table[$i]['weight'] .'</td>';
    $output.=  '<td style = "border: 1px solid grey">'. $objective_table[$i]['plan'] .'</td><td style = "border: 1px solid grey">'. $objective_table[$i]['actual']. '</td>';
    $output.=  '<td style = "border: 1px solid grey">'. $objective_table[$i]['accomplishment'].'</td><td style = "border: 1px solid grey">'. $objective_table[$i]['total_score']. '</td>';
    $output.=  '<td style = "border: 1px solid grey">'. $objective_table[$i]['final_score'] .'</td>';
    $output.='</tr>';
    
    
        
     } 
    
     $output.= '<tr>';
     $output.=	'<td colspan = "4" style = "border: 1px solid grey">Total Score</td><td style = "border: 1px solid grey">'. $total_weight.'%'.'</td>';
     $output.=  '<td style = "border: 1px solid grey"></td><td style = "border: 1px solid grey"></td>';
     $output.= '<td style = "border: 1px solid grey"></td><td style = "border: 1px solid grey"></td>';
    $output.= '<td style = "border: 1px solid grey">'. $score_summary .'</td>';
    $output.= '</tr>';
    
    $output.= '<tr>';
    $output.=	'<td colspan = "4" style = "border: 1px solid grey">Total Score (100%)</td><td style = "border: 1px solid grey">100%</td>';
    $output.=	'<td style = "border: 1px solid grey"></td><td style = "border: 1px solid grey"></td>';
    $output.=	'<td style = "border: 1px solid grey"></td><td style = "border: 1px solid grey"></td>'; 
    $output.=	'<td style = "border: 1px solid grey">'. $total_weight > 0 ? round((100/$total_weight) * $score_summary , 2) : '' .'</td>';
    $output.=	'</tr>';
    
    $output.= '<tr>';
    $output.= '<td colspan = "4" style = "border: 1px solid grey">Summarized Score</td><td style = "border: 1px solid grey"></td>';
    $output.= '<td style = "border: 1px solid grey"></td><td style = "border: 1px solid grey"></td>';
    $output.= '<td style = "border: 1px solid grey"></td><td style = "border: 1px solid grey"></td>';
    $output.= '<td style = "border: 1px solid grey">'. count($objective_table) > 0 ?  round($objective_table[0]['aggregate_score'] , 2) : '' .'</td>';
    $output.= '</tr>';
    
    $output.= '<tr>';
    $output.=		'<td colspan = "10" style = "border: 1px solid grey; text-align: center;">Training and Development Plan</td>';
    $output.=					'</tr>';
    $output.=					'<tr>';
    $output.=					'<td style = "border: 1px solid grey">1</td><td colspan = "9" style = "border: 1px solid grey">'. $training1.'</td>';
    $output.=					'</tr>';
    $output.=					'<tr>';
    $output.=					'<td style = "border: 1px solid grey">2</td><td colspan = "9" style = "border: 1px solid grey">'. $training2 .'</td>';
    $output.=					'</tr>';
    $output.=					'<tr>';
    $output.=					'<td style = "border: 1px solid grey">3</td><td colspan = "9" style = "border: 1px solid grey">'. $training3 .'</td>';
    $output.=					'</tr>';
    
    $output.= '<tr><td style = "border: 1px solid grey" colspan = "3">IMMEDIATE SUPERVISOR NAME</td><td colspan = "7" style = "border: 1px solid grey">'. $immediate_supervisor_name .'</td></tr>';
    $output.=					'<tr><td style = "border: 1px solid grey" colspan = "2">Plan status</td><td colspan = "8" style = "border: 1px solid grey">'. count($objective_table) > 0 ?  $objective_table[0]['plan_status'] : '' .'</td></tr>';
    $output.=					'<tr><td style = "border: 1px solid grey" colspan = "2">Result status</td><td colspan = "8" style = "border: 1px solid grey">'. count($objective_table) > 0 ?  $objective_table[0]['result_status'] : '' .'</td></tr>';
    $output.=					'<tr><td style = "border: 1px solid grey" colspan = "2">Comment</td><td colspan = "8" style = "border: 1px solid grey">'. count($objective_table) > 0 ?  $objective_table[0]['comment'] : '' . '</td></tr>';
    
    
    $output.= '</table>';

} else {

    $output.= '<table style = "border-collapse:collapse;  width:100%; border: 1px solid grey; margin: 10px; font-size: 12px;">';
	$output.=			'<tr><td style = "border: 1px solid grey" colspan = "1">	EMPLOYEE NAME:</td><td colspan = "8" style = "border: 1px solid grey">'. $full_name. '</td></tr>' ;
	$output.=				  '<tr><td style = "border: 1px solid grey" colspan = "1">	ID NO:</td><td colspan = "8" style = "border: 1px solid grey">'. $emp_id .'</td></tr>';
	$output.=				  '<tr><td style = "border: 1px solid grey" colspan = "1">	POSITION:</td><td colspan = "8" style = "border: 1px solid grey">'. $position_name .'</td></tr>';
	$output.=				  '<tr><td style = "border: 1px solid grey" colspan = "1">	DEPARTMENT / DISTRICT:</td><td colspan = "8" style = "border: 1px solid grey">'. $dept_name .'</td></tr>';
	$output.=				  '<tr><td style = "border: 1px solid grey" colspan = "1">	APPRAISAL PERIOD:</td><td colspan = "8" style = "border: 1px solid grey">'. $appraisal_period .'</td></tr>';
	$output.=				  '<tr style = "background: #3498db; color: #fff; height: 40px;"><td style = "border: 1px solid grey; padding: 10px;">Goal/Objective</td><td style = "border: 1px solid grey; padding: 10px;">Target</td><td style = "border: 1px solid grey; padding: 10px; ">Measure</td>';
	$output.=				  '<td style = "border: 1px solid grey; padding: 10px;"> Weight</td><td style = "border: 1px solid grey; padding: 10px;">Total Value</td><td style = "border: 1px solid grey; padding: 10px;">Rating</td>';

    for($i = 0; $i < count($objective_table); $i++){
        
        $output.= '<tr>';
        $output.= '<td style = "border: 1px solid grey">'. $objective_table[$i]['objective'].' </td><td style = "border: 1px solid grey">'. $objective_table[$i]['target'] .'</td>';
        $output.= '<td style = "border: 1px solid grey">'. $objective_table[$i]['measure']. '</td><td style = "border: 1px solid grey">'. $objective_table[$i]['weight']. '</td>';
        $output.= '<td style = "border: 1px solid grey">'. $objective_table[$i]['total_value'] . '</td><td style = "border: 1px solid grey">'. $objective_table[$i]['rating'] .'</td>';
        $output.= '</tr>';
    
        $output.= '<tr>';
        $output.= '<td colspan = "3" style = "border: 1px solid grey">Total Score</td><td style = "border: 1px solid grey">'.  $total_weight."%" .'</td>';
        $output.= '<td style = "border: 1px solid grey"></td>';
        $output.= '<td style = "border: 1px solid grey">'. $score_summary.'</td>';
        $output.= '</tr>';

        $output.= '<tr>';
		$output.=				'<td colspan = "3" style = "border: 1px solid grey">Total Score(100%)</td><td style = "border: 1px solid grey">100%</td>';
		$output.=				'<td style = "border: 1px solid grey"></td>';
		$output.=				'<td style = "border: 1px solid grey">'. $total_weight > 0 ?  round(($score_summary * 100/$total_weight) , 2) : '' . '</td>';
		$output.=			'</tr>';
		$output.=			'<tr>';
		$output.=				'<td colspan = "3" style = "border: 1px solid grey">Branch Result</td><td style = "border: 1px solid grey">100%</td>';
		$output.=				'<td style = "border: 1px solid grey"></td>';
		$output.=				'<td style = "border: 1px solid grey">'. $branch_result.'</td>';
		$output.=			'</tr>';

        $output.= '<tr>';
		$output.=				'<td colspan = "3" style = "border: 1px solid grey">Aggregate Score</td><td style = "border: 1px solid grey">100%</td>';
		$output.=				'<td style = "border: 1px solid grey"></td>';
		$output.=				'<td style = "border: 1px solid grey">'. $score_summary_aggregate .'</td>';
		$output.=			'</tr>';
		$output.=			'<tr>';
		$output.=				'<td colspan = "9" style = "border: 1px solid grey; text-align: center;">Training and Development Plan</td>';
		$output.=			'</tr>';
		$output.=			'<tr>';
		$output.=				'<td style = "border: 1px solid grey">1</td><td colspan = "5" style = "border: 1px solid grey">'. $training1 .'</td>';
		$output.=			'</tr>';
		$output.=			'<tr>';
		$output.=				'<td style = "border: 1px solid grey">2</td><td colspan = "5" style = "border: 1px solid grey">'. $training2 .'</td>';
		$output.=			'</tr>';

        $output.= '<tr>';
		$output.=				'<td style = "border: 1px solid grey">3</td><td colspan = "5" style = "border: 1px solid grey">'. $training3.'</td>';
		$output.=			'</tr>';
		$output.=			'<tr><td style = "border: 1px solid grey" colspan = "2">IMMEDIATE SUPERVISOR NAME</td><td colspan = "4" style = "border: 1px solid grey">'. $immediate_supervisor_name .'</tr>';
		$output.=			'<tr><td style = "border: 1px solid grey" colspan = "2">Result status</td><td colspan = "4" style = "border: 1px solid grey">'.count($objective_table) > 0 ? $objective_table[0]['result_status'] : '' .'</td></tr>';
		$output.=			'<tr><td style = "border: 1px solid grey" colspan = "2">Comment</td><td colspan = "4" style = "border: 1px solid grey">'. count($objective_table) > 0 ? $objective_table[0]['comment'] : '' .'</td></tr>';
        $output.= '</table>';
     }


}


if ($output_type == 'HTML') {				
	echo $output;
}

if ($output_type == 'EXCEL') {
    $file =  time() . ".xls";
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$file");
	echo $output;
}

if($output_type == 'PDF'){
    $file = time() . ".pdf";
	header("Content-type:application/pdf");
	header("Content-Transfer-Encoding: Binary");
	header("Content-Disposition:inline;filename=$file");
	require_once(APPLIBS . DS . 'html2pdf' . DS . 'html2pdf.class.php');
	$h2p = new HTML2PDF('L', 'A4', 'en');	
	$h2p->writeHTML($output); 	
	$h2p->Output($file);  
	readfile($h2p);	
}




