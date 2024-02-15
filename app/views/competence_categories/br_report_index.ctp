var myMask = new Ext.LoadMask(Ext.getBody(), {msg: "Processing please wait..."});
function allReports() {
	
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'competenceCategories', 'action' => 'index_br_report')); ?>',
		success: function(response, opts) {
			var competenceCategory_data = response.responseText;
			
			eval(competenceCategory_data);
			
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
		url: '<?php echo $this->Html->url(array('controller' => 'competenceCategories', 'action' => 'report_br')); ?>',
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
indReports();	

if(center_panel.find('id', 'brReports-tab') != "") {
	var p = center_panel.findById('brReports-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Competence Categories'); ?>',
		closable: true,
		loadMask: true,
		
		id: 'brReports-tab',
		
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
	
		
}
