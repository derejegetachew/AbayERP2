<?php $output = '
		<style>
   table {border-collapse:collapse; table-layout:fixed;width:100%;}
   table th, td{width:100px; word-wrap:break-word;}
   </style>
		
	<h1 align="center"><img src="http://10.1.85.11/AbayERP/app/webroot/img/logo.png" /></h1>			
	<h4>&nbsp;</h4>
	<h3 align="center">Risk Incident Report</h3>	
	
	<p align="left"> Date Range:<b>'. $this->data['OrmsLossData']['from'].' </b>to <b>'.$this->data['OrmsLossData']['to'].'</b></p>	
	<h4 align="center">' .$this->data['OrmsLossData']['title'].'</h4>

	
	
	<table width="100%" border="1">
    <tr bgcolor="#ccccdd">
        <th>Branch</th>
		<th>Risk Occurrence date</th>
		<th>Loss Category</th>
		<th>Loss SubCategory</th>
		<th>Risk</th>
		<th>Description</th>
		<th>Risk Score(severity * frequency)</th>
		<th>Risk Factor</th>
		<th>Estimated Loss</th>
		<th>Insured Amount</th>
		<th>Corrective Action</th>
		<th>Action Date</th>
		<th>Reported Date</th>
	</tr>';
	for($i=0;$i<count($result);$i++)
		{	
			if($result[$i][0] != ''){
				$output.='<tr><td rowspan ='.$brancharray[$result[$i][0]].'>'.$result[$i][0].'</td>';
			}
			$output.='<td>'.$result[$i][1].'</td>
			<td>'.$result[$i][2].'</td>
			<td>'.$result[$i][3].'</td>
			<td>'.$result[$i][4].'</td>
			<td>'.$result[$i][5].'</td>
			<td>'.$result[$i][6].'</td>
			<td>'.$result[$i][7].'</td>
			<td>'.$result[$i][8].'</td>
			<td>'.$result[$i][9].'</td>
			<td>'.$result[$i][10].'</td>
			<td>'.$result[$i][11].'</td>
			<td>'.$result[$i][12].'</td></tr>';		
		}
    $output.='  
</table>
<br/><br/>';

if ($this->data['OrmsLossData']['type'] == 'HTML') {
	header('Content-Type: text/html; charset=utf-8');
	echo $output;
}
 if ($this->data['OrmsLossData']['type'] == 'EXCEL') {
	$file = $this->data['OrmsLossData']['title'] . ".xls";
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$file");
	echo $output;
 }
 if ($this->data['OrmsLossData']['type'] == 'PDF') { 
	$file = $this->data['OrmsLossData']['title'].".pdf";
	header("Content-Type:application/pdf");
	header("Content-Transfer-Encoding: Binary");
	header("Content-Disposition:inline;filename=$file");
	require_once(APPLIBS . DS . 'html2pdf' . DS . 'html2pdf.class.php');
	$h2p = new HTML2PDF('L', 'A4', 'en');	
	$h2p->writeHTML($output); 	
	$h2p->Output($file);  
	readfile($h2p);	
 }			
