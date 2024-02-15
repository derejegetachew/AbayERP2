var is_district_branch_manager = '<?php echo $is_district_branch_mgr; ?>';

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
				html: 'This is available only for district and branch managers!'
			}
				],
			
			buttons: [  
				 {
				text: '<?php __('Ok'); ?>',
				handler: function(btn){
					var p = center_panel.findById('brEmpReports-tab');
					center_panel.remove('brEmpReports-tab');
					
					DialogWindow.close();
				}
			}]
		});

var myMask = new Ext.LoadMask(Ext.getBody(), {msg: "Processing please wait..."});
function allReports() {
	
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformancePlans', 'action' => 'index_br_report')); ?>',
		success: function(response, opts) {
			var branchPerformance_data = response.responseText;
			
			eval(branchPerformance_data);
			
			CompetenceCategoryReportWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Plan add form. Error code'); ?>: ' + response.status);
		}
	});
}

function indReports() {
	myMask.show();
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformancePlans', 'action' => 'emp_report')); ?>',
		success: function(response, opts) {
			var hoPerformancePlan_data = response.responseText;
			
			eval(hoPerformancePlan_data);
			myMask.hide();
            AllReportWindow.show();
           // CompetenceCategoryAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the hoPerformancePlan add form. Error code'); ?>: ' + response.status);
		}
	});
	
} 	
if(is_district_branch_manager == 1 ){
	indReports();
}
	

if(center_panel.find('id', 'brEmpReports-tab') != "") {
	var p = center_panel.findById('brEmpReports-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Competence Categories'); ?>',
		closable: true,
		loadMask: true,
		
		id: 'brEmpReports-tab',
		
		viewConfig: {
			forceFit: true
		}
,
			
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Report'); ?>',
					tooltip:'<?php __('<b>Show report form</b><br />Click here to show report form'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						indReports();
					}
				}, ' ', '-', ' ',{
					xtype: 'tbbutton',
					text: '<?php __('Excel Report'); ?>',
					tooltip:'<?php __('<b>Show report form</b><br />Click here to show report form'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						allReports();
					}
				}
		]}),
		
	});
	
	
	center_panel.setActiveTab(p);

	if(is_district_branch_manager != 1 ){
		DialogWindow.show();
	}
	
		
}
