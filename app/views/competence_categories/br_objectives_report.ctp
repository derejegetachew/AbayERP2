
var str = "<?php echo $br_id.'-'.$budget_year_id.'-'.$quarter ; ?>";
function change_status_branch(id){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceCategories', 'action' => 'change_status_branch_hr')); ?>/'+id,
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

if(center_panel.find('id', 'brObjectiveReport-tab') != "") {
	var p = center_panel.findById('brObjectiveReport-tab');
	center_panel.setActiveTab(p);
} else{ 
	var p = center_panel.add({
	title: 'Branch technical report',
	id: 'brObjectiveReport-tab',
	closable: true,
	tbar: new Ext.Toolbar({
			
			items: [
				{
					xtype: 'tbbutton',
					text: '<?php __('Change status'); ?>',
					disabled: false,
					tooltip:'<?php __('<b>Change status</b><br />click here to agree to plan and result'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
					//	open_plan_history();
				
					change_status_branch(str);
					
						}
					},
					
					]
				}),
				
				html: '<div style = "height: 450px; overflow-y: auto" ><table style = "border-collapse:collapse;  width:100%; border: 1px solid grey; margin: 10px; font-size: 12px;">'+
				'<tr><td style = "border: 1px solid grey" colspan = "1">	BRANCH NAME:</td><td colspan = "8" style = "border: 1px solid grey"><?php echo $dept_name; ?></td></tr>'+
					  '<tr><td style = "border: 1px solid grey" colspan = "1">	BRANCH ID:</td><td colspan = "8" style = "border: 1px solid grey"><?php echo $br_id; ?></td></tr>'+
					  '<tr><td style = "border: 1px solid grey" colspan = "1">	DEPARTMENT / DISTRICT:</td><td colspan = "8" style = "border: 1px solid grey"><?php echo $district_name; ?></td></tr>'+
					  '<tr><td style = "border: 1px solid grey" colspan = "1">	APPRAISAL PERIOD:</td><td colspan = "8" style = "border: 1px solid grey"><?php echo $appraisal_period; ?></td></tr>'+
					  '<tr style = "background: #3498db; color: #fff; height: 40px;"><td style = "border: 1px solid grey; padding: 10px;">Goal/Objective</td><td style = "border: 1px solid grey; padding: 10px;">Target</td><td style = "border: 1px solid grey; padding: 10px; ">Measure</td><td style = "border: 1px solid grey; padding: 10px;">Weight</td>'+
					  '<td style = "border: 1px solid grey; padding: 10px;"> Plan</td><td style = "border: 1px solid grey; padding: 10px;">Actual</td><td style = "border: 1px solid grey; padding: 10px;">% Accomplishment</td><td style = "border: 1px solid grey; padding: 10px;">Total Score</td>'+
					  '<td style = "border: 1px solid grey; padding: 10px;">Final Score</td></tr>'+
					  
					  <?php 
					 for($i = 0; $i < count($objective_table); $i++){
						?>
                    '<tr>'+
						'<td style = "border: 1px solid grey"><?php echo $objective_table[$i]['objective']; ?></td><td style = "border: 1px solid grey"><?php echo $objective_table[$i]['target']; ?></td>'+
						'<td style = "border: 1px solid grey"><?php echo $objective_table[$i]['measure']; ?></td><td style = "border: 1px solid grey"><?php echo $objective_table[$i]['weight']; ?></td>'+
						'<td style = "border: 1px solid grey"><?php echo $objective_table[$i]['plan']; ?></td><td style = "border: 1px solid grey"><?php echo $objective_table[$i]['actual']; ?></td>'+
						'<td style = "border: 1px solid grey"><?php echo $objective_table[$i]['accomplishment']; ?></td><td style = "border: 1px solid grey"><?php echo $objective_table[$i]['rating']; ?></td>'+
						'<td style = "border: 1px solid grey"><?php echo $objective_table[$i]['final_result']; ?></td>'+
					 '</tr>'+
					
						<?php
						
					 } 
					  ?>
					'<tr>'+
						'<td colspan = "3" style = "border: 1px solid grey">Sub Total Score</td><td style = "border: 1px solid grey"><?php echo $actual_total_weight."%"; ?></td>'+
						'<td style = "border: 1px solid grey"></td><td style = "border: 1px solid grey"></td>'+
						'<td style = "border: 1px solid grey"></td><td style = "border: 1px solid grey"></td>'+
						'<td style = "border: 1px solid grey"><?php echo $score_summary; ?></td>'+
					'</tr>'+
					'<tr>'+
						'<td colspan = "3" style = "border: 1px solid grey">Total Score</td><td style = "border: 1px solid grey">100%</td>'+
						'<td style = "border: 1px solid grey"></td><td style = "border: 1px solid grey"></td>'+
						'<td style = "border: 1px solid grey"></td><td style = "border: 1px solid grey"></td>'+
						'<td style = "border: 1px solid grey"><?php if($actual_total_weight > 0) {echo round((100/$actual_total_weight) * $score_summary, 2); } ?></td>'+
					'</tr>'+
					'<tr><td style = "border: 1px solid grey" colspan = "2">IMMEDIATE SUPERVISOR NAME</td><td colspan = "7" style = "border: 1px solid grey"><?php echo $immediate_supervisor_name;?></td></tr>'+
					'</table></div>'

});
center_panel.setActiveTab(p);
}