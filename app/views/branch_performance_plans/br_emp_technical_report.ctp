

var str = "<?php echo $e_id.'-'.$budget_year_id.'-'.$quarter; ?>";
function change_status(id){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformancePlans', 'action' => 'change_status_br')); ?>/'+id,
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

if(center_panel.find('id', 'brEmpObjectiveReport-tab') != "") {
	var p = center_panel.findById('brEmpObjectiveReport-tab');
	center_panel.setActiveTab(p);
} else { 
	var p = center_panel.add({
	title: 'technical report',
	id: 'brEmpObjectiveReport-tab',
	closable: true,
	tbar: new Ext.Toolbar({
			
			items: [{

					xtype: 'tbbutton',
					text: '<?php __('Change status'); ?>',
					disabled: false,
					tooltip:'<?php __('<b>change status</b><br />click here to change status'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
					//	open_plan_history();
					 change_status(str);

					//alert(str);
					
						}
					},
					
					]
				}),
				html: '<div style = "height: 450px; overflow-y: auto" ><table style = "border-collapse:collapse;  width:100%; border: 1px solid grey; margin: 10px; font-size: 12px;">'+
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
					'<tr><td style = "border: 1px solid grey" colspan = "2">IMMEDIATE SUPERVISOR NAME</td><td colspan = "4" style = "border: 1px solid grey"><?php echo $immediate_supervisor_name;?></td></tr>'+
					'</table></div>'

});
center_panel.setActiveTab(p);
}