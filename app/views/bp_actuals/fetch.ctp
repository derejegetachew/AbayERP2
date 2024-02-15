var store_parent_bpActuals = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','GLCode','GLDescription','TDate','VDate','RefNo','CCY','DR','CR','TranCode','TranDesc','Amount','InstrumentCode','CPO','Description'
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'bpActualDetails', 'action' => 'list_data', $month_id)); ?>'})
});

var store_for_Actual = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: ['id',{name:'amount',type:'integer'},{name:'month'},'branch','accont_no','remark','created']
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'bpActuals', 'action' => 'list_data1',$parent_id)); ?>'}),
         groupField:'month'
});


function AddParentBpActual() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpActuals', 'action' => 'search_fetch')); ?>',
		success: function(response, opts) {
			var parent_bpActual_data = response.responseText;
			
			eval(parent_bpActual_data);
			
			BpActualAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpActual add form. Error code'); ?>: ' + response.status);
		}
	});
}

function Finalize(id,plan,branch){
	//,'?' => array('id'=>'id','plan'=>'plan','branch'=>'branch')
	//?id=id&plan=plan&branch=branch
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpActuals', 'action' => 'finalize')); ?>?id='+ id + '&plan='+ plan +'&branch='+branch,
		success: function(response, opts){
			RefreshParentBpActualData();
			RefreshActualData();
			var parent_bpActual_data = response.responseText;
			
			eval(parent_bpActual_data);
			
			BpActualViewWindow.show();
			
		},
		failure: function(response, opts){
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpActual add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentBpActual(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpActuals', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_bpActual_data = response.responseText;
			
			eval(parent_bpActual_data);
			
			BpActualViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpActual edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewBpActual(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpActuals', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var bpActual_data = response.responseText;

			eval(bpActual_data);

			BpActualViewWindow.show();
		},
		failure: function(response, opts){
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpActual view form. Error code'); ?>: ' + response.status);
		}
	});
}

