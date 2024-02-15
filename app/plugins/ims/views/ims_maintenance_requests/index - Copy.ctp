
var store_imsMaintenanceRequests = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','branch','description','requested_by','approved_rejected_by','status','ims_item','tag','branch_recommendation','technician_recommendation','remark','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsMaintenanceRequests', 'action' => 'list_data')); ?>'
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
		url: '<?php echo $this->Html->url(array('controller' => 'imsMaintenanceRequests', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var imsMaintenanceRequest_data = response.responseText;
			
			eval(imsMaintenanceRequest_data);
			
			ImsMaintenanceRequestEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsMaintenanceRequest edit form. Error code'); ?>: ' + response.status);
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


if(center_panel.find('id', 'imsMaintenanceRequest-tab') != "") {
	var p = center_panel.findById('imsMaintenanceRequest-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Ims Maintenance Requests'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'imsMaintenanceRequest-tab',
		xtype: 'grid',
		store: store_imsMaintenanceRequests,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true},
			{header: "<?php __('Description'); ?>", dataIndex: 'description', sortable: true},
			{header: "<?php __('Requested By'); ?>", dataIndex: 'requested_by', sortable: true},
			{header: "<?php __('Approved Rejected By'); ?>", dataIndex: 'approved_rejected_by', sortable: true},
			{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true},
			{header: "<?php __('ImsItem'); ?>", dataIndex: 'ims_item', sortable: true},
			{header: "<?php __('Tag'); ?>", dataIndex: 'tag', sortable: true},
			{header: "<?php __('Branch Recommendation'); ?>", dataIndex: 'branch_recommendation', sortable: true},
			{header: "<?php __('Technician Recommendation'); ?>", dataIndex: 'technician_recommendation', sortable: true},
			{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "ImsMaintenanceRequests" : "ImsMaintenanceRequest"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewImsMaintenanceRequest(Ext.getCmp('imsMaintenanceRequest-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add ImsMaintenanceRequests</b><br />Click here to create a new ImsMaintenanceRequest'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddImsMaintenanceRequest();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-imsMaintenanceRequest',
					tooltip:'<?php __('<b>Edit ImsMaintenanceRequests</b><br />Click here to modify the selected ImsMaintenanceRequest'); ?>',
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
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-imsMaintenanceRequest',
					tooltip:'<?php __('<b>Delete ImsMaintenanceRequests(s)</b><br />Click here to remove the selected ImsMaintenanceRequest(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove ImsMaintenanceRequest'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteImsMaintenanceRequest(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove ImsMaintenanceRequest'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected ImsMaintenanceRequests'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteImsMaintenanceRequest(sel_ids);
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
					text: '<?php __('View ImsMaintenanceRequest'); ?>',
					id: 'view-imsMaintenanceRequest',
					tooltip:'<?php __('<b>View ImsMaintenanceRequest</b><br />Click here to see details of the selected ImsMaintenanceRequest'); ?>',
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
				}, ' ', '-',  '<?php __('Branch'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($branches as $item){if($st) echo ",
							";?>['<?php echo $item['Branch']['id']; ?>' ,'<?php echo $item['Branch']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_imsMaintenanceRequests.reload({
								params: {
									start: 0,
									limit: list_size,
									branch_id : combo.getValue()
								}
							});
						}
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
		p.getTopToolbar().findById('edit-imsMaintenanceRequest').enable();
		p.getTopToolbar().findById('delete-imsMaintenanceRequest').enable();
		p.getTopToolbar().findById('view-imsMaintenanceRequest').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsMaintenanceRequest').disable();
			p.getTopToolbar().findById('view-imsMaintenanceRequest').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsMaintenanceRequest').disable();
			p.getTopToolbar().findById('view-imsMaintenanceRequest').disable();
			p.getTopToolbar().findById('delete-imsMaintenanceRequest').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-imsMaintenanceRequest').enable();
			p.getTopToolbar().findById('view-imsMaintenanceRequest').enable();
			p.getTopToolbar().findById('delete-imsMaintenanceRequest').enable();
		}
		else{
			p.getTopToolbar().findById('edit-imsMaintenanceRequest').disable();
			p.getTopToolbar().findById('view-imsMaintenanceRequest').disable();
			p.getTopToolbar().findById('delete-imsMaintenanceRequest').disable();
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
