<?php 
$output = '	<style>
table {border-collapse:collapse; table-layout:fixed; width:100%;}
table th { word-wrap:break-word; padding: 5px;}
tr td{text-align: center; padding: 5px;}
</style>
	 
 <h1 align="center"><img src="http://10.1.85.11/AbayERP/app/webroot/img/logo.png" /></h1>			
 <h4>&nbsp;</h4>
 <h2 align="center">Branch Performance report</h2>
 <h4 align="center"></h4>

<table width="100%" border="1">
<tr>
<th></th>
<th></th>
<th></th>
<th></th>
<th></th>
<th></th>
<th></th>
<th></th>
<th></th>
<th></th>
<th></th>
</tr>
<tr>
<th>S.N</th>
<th>Branch</th>
<th>Branch District</th>
<th>Budget year</th>
<th>Q1</th>
<th>Q2</th>
<th>Semi Annual one</th>
<th>Q3</th>
<th>Q4</th>
<th>Semi Annual two</th>
<th>Annual</th>
<th>Q1 plan status</th>
<th>Q1 result status</th>
<th>Q1 comment</th>
<th>Q2 plan status</th>
<th>Q2 result status</th>
<th>Q2 comment</th>
<th>Q3 plan status</th>
<th>Q3 result status</th>
<th>Q3 comment</th>
<th>Q4 plan status</th>
<th>Q4 result status</th>
<th>Q4 comment</th>
</tr>
';

function str_format($val){
if($val == 0){
	return "";
}
else{
	return $val;
}
}

for($i = 0; $i < count($report_table); $i++){
$output.= '<tr>';
$output.='<td>'. ($i+1).'</td>';
$output.='<td>'.$report_table[$i]['branch'].'</td>';
$output.='<td>'.$report_table[$i]['branch_district'].'</td>';
$output.='<td>'.$report_table[$i]['budget_year'].'</td>';
$output.='<td>'.$report_table[$i]['q1'].'</td>';
$output.='<td>'.$report_table[$i]['q2'].'</td>';
$output.='<td>'.$report_table[$i]['semiannual_average1'].'</td>';
$output.='<td>'.$report_table[$i]['q3'].'</td>';
$output.='<td>'.$report_table[$i]['q4'].'</td>';
$output.='<td>'.$report_table[$i]['semiannual_average2'].'</td>';
$output.='<td>'.str_format($report_table[$i]['annual'])  .'</td>';
$output.='<td>'.$report_table[$i]['q1_plan_status'].'</td>';
$output.='<td>'.$report_table[$i]['q1_result_status'].'</td>';
$output.='<td>'.$report_table[$i]['q1_comment'].'</td>';
$output.='<td>'.$report_table[$i]['q2_plan_status'].'</td>';
$output.='<td>'.$report_table[$i]['q2_result_status'].'</td>';
$output.='<td>'.$report_table[$i]['q2_comment'].'</td>';
$output.='<td>'.$report_table[$i]['q3_plan_status'].'</td>';
$output.='<td>'.$report_table[$i]['q3_result_status'].'</td>';
$output.='<td>'.$report_table[$i]['q3_comment'].'</td>';
$output.='<td>'.$report_table[$i]['q4_plan_status'].'</td>';
$output.='<td>'.$report_table[$i]['q4_result_status'].'</td>';
$output.='<td>'.$report_table[$i]['q4_comment'].'</td>';
$output.= '</tr>';
}

$output.= '</table>';

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




