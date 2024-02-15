
var store_fmsMaintenanceRequests = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','company','fms_vehicle','km','damage_type','examination','notifier','confirmer','approver','status','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'fmsMaintenanceRequests', 'action' => 'list_data')); ?>'
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

function PostMaintenanceRequest(id) {
		Ext.Ajax.request({
				url: '<?php echo $this->Html->url(array('controller' => 'fmsMaintenanceRequests', 'action' => 'post')); ?>/'+id,
				success: function(response, opts) {
					Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Maintenance Request successfully posted!'); ?>');
					RefreshFmsMaintenanceRequestData();
				},
				failure: function(response, opts) {
					Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Please report this error to Administrator. Cannot post the Maintenance Request. Error code'); ?>: ' + response.status);
				}
		});
    }

if(center_panel.find('id', 'fmsMaintenanceRequest-tab') != "") {
	var p = center_panel.findById('fmsMaintenanceRequest-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Maintenance Requests'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'fmsMaintenanceRequest-tab',
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
				ViewFmsMaintenanceRequest(Ext.getCmp('fmsMaintenanceRequest-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Maintenance Requests</b><br />Click here to create a new Maintenance Request'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddFmsMaintenanceRequest();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-fmsMaintenanceRequest',
					tooltip:'<?php __('<b>Edit Maintenanc eRequests</b><br />Click here to modify the selected Maintenance Request'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditFmsMaintenanceRequest(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-fmsMaintenanceRequest',
					tooltip:'<?php __('<b>Delete Maintenance Requests(s)</b><br />Click here to remove the selected Maintenance Request(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Maintenance Request'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.fms_vehicle+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteFmsMaintenanceRequest(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Maintenance Request'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Maintenance Requests'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteFmsMaintenanceRequest(sel_ids);
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
					id: 'post-fmsMaintenance',
					tooltip:'<?php __('<b>Post Maintenance Request</b><br />Click here to post the selected Maintenance Request'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							PostMaintenanceRequest(sel.data.id);
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
		if(this.getSelections()[0].data.status == 'created'){
			p.getTopToolbar().findById('edit-fmsMaintenanceRequest').enable();
			p.getTopToolbar().findById('delete-fmsMaintenanceRequest').enable();
			p.getTopToolbar().findById('post-fmsMaintenance').enable();
		}
		p.getTopToolbar().findById('view-fmsMaintenanceRequest').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-fmsMaintenanceRequest').disable();
			p.getTopToolbar().findById('view-fmsMaintenanceRequest').disable();
			p.getTopToolbar().findById('post-fmsMaintenance').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-fmsMaintenanceRequest').disable();
			p.getTopToolbar().findById('view-fmsMaintenanceRequest').disable();
			p.getTopToolbar().findById('delete-fmsMaintenanceRequest').enable();
			p.getTopToolbar().findById('post-fmsMaintenance').disable();
		}
		else if(this.getSelections().length == 1){
			if(this.getSelections()[0].data.status == 'created'){
				p.getTopToolbar().findById('edit-fmsMaintenanceRequest').enable();
				p.getTopToolbar().findById('post-fmsMaintenance').enable();
				p.getTopToolbar().findById('delete-fmsMaintenanceRequest').enable();
			}
			p.getTopToolbar().findById('view-fmsMaintenanceRequest').enable();
		}
		else{
			p.getTopToolbar().findById('edit-fmsMaintenanceRequest').disable();
			p.getTopToolbar().findById('view-fmsMaintenanceRequest').disable();
			p.getTopToolbar().findById('delete-fmsMaintenanceRequest').disable();
			p.getTopToolbar().findById('post-fmsMaintenance').disable();
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
