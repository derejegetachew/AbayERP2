<?php $output = '
		<style>
   table {border-collapse:collapse; table-layout:fixed;width:100%;}
   table th {width:80px; word-wrap:break-word;}
   </style>
		
	<h1 align="center"><img src="http://10.1.85.11/AbayERP/app/webroot/img/logo.png" /></h1>			
	<h4>&nbsp;</h4>
	<h3 align="center">SIRV & GRN by Item Category</h3>	
	<p align="left"> Item Category:<b>'. $itemCategory.'</b></p>
	<p align="left"> Date Range:<b>'. $this->data['ImsCard']['from'].' </b>to <b>'.$this->data['ImsCard']['to'].'</b></p>	
	<h4 align="center">' .$this->data['ImsCard']['title'].'</h4>
	<marquee behavior="alternate" direction="left" scrollamount="5"></marquee>
	<h4 align="right"> Head Office and Branches Total Expense  <font color="green">' .number_format($totalExpense,2,".",",").'</font></h4>

<b align="left"><font color="blue"> Head Office Expense</font></b>
<table width="100%" border="1">
    <tr bgcolor="#ccccdd">
        <th>Date</th>
		<th>SIRV n<u>o</u></th>
		<th>Recieved Branch</th>
		<th>Total Price</th>
	</tr>';
	for($i=0;$i<count($resultSIRVHeadOffice);$i++)
		{	
			if($resultSIRVHeadOffice[$i][2] == 'Over All Total')
			{
				$output.='<tr bgcolor="#2ECCFA">				
					<td>'.$resultSIRVHeadOffice[$i][0].'</td>
					<td>'.$resultSIRVHeadOffice[$i][1].'</td>
					<td align="right"><b>'.$resultSIRVHeadOffice[$i][2].'</b></td>
					<td align="right"><b>'.$resultSIRVHeadOffice[$i][3].'</b></td></tr>';
			}
			else if($resultSIRVHeadOffice[$i][0] == ''){
				$output.='<tr bgcolor="grey">				
					<td>'.$resultSIRVHeadOffice[$i][0].'</td>
					<td>'.$resultSIRVHeadOffice[$i][1].'</td>
					<td align="right"><b>'.$resultSIRVHeadOffice[$i][2].'</b></td>
					<td align="right"><b>'.$resultSIRVHeadOffice[$i][3].'</b></td></tr>';
			}
			else{
				$output.='<tr bgcolor="white">				
					<td>'.$resultSIRVHeadOffice[$i][0].'</td>
					<td>'.$resultSIRVHeadOffice[$i][1].'</td>';
					if($resultSIRVHeadOffice[$i][2] != ''){
						$output.='<td rowspan ='.$brancharrayHOffice[$resultSIRVHeadOffice[$i][2]].'>'.$resultSIRVHeadOffice[$i][2].'</td>';
					}
					$output.='<td align="right">'.$resultSIRVHeadOffice[$i][3].'</td></tr>';
				}
		}
    $output.='  
</table><br/><br/>	
	
	<b align="left"><font color="blue"> Branches Expense</font></b>
	<table width="100%" border="1">
    <tr bgcolor="#ccccdd">
        <th>Date</th>
		<th>SIRV n<u>o</u></th>
		<th>Recieved Branch</th>
		<th>Total Price</th>
	</tr>';
	for($i=0;$i<count($resultSIRV);$i++)
		{	
			if($resultSIRV[$i][2] == 'Over All Total')
			{
				$output.='<tr bgcolor="#2ECCFA">				
					<td>'.$resultSIRV[$i][0].'</td>
					<td>'.$resultSIRV[$i][1].'</td>
					<td align="right"><b>'.$resultSIRV[$i][2].'</b></td>
					<td align="right"><b>'.$resultSIRV[$i][3].'</b></td></tr>';
			}
			else if($resultSIRV[$i][0] == ''){
				$output.='<tr bgcolor="grey">				
					<td>'.$resultSIRV[$i][0].'</td>
					<td>'.$resultSIRV[$i][1].'</td>
					<td align="right"><b>'.$resultSIRV[$i][2].'</b></td>
					<td align="right"><b>'.$resultSIRV[$i][3].'</b></td></tr>';
			}
			else{
				$output.='<tr bgcolor="white">				
					<td>'.$resultSIRV[$i][0].'</td>
					<td>'.$resultSIRV[$i][1].'</td>';
					
					if($resultSIRV[$i][2] != ''){
						$output.='<td rowspan ='.$brancharray[$resultSIRV[$i][2]].'>'.$resultSIRV[$i][2].'</td>';
					}
					$output.='<td align="right">'.$resultSIRV[$i][3].'</td></tr>';
				}
		}
    $output.='  
</table>
<br/><br/>
<b align="left"><font color="blue"> GRN</font></b>
<table width="100%" border="1">
    <tr bgcolor="#ccccdd">
        <th>Date</th>
		<th>GRN n<u>o</u></th>
		<th>Total Price</th>
		<th>Type</th>
		<th>Created By</th>
		<th>Approved By</th>
	</tr>';
	for($i=0;$i<count($resultGRN);$i++)
		{
			if($resultGRN[$i][0] == ''){
				$output.='<tr bgcolor="#2ECCFA">				
					<td>'.$resultGRN[$i][0].'</td>
					<td>'.$resultGRN[$i][1].'</td>
					<td align="right"><b>'.$resultGRN[$i][2].'</b></td>
					<td align="right"><b>'.$resultGRN[$i][3].'</b></td>
					<td>'.$resultGRN[$i][4].'</td>
					<td>'.$resultGRN[$i][5].'</td></tr>';
			}
			else 
			{
				$output.='<tr bgcolor="white">				
					<td>'.$resultGRN[$i][0].'</td>
					<td>'.$resultGRN[$i][1].'</td>
					<td align="right">'.$resultGRN[$i][2].'</td>
					<td align="right"><font color="red">'.$resultGRN[$i][3].'</font></td>
					<td>'.$resultGRN[$i][4].'</td>
					<td>'.$resultGRN[$i][5].'</td></tr>';
			}
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
