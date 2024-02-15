
var store_dmsGroupLists = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','user','dms_group'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsGroupLists', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'user_id', direction: "ASC"},
	groupField: 'dms_group_id'
});


function AddDmsGroupList() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsGroupLists', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var dmsGroupList_data = response.responseText;
			
			eval(dmsGroupList_data);
			
			DmsGroupListAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsGroupList add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditDmsGroupList(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsGroupLists', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var dmsGroupList_data = response.responseText;
			
			eval(dmsGroupList_data);
			
			DmsGroupListEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsGroupList edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewDmsGroupList(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'dmsGroupLists', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var dmsGroupList_data = response.responseText;

            eval(dmsGroupList_data);

            DmsGroupListViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsGroupList view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteDmsGroupList(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsGroupLists', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('DmsGroupList successfully deleted!'); ?>');
			RefreshDmsGroupListData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsGroupList add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchDmsGroupList(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsGroupLists', 'action' => 'search')); ?>',
		success: function(response, opts){
			var dmsGroupList_data = response.responseText;

			eval(dmsGroupList_data);

			dmsGroupListSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the dmsGroupList search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByDmsGroupListName(value){
	var conditions = '\'DmsGroupList.name LIKE\' => \'%' + value + '%\'';
	store_dmsGroupLists.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshDmsGroupListData() {
	store_dmsGroupLists.reload();
}


if(center_panel.find('id', 'dmsGroupList-tab') != "") {
	var p = center_panel.findById('dmsGroupList-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Dms Group Lists'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'dmsGroupList-tab',
		xtype: 'grid',
		store: store_dmsGroupLists,
		columns: [
			{header: "<?php __('User'); ?>", dataIndex: 'user', sortable: true},
			{header: "<?php __('DmsGroup'); ?>", dataIndex: 'dms_group', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "DmsGroupLists" : "DmsGroupList"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewDmsGroupList(Ext.getCmp('dmsGroupList-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add DmsGroupLists</b><br />Click here to create a new DmsGroupList'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddDmsGroupList();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-dmsGroupList',
					tooltip:'<?php __('<b>Edit DmsGroupLists</b><br />Click here to modify the selected DmsGroupList'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditDmsGroupList(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-dmsGroupList',
					tooltip:'<?php __('<b>Delete DmsGroupLists(s)</b><br />Click here to remove the selected DmsGroupList(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove DmsGroupList'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteDmsGroupList(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove DmsGroupList'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected DmsGroupLists'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteDmsGroupList(sel_ids);
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
					text: '<?php __('View DmsGroupList'); ?>',
					id: 'view-dmsGroupList',
					tooltip:'<?php __('<b>View DmsGroupList</b><br />Click here to see details of the selected DmsGroupList'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewDmsGroupList(sel.data.id);
						};
					},
					menu : {
						items: [
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
							store_dmsGroupLists.reload({
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
					id: 'dmsGroupList_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByDmsGroupListName(Ext.getCmp('dmsGroupList_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'dmsGroupList_go_button',
					handler: function(){
						SearchByDmsGroupListName(Ext.getCmp('dmsGroupList_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchDmsGroupList();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_dmsGroupLists,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-dmsGroupList').enable();
		p.getTopToolbar().findById('delete-dmsGroupList').enable();
		p.getTopToolbar().findById('view-dmsGroupList').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-dmsGroupList').disable();
			p.getTopToolbar().findById('view-dmsGroupList').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-dmsGroupList').disable();
			p.getTopToolbar().findById('view-dmsGroupList').disable();
			p.getTopToolbar().findById('delete-dmsGroupList').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-dmsGroupList').enable();
			p.getTopToolbar().findById('view-dmsGroupList').enable();
			p.getTopToolbar().findById('delete-dmsGroupList').enable();
		}
		else{
			p.getTopToolbar().findById('edit-dmsGroupList').disable();
			p.getTopToolbar().findById('view-dmsGroupList').disable();
			p.getTopToolbar().findById('delete-dmsGroupList').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_dmsGroupLists.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
