<?php $output = '
		<style>
   table {border-collapse:collapse; table-layout:fixed;width:100%;}
   table th {width:80px; word-wrap:break-word;}
   </style>
		
	<h1 align="center"><img src="http://10.1.85.11/AbayERP/app/webroot/img/logo.png" /></h1>			
	<h4>&nbsp;</h4>
	<h2 align="center">Uncompleted Purchase Orders</h2>	
	<p align="left"> Date:<b>'. date("F j, Y").' </b></p>	
	<h4 align="center">' .$this->data['ImsPurchaseOrder']['title'].'</h4>			
	

	<table width="100%" border="1">
    <tr bgcolor="#ccccdd">
		<th>PO n<u>o</u></th>
		<th>Supplier Name</th>
        <th>Item Code</th>
		<th>Item Name</th>		
		<th>Ordered Quantity</th>
		<th>Purchased Quantity</th>
		<th>Difference</th>
	</tr>';
	$count =0;
	$rowspan =0;
	for($i=0;$i<count($result);$i++)
		{
			

			$output.='<tr bgcolor="white">';	
			if($result[$i][0] != ''){
				$output.='<td rowspan ='.$poarray[$result[$i][0]].'>'.$result[$i][0].'</td>';
				$output.='<td rowspan ='.$poarray[$result[$i][0]].'>'.$result[$i][1].'</td>';
			}
			$output.='<td align="left">'.$result[$i][2].'</td>
			<td align="left">'.$result[$i][3].'</td>
			<td align="right">'.$result[$i][4].'</td>
			<td align="right">'.$result[$i][5].'</td>
			<td align="right">'.$result[$i][6].'</td>';
						
		}
    $output.='  
</table>';

if ($this->data['ImsPurchaseOrder']['type'] == 'HTML') {				
	echo $output;
}
 if ($this->data['ImsPurchaseOrder']['type'] == 'EXCEL') {
	$file = $this->data['ImsPurchaseOrder']['title'] . ".xls";
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$file");
	echo $output;
 }
 if ($this->data['ImsPurchaseOrder']['type'] == 'PDF') { 
	$file = $this->data['ImsPurchaseOrder']['title'].".pdf";
	header("Content-Type:application/pdf");
	header("Content-Transfer-Encoding: Binary");
	header("Content-Disposition:inline;filename=$file");
	require_once(APPLIBS . DS . 'html2pdf' . DS . 'html2pdf.class.php');
	$h2p = new HTML2PDF('L', 'A4', 'en');	
	$h2p->writeHTML($output); 	
	$h2p->Output($file);  
	readfile($h2p);	
 }			
