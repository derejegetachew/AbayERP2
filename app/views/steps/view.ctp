
var store_step_scales = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','grade','step','salary'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'scales', 'action' => 'list_data', $step['Step']['id'])); ?>'	})
});
		
<?php $step_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $step['Step']['name'] . "</b></td></tr>" . 
"</table>"; 
?>
		var step_view_panel_1 = {
			html : '<?php echo $step_html; ?>',
			frame : true,
			height: 80
		}
		var step_view_panel_2 = new Ext.TabPanel({
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
				store: store_step_scales,
				title: '<?php __('Scales'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_step_scales.getCount() == '')
							store_step_scales.reload();
					}
				},
				columns: [
					{header: "<?php __('Grade'); ?>", dataIndex: 'grade', sortable: true}
,					{header: "<?php __('Salary'); ?>", dataIndex: 'salary', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_step_scales,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var StepViewWindow = new Ext.Window({
			title: '<?php __('View Step'); ?>: <?php echo $step['Step']['name']; ?>',
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
				step_view_panel_1,
				step_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					StepViewWindow.close();
				}
			}]
		});
