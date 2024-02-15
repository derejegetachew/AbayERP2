<?php $output = '
		<style>
   table {border-collapse:collapse; table-layout:fixed;width:100%;}
   table th {width:80px; word-wrap:break-word;}
   </style>
		
	<h1 align="center"><img src="http://10.1.85.11/AbayERP/app/webroot/img/logo.png" /></h1>			
	<h4>&nbsp;</h4>
	<h2 align="center">Balance</h2>	
	<p align="left"> Item Category:<b>'. $itemCategory.'</b></p>
	<p align="left"> Date:<b>'. $this->data['ImsCard']['date'].'</b></p>	
	<h4 align="center">' .$this->data['ImsCard']['title'].'</h4>			
		
	<table width="100%" border="1">
    <tr bgcolor="#ccccdd">
        <th>N<u>o</u></th>
		<th>Item Code</th>
		<th>Item Description</th>
		<th>Meas</th>
		<th>Total Balance</th>
		<th>Addis Ababa Store</th>
		<th>BahirDar Store</th>
		<th>Desse Store</th>
		<th>Unit Price</th>
		<th>Total Price</th>
		<th>GRN Date</th>
		<th>GRN Number</th>
		<th>Quantity</th>
	</tr>';
	for($i=0;$i<count($result);$i++)
		{
			$output.='<tr bgcolor="white">				
				<td>'.$result[$i][0].'</td>
				<td>'.$result[$i][1].'</td>
				<td>'.$result[$i][2].'</td>
				<td>'.$result[$i][3].'</td>
				<td align="right">'.$result[$i][4].'</td>
				<td align="right">'.$result[$i][5].'</td>
				<td align="right">'.$result[$i][6].'</td>
				<td align="right">'.$result[$i][7].'</td>
				<td align="right">'.$result[$i][8].'</td>
				<td align="right">'.$result[$i][9].'</td>
				<td align="right">'.$result[$i][10].'</td>
				<td align="right">'.$result[$i][11].'</td>
				<td align="right">'.$result[$i][12].'</td></tr>';
		}
    $output.='<tr bgcolor="aqua">
        <td colspan="9" align="right"><b>Grand Total:</b></td>
        <td align="right"><b>'.$grandTotalPrice.'</b></td>
    </tr>  
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
