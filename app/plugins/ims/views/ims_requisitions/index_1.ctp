//<script>
var store_imsRequisitions = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','budget_year','branch','purpose','requested_by','approved/rejected_by','status','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({	
		url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitions', 'action' => 'list_data_1')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'branch'
});


function AddImsRequisition() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitions', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var imsRequisition_data = response.responseText;
			
			eval(imsRequisition_data);
			
			ImsRequisitionAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Requisition add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditImsRequisition(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitions', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var imsRequisition_data = response.responseText;
			
			eval(imsRequisition_data);
			
			ImsRequisitionEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Requisition edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsRequisition(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitions', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var imsRequisition_data = response.responseText;

            eval(imsRequisition_data);

            ImsRequisitionViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Requisition view form. Error code'); ?>: ' + response.status);
        }
    });
}

function ViewImsSIRV(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ims_sirv_items', 'action' => 'index_4')); ?>/'+id,
        success: function(response, opts) {
			var sirv_item_data = response.responseText;

			eval(sirv_item_data);

			parentImsSirvItemsViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the SIRV item form. Error code'); ?>: ' + response.status);
		}
    });
}

function Receive(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ims_requisitions', 'action' => 'receive_sirv_items')); ?>/'+id,
        success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Requisition successfully received!'); ?>');
             RefreshImsRequisitionData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the SIRV item form. Error code'); ?>: ' + response.status);
		}
    });
}

function ViewParentImsRequisitionItems(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitionItems', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_imsRequisitionItems_data = response.responseText;

            eval(parent_imsRequisitionItems_data);

            parentImsRequisitionItemsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteImsRequisition(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitions', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Requisition successfully deleted!'); ?>');
			RefreshImsRequisitionData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Requisition add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchImsRequisition(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitions', 'action' => 'search')); ?>',
		success: function(response, opts){
			var imsRequisition_data = response.responseText;

			eval(imsRequisition_data);

			imsRequisitionSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the Requisition search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByImsRequisitionName(value){
	var conditions = '\'ImsRequisition.name LIKE\' => \'%' + value + '%\'';
	store_imsRequisitions.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshImsRequisitionData() {
	store_imsRequisitions.reload();
}

 function PostRequisition(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_requisitions', 'action' => 'post')); ?>/'+id,
            success: function(response, opts) {
                Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Requisition successfully posted!'); ?>');
                RefreshImsRequisitionData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Please report this error to Administrator. Cannot post the requisition. Error code'); ?>: ' + response.status);
            }
	});
    }

function showMenu(grid, index, event) {
        event.stopEvent();
        var record = grid.getStore().getAt(index);
        //alert(record.get('rejected'));
        var btnStatus = (record.get('status') == 'created')? true: false;
        //alert(btnStatus);
        var menu = new Ext.menu.Menu({
            items: [{
                    text: '<b><i>Post Requisition</i></b>',
                    icon: 'img/table_edit.png',					
                    handler: function() {
                        PostRequisition(record.get('id'));
                    },
					disabled: !btnStatus
                }
            ]
        }).showAt(event.xy);
    }


