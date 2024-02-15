var store_for_Actual = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: ['id',{name:'amount',type:'integer'},'month','branch','accont_no','remark','created']
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'bpActuals', 'action' => 'list_data1',$parent_id)); ?>'
		}),
	groupField:'month'
});


function RefreshActualData() {
	store_for_Actual.reload();
}
function remove(id){
	 
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpActuals', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('BpActual(s) successfully deleted!'); ?>');
			RefreshActualData();
			
			
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpActual to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

		
var summary = new Ext.ux.grid.GroupSummary();

var h = new Ext.grid.GridPanel({
	title: '<?php __('BpActuals'); ?>',
	store: store_for_Actual,
	loadMask: true,
	stripeRows: true,
	height: 400,
	anchor: '100%',
    id: 'bpActualGrid',
	columns: [
	
	
	    {header: "<?php __('Month'); ?>", dataIndex: 'month', sortable: true},
		{header:"<?php __('Account No'); ?>", dataIndex: 'accont_no', sortable: true},
		 {header: "<?php __('Amount'); ?>", dataIndex: 'amount', sortable: true,renderer: function(value, metaData, record){
                      
                           return Ext.util.Format.number(value, '0,0.00');
                      
                } ,
						summaryType: 'sum',
						summaryRenderer : function(v){
		                    return  'Total '+v ;
		                },
			            editor: new Ext.form.NumberField({
	                    allowBlank: false,
	                    allowNegative: false,
	                    style: 'text-align:left'
	                	})},
		//{header:"<?php __('branch'); ?>", dataIndex: 'branch', sortable: true},
		
		{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true,width:400,renderer: function (value, metaData) {
                 return '<div style="white-space:normal">' + value + '</div>';
             } },
		{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
		
			],
view: new Ext.grid.GroupingView({
            forceFit:true,
           			listeners:{
				refresh:function(){
					//this.toggleAllGroups();
				}
			}
        }),
 
        defaults:{collapsed:true},
	plugins: summary,
	
    listeners: {
        celldblclick: function(){
            //ViewBpActual(Ext.getCmp('bpActualGrid').getSelectionModel().getSelected().data.id);
        },
		'rowcontextmenu': function(grid,index,event){
			event.stopEvent();
			var record=grid.getStore().getAt(index);
			var menu = new Ext.menu.Menu({
            items: [
				{
                    text: '<b>Remove</b>',
                    icon: 'img/table_edit.png',
                    handler: function() {
                        remove(record.get('id'));
                    },
                    disabled: false
                }
            ]
        }).showAt(event.xy);
		}
    },
	
	tbar: new Ext.Toolbar({
 handler : function(){summary.toggleSummaries();},
		items: [{
					xtype: 'tbbutton',
					text: '<?php __('Transfer'); ?>',
					id: 'edit-bpPlan',
					tooltip:'<?php __('<b>Edit BpPlans</b><br />Click here to modify the selected BpPlan'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					disabled: false,
					hidden:true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							//AddBpActual('<?php echo $parent_id ?>'+'_'+'<?php echo $branch_id ?>');
						};
					}
				},
			 ' ','-',' ',  '<?php __('Branch'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							 <?php $st = false;
							 foreach ($branches as $item){
								if($st) echo ",";?>
							 ['<?php echo $item['Branch']['id']; ?>' ,'<?php echo $item['Branch']['name']; ?>']
							 <?php $st = true; }
							 ?>						
							]
					
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value :'<?php echo $branch_id ?>',
					disabled:true,
					id:'transfer_branches',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
					
						select : function(combo, record, index){
						
						if(combo.getValue()==-1 || combo.getValue()==0){
							g.getTopToolbar().findById('finish-actual').disable();
						}
						else{
						g.getTopToolbar().findById('finish-actual').enable();
						}
						 
							
						}
						
					}
				},{
				xtype: 'tbbutton',
				id:'finish-actual',
				text: '<?php __('Transfer To Other'); ?>',
				tooltip:'<?php __('<b>Add BpActual</b><br />Click here Finalize'); ?>',
				icon: 'img/table_add.png',
				disabled: true,
				hidden:true,
				cls: 'x-btn-text-icon',
					handler: function(btn) {
						var sm = g.getSelectionModel();
						var sel = sm.getSelections();
						var v='<?php echo $parent_id ?>';
						if (sm.hasSelection()){
							Ext.Msg.alert('Count',sm.getCount());
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Grade'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Finalize'); ?> '+sel[0].data.id+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											//Finalize(sel[0].data.id,v,g.getTopToolbar().findById('branches').getValue());
                                    	
										}
									}
								});
							}
						} else {
							
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
			}
	]})
	,bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_for_Actual,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});

		
		var bpActual_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			width: 790,
	        height:450,
			plain:true,
			defaults:{autoScroll: true},
			items:[{ title:'Actual Plan List',items:[h] }]
		});

		var BpActualViewWindow = new Ext.Window({
			title: '<?php __('View BpActual'); ?>',
	    	width: 800,
	        height:475,
	        minWidth: 700,
	        minHeight: 475,
			resizable: false,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'center',
                        modal: true,
			items: [ 
				bpActual_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					BpActualViewWindow.close();
				}
			}]
		});

store_for_Actual.load({
    params: {
        start: 0,    
        limit: list_size
    }
});