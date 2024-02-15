
var store_budgetYear_celebrationDays = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','day','name','budget_year'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'celebrationDays', 'action' => 'list_data', $budgetYear['BudgetYear']['id'])); ?>'	})
});
		
<?php $budgetYear_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('From Date', true) . ":</th><td><b>" . $budgetYear['BudgetYear']['from_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('To Date', true) . ":</th><td><b>" . $budgetYear['BudgetYear']['to_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $budgetYear['BudgetYear']['name'] . "</b></td></tr>" . 
"</table>"; 
?>
		var budgetYear_view_panel_1 = {
			html : '<?php echo $budgetYear_html; ?>',
			frame : true,
			height: 80
		}
		var budgetYear_view_panel_2 = new Ext.TabPanel({
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
				store: store_budgetYear_celebrationDays,
				title: '<?php __('CelebrationDays'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_budgetYear_celebrationDays.getCount() == '')
							store_budgetYear_celebrationDays.reload();
					}
				},
				columns: [
					{header: "<?php __('Day'); ?>", dataIndex: 'day', sortable: true}
,					{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}
,					{header: "<?php __('Budget Year'); ?>", dataIndex: 'budget_year', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_budgetYear_celebrationDays,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var BudgetYearViewWindow = new Ext.Window({
			title: '<?php __('View BudgetYear'); ?>: <?php echo $budgetYear['BudgetYear']['name']; ?>',
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
				budgetYear_view_panel_1,
				budgetYear_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					BudgetYearViewWindow.close();
				}
			}]
		});
