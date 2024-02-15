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
<th>Employee id</th>
<th>Budget year</th>
<th>Q1</th>
<th>Q2</th>
<th>Q3</th>
<th>Q4</th>
<th>Annual Average</th>
</tr>
';

for($i = 0; $i < count($report_table); $i++){
$output.= '<tr>';
$output.='<td>'.$report_table[$i]['employee_id'].'</td>';
$output.='<td>'.$report_table[$i]['budget_year'].'</td>';
$output.='<td>'.$report_table[$i]['quarter1'].'</td>';
$output.='<td>'.$report_table[$i]['quarter2'].'</td>';
$output.='<td>'.$report_table[$i]['quarter3'].'</td>';
$output.='<td>'.$report_table[$i]['quarter4'].'</td>';
$output.='<td>'.$report_table[$i]['annual_average'].'</td>';
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




