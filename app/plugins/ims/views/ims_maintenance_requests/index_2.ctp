
var store_imsMaintenanceRequests = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','branch','description','requested_by','approved_rejected_by','received_by','status','ims_item','tag','branch_recommendation','technician_recommendation','remark','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsMaintenanceRequests', 'action' => 'list_data_2')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"}
});


function AddImsMaintenanceRequest() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsMaintenanceRequests', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var imsMaintenanceRequest_data = response.responseText;
			
			eval(imsMaintenanceRequest_data);
			
			ImsMaintenanceRequestAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsMaintenanceRequest add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditImsMaintenanceRequest(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsMaintenanceRequests', 'action' => 'edit_1')); ?>/'+id,
		success: function(response, opts) {
			var imsMaintenanceRequest_data = response.responseText;
			
			eval(imsMaintenanceRequest_data);
			
			ImsMaintenanceRequestEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsMaintenanceRequest spare-part form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsMaintenanceRequest(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsMaintenanceRequests', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var imsMaintenanceRequest_data = response.responseText;

            eval(imsMaintenanceRequest_data);

            ImsMaintenanceRequestViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsMaintenanceRequest view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteImsMaintenanceRequest(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsMaintenanceRequests', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsMaintenanceRequest successfully deleted!'); ?>');
			RefreshImsMaintenanceRequestData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsMaintenanceRequest add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchImsMaintenanceRequest(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsMaintenanceRequests', 'action' => 'search')); ?>',
		success: function(response, opts){
			var imsMaintenanceRequest_data = response.responseText;

			eval(imsMaintenanceRequest_data);

			imsMaintenanceRequestSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the imsMaintenanceRequest search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByImsMaintenanceRequestName(value){
	var conditions = '\'ImsMaintenanceRequest.name LIKE\' => \'%' + value + '%\'';
	store_imsMaintenanceRequests.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshImsMaintenanceRequestData() {
	store_imsMaintenanceRequests.reload();
}

function AcceptMaintenanceRequisition(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'imsMaintenanceRequests', 'action' => 'accept')); ?>/'+id,
            success: function(response, opts) {
                Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Maintenance Request successfully accepted!'); ?>');
                RefreshImsMaintenanceRequestData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Please report this error to Administrator. Cannot accept the Maintenance Request. Error code'); ?>: ' + response.status);
            }
	});
}

function CompleteMaintenanceRequisition(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'imsMaintenanceRequests', 'action' => 'complete')); ?>/'+id,
            success: function(response, opts) {
                Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Maintenance Request successfully Completed!'); ?>');
                RefreshImsMaintenanceRequestData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Please report this error to Administrator. Cannot Complete the Maintenance Request. Error code'); ?>: ' + response.status);
            }
	});
}

