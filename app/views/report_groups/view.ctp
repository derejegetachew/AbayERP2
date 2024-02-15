
var store_reportGroup_childReportGroups = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','parent','name','lft','rght'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'childReportGroups', 'action' => 'list_data', $reportGroup['ReportGroup']['id'])); ?>'	})
});
var store_reportGroup_reports = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','type','rows','SQL','PHP','report_group','output','before_html','after_html','column_group'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'list_data', $reportGroup['ReportGroup']['id'])); ?>'	})
});
		
<?php $reportGroup_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Parent Report Group', true) . ":</th><td><b>" . $reportGroup['ParentReportGroup']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $reportGroup['ReportGroup']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Lft', true) . ":</th><td><b>" . $reportGroup['ReportGroup']['lft'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Rght', true) . ":</th><td><b>" . $reportGroup['ReportGroup']['rght'] . "</b></td></tr>" . 
"</table>"; 
?>
		var reportGroup_view_panel_1 = {
			html : '<?php echo $reportGroup_html; ?>',
			frame : true,
			height: 80
		}
		var reportGroup_view_panel_2 = new Ext.TabPanel({
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
				store: store_reportGroup_childReportGroups,
				title: '<?php __('ChildReportGroups'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_reportGroup_childReportGroups.getCount() == '')
							store_reportGroup_childReportGroups.reload();
					}
				},
				columns: [
					{header: "<?php __('Parent'); ?>", dataIndex: 'parent', sortable: true}
,					{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}
,					{header: "<?php __('Lft'); ?>", dataIndex: 'lft', sortable: true}
,					{header: "<?php __('Rght'); ?>", dataIndex: 'rght', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_reportGroup_childReportGroups,
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
				store: store_reportGroup_reports,
				title: '<?php __('Reports'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_reportGroup_reports.getCount() == '')
							store_reportGroup_reports.reload();
					}
				},
				columns: [
					{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}
,					{header: "<?php __('Type'); ?>", dataIndex: 'type', sortable: true}
,					{header: "<?php __('Rows'); ?>", dataIndex: 'rows', sortable: true}
,					{header: "<?php __('SQL'); ?>", dataIndex: 'SQL', sortable: true}
,					{header: "<?php __('PHP'); ?>", dataIndex: 'PHP', sortable: true}
,					{header: "<?php __('Report Group'); ?>", dataIndex: 'report_group', sortable: true}
,					{header: "<?php __('Output'); ?>", dataIndex: 'output', sortable: true}
,					{header: "<?php __('Before Html'); ?>", dataIndex: 'before_html', sortable: true}
,					{header: "<?php __('After Html'); ?>", dataIndex: 'after_html', sortable: true}
,					{header: "<?php __('Column Group'); ?>", dataIndex: 'column_group', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_reportGroup_reports,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var ReportGroupViewWindow = new Ext.Window({
			title: '<?php __('View ReportGroup'); ?>: <?php echo $reportGroup['ReportGroup']['name']; ?>',
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
				reportGroup_view_panel_1,
				reportGroup_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					ReportGroupViewWindow.close();
				}
			}]
		});
