<?php $output = '
		<style>
   table {border-collapse:collapse; table-layout:fixed;width:100%;}
   table th {width:80px; word-wrap:break-word;}
   </style>
		
	<h1 align="center"><img src="http://10.1.85.11/AbayERP/app/webroot/img/logo.png" /></h1>			
	<h4>&nbsp;</h4>
	<h2 align="center">Ending Balance</h2>
	<h4 align="center">' .$this->data['ImsCard']['title'].'</h4>			
		
	<table width="100%" border="1">
    <tr bgcolor="#ccccdd">
        <th></th>';		
		for($i=1;$i<=count($result[0]);$i++)
		{
			$output.='<th>'.$result[0][$i].'</th>';
		}
    $output.='</tr>
    <tr bgcolor="#ccdddd">
        <b><td bgcolor="#cccccc"><font color="blue">'.$date.'</font> ending balance</td></b>';
		for($i=1;$i<=count($result[1]);$i++)
		{		
			$output.='<td>'.number_format($result[1][$i], 2 , '.' , ',' ).'</td>';
		}
    $output.='</tr>
    <tr bgcolor="#ccdddd">
        <b><td bgcolor="#cccccc"><font color="blue">'.$from.'</font> UpTo <font color="blue">'. $to.'</font> GRN</td></b>';
		for($i=1;$i<=count($result[2]);$i++)
		{
			$output.='<td>'.number_format($result[2][$i], 2 , '.' , ',' ).'</td>';
		}
     $output.='</tr>
	<tr bgcolor="#ccdddd">
        <b><td bgcolor="#cccccc"><font color="blue">'.$from.'</font> UpTo <font color="blue">'. $to.'</font> SIRV</td></b>';
		for($i=1;$i<=count($result[3]);$i++)
		{
			$output.='<td>'.number_format($result[3][$i], 2 , '.' , ',' ).'</td>';
		}		
    $output.='</tr>
	<tr bgcolor="#ccdddd">
        <b><td bgcolor="#cccccc">Ending Balance</td></b>';
		for($i=1;$i<=count($result[4]);$i++)
		{
			$output.='<td>'.number_format($result[4][$i], 2 , '.' , ',' ).'</td>';
		}
    $output.='</tr>	
</table>';

if ($this->data['ImsCard']['type'] == 'HTML') {				
	echo $output;
}
 if ($this->data['ImsCard']['type'] == 'EXCEL') {
	$file = date("F",strtotime($date)) . ".xls";
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$file");
	echo $output;
 }
 if ($this->data['ImsCard']['type'] == 'PDF') { 
	$file = date("F",strtotime($date)) . ".pdf";
	header("Content-type:application/pdf");
	header("Content-Transfer-Encoding: Binary");
	header("Content-Disposition:inline;filename=$file");
	require_once(APPLIBS . DS . 'html2pdf' . DS . 'html2pdf.class.php');
	$h2p = new HTML2PDF('L', 'A4', 'en');	
	$h2p->writeHTML($output); 	
	$h2p->Output($file);  
	readfile($h2p);	
 }			
