
var store_fmsMaintenanceRequests = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','company','fms_vehicle','km','damage_type','examination','notifier','confirmer','approver','status','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsMaintenanceRequests', 'action' => 'list_data2')); ?>'
	})
,	sortInfo:{field: 'company', direction: "ASC"},
	groupField: 'fms_vehicle'
});


function AddFmsMaintenanceRequest() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsMaintenanceRequests', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var fmsMaintenanceRequest_data = response.responseText;
			
			eval(fmsMaintenanceRequest_data);
			
			FmsMaintenanceRequestAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsMaintenanceRequest add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditFmsMaintenanceRequest(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsMaintenanceRequests', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var fmsMaintenanceRequest_data = response.responseText;
			
			eval(fmsMaintenanceRequest_data);
			
			FmsMaintenanceRequestEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsMaintenanceRequest edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewFmsMaintenanceRequest(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'fmsMaintenanceRequests', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var fmsMaintenanceRequest_data = response.responseText;

            eval(fmsMaintenanceRequest_data);

            FmsMaintenanceRequestViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsMaintenanceRequest view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteFmsMaintenanceRequest(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsMaintenanceRequests', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('FmsMaintenanceRequest successfully deleted!'); ?>');
			RefreshFmsMaintenanceRequestData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the fmsMaintenanceRequest add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchFmsMaintenanceRequest(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsMaintenanceRequests', 'action' => 'search')); ?>',
		success: function(response, opts){
			var fmsMaintenanceRequest_data = response.responseText;

			eval(fmsMaintenanceRequest_data);

			fmsMaintenanceRequestSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the fmsMaintenanceRequest search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByFmsMaintenanceRequestName(value){
	var conditions = '\'FmsMaintenanceRequest.name LIKE\' => \'%' + value + '%\'';
	store_fmsMaintenanceRequests.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshFmsMaintenanceRequestData() {
	store_fmsMaintenanceRequests.reload();
}

function ApproveMaintenanceRequest(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'fmsMaintenanceRequests', 'action' => 'approve')); ?>/'+id,
            success: function(response, opts) {
                Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Maintenance request successfully approved!'); ?>');
                RefreshFmsMaintenanceRequestData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Please report this error to Administrator. Cannot approve the Maintenance request. Error code'); ?>: ' + response.status);
            }
	});
}

function RejectMaintenanceRequest(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'fmsMaintenanceRequests', 'action' => 'reject')); ?>/'+id,
            success: function(response, opts) {
                Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Maintenance request successfully rejected!'); ?>');
                RefreshFmsMaintenanceRequestData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Please report this error to Administrator. Cannot reject the Maintenance request. Error code'); ?>: ' + response.status);
            }
	});
}