if(center_panel.find('id', 'imsRequisition-tab1') != "") {
	var p = center_panel.findById('imsRequisition-tab1');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Requisitions'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'imsRequisition-tab1',
		xtype: 'grid',
		store: store_imsRequisitions,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('BudgetYear'); ?>", dataIndex: 'budget_year', sortable: true},
			{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true},
			{header: "<?php __('Purpose'); ?>", dataIndex: 'purpose', sortable: true},
			{header: "<?php __('Requested By'); ?>", dataIndex: 'requested_by', sortable: true},			
			{header: "<?php __('Approved/Rejected By'); ?>", dataIndex: 'approved/rejected_by', sortable: true},
			{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "ImsRequisitions" : "ImsRequisition"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewImsRequisition(Ext.getCmp('imsRequisition-tab1').getSelectionModel().getSelected().data.id);
			},
                'rowcontextmenu': function(grid, index, event) {
                    showMenu(grid, index, event);
                }
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Requisitions</b><br />Click here to create a new Requisition'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddImsRequisition();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-imsRequisition',
					tooltip:'<?php __('<b>Edit Requisitions</b><br />Click here to modify the selected Requisition'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditImsRequisition(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-imsRequisition',
					tooltip:'<?php __('<b>Delete Requisitions(s)</b><br />Click here to remove the selected Requisition(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Requisition'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteImsRequisition(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Requisition'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Requisitions'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteImsRequisition(sel_ids);
										}
									}
								});
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Post'); ?>',
					id: 'post-imsRequisition',
					tooltip:'<?php __('<b>Post Requisitions</b><br />Click here to post the selected Requisition'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							PostRequisition(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbsplit',
					text: '<?php __('View Requisition'); ?>',
					id: 'view-imsRequisition',
					tooltip:'<?php __('<b>View Requisition</b><br />Click here to see details of the selected Requisition'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {						
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewImsRequisition(sel.data.id);
						};
					},
					menu : {
						items: [
{
							text: '<?php __('View Requisition Items'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							id: 'view-imsRequisitionItems',
							disabled: true,
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){								
									ViewParentImsRequisitionItems(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('View SIRV'); ?>',
					id: 'view-imsSIRV',
					tooltip:'<?php __('<b>View SIRV</b><br />Click here to see details of the selected SIRV'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {						
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewImsSIRV(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Receive'); ?>',
					id: 'receive',
					tooltip:'<?php __('<b>Receive</b><br />Click here to receive the items'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {						
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							Receive(sel.data.id);
						};
					}
				}, ' ', '-',  '<?php __('BudgetYear'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($budget_years as $item){if($st) echo ",
							";?>['<?php echo $item['BudgetYear']['id']; ?>' ,'<?php echo $item['BudgetYear']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_imsRequisitions.reload({
								params: {
									start: 0,
									limit: list_size,
									budgetyear_id : combo.getValue()
								}
							});
						}
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<b><style="color:green"><?php __('Help'); ?></style></b>',
					id: 'help-imsRequisition',
					tooltip:'<?php __('<b>Help </b><br />Click here to see the help document'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: false,
					handler: function(btn) {
						Help();
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'imsRequisition_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByImsRequisitionName(Ext.getCmp('imsRequisition_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'imsRequisition_go_button',
					handler: function(){
						SearchByImsRequisitionName(Ext.getCmp('imsRequisition_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchImsRequisition();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_imsRequisitions,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('view-imsRequisition').enable();
		if(this.getSelections()[0].data.status == 'created'){
			p.getTopToolbar().findById('edit-imsRequisition').enable();
			p.getTopToolbar().findById('delete-imsRequisition').enable();
			p.getTopToolbar().findById('post-imsRequisition').enable();
			Ext.getCmp('view-imsRequisitionItems').enable();
		}
		if(this.getSelections()[0].data.status == 'SIRV created'){
			p.getTopToolbar().findById('view-imsSIRV').enable();
		}
		if(this.getSelections()[0].data.status == 'accepted'){
			p.getTopToolbar().findById('receive').enable();
		}
		if(this.getSelections().length > 1){			
			p.getTopToolbar().findById('edit-imsRequisition').disable();
			p.getTopToolbar().findById('post-imsRequisition').disable();
			p.getTopToolbar().findById('view-imsRequisition').disable();
			Ext.getCmp('view-imsRequisitionItems').disable();
			p.getTopToolbar().findById('delete-imsRequisition').disable();
			p.getTopToolbar().findById('view-imsSIRV').disable();
			p.getTopToolbar().findById('receive').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsRequisition').disable();
			p.getTopToolbar().findById('post-imsRequisition').disable();
			p.getTopToolbar().findById('view-imsRequisition').disable();
			p.getTopToolbar().findById('delete-imsRequisition').disable();
			Ext.getCmp('view-imsRequisitionItems').disable();
			p.getTopToolbar().findById('view-imsSIRV').disable();
			p.getTopToolbar().findById('receive').disable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('view-imsRequisition').enable();
			if(this.getSelections()[0].data.status == 'created'){
				p.getTopToolbar().findById('edit-imsRequisition').enable();
				p.getTopToolbar().findById('post-imsRequisition').enable();				
				p.getTopToolbar().findById('delete-imsRequisition').enable();
				Ext.getCmp('view-imsRequisitionItems').enable();
			}
			if(this.getSelections()[0].data.status == 'SIRV created'){
				p.getTopToolbar().findById('view-imsSIRV').enable();
			}
			if(this.getSelections()[0].data.status == 'accepted'){
				p.getTopToolbar().findById('receive').enable();
			}
		}
		else{
			p.getTopToolbar().findById('edit-imsRequisition').disable();
			p.getTopToolbar().findById('post-imsRequisition').disable();
			p.getTopToolbar().findById('view-imsRequisition').disable();
			p.getTopToolbar().findById('delete-imsRequisition').disable();
			Ext.getCmp('view-imsRequisitionItems').disable();
			p.getTopToolbar().findById('view-imsSIRV').disable();
			p.getTopToolbar().findById('receive').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_imsRequisitions.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
