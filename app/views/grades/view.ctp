
var store_grade_positions = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','grade'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'positions', 'action' => 'list_data', $grade['Grade']['id'])); ?>'	})
});
var store_grade_scales = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','grade','step','salary'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'scales', 'action' => 'list_data', $grade['Grade']['id'])); ?>'	})
});
		
<?php $grade_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $grade['Grade']['name'] . "</b></td></tr>" . 
"</table>"; 
?>
		var grade_view_panel_1 = {
			html : '<?php echo $grade_html; ?>',
			frame : true,
			height: 80
		}
		var grade_view_panel_2 = new Ext.TabPanel({
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
				store: store_grade_positions,
				title: '<?php __('Positions'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_grade_positions.getCount() == '')
							store_grade_positions.reload();
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
					store: store_grade_positions,
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
				store: store_grade_scales,
				title: '<?php __('Scales'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_grade_scales.getCount() == '')
							store_grade_scales.reload();
					}
				},
				columns: [
					{header: "<?php __('Step'); ?>", dataIndex: 'step', sortable: true}
,					{header: "<?php __('Salary'); ?>", dataIndex: 'salary', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_grade_scales,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var GradeViewWindow = new Ext.Window({
			title: '<?php __('View Grade'); ?>: <?php echo $grade['Grade']['name']; ?>',
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
				grade_view_panel_1,
				grade_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					GradeViewWindow.close();
				}
			}]
		});
