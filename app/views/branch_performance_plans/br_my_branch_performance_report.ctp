var is_branch_manager = '<?php echo $is_branch_mgr; ?>';

var DialogWindow = new Ext.Window({
			title: '<?php __('Error!'); ?>',
			width: 400,
			minWidth: 400,
			closable: false,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: [{
				xtype: 'label',
				html: 'This is available only for branch managers!'
			}
				],
			
			buttons: [  
				 {
				text: '<?php __('Ok'); ?>',
				handler: function(btn){
					var p = center_panel.findById('myBranchPerformanceReport-tab');
					center_panel.remove('myBranchPerformanceReport-tab');
					
					DialogWindow.close();
				}
			}]
		});

function open_plan_history_br() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformancePlans', 'action' => 'br_my_branch_performance_history_index')); ?>',
		success: function(response, opts) {
			var brPerformancePlan_data = response.responseText;
			
			eval(brPerformancePlan_data);
			
			
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the brPerformancePlan edit form. Error code'); ?>: ' + response.status);
		}
	});
}

if(center_panel.find('id', 'myBranchPerformanceReport-tab') != "") {
	var p = center_panel.findById('myBranchPerformanceReport-tab');
	center_panel.setActiveTab(p);
} else { 
	var p = center_panel.add({
	title: 'my branch performance result',
	id: 'myBranchPerformanceReport-tab',
	closable: true,
	tbar: new Ext.Toolbar({
			
			items: [
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
				'<tr><td style = "border: 1px solid grey" colspan = "2">	BRANCH NAME:</td><td colspan = "3" style = "border: 1px solid grey"><?php echo $branch_name; ?></td></tr>'+
					  '<tr><td style = "border: 1px solid grey" colspan = "2">	BRANCH ID:</td><td colspan = "3" style = "border: 1px solid grey"><?php echo $branch_id; ?></td></tr>'+
					  '<tr><td style = "border: 1px solid grey" colspan = "2">	REGION:</td><td colspan = "3" style = "border: 1px solid grey"><?php echo $region; ?></td></tr>'+
					 
					  '<tr><td style = "border: 1px solid grey">Budget year</td><td style = "border: 1px solid grey">1st Quarter</td><td style = "border: 1px solid grey">2nd Quarter</td>'+
					  '<td style = "border: 1px solid grey">3rd Quarter</td><td style = "border: 1px solid grey">4th Quarter</td>'+
					 
		
					  <?php 
					 for($i = 0; $i < count($report_table); $i++){
						?>
                        '<tr>'+
						'<td style = "border: 1px solid grey"><?php echo $report_table[$i]['budget_year']; ?></td><td style = "border: 1px solid grey"><?php echo $report_table[$i]['quarter1']; ?></td>'+
						'<td style = "border: 1px solid grey"><?php echo $report_table[$i]['quarter2']; ?></td>'+
						
						'<td style = "border: 1px solid grey"><?php echo $report_table[$i]['quarter3']; ?></td><td style = "border: 1px solid grey"><?php echo $report_table[$i]['quarter4']; ?></td>'+
						
					 '</tr>'+
						<?php
						
					 } 
					  ?>
					  
					  '</table></div>'

});
center_panel.setActiveTab(p);

if(is_branch_manager != "1" ){
		DialogWindow.show();
	}
}