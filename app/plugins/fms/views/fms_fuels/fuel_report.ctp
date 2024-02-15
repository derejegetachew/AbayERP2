<?php $output = '
		<style>
   table {border-collapse:collapse; table-layout:fixed;width:100%;}
   table th {width:80px; word-wrap:break-word;}
   </style>
		
	<h1 align="center"><img src="http://10.1.85.11/AbayERP/app/webroot/img/logo.png" /></h1>			
	<h4>&nbsp;</h4>
	<h2 align="center">የነዳጅ አጠቃቀም መከታተያ እና መመዝገቢያ ቅጽ</h2>
	
	<table border="0" width="100%">
    <tr>
		
		<td></td>
		<td></td>
        <td  align="center">Date:'. date("F j, Y") .'</td>
    </tr>
	
    <tr>		
        <td colspan="1" style="padding:0 0 0 55px;" valign="top"></br>
            <p align="left"> የመኪናው አይነት:<b>&nbsp;&nbsp;&nbsp;'. $vehicle['FmsVehicle']['vehicle_type'].'</b></p>
			
        </td> 
		<td colspan="1" style="padding:0 0 0 55px;" valign="top"></br>
            <p align="left"> ታርጋ ቁጥር:<b>&nbsp;&nbsp;&nbsp;'. $vehicle['FmsVehicle']['plate_no'].'</b></p>			
        </td>
		<td colspan="1" style="padding:0 0 0 55px;" valign="top"></br>
            <p align="left"> የሚወስደው የነዳጅ አይነት:<b>&nbsp;&nbsp;&nbsp;'. $vehicle['FmsVehicle']['fuel_type'].'</b></p>			
        </td>
    </tr>    
</table>

	</br>
	
	<p align="left"> Date Range:<b>'. $this->data['FmsFuel']['from'].' </b>to <b>'.$this->data['FmsFuel']['to'].'</b></p>	
	<h4 align="center">' .$this->data['FmsFuel']['title'].'</h4>			
	
	<table width="100%" border="1">
    <tr bgcolor="#ccccdd">
		<th>ነዳጅ የተቀዳበት ቀን</th>
		<th>የ 1 ሊትር ዋጋ</th>
        <th>በሊትር</th>
		<th>በብር</th>
		<th>ኪሎ ሜትር</th>
		<th>በ 1 ሊትር መጓዝ ያለበት ኪሎ ሜትር</th>
		<th>የአሽከርካሪው ስም</th>
		<th>ምርመራ</th>		
	</tr>';
	$rowspan =0;
	for($i=0; $i<count($result); $i++)
		{
			if($result[$i][3] == 'Grand Total' or $result[$i][3] == 'Over All Total')
			{
				if($result[$i][3] == 'Grand Total'){
					$output.='<tr bgcolor="grey">';
				}
				else if($result[$i][3] == 'Over All Total'){
					$output.='<tr bgcolor="#2ECCFA">';
				}
				
				if($result[$i][0] != '')
				{
					$output.='<td rowspan ='.$brancharray[$result[$i][0]].'>'.$result[$i][0].'</td>';
				}
				
				if($result[$i][1] != '')
				{
					$output.='<td rowspan ='.$sirvarray[$result[$i][0]][$result[$i][2]].'>'.$result[$i][1].'</td>';
				}				
				if($result[$i][2] != '')
				{
					$output.='<td rowspan ='.$sirvarray[$result[$i][0]][$result[$i][2]].'>'.$result[$i][2].'</td>';
				}
				
				$output.='<td colspan =7 align="right"><b>'.$result[$i][3].'</b></td>
				<td align="right"><b>'.$result[$i][4].'</b></td>
				<td colspan=3></td>';				
			}
			
			else if($result[$i][3] != 'Grand Total')
			{
				$output.='<tr bgcolor="white">
				<td>'.$result[$i][1].'</td>
				<td align="left">'.$result[$i][2].'</td>
				<td align="right">'.$result[$i][3].'</td>
				<td align="right">'.$result[$i][4].'</td>
				<td align="right">'.$result[$i][5].'</td>
				<td>'.$result[$i][6].'</td>
				<td>'.$result[$i][8].'</td>
				<td>'.$result[$i][7].'</td></tr>';
			}				
		}
    $output.='  
</table></br></br></br>
<table>
	<tr>
		<td>
		</td>
		<td align="left" colspan ="2"></br>
			<p align="left"> <u>ያዘጋጀው ሰራተኛ</u></p>
			<p align="left"> ስም.......................</p>
			<p align="left"> ፊርማ.......................</p>
			<p align="left"> ቀን.......................</p>
		</td>
	
		<td align="right" colspan ="2"></br>
			<p align="left"> <u>ያረጋገጠው የክፍል ሀላፊ</u></p>
			<p align="left"> ስም.......................</p>
			<p align="left"> ፊርማ.......................</p>
			<p align="left"> ቀን.......................</p>
		</td>
	</tr>
</table></br></br>
<p align="left"> <b>ማሳሰቢያ፡</b> ለእያንዳንዱ መኪና ራሱን የቻለ አንድ ቅጽ ማዘጋጀትና ምዝገባው በእያንዳንዱ መኪና ሳይቆራረጥ መመዝገብና መወራረድ አለበት። </p>';

if ($this->data['FmsFuel']['type'] == 'HTML') {				
	echo $output;
}
 if ($this->data['FmsFuel']['type'] == 'EXCEL') {
	$file = $this->data['FmsFuel']['title'] . ".xls";
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$file");
	echo $output;
 }
 if ($this->data['FmsFuel']['type'] == 'PDF') { 
	$file = $this->data['FmsFuel']['title'].".pdf";
	header("Content-Type:application/pdf");
	header("Content-Transfer-Encoding: Binary");
	header("Content-Disposition:inline;filename=$file");
	require_once(APPLIBS . DS . 'html2pdf' . DS . 'html2pdf.class.php');
	$h2p = new HTML2PDF('L', 'A4', 'en');	
	$h2p->writeHTML($output); 	
	$h2p->Output($file);  
	readfile($h2p);	
 }			
