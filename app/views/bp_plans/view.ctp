
var plan_details = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','bp_item',{name:'amount',type:'integer'},'month'	]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'BpPlanDetails', 'action' => 'list_data',$bpPlan['BpPlan']['id'])); ?>'	}),
groupField:'month'

});
	

		
<?php $bpPlan_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Branch', true) . ":</th><td><b>" . $bpPlan['Branch']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Budget Year', true) . ":</th><td><b>" . $bpPlan['BudgetYear']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $bpPlan['BpPlan']['created'] . "</b></td></tr>" . 
"</table>"; 
?>


      

		var bpPlan_view_panel_1 = {
			html : '<?php echo $bpPlan_html; ?>',
			frame : true,
			height: 80
		}
 var summary = new Ext.ux.grid.GroupSummary();
		var bpPlan_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:390,
			plain:true,
			defaults:{autoScroll: true},
			items:[
			{
				xtype: 'grid',
				loadMask: true,
				stripeRows: true,
				store: plan_details,
				title: '<?php __('Plan Detail'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(plan_details.getCount() == '')
							plan_details.reload();
					}
				},
				columns: [
					{header: "<?php __('ID'); ?>", dataIndex: 'id', sortable: true,hidden:true},
					{header: "<?php __('Month'); ?>", dataIndex: 'month', sortable: true,hidden:true},
					{header: "<?php __('Planed Item'); ?>", dataIndex: 'bp_item', sortable: true},
					{header: "<?php __('Amount'); ?>", dataIndex: 'amount', sortable: true,renderer: function(value, metaData, record){
                      
                           return Ext.util.Format.number(value, '0,0.00');
                      
                }, summaryType: 'sum',
						summaryRenderer : function(v){
		                    return "Total: "+Ext.util.Format.number(v, '0,0.00');
		                },
			            editor: new Ext.form.NumberField({
	                    allowBlank: false,
	                    allowNegative: false,
	                    style: 'text-align:left'
	               		 })}
		
				],view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text}',
			        }),
				viewConfig: {
					forceFit: true
				},	plugins: summary,
				bbar: new Ext.PagingToolbar({
					pageSize: list_size,
					store: plan_details,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
			
		});

		var BpPlanViewWindow = new Ext.Window({
			title: '<?php __('View BpPlan'); ?>: <?php echo $bpPlan['BpPlan']['id']; ?>',
			width: 700,
			height:545,
			minWidth: 700,
			minHeight: 545,
			resizable: false,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'center',
                        modal: true,
			items: [ 
				bpPlan_view_panel_1,
				bpPlan_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					BpPlanViewWindow.close();
				}
			}]
		});
