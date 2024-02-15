<?php $output = '
		<style>
   table {border-collapse:collapse; table-layout:fixed;width:100%;}
   table th {width:80px; word-wrap:break-word;}
   </style>
		
	<h1 align="center"><img src="http://10.1.85.11/AbayERP/app/webroot/img/logo.png" /></h1>			
	<h4>&nbsp;</h4>
	<h2 align="center">SIRV</h2>	
	<p align="left"> Item Category:<b>'. $itemCategory.'</b></p>
	<p align="left"> Date Range:<b>'. $this->data['ImsCard']['from'].' </b>to <b>'.$this->data['ImsCard']['to'].'</b></p>	
	<h4 align="center">' .$this->data['ImsCard']['title'].'</h4>			
	
<b align="left"><font color="blue"> Booked SIRV</font></b>	
	<table width="100%" border="1">
    <tr bgcolor="#ccccdd">
		<th>Branch</th>
        <th>Date</th>
		<th>SIRV n<u>o</u></th>
		<th>Item Code</th>
		<th>Item Description</th>
		<th>Quantity</th>
		<th>Unit Price</th>
		<th>Total Price</th>
		<th>Status</th>
		<th>Receiver</th>
		<th>Tag</th>
		<th>GRN date</th>
	</tr>';
	$count =0;
	$rowspan =0;
	$branchName;
	for($i=0;$i<count($result);$i++)
		{
			if($result[$i][3] == 'Grand Total' or $result[$i][3] == 'Over All Total')
			{
				if($result[$i][3] == 'Grand Total'){
					$output.='<tr bgcolor="grey">';
				}
				else if($result[$i][3] == 'Over All Total'){
					$output.='<tr bgcolor="#2ECCFA">';
				}
				
				
				
				$output.='<td colspan =7 align="right"><b>'.$result[$i][3].'</b></td>
				<td align="right"><b>'.$result[$i][4].'</b></td>
				<td colspan=4></td>';				
			}
			
			else if($result[$i][3] != 'Grand Total')
			{
				$output.='<tr bgcolor="white">';
			
				
				if($result[$i][0] != '')
				{
					$branchName = $result[$i][0];
					$output.='<td rowspan ='.$brancharray[$result[$i][0]].'>'.$result[$i][0].'</td>';
				}
				
				if($result[$i][1] != '')
				{
					$output.='<td rowspan ='.$sirvarray[$branchName][$result[$i][2]].'>'.$result[$i][1].'</td>';
				}				
				if($result[$i][2] != '')
				{
					$output.='<td rowspan ='.$sirvarray[$branchName][$result[$i][2]].'>'.$result[$i][2].'</td>';
				}
				
				$output.='<td>'.$result[$i][3].'</td>
				<td align="left">'.$result[$i][4].'</td>
				<td align="right">'.$result[$i][5].'</td>
				<td align="right">'.$result[$i][6].'</td>
				<td align="right">'.$result[$i][7].'</td>
				<td>'.$result[$i][8].'</td>
				<td>'.$result[$i][9].'</td>
				<td>'.$result[$i][11].'</td>
				<td>'.$result[$i][12].'</td></tr>';
			}				
			$count = $i;
		}
    $output.='  
</table>';

if ($this->data['ImsCard']['type'] == 'HTML') {				
	echo $output;
}
 if ($this->data['ImsCard']['type'] == 'EXCEL') {
	$file = $this->data['ImsCard']['title'] . ".xls";
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$file");
	echo $output;
 }
 if ($this->data['ImsCard']['type'] == 'PDF') { 
	$file = $this->data['ImsCard']['title'].".pdf";
	header("Content-Type:application/pdf");
	header("Content-Transfer-Encoding: Binary");
	header("Content-Disposition:inline;filename=$file");
	require_once(APPLIBS . DS . 'html2pdf' . DS . 'html2pdf.class.php');
	$h2p = new HTML2PDF('L', 'A4', 'en');	
	$h2p->writeHTML($output); 	
	$h2p->Output($file);  
	readfile($h2p);	
 }			
