
var store_field_reports = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','type','rows','SQL','PHP','report_group','output','before_html','after_html','column_group'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'list_data', $field['Field']['id'])); ?>'	})
});
		
<?php $field_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $field['Field']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Type', true) . ":</th><td><b>" . $field['Field']['type'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('SQL', true) . ":</th><td><b>" . $field['Field']['SQL'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('PHP', true) . ":</th><td><b>" . $field['Field']['PHP'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Choices', true) . ":</th><td><b>" . $field['Field']['choices'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Params', true) . ":</th><td><b>" . $field['Field']['params'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Store', true) . ":</th><td><b>" . $field['Field']['store'] . "</b></td></tr>" . 
"</table>"; 
?>
		var field_view_panel_1 = {
			html : '<?php echo $field_html; ?>',
			frame : true,
			height: 80
		}
		var field_view_panel_2 = new Ext.TabPanel({
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
				store: store_field_reports,
				title: '<?php __('Reports'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_field_reports.getCount() == '')
							store_field_reports.reload();
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
					store: store_field_reports,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var FieldViewWindow = new Ext.Window({
			title: '<?php __('View Field'); ?>: <?php echo $field['Field']['name']; ?>',
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
				field_view_panel_1,
				field_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					FieldViewWindow.close();
				}
			}]
		});