function AddBpActual(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpActuals', 'action' => 'add_actual')); ?>/'+id,
		success: function(response, opts) {
			RefreshActualData();
			var bpActual_data = response.responseText;

			eval(bpActual_data);

			BpActualAddWindow.show();
		},
		failure: function(response, opts){
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpActual view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentBpActual(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpActuals', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('BpActual(s) successfully deleted!'); ?>');
			RefreshParentBpActualData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpActual to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentBpActualName(value){
	var conditions = '\'BpActual.name LIKE\' => \'%' + value + '%\'';
	store_parent_bpActuals.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentBpActualData() {
	store_parent_bpActuals.reload();
}
function RefreshActualData() {
	store_for_Actual.reload();
}

function remove(id){
	 
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpActuals', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('BpActual(s) successfully deleted!'); ?>');
			RefreshActualData();
			RefreshParentBpActualData();
			
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpActual to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}
function split(id,amount){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpActuals', 'action' => 'show_split')); ?>?id='+ id + '&amount='+ amount+'&plan_id=<?php echo $id ?>',
		success: function(response, opts) {
			var bpActual_data = response.responseText;

			eval(bpActual_data);

			BpActualAddWindow.show();
			
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpActual to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

var summary = new Ext.ux.grid.GroupSummary();
var h = new Ext.grid.GridPanel({
	title: '<?php __('Actuals'); ?>',
	store: store_for_Actual,
	loadMask: true,
	stripeRows: true,
	height: 370,
	anchor: '100%',
    id: 'bpActualGrid',
	columns: [
		 {header: "<?php __('Month'); ?>", dataIndex: 'month', sortable: true,hidden:true},
		 {header:"<?php __('Account No'); ?>", dataIndex: 'accont_no', sortable: true},
		  {header: "<?php __('Amount'); ?>", dataIndex: 'amount', sortable: true,renderer: function(value, metaData, record){
                      
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
		//{header:"<?php __('branch'); ?>", dataIndex: 'branch', sortable: true},
		
		{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true,renderer: function (value, metaData) {
                 return '<div style="white-space:normal">' + value + '</div>';
             }},
		{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
		
			],
sm: new Ext.grid.RowSelectionModel({
			singleSelect: true
		}),
view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text}'
        }),
     defaults:{collapsed:true},
		plugins: summary
,
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
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							AddBpActual('<?php echo $parent_id ?>'+'_'+'<?php echo $branch_id ?>');
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
     ?>						]
					
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
						 
							store_parent_bpActuals.reload({
								params: {
									start: 0,
									limit: list_size,
									branch_id : combo.getValue()
								}
							});
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
											Finalize(sel[0].data.id,v,g.getTopToolbar().findById('branches').getValue());
                                    	
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


var g = new Ext.grid.GridPanel({
	title: '<?php __('BpActuals'); ?>',
	store: store_parent_bpActuals,
	loadMask: true,
	stripeRows: true,
	height: 370,
	anchor: '100%',
    id: 'bpActualGrid',
	columns: [
                  		    {header: "<?php __('GL Code'); ?>", dataIndex: 'GLCode', sortable: true},
			{header: "<?php __('GL Description'); ?>", dataIndex: 'GLDescription', sortable: true},
			{header: "<?php __('T.Date'); ?>", dataIndex: 'TDate', sortable: true},
			//{header: "<?php __('VDate'); ?>", dataIndex: 'VDate', sortable: true},
			{header: "<?php __('Reference'); ?>", dataIndex: 'RefNo', sortable: true},
			{header: "<?php __('CCY'); ?>", dataIndex: 'CCY', sortable: true,width:50},
			//{header: "<?php __('DR'); ?>", dataIndex: 'DR', sortable: true},
			//{header: "<?php __('CR'); ?>", dataIndex: 'CR', sortable: true},
			//{header: "<?php __('Code'); ?>", dataIndex: 'TranCode', sortable: true},
			{header: "<?php __('Transaction'); ?>", dataIndex: 'TranDesc', sortable: true},
			{header: "<?php __('Amount'); ?>", dataIndex: 'Amount', sortable: true,renderer: function(value, metaData, record){
                      
                           return Ext.util.Format.number(value, '0,0.00');
                      
                }},
			//{header: "<?php __('InstrumentCode'); ?>", dataIndex: 'InstrumentCode', sortable: true},
			//{header: "<?php __('CPO'); ?>", dataIndex: 'CPO', sortable: true},
			{header: "<?php __('Description'); ?>", dataIndex: 'Description', sortable: true,width:300,renderer: function (value, metaData) {
                 return '<div style="white-space:normal">' + value + '</div>';
             }}
			],
	defaults:{collapsed:true}
			,

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
                    text: '<b>Split</b>',
                    icon: 'img/table_edit.png',
                    handler: function() {
                        split(record.get('id'),record.get('Amount'));
                    },
                    disabled: false
                }
            ]
        }).showAt(event.xy);
		}
    },
	tbar: new Ext.Toolbar({
                
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Fetch Data'); ?>',
				tooltip:'<?php  __('<b>Add BpActual</b><br />Click here to create a new BpActual'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentBpActual();
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
     ?>						]
					
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value :'<?php echo $branch_id ?>',
					disabled:true,
					id:'branches',
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
						 
							store_parent_bpActuals.reload({
								params: {
									start: 0,
									limit: list_size,
									branch_id : combo.getValue()
								}
							});
						}
						
					}
				},{
				xtype: 'tbbutton',
				id:'finish-actual',
				text: '<?php __('Save Selected'); ?>',
				tooltip:'<?php __('<b>Add BpActual</b><br />Click here Finalize'); ?>',
				icon: 'img/table_add.png',
				disabled: true,
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
											Finalize(sel[0].data.id,v,g.getTopToolbar().findById('branches').getValue());
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Grade'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Finalize Selected Transactions'); ?>',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											Finalize(sel_ids,v,g.getTopToolbar().findById('branches').getValue());
										}
									}
								});
							}
						} else {
							
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
			}
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_bpActuals,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	//g.getTopToolbar().findById('edit-parent-bpActual').enable();
	//g.getTopToolbar().findById('delete-parent-bpActual').enable();
    //g.getTopToolbar().findById('view-bpActual2').enable();
	
	
	//Ext.Msg.alert(' ',g.getTopToolbar().findById('branches').getValue());
	if(g.getTopToolbar().findById('branches').getValue()!=-1 && 
	    g.getTopToolbar().findById('branches').getValue()!=0 && 
		g.getTopToolbar().findById('branches').getValue()!= null){
	   g.getTopToolbar().findById('finish-actual').enable();
	}
	
	if(this.getSelections().length > 1){
	   // g.getTopToolbar().findById('edit-parent-bpActual').disable();
       // g.getTopToolbar().findById('view-bpActual2').disable();
		
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		//g.getTopToolbar().findById('edit-parent-bpActual').disable();
		//g.getTopToolbar().findById('delete-parent-bpActual').enable();
        //g.getTopToolbar().findById('view-bpActual2').disable();
		if(g.getTopToolbar().findById('branches').getValue()!=-1 && 
	    g.getTopToolbar().findById('branches').getValue()!=0 && 
		g.getTopToolbar().findById('branches').getValue()!= null){
		g.getTopToolbar().findById('finish-actual').enable();
		}
	}
	else if(this.getSelections().length == 1){
		//g.getTopToolbar().findById('edit-parent-bpActual').enable();
		//g.getTopToolbar().findById('delete-parent-bpActual').enable();
        //g.getTopToolbar().findById('view-bpActual2').enable();
		if(g.getTopToolbar().findById('branches').getValue()!=-1 && 
	    g.getTopToolbar().findById('branches').getValue()!=0 && 
		g.getTopToolbar().findById('branches').getValue()!= null){
		g.getTopToolbar().findById('finish-actual').enable();
		}
	}
	else{
		//g.getTopToolbar().findById('edit-parent-bpActual').disable();
		//g.getTopToolbar().findById('delete-parent-bpActual').disable();
        //g.getTopToolbar().findById('view-bpActual2').disable();
		g.getTopToolbar().findById('finish-actual').disable();
	}
});


var panel=new Ext.TabPanel({
	width: 790,
	height:400,
	activeTab:0,
	plan:true,
	default:{autoscrol:false},
	items:[
	{ title:'Transaction from Flex',items:[g] },
	{ title:'Actual Plan List',items:[h] }
	]
});


var BpActualViewWindow = new Ext.Window({
	title: 'BpActual Under the selected Item',
	width: 800,
	height:470,
	minWidth: 700,
	minHeight: 475,
	resizable: false,
	plain:true,
	bodyStyle:'padding:5px;',
	buttonAlign:'center',
        modal: true,
	items: [
		panel
	],

	buttons: [{
		text: 'Close',
		handler: function(btn){
			BpActualViewWindow.close();
		}
	}]
});

store_parent_bpActuals.load({
    params: {
        start: 0,    
        limit: list_size
    }
});

store_for_Actual.load({
    params: {
        start: 0,    
        limit: list_size
    }
});