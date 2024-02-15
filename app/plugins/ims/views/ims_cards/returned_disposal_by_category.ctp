<?php $output = '
		<style>
   table {border-collapse:collapse; table-layout:fixed;width:100%;}
   table th {width:80px; word-wrap:break-word;}
   </style>
		
	<h1 align="center"><img src="http://10.1.85.11/AbayERP/app/webroot/img/logo.png" /></h1>			
	<h4>&nbsp;</h4>
	<h2 align="center">Disposal (Returned Items)</h2>	
	<p align="left"> Item Category:<b>'. $itemCategory.'</b></p>
	<p align="left"> Date Range:<b>'. $this->data['ImsCard']['from'].' </b>to <b>'.$this->data['ImsCard']['to'].'</b></p>	
	<h4 align="center">' .$this->data['ImsCard']['title'].'</h4>			
	
<b align="left"><font color="blue"> Returned Items Disposal </font></b>	
	<table width="100%" border="1">
    <tr bgcolor="#ccccdd">
		<th>Created By</th>
        <th>Approved By</th>
		<th>Returned Disposal n<u>o</u></th>
		<th>Item Code</th>
		<th>Item Description</th>
		<th>Measurement</th>
		<th>Quantity</th>
		<th>Unit Price</th>
		<th>Total Price</th>
		<th>Branch</th>
		<th>Date</th>
	</tr>';
	$count =0;
	$rowspan =0;
	for($i=0;$i<count($result);$i++)
		{
			if($result[$i][4] == 'Grand Total')
			{
				if($result[$i][4] == 'Grand Total'){
					$output.='<tr bgcolor="#2ECCFA">';
				}				
				$output.='<td colspan =8 align="right"><b>'.$result[$i][4].'</b></td>
				<td align="right"><b>'.$result[$i][5].'</b></td>
				<td></td>
				<td></td>';
			}
			
			else if($result[$i][4] != 'Grand Total')
			{
				$output.='<tr bgcolor="white">';
				if($result[$i][2] != '')
				{
					$output.='<td align="left" rowspan ='.$disposalarray[$result[$i][2]].'>'.$result[$i][0].'</td>
					<td align="left" rowspan ='.$disposalarray[$result[$i][2]].'>'.$result[$i][1].'</td>
					<td align="left" rowspan ='.$disposalarray[$result[$i][2]].'>'.$result[$i][2].'</td>';
				}
				$output.='<td>'.$result[$i][3].'</td>
				<td align="left">'.$result[$i][4].'</td>
				<td align="right">'.$result[$i][5].'</td>
				<td align="right">'.$result[$i][6].'</td>
				<td align="right">'.$result[$i][7].'</td>
				<td align="right">'.$result[$i][8].'</td>
				<td align="right">'.$result[$i][9].'</td>
				<td align="right">'.$result[$i][10].'</td></tr>';
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
