
var store_bpPlans = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: ['id','branch','branch_id','month','amount','bp_item','budget_year','budget_id'	]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlans', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'branch', direction: "ASC"}
,groupField:'branch'
});


function AddBpPlan() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlans', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var bpPlan_data = response.responseText;
			
			eval(bpPlan_data);
			
			BpPlanAddWindow.show();
		},
		failure: function(response, opts){
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpPlan add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditBpPlan(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlans', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var bpPlan_data = response.responseText;
			
			eval(bpPlan_data);
			
			BpPlanEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpPlan edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewBpPlan(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'bpPlans', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var bpPlan_data = response.responseText;

            eval(bpPlan_data);

            BpPlanViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpPlan view form. Error code'); ?>: ' + response.status);
        }
    });
}
function DownloadItem(id){
	
  window.open('<?php echo $this->Html->url(array('controller' => 'bpPlans', 'action' => 'download')); ?>/'+id);
}

function UploadFile(id){

        Ext.Ajax.request({
        	url:'<?php echo $this->Html->url(array('controller' => 'BpPlanAttachments', 'action' => 'index2')); ?>/'+id,
        	success: function(response,opts){
        		
               var bpPlan_data = response.responseText;
             
               eval(bpPlan_data);
         
                parentBpPlanAttachmentsViewWindow.show();
               //DmsAttachmentAddWindow.show();
        	},
        	failure: function(response,opts){
        		Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the BpPlanAttachments add form. Error code'); ?>: ' + response.status);
        	}
        	
        });
}
function DeleteBpPlan(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlans', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('BpPlan successfully deleted!'); ?>');
			RefreshBpPlanData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpPlan add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchBpPlan(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlans', 'action' => 'search')); ?>',
		success: function(response, opts){
			var bpPlan_data = response.responseText;

			eval(bpPlan_data);

			bpPlanSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the bpPlan search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByBpPlanName(value){
	var conditions = '\'BpPlan.name LIKE\' => \'%' + value + '%\'';
	store_bpPlans.reload({
		 params: {
			start: 0,
			limit: 1000,
			conditions: conditions
	    }
	});
}



function RefreshBpPlanData() {
	store_bpPlans.reload();
}

function   CloseBudget(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'bpPlans', 'action' => 'close_budget')); ?>',
		success: function(response, opts){
			var bpPlan_data = response.responseText;

			eval(bpPlan_data);

			BpPlanAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the bpPlan search form. Error Code'); ?>: ' + response.status);
		}
	});
}


