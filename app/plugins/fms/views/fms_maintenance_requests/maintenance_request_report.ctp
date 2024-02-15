<?php 
	$output = '
		<style>
   table {border-collapse:collapse; table-layout:fixed;width:100%;}
   table th {width:80px; word-wrap:break-word;}
   </style>
		
	<h1 align="center"><img src="http://10.1.85.11/AbayERP/app/webroot/img/logo.png" /></h1>			
	<h4>&nbsp;</h4>
	<h2 align="center">ለጥገና የተጠየቁ ዝርዝር</h2>
	<p align="left"> ቀን:<b>'. date("F j, Y").' </b></p>
	
	<table width="100%" border="1">
    <tr bgcolor="#ccccdd">
		<th>ተራ ቁጥር</th>
        <th>ኩባኒያ</th>
		<th>ታርጋ ቁጥር</th>
		<th>ርቀት</th>	
		<th>የጉዳት አይነት</th>
		<th>ምርመራ</th>
		<th>ያሳወቀው</th>
        <th>ያረጋገጠው</th>	
         <th>ያጸደቀው</th>		
	</tr>';
	for($i=0;$i<count($result);$i++)
		{
			if($result[$i][5] == 'Grand Total')
			{
				$output.='<tr bgcolor="lightblue">
				<td colspan =6 align="right">ጠቅላላ ድምር</td>
				<td align="right"><b>'.$result[$i][6].'</b></td>';							
			}
			
			else if($result[$i][5] != 'ጠቅላላ ድምር')
			{
				$output.='<tr bgcolor="white">';
				
				$output.='<td align="left">'.$result[$i][0].'</td>
				<td align="right">'.$result[$i][1].'</td>
				<td align="right">'.$result[$i][2].'</td>
				<td align="right">'.$result[$i][3].'</td>
				<td align="right">'.$result[$i][4].'</td>
				<td align="right">'.$result[$i][5].'</td>
				<td align="right">'.$result[$i][6].'</td>
				<td align="right">'.$result[$i][7].'</td>
				<td align="right">'.$result[$i][8].'</td>';
			}				
			$count = $i;
		}
    $output.='  
</table></br></br>';	


if ($this->data['FmsVehicle']['type'] == 'HTML') {				
	echo $output;
}
 if ($this->data['FmsVehicle']['type'] == 'EXCEL') {
	$file = "Maintenance Cost Report.xls";
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$file");
	echo $output;
 }
 if ($this->data['FmsVehicle']['type'] == 'PDF') { 
	$file = "Maintenance Cost Report.pdf";
	header("Content-Type:application/pdf");
	header("Content-Transfer-Encoding: Binary");
	header("Content-Disposition:inline;filename=$file");
	require_once(APPLIBS . DS . 'html2pdf' . DS . 'html2pdf.class.php');
	$h2p = new HTML2PDF('L', 'A4', 'en');	
	$h2p->writeHTML($output); 	
	$h2p->Output($file);  
	readfile($h2p);	
 }			
