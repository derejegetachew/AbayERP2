<?php $output = '
		<style>
   table {border-collapse:collapse; table-layout:fixed;width:100%;}
   table th {width:80px; word-wrap:break-word;}
   </style>
		
	<h1 align="center"><img src="http://10.1.85.11/AbayERP/app/webroot/img/logo.png" /></h1>			
	<h4>&nbsp;</h4>
	<h2 align="center">Fixed Asset</h2>	
	<p align="left"> Employee Name:<b>'.$person.'</b></p>
	<p align="left"> Date:<b>'. date("F j, Y").' </b></p>	
	<h4 align="center">' .$this->data['ImsCard']['title'].'</h4>			
	

	<table width="100%" border="1">
    <tr bgcolor="#ccccdd">
		<th>SIRV n<u>o</u></th>
        <th>Item Code</th>
		<th>Item Name</th>		
		<th>Quantity</th>
		<th>Unit Price</th>
		<th>Tag Code</th>
	</tr>';
	$count =0;
	$rowspan =0;
	for($i=0;$i<count($result);$i++)
		{
			if($result[$i][3] == 'Grand Total')
			{
				$output.='<tr bgcolor="lightblue">
				<td colspan =4 align="right">'.$result[$i][3].'</td>
				<td align="right">'.$result[$i][4].'</td>';							
			}
			
			else if($result[$i][3] != 'Grand Total')
			{
				$output.='<tr bgcolor="white">';	
				if($result[$i][0] != ''){
					$output.='<td rowspan ='.$sirvarray[$result[$i][0]].'>'.$result[$i][0].'</td>';
				}
				$output.='<td align="left">'.$result[$i][1].'</td>
				<td align="right">'.$result[$i][2].'</td>
				<td align="right">'.str_replace('.00', '', $result[$i][3]).'</td>
				<td align="right">'.number_format($result[$i][4], 2, '.', ',') .'</td>
				<td align="right">'.$result[$i][5].'</td>';
			}				
			$count = $i;
		}
    $output.='  
</table>
<p align="left"> <b>Note: </b>This report applies to head office staff only.</p>';

// Strip out carriage returns
$output = ereg_replace("\r",'',$output);
// Handle paragraphs
$output = ereg_replace("\n\n",'',$output);
// Handle line breaks
$output = ereg_replace("\n",'',$output);


?>

var mywindow=window.open("","_blank");
mywindow.document.write('<?php echo $output; ?>');
myWindow.blur();
myWindow.focus(); 

		
