
function open_plan_history_ho() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'hoPerformancePlans', 'action' => 'ho_my_performance_history_index')); ?>',
		success: function(response, opts) {
			var hoPerformancePlan_data = response.responseText;
			
			eval(hoPerformancePlan_data);
			
			
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the hoPerformancePlan edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function open_plan_history_br() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'hoPerformancePlans', 'action' => 'br_my_performance_history_index')); ?>',
		success: function(response, opts) {
			var hoPerformancePlan_data = response.responseText;
			
			eval(hoPerformancePlan_data);
			
			
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the hoPerformancePlan edit form. Error code'); ?>: ' + response.status);
		}
	});
}

if(center_panel.find('id', 'myPerformanceReport-tab') != "") {
	var p = center_panel.findById('myPerformanceReport-tab');
	center_panel.setActiveTab(p);
} else { 
	var p = center_panel.add({
	title: 'my performance result',
	id: 'myPerformanceReport-tab',
	closable: true,
	tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('View my HO performance history'); ?>',
					tooltip:'<?php __('<b>View my HO performance history</b><br />Click here to view history'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						open_plan_history_ho();
					// window.location.assign("http://localhost/AbayTest/ho_performance_plans/ho_my_technical_report");

					//window.open("http://localhost/AbayTest/ho_performance_plans/index");
					
					}
					},
					{
					xtype: 'tbbutton',
					text: '<?php __('View my Branch performance history'); ?>',
					tooltip:'<?php __('<b>View my Branch performance history</b><br />Click here to view history'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						open_plan_history_br();
					// window.location.assign("http://localhost/AbayTest/ho_performance_plans/ho_my_technical_report");

					//window.open("http://localhost/AbayTest/ho_performance_plans/index");
					
					}
					},
					

					
					]
				}),
				html: '<div style = "height: 450px; overflow-y: auto" ><table style = "border-collapse:collapse;  width:100%; border: 1px solid grey; margin: 10px; font-size: 12px;">'+
				'<tr><td style = "border: 1px solid grey" colspan = "2">	EMPLOYEE NAME:</td><td colspan = "10" style = "border: 1px solid grey"><?php echo $full_name; ?></td></tr>'+
					  '<tr><td style = "border: 1px solid grey" colspan = "2">	ID NO:</td><td colspan = "10" style = "border: 1px solid grey"><?php echo $emp_id; ?></td></tr>'+
					  '<tr><td style = "border: 1px solid grey" colspan = "2">	POSITION:</td><td colspan = "10" style = "border: 1px solid grey"><?php echo $position_name; ?></td></tr>'+
					  '<tr><td style = "border: 1px solid grey" colspan = "2">	DEPARTMENT /DISTRICT:</td><td colspan = "10" style = "border: 1px solid grey"><?php echo $dept_name; ?></td></tr>'+
					  '<tr><td style = "border: 1px solid grey">Budget year</td><td style = "border: 1px solid grey">1st Quarter</td><td style = "border: 1px solid grey">2nd Quarter</td><td style = "border: 1px solid grey">Semiannual Average (Q1+Q2)/2 * 90%</td>'+
					  '<td style = "border: 1px solid grey"> Behavioural competency appraisal result 10%</td><td style = "border: 1px solid grey">Semiannual Result 100%</td><td style = "border: 1px solid grey">3rd Quarter</td><td style = "border: 1px solid grey">4th Quarter</td>'+
					  '<td style = "border: 1px solid grey">Semiannual Average (Q3+Q4)/2 * 90%</td><td style = "border: 1px solid grey">Behavioural competency appraisal result 10%</td><td style = "border: 1px solid grey">Semiannual result 100%</td>'+
					  '<td style = "border: 1px solid grey">Total annual result</td></tr>'+
					  <?php 
					 for($i = 0; $i < count($report_table); $i++){
						?>
                        '<tr>'+
						'<td style = "border: 1px solid grey"><?php echo $report_table[$i]['budget_year']; ?></td><td style = "border: 1px solid grey"><?php echo $report_table[$i]['quarter1']; ?></td>'+
						'<td style = "border: 1px solid grey"><?php echo $report_table[$i]['quarter2']; ?></td><td style = "border: 1px solid grey"><?php echo $report_table[$i]['semi_annual_technical_1']; ?></td>'+
						'<td style = "border: 1px solid grey"><?php echo $report_table[$i]['behavioural_1']; ?></td><td style = "border: 1px solid grey"><?php echo $report_table[$i]['semi_annual_result_1']; ?></td>'+
						'<td style = "border: 1px solid grey"><?php echo $report_table[$i]['quarter3']; ?></td><td style = "border: 1px solid grey"><?php echo $report_table[$i]['quarter4']; ?></td>'+
						'<td style = "border: 1px solid grey"><?php echo $report_table[$i]['semi_annual_technical_2']; ?></td><td style = "border: 1px solid grey"><?php echo $report_table[$i]['behavioural_2']; ?></td>'+
						'<td style = "border: 1px solid grey"><?php echo $report_table[$i]['semi_annual_result_2']; ?></td><td style = "border: 1px solid grey"><?php echo $report_table[$i]['annual_average']; ?></td>'+
					 '</tr>'+
						<?php
						
					 } 
					  ?>
					  
					  '</table></div>'

});
center_panel.setActiveTab(p);
}