if(center_panel.find('id', 'bpPlan-tab') != "") {
	var p = center_panel.findById('bpPlan-tab');
	center_panel.setActiveTab(p);
} else {

	var win=new Ext.Window({
        title: 'Bottom Header, plain: true',
        width: 400,
        height: 200,
        plain: true,
        x:100,y:100,
        headerPosition: 'bottom',
        layout: 'fit',
        items: {
            border: false
        }
    });
	var p = center_panel.add({
		title: '<?php __('Bp Plans'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'bpPlan-tab',
		xtype: 'grid',
		store: store_bpPlans,
		columns: [
		    {header: "<?php __('Id'); ?>", dataIndex: 'id', sortable: true,hidden:true},
			{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true},
			{header: "<?php __('Month'); ?>",  dataIndex: 'month', sortable: true},
			{header: "<?php __('Amount'); ?>", dataIndex: 'amount', sortable: true,hidden:true,renderer: function(value, metaData, record){
                      
                           return Ext.util.Format.number(value, '0,0.00');
                      
                }},
			{header: "<?php __('Item'); ?>",   dataIndex: 'bp_item', sortable: true,hidden:true},
			{header: "<?php __('Budget Year'); ?>", dataIndex: 'budget_year', sortable: true},
			//{header: "<?php __('Created'); ?>",     dataIndex: 'created', sortable: true},
			//{header: "<?php __('Modified'); ?>",    dataIndex: 'modified', sortable: true,hidden:true}
		],
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text}',
			listeners:{
				refresh:function(){
					this.toggleAllGroups();
				}
			}
        }),
		
		listeners: {
			celldblclick: function(){
				ViewBpPlan(Ext.getCmp('bpPlan-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add BpPlans</b><br />Click here to create a new BpPlan'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddBpPlan();
					}
				}, ' ', '-', '', {
					xtype: 'tbbutton',
					text: '<?php __('Close Budget Year'); ?>',
					id: 'close-budget-year',
					tooltip:'<?php __('<b>Close Budget Year</b><br />Click here to close budget year'); ?>',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						CloseBudget();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-bpPlan',
					tooltip:'<?php __('<b>Edit BpPlans</b><br />Click here to modify the selected BpPlan'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditBpPlan(sel.data.id);
						};
					}
				}, ' ', ' ', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-bpPlan',
					tooltip:'<?php __('<b>Delete BpPlans(s)</b><br />Click here to remove the selected BpPlan(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					hidden:true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove BpPlan'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteBpPlan(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove BpPlan'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected BpPlans'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteBpPlan(sel_ids);
										}
									}
								});
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbsplit',
					text: '<?php __('View BpPlan'); ?>',
					id: 'view-bpPlan',
					tooltip:'<?php __('<b>View BpPlan</b><br />Click here to see details of the selected BpPlan'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewBpPlan(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('Branch'); ?>: ', {
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
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_bpPlans.reload({
								params: {
									start: 0,
									limit: 1000,
									branch_id : combo.getValue()
								}
							});
						}
					}
				},
				{
					xtype: 'tbbutton',
					text: '<?php __('Download Excel Template'); ?>',
					id:'view_download',
					tooltip:'<?php __('<b>Download CSV Template Based on The Existing Item List</b><br />Click here to create a new BpPlan'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
						DownloadItem(sel.data.branch_id+'_'+sel.data.budget_id);
					    }
					}
				},
				{
					xtype:'tbbutton',
					text:'Upload',
					id:'view_upload',
					tooltip:'<?php __('<b>Upload Plane For Department</b><br />Click here to create a new BpPlan'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler:function(){
						
					var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
						
						 UploadFile(sel.data.id);
						};
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'bpPlan_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByBpPlanName(Ext.getCmp('bpPlan_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'bpPlan_go_button',
					handler: function(){
						SearchByBpPlanName(Ext.getCmp('bpPlan_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchBpPlan();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: 1000,
			store: store_bpPlans,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-bpPlan').enable();
		p.getTopToolbar().findById('delete-bpPlan').enable();
		p.getTopToolbar().findById('view-bpPlan').enable();
		p.getTopToolbar().findById('view_upload').enable();
		p.getTopToolbar().findById('view_download').enable();
		
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-bpPlan').disable();
			p.getTopToolbar().findById('view-bpPlan').disable();
			p.getTopToolbar().findById('view_upload').disable();
			p.getTopToolbar().findById('view_download').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-bpPlan').disable();
			p.getTopToolbar().findById('view-bpPlan').disable();
			p.getTopToolbar().findById('delete-bpPlan').enable();
			p.getTopToolbar().findById('view_upload').disable();
			p.getTopToolbar().findById('view_download').disable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-bpPlan').enable();
			p.getTopToolbar().findById('view-bpPlan').enable();
			p.getTopToolbar().findById('delete-bpPlan').enable();
			p.getTopToolbar().findById('view_upload').enable();
			p.getTopToolbar().findById('view_download').enable();
		}
		else{
			p.getTopToolbar().findById('edit-bpPlan').disable();
			p.getTopToolbar().findById('view-bpPlan').disable();
			p.getTopToolbar().findById('delete-bpPlan').disable();
			p.getTopToolbar().findById('view_upload').disable();
			p.getTopToolbar().findById('view_download').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_bpPlans.load({
		params: {
			start: 0,          
			limit: 1000
		}
	});
	
}
