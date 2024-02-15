
var store_dmsGroups = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','user','public','created'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsGroups', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'user_id'
});


function AddDmsGroup() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsGroups', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var dmsGroup_data = response.responseText;
			
			eval(dmsGroup_data);
			
			DmsGroupAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsGroup add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditDmsGroup(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsGroups', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var dmsGroup_data = response.responseText;
			
			eval(dmsGroup_data);
			
			DmsGroupEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsGroup edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewDmsGroup(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'dmsGroups', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var dmsGroup_data = response.responseText;

            eval(dmsGroup_data);

            DmsGroupViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsGroup view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentDmsGroupLists(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'dmsGroupLists', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_dmsGroupLists_data = response.responseText;

            eval(parent_dmsGroupLists_data);

            parentDmsGroupListsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteDmsGroup(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsGroups', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('DmsGroup successfully deleted!'); ?>');
			RefreshDmsGroupData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsGroup add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchDmsGroup(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsGroups', 'action' => 'search')); ?>',
		success: function(response, opts){
			var dmsGroup_data = response.responseText;

			eval(dmsGroup_data);

			dmsGroupSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the dmsGroup search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByDmsGroupName(value){
	var conditions = '\'DmsGroup.name LIKE\' => \'%' + value + '%\'';
	store_dmsGroups.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshDmsGroupData() {
	store_dmsGroups.reload();
}


if(center_panel.find('id', 'dmsGroup-tab') != "") {
	var p = center_panel.findById('dmsGroup-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Dms Groups'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'dmsGroup-tab',
		xtype: 'grid',
		store: store_dmsGroups,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('User'); ?>", dataIndex: 'user', sortable: true},
			{header: "<?php __('Public'); ?>", dataIndex: 'public', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "DmsGroups" : "DmsGroup"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewDmsGroup(Ext.getCmp('dmsGroup-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add DmsGroups</b><br />Click here to create a new DmsGroup'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddDmsGroup();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-dmsGroup',
					tooltip:'<?php __('<b>Edit DmsGroups</b><br />Click here to modify the selected DmsGroup'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditDmsGroup(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-dmsGroup',
					tooltip:'<?php __('<b>Delete DmsGroups(s)</b><br />Click here to remove the selected DmsGroup(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove DmsGroup'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteDmsGroup(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove DmsGroup'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected DmsGroups'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteDmsGroup(sel_ids);
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
					text: '<?php __('View DmsGroup'); ?>',
					id: 'view-dmsGroup',
					tooltip:'<?php __('<b>View DmsGroup</b><br />Click here to see details of the selected DmsGroup'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewDmsGroup(sel.data.id);
						};
					},
					menu : {
						items: [
{
							text: '<?php __('View Dms Group Lists'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentDmsGroupLists(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-',  '<?php __('User'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($users as $item){if($st) echo ",
							";?>['<?php echo $item['User']['id']; ?>' ,'<?php echo $item['User']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_dmsGroups.reload({
								params: {
									start: 0,
									limit: list_size,
									user_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'dmsGroup_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByDmsGroupName(Ext.getCmp('dmsGroup_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'dmsGroup_go_button',
					handler: function(){
						SearchByDmsGroupName(Ext.getCmp('dmsGroup_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchDmsGroup();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_dmsGroups,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-dmsGroup').enable();
		p.getTopToolbar().findById('delete-dmsGroup').enable();
		p.getTopToolbar().findById('view-dmsGroup').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-dmsGroup').disable();
			p.getTopToolbar().findById('view-dmsGroup').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-dmsGroup').disable();
			p.getTopToolbar().findById('view-dmsGroup').disable();
			p.getTopToolbar().findById('delete-dmsGroup').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-dmsGroup').enable();
			p.getTopToolbar().findById('view-dmsGroup').enable();
			p.getTopToolbar().findById('delete-dmsGroup').enable();
		}
		else{
			p.getTopToolbar().findById('edit-dmsGroup').disable();
			p.getTopToolbar().findById('view-dmsGroup').disable();
			p.getTopToolbar().findById('delete-dmsGroup').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_dmsGroups.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
