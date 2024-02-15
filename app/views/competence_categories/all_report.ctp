<?php 
$output = '	<style>
table {border-collapse:collapse; table-layout:fixed; width:100%;}
table th { word-wrap:break-word; padding: 5px;}
tr td{text-align: center; padding: 5px;}
</style>
	 
 <h1 align="center"><img src="http://10.1.85.11/AbayERP/app/webroot/img/logo.png" /></h1>			
 <h4>&nbsp;</h4>
 <h2 align="center">Head Office Performance report</h2>
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
<th></th>
<th colspan = "3">Q1 training and Development Plan</th>
<th colspan = "3">Q2 training and Development Plan</th>
<th colspan = "3">Q3 training and Development Plan</th>
<th colspan = "3">Q4 training and Development Plan</th>
<th colspan = "3">Q1 agreement status</th>
<th colspan = "5">Q2 agreement status</th>
<th colspan = "3">Q3 agreement status</th>
<th colspan = "5">Q4 agreement status</th>

</tr>
<tr>
<th>S.N</th>
<th>Employee id</th>
<th>First Name</th>
<th>Middle Name</th>
<th>Last Name</th>
<th>Sex</th>
<th>Date of employment</th>
<th>Status</th>
<th>Last Position</th>
<th>Branch</th>
<th>Branch District</th>
<th>Budget year</th>
<th>Q1</th>
<th>Q2</th>
<th>(Q1+Q2)/2*90%</th>
<th>Behavioural 10%</th>
<th>Semi Annual one</th>
<th>Q3</th>
<th>Q4</th>
<th>(Q3+Q4)/2*90%</th>
<th>Behavioural 10%</th>
<th>Semi Annual two</th>
<th>Annual</th>
<th>Training1</th>
<th>Training2</th>
<th>Training3</th>
<th>Training1</th>
<th>Training2</th>
<th>Training3</th>
<th>Training1</th>
<th>Training2</th>
<th>Training3</th>
<th>Training1</th>
<th>Training2</th>
<th>Training3</th>
<th>Q1 technical plan status</th>
<th>Q1 technical result status</th>
<th>Q1 technical comment</th>
<th>Q2 technical plan status</th>
<th>Q2 technical result status</th>
<th>Q2 technical comment</th>
<th>Q2 behavioural result status</th>
<th>Q2 behavioural comment</th>
<th>Q3 technical plan status</th>
<th>Q3 technical result status</th>
<th>Q3 technical comment</th>
<th>Q4 technical plan status</th>
<th>Q4 technical result status</th>
<th>Q4 technical comment</th>
<th>Q4 behavioural result status</th>
<th>Q4 behavioural comment</th>
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
$output.='<td>'.$report_table[$i]['employee_id'].'</td>';
$output.='<td>'.$report_table[$i]['first_name'].'</td>';
$output.='<td>'.$report_table[$i]['middle_name'].'</td>';
$output.='<td>'.$report_table[$i]['last_name'].'</td>';
$output.='<td>'.$report_table[$i]['sex'].'</td>';
$output.='<td>'.$report_table[$i]['date_of_employment'].'</td>';
$output.='<td>'.$report_table[$i]['status'].'</td>';
$output.='<td>'.$report_table[$i]['last_position'].'</td>';
$output.='<td>'.$report_table[$i]['branch'].'</td>';
$output.='<td>'.$report_table[$i]['branch_district'].'</td>';
$output.='<td>'.$report_table[$i]['budget_year'].'</td>';
$output.='<td>'.$report_table[$i]['q1'].'</td>';
$output.='<td>'.$report_table[$i]['q2'].'</td>';
$output.='<td>'.$report_table[$i]['semiannual_technical1'].'</td>';
$output.='<td>'.$report_table[$i]['behavioural1'].'</td>';
$output.='<td>'.$report_table[$i]['semiannual_average1'].'</td>';
$output.='<td>'.$report_table[$i]['q3'].'</td>';
$output.='<td>'.$report_table[$i]['q4'].'</td>';
$output.='<td>'.$report_table[$i]['semiannual_technical2'].'</td>';
$output.='<td>'.$report_table[$i]['behavioural2'].'</td>';
$output.='<td>'.$report_table[$i]['semiannual_average2'].'</td>';
$output.='<td>'.str_format($report_table[$i]['annual'])  .'</td>';
$output.='<td>'.$report_table[$i]['q1_training1']  .'</td>';
$output.='<td>'.$report_table[$i]['q1_training2']  .'</td>';
$output.='<td>'.$report_table[$i]['q1_training3']  .'</td>';
$output.='<td>'.$report_table[$i]['q2_training1']  .'</td>';
$output.='<td>'.$report_table[$i]['q2_training2']  .'</td>';
$output.='<td>'.$report_table[$i]['q2_training3']  .'</td>';
$output.='<td>'.$report_table[$i]['q3_training1']  .'</td>';
$output.='<td>'.$report_table[$i]['q3_training2']  .'</td>';
$output.='<td>'.$report_table[$i]['q3_training3']  .'</td>';
$output.='<td>'.$report_table[$i]['q4_training1']  .'</td>';
$output.='<td>'.$report_table[$i]['q4_training2']  .'</td>';
$output.='<td>'.$report_table[$i]['q4_training3']  .'</td>';
$output.='<td>'.$report_table[$i]['q1_technical_agreement_plan']  .'</td>';
$output.='<td>'.$report_table[$i]['q1_technical_agreement_result']  .'</td>';
$output.='<td>'.$report_table[$i]['q1_technical_comment']  .'</td>';
$output.='<td>'.$report_table[$i]['q2_technical_agreement_plan']  .'</td>';
$output.='<td>'.$report_table[$i]['q2_technical_agreement_result']  .'</td>';
$output.='<td>'.$report_table[$i]['q2_technical_comment']  .'</td>';
$output.='<td>'.$report_table[$i]['q2_behavioural_agreement_result']  .'</td>';
$output.='<td>'.$report_table[$i]['q2_behavioural_comment']  .'</td>';
$output.='<td>'.$report_table[$i]['q3_technical_agreement_plan']  .'</td>';
$output.='<td>'.$report_table[$i]['q3_technical_agreement_result']  .'</td>';
$output.='<td>'.$report_table[$i]['q3_technical_comment']  .'</td>';
$output.='<td>'.$report_table[$i]['q4_technical_agreement_plan']  .'</td>';
$output.='<td>'.$report_table[$i]['q4_technical_agreement_result']  .'</td>';
$output.='<td>'.$report_table[$i]['q4_technical_comment']  .'</td>';
$output.='<td>'.$report_table[$i]['q4_behavioural_agreement_result']  .'</td>';
$output.='<td>'.$report_table[$i]['q4_behavioural_comment']  .'</td>';
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