if(center_panel.find('id', 'fmsMaintenanceRequest-tab-approve') != "") {
	var p = center_panel.findById('fmsMaintenanceRequest-tab-approve');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Approve Maintenance Requests'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'fmsMaintenanceRequest-tab-approve',
		xtype: 'grid',
		store: store_fmsMaintenanceRequests,
		columns: [
			{header: "<?php __('Company'); ?>", dataIndex: 'company', sortable: true},
			{header: "<?php __('Vehicle'); ?>", dataIndex: 'fms_vehicle', sortable: true},
			{header: "<?php __('Km'); ?>", dataIndex: 'km', sortable: true},
			{header: "<?php __('Damage Type'); ?>", dataIndex: 'damage_type', sortable: true},
			{header: "<?php __('Examination'); ?>", dataIndex: 'examination', sortable: true},
			{header: "<?php __('Notifier'); ?>", dataIndex: 'notifier', sortable: true},
			{header: "<?php __('Confirmer'); ?>", dataIndex: 'confirmer', sortable: true},
			{header: "<?php __('Approver'); ?>", dataIndex: 'approver', sortable: true},
			{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "FmsMaintenanceRequests" : "FmsMaintenanceRequest"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewFmsMaintenanceRequest(Ext.getCmp('fmsMaintenanceRequest-tab-approve').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
                        xtype: 'tbbutton',
                        text: '<?php __('Approve'); ?>',
                        id: 'approve-maintenance',
                        tooltip:'<?php __('<b>Approve Maintenance request</b><br />Click here to approve the selected Maintenance request'); ?>',
                        icon: 'img/table_edit.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelected();
                            if (sm.hasSelection()){
                                Ext.Msg.show({
                                    title: '<?php __('Approve Maintenance request'); ?>',
                                    buttons: Ext.MessageBox.YESNO,
                                    msg: '<?php __('Approve'); ?> '+sel.data.fms_vehicle+'?',
                                    icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
                                        if (btn == 'yes'){
                                            ApproveMaintenanceRequest(sel.data.id);
                                        }
                                    }
                                });
                            };
                        }
                }, ' ', '-', ' ', {
                        xtype: 'tbbutton',
                        text: '<?php __('Reject'); ?>',
                        id: 'reject-maintenance',
                        tooltip:'<?php __('<b>Reject Maintenance request</b><br />Click here to reject the selected Maintenance request'); ?>',
                        icon: 'img/table_edit.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelected();
                            if (sm.hasSelection()){
                                Ext.Msg.show({
                                    title: '<?php __('Reject Maintenance request'); ?>',
                                    buttons: Ext.MessageBox.YESNO,
                                    msg: '<?php __('Reject'); ?> '+sel.data.fms_vehicle+'?',
                                    icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
                                        if (btn == 'yes'){
                                            RejectMaintenanceRequest(sel.data.id);
                                        }
                                    }
                                });
                            };
                        }
				}, ' ', '-', ' ', {
					xtype: 'tbsplit',
					text: '<?php __('View Maintenance Request'); ?>',
					id: 'view-fmsMaintenanceRequest',
					tooltip:'<?php __('<b>View Maintenance Request</b><br />Click here to see details of the selected Maintenance Request'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewFmsMaintenanceRequest(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('Vehicle'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($fmsvehicles as $item){if($st) echo ",
							";?>['<?php echo $item['FmsVehicle']['id']; ?>' ,'<?php echo $item['FmsVehicle']['plate_no']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_fmsMaintenanceRequests.reload({
								params: {
									start: 0,
									limit: list_size,
									fmsvehicle_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'fmsMaintenanceRequest_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByFmsMaintenanceRequestName(Ext.getCmp('fmsMaintenanceRequest_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'fmsMaintenanceRequest_go_button',
					handler: function(){
						SearchByFmsMaintenanceRequestName(Ext.getCmp('fmsMaintenanceRequest_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchFmsMaintenanceRequest();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_fmsMaintenanceRequests,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		if(this.getSelections()[0].data.status == 'posted'){
			p.getTopToolbar().findById('approve-maintenance').enable();
			p.getTopToolbar().findById('reject-maintenance').enable();
		}
		p.getTopToolbar().findById('view-fmsMaintenanceRequest').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('approve-maintenance').disable();
			p.getTopToolbar().findById('view-fmsMaintenanceRequest').disable();
			p.getTopToolbar().findById('reject-maintenance').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('approve-maintenance').disable();
			p.getTopToolbar().findById('view-fmsMaintenanceRequest').disable();
			p.getTopToolbar().findById('reject-maintenance').disable();
		}
		else if(this.getSelections().length == 1){
			if(this.getSelections()[0].data.status == 'posted'){
				p.getTopToolbar().findById('approve-maintenance').enable();
				p.getTopToolbar().findById('reject-maintenance').enable();
			}
			p.getTopToolbar().findById('view-fmsMaintenanceRequest').enable();
		}
		else{
			p.getTopToolbar().findById('approve-maintenance').disable();
			p.getTopToolbar().findById('view-fmsMaintenanceRequest').disable();
			p.getTopToolbar().findById('reject-maintenance').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_fmsMaintenanceRequests.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
