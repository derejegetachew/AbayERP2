
var str = "<?php echo $e_id.'-'.$budget_year_id.'-'.$quarter ; ?>";
var is_branch = "<?php echo $is_branch; ?>";

function change_status_br(id){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceCategories', 'action' => 'change_status_br_hr')); ?>/'+id,
		success: function(response, opts) {
			var hoPerformancePlan_data = response.responseText;
			
			eval(hoPerformancePlan_data);
			
			ChangeStatusWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the hoPerformancePlan edit form. Error code'); ?>: ' + response.status);
		}
	});
}
function change_status_ho(id){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceCategories', 'action' => 'change_status_ho_hr')); ?>/'+id,
		success: function(response, opts) {
			var hoPerformancePlan_data = response.responseText;
			
			eval(hoPerformancePlan_data);
			
			ChangeStatusWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the competenceCategories edit form. Error code'); ?>: ' + response.status);
		}
	});
}
function excel_report(id){
	//location.href = "http://10.1.10.86/AbayERP/competenceCategories/ho_ind_objectives_report_excel/"+id;
	window.open("http://10.1.10.87/AbayERP/competenceCategories/ho_ind_objectives_report_excel/"+id , '_blank');
}

if(center_panel.find('id', 'indObjectiveReport-tab') != "") {
	var p = center_panel.findById('indObjectiveReport-tab');
	center_panel.setActiveTab(p);
} else{ 
	var p = center_panel.add({
	title: 'Employee technical report',
	id: 'indObjectiveReport-tab',
	closable: true,
	tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Change status'); ?>',
					disabled: false,
					tooltip:'<?php __('<b>change status</b><br />click here to agree to plan and result'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
					//	open_plan_history();
					
					//change_status(str);
					if(is_branch == "0"){
						change_status_ho(str);
					}
					else{
						change_status_br(str);
					}
					
						}
					},

					{
					xtype: 'tbbutton',
					text: '<?php __('Excel Report'); ?>',
					disabled: false,
					tooltip:'<?php __('<b>Excel report</b><br />click here to download excel'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
					//	open_plan_history();
					
					//change_status(str);
					if(is_branch == "0"){
						excel_report(str);
					}
					else {
						excel_report(str);
					}
					
						}
					},
					
					]
				}),
				
				html: <?php if ($is_branch == 0){?>'<div style = "height: 450px; overflow-y: auto" ><table style = "border-collapse:collapse;  width:100%; border: 1px solid grey; margin: 10px; font-size: 12px;">'+
				'<tr><td style = "border: 1px solid grey" colspan = "2">	EMPLOYEE NAME:</td><td colspan = "8" style = "border: 1px solid grey"><?php echo $full_name; ?></td></tr>'+
					  '<tr><td style = "border: 1px solid grey" colspan = "2">	ID NO:</td><td colspan = "8" style = "border: 1px solid grey"><?php echo $emp_id; ?></td></tr>'+
					  '<tr><td style = "border: 1px solid grey" colspan = "2">	POSITION:</td><td colspan = "8" style = "border: 1px solid grey"><?php echo $position_name; ?></td></tr>'+
					  '<tr><td style = "border: 1px solid grey" colspan = "2">	DEPARTMENT / DISTRICT:</td><td colspan = "8" style = "border: 1px solid grey"><?php echo $dept_name; ?></td></tr>'+
					  '<tr><td style = "border: 1px solid grey" colspan = "2">	APPRAISAL PERIOD:</td><td colspan = "8" style = "border: 1px solid grey"><?php echo $appraisal_period; ?></td></tr>'+
					  '<tr style = "background: #3498db; color: #fff; height: 40px;"><td style = "border: 1px solid grey; padding: 10px;">Perspective</td><td style = "border: 1px solid grey; padding: 10px;">Goal/Objective</td><td style = "border: 1px solid grey; padding: 10px;">KPIs</td><td style = "border: 1px solid grey; padding: 10px; ">Measure</td><td style = "border: 1px solid grey; padding: 10px;">Weight</td>'+
					  '<td style = "border: 1px solid grey; padding: 10px;"> Plan</td><td style = "border: 1px solid grey; padding: 10px;">Actual</td><td style = "border: 1px solid grey; padding: 10px;">% Accomplishment</td><td style = "border: 1px solid grey; padding: 10px;">Total Score</td>'+
					  '<td style = "border: 1px solid grey; padding: 10px;">Final Score</td></tr>'+
					  
					  <?php 
					 for($i = 0; $i < count($objective_table); $i++){
						?>
                    '<tr>'+
					'<td style = "border: 1px solid grey"><?php echo $objective_table[$i]['perspective']; ?></td>'+
						'<td style = "border: 1px solid grey"><?php echo $objective_table[$i]['objective']; ?></td><td style = "border: 1px solid grey"><?php echo $objective_table[$i]['kpis']; ?></td>'+
						'<td style = "border: 1px solid grey"><?php echo $objective_table[$i]['measure']; ?></td><td style = "border: 1px solid grey"><?php echo $objective_table[$i]['weight']; ?></td>'+
						'<td style = "border: 1px solid grey"><?php echo $objective_table[$i]['plan']; ?></td><td style = "border: 1px solid grey"><?php echo $objective_table[$i]['actual']; ?></td>'+
						'<td style = "border: 1px solid grey"><?php echo $objective_table[$i]['accomplishment']; ?></td><td style = "border: 1px solid grey"><?php echo $objective_table[$i]['total_score']; ?></td>'+
						'<td style = "border: 1px solid grey"><?php echo $objective_table[$i]['final_score']; ?></td>'+
					 '</tr>'+
					
						<?php
						
					 } 
					  ?>
					'<tr>'+
						'<td colspan = "4" style = "border: 1px solid grey">Total Score</td><td style = "border: 1px solid grey"><?php echo $total_weight.'%'; ?></td>'+
						'<td style = "border: 1px solid grey"></td><td style = "border: 1px solid grey"></td>'+
						'<td style = "border: 1px solid grey"></td><td style = "border: 1px solid grey"></td>'+
						'<td style = "border: 1px solid grey"><?php echo $score_summary; ?></td>'+
					'</tr>'+
					'<tr>'+
						'<td colspan = "4" style = "border: 1px solid grey">Total Score (100%)</td><td style = "border: 1px solid grey">100%</td>'+
						'<td style = "border: 1px solid grey"></td><td style = "border: 1px solid grey"></td>'+
						'<td style = "border: 1px solid grey"></td><td style = "border: 1px solid grey"></td>'+
						'<td style = "border: 1px solid grey"><?php if($total_weight > 0) {echo round((100/$total_weight) * $score_summary , 2); } ?></td>'+
					'</tr>'+
					'<tr>'+
						'<td colspan = "4" style = "border: 1px solid grey">Summarized Score</td><td style = "border: 1px solid grey"></td>'+
						'<td style = "border: 1px solid grey"></td><td style = "border: 1px solid grey"></td>'+
						'<td style = "border: 1px solid grey"></td><td style = "border: 1px solid grey"></td>'+
						'<td style = "border: 1px solid grey"><?php if(count($objective_table) > 0) { echo round($objective_table[0]['aggregate_score'] , 2); } ?></td>'+
					'</tr>'+
					'<tr>'+
						'<td colspan = "10" style = "border: 1px solid grey; text-align: center;">Training and Development Plan</td>'+
					'</tr>'+
					'<tr>'+
						'<td style = "border: 1px solid grey">1</td><td colspan = "9" style = "border: 1px solid grey"><?php echo $training1; ?></td>'+
					'</tr>'+
					'<tr>'+
						'<td style = "border: 1px solid grey">2</td><td colspan = "9" style = "border: 1px solid grey"><?php echo $training2; ?></td>'+
					'</tr>'+
					'<tr>'+
						'<td style = "border: 1px solid grey">3</td><td colspan = "9" style = "border: 1px solid grey"><?php echo $training3; ?></td>'+
					'</tr>'+
					'<tr><td style = "border: 1px solid grey" colspan = "3">IMMEDIATE SUPERVISOR NAME</td><td colspan = "7" style = "border: 1px solid grey"><?php echo $immediate_supervisor_name;?></td></tr>'+
					'<tr><td style = "border: 1px solid grey" colspan = "2">Plan status</td><td colspan = "8" style = "border: 1px solid grey"><?php if(count($objective_table) > 0) { echo $objective_table[0]['plan_status']; } ?></td></tr>'+
					'<tr><td style = "border: 1px solid grey" colspan = "2">Result status</td><td colspan = "8" style = "border: 1px solid grey"><?php if(count($objective_table) > 0) { echo $objective_table[0]['result_status']; } ?></td></tr>'+
					'<tr><td style = "border: 1px solid grey" colspan = "2">Comment</td><td colspan = "8" style = "border: 1px solid grey"><?php if(count($objective_table) > 0) { echo $objective_table[0]['comment']; } ?></td></tr>'+
					'</table></div>'<?php } else { ?>
						'<div style = "height: 450px; overflow-y: auto" ><table style = "border-collapse:collapse;  width:100%; border: 1px solid grey; margin: 10px; font-size: 12px;">'+
				'<tr><td style = "border: 1px solid grey" colspan = "1">	EMPLOYEE NAME:</td><td colspan = "8" style = "border: 1px solid grey"><?php echo $full_name; ?></td></tr>'+
					  '<tr><td style = "border: 1px solid grey" colspan = "1">	ID NO:</td><td colspan = "8" style = "border: 1px solid grey"><?php echo $emp_id; ?></td></tr>'+
					  '<tr><td style = "border: 1px solid grey" colspan = "1">	POSITION:</td><td colspan = "8" style = "border: 1px solid grey"><?php echo $position_name; ?></td></tr>'+
					  '<tr><td style = "border: 1px solid grey" colspan = "1">	DEPARTMENT / DISTRICT:</td><td colspan = "8" style = "border: 1px solid grey"><?php echo $dept_name; ?></td></tr>'+
					  '<tr><td style = "border: 1px solid grey" colspan = "1">	APPRAISAL PERIOD:</td><td colspan = "8" style = "border: 1px solid grey"><?php echo $appraisal_period; ?></td></tr>'+
					  '<tr style = "background: #3498db; color: #fff; height: 40px;"><td style = "border: 1px solid grey; padding: 10px;">Goal/Objective</td><td style = "border: 1px solid grey; padding: 10px;">Target</td><td style = "border: 1px solid grey; padding: 10px; ">Measure</td>'+
					  '<td style = "border: 1px solid grey; padding: 10px;"> Weight</td><td style = "border: 1px solid grey; padding: 10px;">Total Value</td><td style = "border: 1px solid grey; padding: 10px;">Rating</td>'+
					
					  
					  <?php 
					 for($i = 0; $i < count($objective_table); $i++){
						?>
                    '<tr>'+
						'<td style = "border: 1px solid grey"><?php echo $objective_table[$i]['objective']; ?></td><td style = "border: 1px solid grey"><?php echo $objective_table[$i]['target']; ?></td>'+
						'<td style = "border: 1px solid grey"><?php echo $objective_table[$i]['measure']; ?></td><td style = "border: 1px solid grey"><?php echo $objective_table[$i]['weight']; ?></td>'+
						'<td style = "border: 1px solid grey"><?php echo $objective_table[$i]['total_value']; ?></td><td style = "border: 1px solid grey"><?php echo $objective_table[$i]['rating']; ?></td>'+
					 '</tr>'+
					
						<?php
						
					 } 
					  ?>
					'<tr>'+
						'<td colspan = "3" style = "border: 1px solid grey">Total Score</td><td style = "border: 1px solid grey"><?php echo $total_weight."%"; ?></td>'+
						'<td style = "border: 1px solid grey"></td>'+
						'<td style = "border: 1px solid grey"><?php echo $score_summary; ?></td>'+
					'</tr>'+
					'<tr>'+
						'<td colspan = "3" style = "border: 1px solid grey">Total Score(100%)</td><td style = "border: 1px solid grey">100%</td>'+
						'<td style = "border: 1px solid grey"></td>'+
						'<td style = "border: 1px solid grey"><?php if($total_weight > 0){ echo round(($score_summary * 100/$total_weight) , 2); } ?></td>'+
					'</tr>'+
					'<tr>'+
						'<td colspan = "3" style = "border: 1px solid grey">Branch Result</td><td style = "border: 1px solid grey">100%</td>'+
						'<td style = "border: 1px solid grey"></td>'+
						'<td style = "border: 1px solid grey"><?php echo $branch_result; ?></td>'+
					'</tr>'+
					'<tr>'+
						'<td colspan = "3" style = "border: 1px solid grey">Aggregate Score</td><td style = "border: 1px solid grey">100%</td>'+
						'<td style = "border: 1px solid grey"></td>'+
						'<td style = "border: 1px solid grey"><?php echo $score_summary_aggregate; ?></td>'+
					'</tr>'+
					'<tr>'+
						'<td colspan = "9" style = "border: 1px solid grey; text-align: center;">Training and Development Plan</td>'+
					'</tr>'+
					'<tr>'+
						'<td style = "border: 1px solid grey">1</td><td colspan = "5" style = "border: 1px solid grey"><?php echo $training1; ?></td>'+
					'</tr>'+
					'<tr>'+
						'<td style = "border: 1px solid grey">2</td><td colspan = "5" style = "border: 1px solid grey"><?php echo $training2; ?></td>'+
					'</tr>'+
					'<tr>'+
						'<td style = "border: 1px solid grey">3</td><td colspan = "5" style = "border: 1px solid grey"><?php echo $training3; ?></td>'+
					'</tr>'+
					'<tr><td style = "border: 1px solid grey" colspan = "2">IMMEDIATE SUPERVISOR NAME</td><td colspan = "4" style = "border: 1px solid grey"><?php echo $immediate_supervisor_name; ?></td></tr>'+
					'<tr><td style = "border: 1px solid grey" colspan = "2">Result status</td><td colspan = "4" style = "border: 1px solid grey"><?php if(count($objective_table) > 0) { echo $objective_table[0]['result_status']; } ?></td></tr>'+
					'<tr><td style = "border: 1px solid grey" colspan = "2">Comment</td><td colspan = "4" style = "border: 1px solid grey"><?php if(count($objective_table) > 0) { echo $objective_table[0]['comment']; } ?></td></tr>'+
					'</table></div>'
					<?php } ?>

});
center_panel.setActiveTab(p);
}