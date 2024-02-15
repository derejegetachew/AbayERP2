
var store_imsRequisitions = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','budget_year','branch','purpose','requested_by','approved/rejected_by','status','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({	
		url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitions', 'action' => 'list_data_2')); ?>'
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

function ApproveRequisition(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_requisitions', 'action' => 'approve')); ?>/'+id,
            success: function(response, opts) {
                Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Requisition successfully approved!'); ?>');
                RefreshImsRequisitionData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Please report this error to Administrator. Cannot approve the Requisition. Error code'); ?>: ' + response.status);
            }
	});
}

function RejectRequisition(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_requisitions', 'action' => 'reject')); ?>/'+id,
            success: function(response, opts) {
                Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Requisition successfully rejected!'); ?>');
                RefreshImsRequisitionData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Please report this error to Administrator. Cannot reject the Requisition. Error code'); ?>: ' + response.status);
            }
	});
}


if(center_panel.find('id', 'imsRequisition-tab2') != "") {
	var p = center_panel.findById('imsRequisition-tab2');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Approve Requisitions'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'imsRequisition-tab2',
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
				ViewImsRequisition(Ext.getCmp('imsRequisition-tab2').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
                        xtype: 'tbbutton',
                        text: '<?php __('Approve'); ?>',
                        id: 'approve-request-approve',
                        tooltip:'<?php __('<b>Approve Requisition</b><br />Click here to approve the selected requisition'); ?>',
                        icon: 'img/table_edit.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelected();
                            if (sm.hasSelection()){
                                Ext.Msg.show({
                                    title: '<?php __('Approve Requisition'); ?>',
                                    buttons: Ext.MessageBox.YESNO,
                                    msg: '<?php __('Approve'); ?> '+sel.data.name+'?',
                                    icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
                                        if (btn == 'yes'){
                                            ApproveRequisition(sel.data.id);
                                        }
                                    }
                                });
                            };
                        }
                }, ' ', '-', ' ', {
                        xtype: 'tbbutton',
                        text: '<?php __('Reject'); ?>',
                        id: 'reject-request-approve',
                        tooltip:'<?php __('<b>Reject Requisition</b><br />Click here to reject the selected Requisition'); ?>',
                        icon: 'img/table_edit.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelected();
                            if (sm.hasSelection()){
                                Ext.Msg.show({
                                    title: '<?php __('Reject Requisition'); ?>',
                                    buttons: Ext.MessageBox.YESNO,
                                    msg: '<?php __('Reject'); ?> '+sel.data.name+'?',
                                    icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
                                        if (btn == 'yes'){
                                            RejectRequisition(sel.data.id);
                                        }
                                    }
                                });
                            };
                        }
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
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
		if(this.getSelections()[0].data.status == 'posted'){
			p.getTopToolbar().findById('reject-request-approve').enable();
			p.getTopToolbar().findById('approve-request-approve').enable();
		}
		p.getTopToolbar().findById('view-imsRequisition').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('reject-request-approve').disable();
			p.getTopToolbar().findById('approve-request-approve').disable();
			p.getTopToolbar().findById('view-imsRequisition').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('reject-request-approve').disable();
			p.getTopToolbar().findById('view-imsRequisition').disable();
			p.getTopToolbar().findById('approve-request-approve').disable();
		}
		else if(this.getSelections().length == 1){
			if(this.getSelections()[0].data.status == 'posted'){
				p.getTopToolbar().findById('reject-request-approve').enable();
				p.getTopToolbar().findById('approve-request-approve').enable();
			}
			p.getTopToolbar().findById('view-imsRequisition').enable();			
		}
		else{
			p.getTopToolbar().findById('reject-request-approve').disable();
			p.getTopToolbar().findById('view-imsRequisition').disable();
			p.getTopToolbar().findById('approve-request-approve').disable();
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
