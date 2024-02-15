
var plan_details = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: ['id','bp_item',{name:'amount',type:'integer'},{name:'actualAmount',type:'integer'},'difference','percent','percent1',{name:'cumulativePlan',type:'integer'},{name:'cumilativeActual',type:'integer'},'month']
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'BpPlanDetails', 'action' => 'list_data1',$bpPlan['BpPlan']['id'])); ?>'	
	}),
	//sortInfo:{field: 'month', direction: "ASC"},
	groupField:'month'
});


function Export(id){
window.open('<?php echo $this->Html->url(array('controller' => 'bpPlans', 'action' => 'export')); ?>/'+id);
}
	
	
<?php $bpPlan_html = "<table cellspacing=3>" . 	
    	"<tr><th align=right>" . __('Branch', true) . ":</th><td><b>" . $bpPlan['Branch']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Budget Year', true) . ":</th><td><b>" . $bpPlan['BudgetYear']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Month', true) . ":</th><td><b>" . $bpPlan['BpMonth']['name'] . "</b></td></tr>" . 
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
				listeners:{
					activate: function(){
						if(plan_details.getCount() == '')
							plan_details.reload();
					}
				},
				columns: [
					//{header: "<?php __('ID'); ?>", dataIndex: 'id', sortable: true,hidden:true},
					{header: "<?php __('Month'); ?>", dataIndex: 'month', sortable: true,hidden:true},
					{header: "<?php __('Planed Item'); ?>", dataIndex: 'bp_item', sortable: true},
					{header: "<?php __('Plan Amount'); ?>", dataIndex: 'amount', sortable: true,renderer: function(value, metaData, record){
                      
                           return Ext.util.Format.number(value, '0,0.00');
                      
                },
						summaryType: 'sum',
						summaryRenderer : function(v){
		                    return "Total: "+ Ext.util.Format.number(v, '0,0.00'); ;
		                },
			            editor: new Ext.form.NumberField({
	                    allowBlank: false,
	                    allowNegative: false,
	                    style: 'text-align:left'
	               		 }) },
					{header: "<?php __('Actual Amount'); ?>", dataIndex: 'actualAmount', sortable: true,renderer: function(value, metaData, record){
                      
                           return Ext.util.Format.number(value, '0,0.00');
                      
                },
						summaryType: 'sum',
						summaryRenderer : function(v){
		                    return Ext.util.Format.number(v, '0,0.00');
 ;
		                },
			            editor: new Ext.form.NumberField({
	                    allowBlank: false,
	                    allowNegative: false,
	                    style: 'text-align:left'
	               		 })},
					//{header: "<?php __('Difference'); ?>", dataIndex: 'difference', sortable: true,hidden:true,},
					{header: "<?php __('%'); ?>", dataIndex: 'percent', sortable: true},
					{header: "<?php __('Cumulative Plan'); ?>", dataIndex: 'cumulativePlan', sortable: true,renderer: function(value, metaData, record){
                      
                           return Ext.util.Format.number(value, '0,0.00');
                      
                },
						summaryType: 'sum',
						summaryRenderer : function(v){
		                    return Ext.util.Format.number(v, '0,0.00');
 ;
		                },
			            editor: new Ext.form.NumberField({
	                    allowBlank: false,
	                    allowNegative: false,
	                    style: 'text-align:left'
	                	})},
					{header: "<?php __('Cumulative Actual'); ?>", dataIndex: 'cumilativeActual', sortable: true,renderer: function(value, metaData, record){
                      
                           return Ext.util.Format.number(value, '0,0.00');
                      
                },
						summaryType: 'sum',
						summaryRenderer : function(v){
		                    return Ext.util.Format.number(v, '0,0.00');
 ;
		                },
			            editor: new Ext.form.NumberField({
	                    allowBlank: false,
	                    allowNegative: false,
	                    style: 'text-align:left'
	               		 })},
					{header: "<?php __('%'); ?>", dataIndex: 'percent1', sortable: true}
		
				],
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Plan Items" : "Plan Item"]})'
        }), defaults:{collapsed:true}
			,
	plugins: summary
,
			tbar: new Ext.Toolbar({
			 handler : function(){summary.toggleSummaries();},
			items: [   {
					xtype: 'tbbutton',
					text: '<?php __('Export To Excel'); ?>',
					id: 'edit-bpPlan',
					tooltip:'<?php __('<b>Edit BpPlans</b><br />Click here to modify the selected BpPlan'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: false,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							Export(sel.data.id);
						};
					}
				}
		]}),
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
			width: 900,
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
		
