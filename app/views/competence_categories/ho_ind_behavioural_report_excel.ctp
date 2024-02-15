<?php 
 $output = '	<style>
 table {border-collapse:collapse; table-layout:fixed; width:100%;}
 table th { word-wrap:break-word; padding: 5px;}
 tr td{text-align: center; padding: 5px;}
 </style><h1 align="center"><img src="http://10.1.85.11/AbayERP/app/webroot/img/logo.png" /></h1>			
 <h4>&nbsp;</h4>
 <h2 align="center">Head Office Performance report</h2>
 <h4 align="center"></h4>';

 $output.= '<table width="100%" border="1">';
 $output.= '<tr><td style = "border: 1px solid grey" colspan = "1">	EMPLOYEE NAME:</td><td colspan = "7" style = "border: 1px solid grey">'. $full_name. '</td></tr>';
 $output.= '<tr><td style = "border: 1px solid grey" colspan = "1">	ID NO:</td><td colspan = "7" style = "border: 1px solid grey">'. $emp_id.'</td></tr>';
 $output.= '<tr><td style = "border: 1px solid grey" colspan = "1">	POSITION:</td><td colspan = "7" style = "border: 1px solid grey">'. $position_name .'</td></tr>';
 $output.= '<tr><td style = "border: 1px solid grey" colspan = "1">	DEPARTMENT / DISTRICT:</td><td colspan = "7" style = "border: 1px solid grey">'. $dept_name .'</td></tr>';
 $output.= '<tr><td style = "border: 1px solid grey" colspan = "1">	APPRAISAL PERIOD:</td><td colspan = "7" style = "border: 1px solid grey">'. $appraisal_period .'</td></tr>';
 $output.= '<tr style = "background: #3498db; color: #fff; height: 40px;"><td style = "border: 1px solid grey; padding: 10px;">Competency</td><td style = "border: 1px solid grey; padding: 10px;">Competency Definition</td><td style = "border: 1px solid grey; padding: 10px; ">Expected Proficiency Level</td><td style = "border: 1px solid grey; padding: 10px;">Weight</td>';
 $output.=	'<td style = "border: 1px solid grey; padding: 10px;">Actual Proficiency</td><td style = "border: 1px solid grey; padding: 10px;">Score</td><td style = "border: 1px solid grey; padding: 10px;">Rating</td><td style = "border: 1px solid grey; padding: 10px;">Remark</td></tr>';
 for($i = 0; $i < count($behavioural_table); $i++){
    $excected_proficiency = "";
    $actual_proficiency = "";

    $output.=  '<tr>';
    $output.= '<td style = "border: 1px solid grey">'. $behavioural_table[$i]['competency'] .'</td><td style = "border: 1px solid grey">'. $behavioural_table[$i]['competency_definition'] .'</td>';
    $output.= '<td style = "border: 1px solid grey">';
    
    if($behavioural_table[$i]['expected_proficiency_level'] == 1)
    { $excected_proficiency = "beginner"; } 
    if($behavioural_table[$i]['expected_proficiency_level'] == 2)
    { $excected_proficiency = "intermediate"; }
    if($behavioural_table[$i]['expected_proficiency_level'] == 3)
    { $excected_proficiency = "advanced"; }
    if($behavioural_table[$i]['expected_proficiency_level'] == 4)
    { $excected_proficiency = "expert"; }
    
    
    $output.= $excected_proficiency.'</td>';
    $output.= '<td style = "border: 1px solid grey">'. $behavioural_table[$i]['weight'] .'</td>';
    $output.= '<td style = "border: 1px solid grey">';
    
    if($behavioural_table[$i]['actual_proficiency'] == 1)
    {$actual_proficiency = "beginner"; } 
    if($behavioural_table[$i]['actual_proficiency'] == 2)
    {$actual_proficiency = "intermediate"; }
    if($behavioural_table[$i]['actual_proficiency'] == 3)
    {$actual_proficiency = "advanced"; }
    if($behavioural_table[$i]['actual_proficiency'] == 4)
    {$actual_proficiency = "expert"; }
   
    $output.= $actual_proficiency.'</td>';
    $output.= '<td style = "border: 1px solid grey">'. $behavioural_table[$i]['score']. '</td>';
    $output.= '<td style = "border: 1px solid grey">'. $behavioural_table[$i]['rating']. '</td><td style = "border: 1px solid grey"></td>';
    
    $output.= '</tr>';
}
    $output.= '<tr>';
    $output.= '<td style = "border: 1px solid grey"></td><td style = "border: 1px solid grey"></td>';
    $output.= '<td style = "border: 1px solid grey"></td><td style = "border: 1px solid grey">10%</td>';
    $output.= '<td style = "border: 1px solid grey"></td><td style = "border: 1px solid grey"></td>';
    $output.= '<td style = "border: 1px solid grey">'. $total_rating .'</td><td style = "border: 1px solid grey"></td>';
    $output.= '</tr>';
    $output.= '<tr><td style = "border: 1px solid grey" colspan = "2">IMMEDIATE SUPERVISOR NAME</td><td colspan = "6" style = "border: 1px solid grey">'. $immediate_supervisor_name .'</td></tr>';
    

  

                      $output.= '</table>';

                      if ($output_type == 'HTML') {				
                        echo $output;
                    }
                    
                    if ($output_type == 'EXCEL') {
                        $file =  time() . ".xls";
                        header("Content-type: application/vnd.ms-excel");
                        header("Content-Disposition: attachment; filename=$file");
                        echo $output;
                    }
                    
                    if($output_type == 'PDF'){
                        $file = time() . ".pdf";
                        header("Content-type:application/pdf");
                        header("Content-Transfer-Encoding: Binary");
                        header("Content-Disposition:inline;filename=$file");
                        require_once(APPLIBS . DS . 'html2pdf' . DS . 'html2pdf.class.php');
                        $h2p = new HTML2PDF('L', 'A4', 'en');	
                        $h2p->writeHTML($output); 	
                        $h2p->Output($file);  
                        readfile($h2p);	
                    }

 ?>