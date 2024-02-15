
var store_spPlanHd_spPlans = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','sp_plan_hd','march_end','june_end','July','august','september','october','november','december','january','february','march','april','may','june'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'spPlans', 'action' => 'list_data', $spPlanHd['SpPlanHd']['id'])); ?>'	})
});
		
<?php $spPlanHd_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Branch', true) . ":</th><td><b>" . $spPlanHd['Branch']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Budget Year', true) . ":</th><td><b>" . $spPlanHd['BudgetYear']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('User', true) . ":</th><td><b>" . $spPlanHd['User']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Approved', true) . ":</th><td><b>" . $spPlanHd['SpPlanHd']['approved'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Rollback Comment', true) . ":</th><td><b>" . $spPlanHd['SpPlanHd']['rollback_comment'] . "</b></td></tr>" . 
"</table>"; 
?>
		var spPlanHd_view_panel_1 = {
			html : '<?php echo $spPlanHd_html; ?>',
			frame : true,
			height: 80
		}
		var spPlanHd_view_panel_2 = new Ext.TabPanel({
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
				store: store_spPlanHd_spPlans,
				title: '<?php __('SpPlans'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_spPlanHd_spPlans.getCount() == '')
							store_spPlanHd_spPlans.reload();
					}
				},
				columns: [
					{header: "<?php __('Sp Plan Hd'); ?>", dataIndex: 'sp_plan_hd', sortable: true}
,					{header: "<?php __('March End'); ?>", dataIndex: 'march_end', sortable: true}
,					{header: "<?php __('June End'); ?>", dataIndex: 'june_end', sortable: true}
,					{header: "<?php __('July'); ?>", dataIndex: 'July', sortable: true}
,					{header: "<?php __('August'); ?>", dataIndex: 'august', sortable: true}
,					{header: "<?php __('September'); ?>", dataIndex: 'september', sortable: true}
,					{header: "<?php __('October'); ?>", dataIndex: 'october', sortable: true}
,					{header: "<?php __('November'); ?>", dataIndex: 'november', sortable: true}
,					{header: "<?php __('December'); ?>", dataIndex: 'december', sortable: true}
,					{header: "<?php __('January'); ?>", dataIndex: 'january', sortable: true}
,					{header: "<?php __('February'); ?>", dataIndex: 'february', sortable: true}
,					{header: "<?php __('March'); ?>", dataIndex: 'march', sortable: true}
,					{header: "<?php __('April'); ?>", dataIndex: 'april', sortable: true}
,					{header: "<?php __('May'); ?>", dataIndex: 'may', sortable: true}
,					{header: "<?php __('June'); ?>", dataIndex: 'june', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_spPlanHd_spPlans,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var SpPlanHdViewWindow = new Ext.Window({
			title: '<?php __('View SpPlanHd'); ?>: <?php echo $spPlanHd['SpPlanHd']['id']; ?>',
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
				spPlanHd_view_panel_1,
				spPlanHd_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					SpPlanHdViewWindow.close();
				}
			}]
		});
