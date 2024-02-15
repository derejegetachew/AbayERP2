
var store_imsDisposals = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','status','ims_store','created_by','approved_by','user_id','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsDisposals', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'ims_store'
});


function AddImsDisposal() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsDisposals', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var imsDisposal_data = response.responseText;
			
			eval(imsDisposal_data);
			
			ImsDisposalAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsDisposal add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditImsDisposal(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsDisposals', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var imsDisposal_data = response.responseText;
			
			eval(imsDisposal_data);
			
			ImsDisposalEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsDisposal edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsDisposal(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsDisposals', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var imsDisposal_data = response.responseText;

            eval(imsDisposal_data);

            ImsDisposalViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsDisposal view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentImsDisposalItems(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsDisposalItems', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_imsDisposalItems_data = response.responseText;

            eval(parent_imsDisposalItems_data);

            parentImsDisposalItemsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteImsDisposal(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsDisposals', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsDisposal successfully deleted!'); ?>');
			RefreshImsDisposalData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsDisposal add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchImsDisposal(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsDisposals', 'action' => 'search')); ?>',
		success: function(response, opts){
			var imsDisposal_data = response.responseText;

			eval(imsDisposal_data);

			imsDisposalSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the imsDisposal search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByImsDisposalName(value){
	var conditions = '\'ImsDisposal.name LIKE\' => \'%' + value + '%\'';
	store_imsDisposals.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshImsDisposalData() {
	store_imsDisposals.reload();
}

function PostDisposal(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_disposals', 'action' => 'post')); ?>/'+id,
            success: function(response, opts) {
                Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Disposal successfully posted!'); ?>');
                RefreshImsDisposalData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Please report this error to Administrator. Cannot post the disposal. Error code'); ?>: ' + response.status);
            }
	});
}

if(center_panel.find('id', 'imsDisposal-tab') != "") {
	var p = center_panel.findById('imsDisposal-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Disposals'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'imsDisposal-tab',
		xtype: 'grid',
		store: store_imsDisposals,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true},
			{header: "<?php __('Store'); ?>", dataIndex: 'ims_store', sortable: true},
			{header: "<?php __('Created By'); ?>", dataIndex: 'created_by', sortable: true},
			{header: "<?php __('Approved By'); ?>", dataIndex: 'approved_by', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Disposals" : "Disposal"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewImsDisposal(Ext.getCmp('imsDisposal-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Disposals</b><br />Click here to create a new Disposal'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddImsDisposal();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-imsDisposal',
					tooltip:'<?php __('<b>Edit Disposals</b><br />Click here to modify the selected Disposal'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditImsDisposal(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-imsDisposal',
					tooltip:'<?php __('<b>Delete Disposals(s)</b><br />Click here to remove the selected Disposal(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Disposal'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteImsDisposal(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Disposal'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Disposals'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteImsDisposal(sel_ids);
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
					id: 'post-imsDisposal',
					tooltip:'<?php __('<b>Post Disposals</b><br />Click here to post the selected Disposal'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							PostDisposal(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbsplit',
					text: '<?php __('View Disposal'); ?>',
					id: 'view-imsDisposal',
					tooltip:'<?php __('<b>View Disposal</b><br />Click here to see details of the selected Disposal'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewImsDisposal(sel.data.id);
						};
					},
					menu : {
						items: [
{
							text: '<?php __('View Disposal Items'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentImsDisposalItems(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-',  '<?php __('Store'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($ims_stores as $item){if($st) echo ",
							";?>['<?php echo $item['ImsStore']['id']; ?>' ,'<?php echo $item['ImsStore']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_imsDisposals.reload({
								params: {
									start: 0,
									limit: list_size,
									imsstore_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'imsDisposal_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByImsDisposalName(Ext.getCmp('imsDisposal_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'imsDisposal_go_button',
					handler: function(){
						SearchByImsDisposalName(Ext.getCmp('imsDisposal_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchImsDisposal();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_imsDisposals,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		if(this.getSelections()[0].data.status == 'created' && this.getSelections()[0].data.user_id == <?php echo $user; ?>){
			//p.getTopToolbar().findById('edit-imsDisposal').enable();
			p.getTopToolbar().findById('delete-imsDisposal').enable();
			p.getTopToolbar().findById('post-imsDisposal').enable();
			p.getTopToolbar().findById('view-imsDisposal').enable();
		}
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsDisposal').disable();
			p.getTopToolbar().findById('view-imsDisposal').disable();
			p.getTopToolbar().findById('post-imsDisposal').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsDisposal').disable();
			p.getTopToolbar().findById('view-imsDisposal').disable();
			p.getTopToolbar().findById('delete-imsDisposal').disable();
			p.getTopToolbar().findById('post-imsDisposal').disable();
		}
		else if(this.getSelections().length == 1){
			if(this.getSelections()[0].data.status == 'created' && this.getSelections()[0].data.user_id == <?php echo $user; ?>){
				//p.getTopToolbar().findById('edit-imsDisposal').enable();
				p.getTopToolbar().findById('view-imsDisposal').enable();
				p.getTopToolbar().findById('delete-imsDisposal').enable();
				p.getTopToolbar().findById('post-imsDisposal').enable();
			}
		}
		else{
			p.getTopToolbar().findById('edit-imsDisposal').disable();
			p.getTopToolbar().findById('view-imsDisposal').disable();
			p.getTopToolbar().findById('delete-imsDisposal').disable();
			p.getTopToolbar().findById('post-imsDisposal').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_imsDisposals.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
