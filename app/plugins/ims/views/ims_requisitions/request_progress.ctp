<?php $output = '
		<style>
   table {border-collapse:collapse; table-layout:fixed;width:100%;}
   table th {width:80px; word-wrap:break-word;}
   </style>
		
	<h1 align="center"><img src="http://10.1.85.11/AbayERP/app/webroot/img/logo.png" /></h1>			
	<h4>&nbsp;</h4>
	<h2 align="center">Requisition Progress by status</h2>	
	<p align="left"> Status:<b>'.$this->data['ImsRequisition']['status'].'</b></p>
	<p align="left"> Date:<b>'. date("F j, Y").' </b></p>	
	<h4 align="center">' .$this->data['ImsRequisition']['title'].'</h4>			
	

	<table width="100%" border="1">
    <tr bgcolor="#ccccdd">
		<th>N<u>o</u></th>
        <th>Requisition</th>
		<th>Branch</th>		
		<th>Created</th>
		<th>'.$this->data['ImsRequisition']['status'].' Date</th>
		<th>N<u>o</u> of date after '.$this->data['ImsRequisition']['status'].'</th>
	</tr>';
	
	for($i=0; $i<count($result); $i++)
		{
				
			$output.='<tr bgcolor="white">';	
			
			$output.='<td align="left">'.$result[$i][0].'</td>
			<td align="left">'.$result[$i][1].'</td>
			<td align="left">'.$result[$i][2].'</td>
			<td align="left">'.$result[$i][3].'</td>
			<td align="left">'.$result[$i][4].'</td>
			<td align="right">'.$result[$i][5].'</td>';
							
		}
    $output.='  
</table>';

if ($this->data['ImsRequisition']['type'] == 'HTML') {				
	echo $output;
}
 if ($this->data['ImsRequisition']['type'] == 'EXCEL') {
	$file = $this->data['ImsRequisition']['title'] . ".xls";
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$file");
	echo $output;
 }
 if ($this->data['ImsRequisition']['type'] == 'PDF') { 
	$file = $this->data['ImsRequisition']['title'].".pdf";
	header("Content-Type:application/pdf");
	header("Content-Transfer-Encoding: Binary");
	header("Content-Disposition:inline;filename=$file");
	require_once(APPLIBS . DS . 'html2pdf' . DS . 'html2pdf.class.php');
	$h2p = new HTML2PDF('L', 'A4', 'en');	
	$h2p->writeHTML($output); 	
	$h2p->Output($file);  
	readfile($h2p);	
 }			
