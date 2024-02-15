
var store_mine_minerRules = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','mine','tableField','param','value'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'minerRules', 'action' => 'list_data', $mine['Mine']['id'])); ?>'	})
});
		
<?php $mine_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $mine['Mine']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Field', true) . ":</th><td><b>" . $mine['Mine']['field'] . "</b></td></tr>" . 
"</table>"; 
?>
		var mine_view_panel_1 = {
			html : '<?php echo $mine_html; ?>',
			frame : true,
			height: 80
		}
		var mine_view_panel_2 = new Ext.TabPanel({
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
				store: store_mine_minerRules,
				title: '<?php __('MinerRules'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_mine_minerRules.getCount() == '')
							store_mine_minerRules.reload();
					}
				},
				columns: [
					{header: "<?php __('TableField'); ?>", dataIndex: 'tableField', sortable: true}
,					{header: "<?php __('Param'); ?>", dataIndex: 'param', sortable: true}
,					{header: "<?php __('Value'); ?>", dataIndex: 'value', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_mine_minerRules,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var MineViewWindow = new Ext.Window({
			title: '<?php __('View Mine'); ?>: <?php echo $mine['Mine']['name']; ?>',
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
				mine_view_panel_1,
				mine_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					MineViewWindow.close();
				}
			}]
		});