if(center_panel.find('id', 'imsAllMaintenanceRequest-tab') != "") {
	var p = center_panel.findById('imsAllMaintenanceRequest-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Maintenance Requests'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'imsAllMaintenanceRequest-tab',
		xtype: 'grid',
		store: store_imsMaintenanceRequests,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true},
			{header: "<?php __('Description'); ?>", dataIndex: 'description', sortable: true},
			{header: "<?php __('Requested By'); ?>", dataIndex: 'requested_by', sortable: true},
			{header: "<?php __('Approved Rejected By'); ?>", dataIndex: 'approved_rejected_by', sortable: true},
			{header: "<?php __('Received By'); ?>", dataIndex: 'received_by', sortable: true},
			{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true},
			{header: "<?php __('Item'); ?>", dataIndex: 'ims_item', sortable: true},
			{header: "<?php __('Tag'); ?>", dataIndex: 'tag', sortable: true},
			{header: "<?php __('Branch Recommendation'); ?>", dataIndex: 'branch_recommendation', sortable: true},
			{header: "<?php __('Technician Recommendation'); ?>", dataIndex: 'technician_recommendation', sortable: true},
			{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "ImsMaintenanceRequests" : "ImsMaintenanceRequest"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewImsMaintenanceRequest(Ext.getCmp('imsAllMaintenanceRequest-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
                        xtype: 'tbbutton',
                        text: '<?php __('Accept'); ?>',
                        id: 'accept-request',
                        tooltip:'<?php __('<b>Accept Maintenance Request</b><br />Click here to Accept the selected Maintenance Request'); ?>',
                        icon: 'img/table_edit.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelected();
                            if (sm.hasSelection()){
                                Ext.Msg.show({
                                    title: '<?php __('Accept Maintenance Request'); ?>',
                                    buttons: Ext.MessageBox.YESNO,
                                    msg: '<?php __('Accept'); ?> '+sel.data.name+'?',
                                    icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
                                        if (btn == 'yes'){
                                           AcceptMaintenanceRequisition(sel.data.id);
                                        }
                                    }
                                });
                            };
                        }
                }, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Spare-part'); ?>',
					id: 'edit-imsMaintenanceRequest',
					tooltip:'<?php __('<b>Spare-part recommendation</b><br />Click here to recommend Spare-part'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditImsMaintenanceRequest(sel.data.id);
						};
					}
				},' ', '-', ' ',{
                        xtype: 'tbbutton',
                        text: '<?php __('Complete'); ?>',
                        id: 'complete-request',
                        tooltip:'<?php __('<b>Complete Maintenance Request</b><br />Click here to Complete the selected Maintenance Request'); ?>',
                        icon: 'img/table_edit.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelected();
                            if (sm.hasSelection()){
                                Ext.Msg.show({
                                    title: '<?php __('Complete Maintenance Request'); ?>',
                                    buttons: Ext.MessageBox.YESNO,
                                    msg: '<?php __('Complete'); ?> '+sel.data.name+'?',
                                    icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
                                        if (btn == 'yes'){
                                           CompleteMaintenanceRequisition(sel.data.id);
                                        }
                                    }
                                });
                            };
                        }
                }, ' ', '-', ' ', {
					xtype: 'tbsplit',
					text: '<?php __('View Maintenance Request'); ?>',
					id: 'view-imsMaintenanceRequest',
					tooltip:'<?php __('<b>View Maintenance Request</b><br />Click here to see details of the selected Maintenance Request'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewImsMaintenanceRequest(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, 
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'imsMaintenanceRequest_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByImsMaintenanceRequestName(Ext.getCmp('imsMaintenanceRequest_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'imsMaintenanceRequest_go_button',
					handler: function(){
						SearchByImsMaintenanceRequestName(Ext.getCmp('imsMaintenanceRequest_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchImsMaintenanceRequest();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_imsMaintenanceRequests,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		if(this.getSelections()[0].data.status == 'approved'){
			p.getTopToolbar().findById('accept-request').enable();
		}
		if(this.getSelections()[0].data.status == 'accepted'){
			p.getTopToolbar().findById('edit-imsMaintenanceRequest').enable();
		}
		if(this.getSelections()[0].data.status == 'accepted' || this.getSelections()[0].data.status == 'spare-part needed'){
			p.getTopToolbar().findById('complete-request').enable();
		}
		p.getTopToolbar().findById('view-imsMaintenanceRequest').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('accept-request').disable();
			p.getTopToolbar().findById('edit-imsMaintenanceRequest').disable();
			p.getTopToolbar().findById('complete-request').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('accept-request').disable();
			p.getTopToolbar().findById('view-imsMaintenanceRequest').disable();
			p.getTopToolbar().findById('edit-imsMaintenanceRequest').disable();
			p.getTopToolbar().findById('complete-request').disable();
		}
		else if(this.getSelections().length == 1){
			if(this.getSelections()[0].data.status == 'approved'){
				p.getTopToolbar().findById('accept-request').enable();				
			}
			if(this.getSelections()[0].data.status == 'accepted'){
				p.getTopToolbar().findById('edit-imsMaintenanceRequest').enable();
			}
			if(this.getSelections()[0].data.status == 'accepted' || this.getSelections()[0].data.status == 'spare-part needed'){
				p.getTopToolbar().findById('complete-request').enable();
			}
			p.getTopToolbar().findById('view-imsMaintenanceRequest').enable();
		}
		else{
			p.getTopToolbar().findById('accept-request').disable();
			p.getTopToolbar().findById('view-imsMaintenanceRequest').disable();
			p.getTopToolbar().findById('edit-imsMaintenanceRequest').disable();
			p.getTopToolbar().findById('complete-request').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_imsMaintenanceRequests.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
