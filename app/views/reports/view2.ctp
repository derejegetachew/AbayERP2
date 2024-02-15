
var store_report_reportFields = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','report','field','Renamed','getas'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'reportFields', 'action' => 'list_data', $report['Report']['id'])); ?>'	})
});
var store_report_payrolls = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'payrolls', 'action' => 'list_data', $report['Report']['id'])); ?>'	})
});
		
<?php $report_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $report['Report']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Type', true) . ":</th><td><b>" . $report['Report']['type'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Rows', true) . ":</th><td><b>" . $report['Report']['rows'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('SQL', true) . ":</th><td><b>" . $report['Report']['SQL'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('PHP', true) . ":</th><td><b>" . $report['Report']['PHP'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Report Group', true) . ":</th><td><b>" . $report['ReportGroup']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Output', true) . ":</th><td><b>" . $report['Report']['output'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Before Html', true) . ":</th><td><b>" . $report['Report']['before_html'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('After Html', true) . ":</th><td><b>" . $report['Report']['after_html'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Column Group', true) . ":</th><td><b>" . $report['Report']['column_group'] . "</b></td></tr>" . 
"</table>"; 
?>
		var report_view_panel_1 = {
			html : '<?php echo $report_html; ?>',
			frame : true,
			height: 80
		}
		var report_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
			{
				xtype: 'grid',
				loadMask: true,
				stripeRows: true,
				store: store_report_reportFields,
				title: '<?php __('ReportFields'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_report_reportFields.getCount() == '')
							store_report_reportFields.reload();
					}
				},
				columns: [
					{header: "<?php __('Field'); ?>", dataIndex: 'field', sortable: true}
,					{header: "<?php __('Renamed'); ?>", dataIndex: 'Renamed', sortable: true}
,					{header: "<?php __('Getas'); ?>", dataIndex: 'getas', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_report_reportFields,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			},
{
				xtype: 'grid',
				loadMask: true,
				stripeRows: true,
				store: store_report_payrolls,
				title: '<?php __('Payrolls'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_report_payrolls.getCount() == '')
							store_report_payrolls.reload();
					}
				},
				columns: [
					{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_report_payrolls,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var ReportViewWindow = new Ext.Window({
			title: '<?php __('View Report'); ?>: <?php echo $report['Report']['name']; ?>',
			width: 500,
			height:345,
			minWidth: 500,
			minHeight: 345,
			resizable: false,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'center',
                        modal: true,
			items: [ 
				report_view_panel_1,
				report_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ReportViewWindow.close();
				}
			}]
		});
