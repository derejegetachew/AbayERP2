var store_parent_dmsGroupLists = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','user','type'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsGroupLists', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentDmsGroupList() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsGroupLists', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_dmsGroupList_data = response.responseText;
			
			eval(parent_dmsGroupList_data);
			
			DmsGroupListAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsGroupList add form. Error code'); ?>: ' + response.status);
		}
	});
}
function add_position() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsGroupLists', 'action' => 'add_position', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_dmsGroupList_data = response.responseText;
			
			eval(parent_dmsGroupList_data);
			
			DmsGroupListAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsGroupList add form. Error code'); ?>: ' + response.status);
		}
	});
}
function add_branch() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsGroupLists', 'action' => 'add_branch', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_dmsGroupList_data = response.responseText;
			
			eval(parent_dmsGroupList_data);
			
			DmsGroupListAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsGroupList add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentDmsGroupList(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsGroupLists', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_dmsGroupList_data = response.responseText;
			
			eval(parent_dmsGroupList_data);
			
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


function DeleteParentDmsGroupList(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dmsGroupLists', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('DmsGroupList(s) successfully deleted!'); ?>');
			RefreshParentDmsGroupListData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the dmsGroupList to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentDmsGroupListName(value){
	var conditions = '\'DmsGroupList.name LIKE\' => \'%' + value + '%\'';
	store_parent_dmsGroupLists.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentDmsGroupListData() {
	store_parent_dmsGroupLists.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('DmsGroupLists'); ?>',
	store: store_parent_dmsGroupLists,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'dmsGroupListGrid',
	columns: [
		{header:"<?php __('user'); ?>", dataIndex: 'user', sortable: true},
		{header:"<?php __('Type'); ?>", dataIndex: 'type', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewDmsGroupList(Ext.getCmp('dmsGroupListGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add Staff'); ?>',
				tooltip:'<?php __('<b>Add DmsGroupList</b><br />Click here to create a new DmsGroupList'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentDmsGroupList();
				}
			},{
				xtype: 'tbbutton',
				text: '<?php __('Add Position Filter'); ?>',
				tooltip:'<?php __('<b>Add Position Filter</b>'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					add_position();
				}
			},{
				xtype: 'tbbutton',
				text: '<?php __('Add Branch Filter'); ?>',
				tooltip:'<?php __('<b>Add DmsGroupList</b><br />Click here to create a new DmsGroupList'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					add_branch();
				}
			}, ' ', '-', ' ',  {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-dmsGroupList',
				tooltip:'<?php __('<b>Delete DmsGroupList(s)</b><br />Click here to remove the selected DmsGroupList(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove DmsGroupList'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentDmsGroupList(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove DmsGroupList'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected DmsGroupList'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentDmsGroupList(sel_ids);
											}
									}
							});
						}
					} else {
						Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
					};
				}
			}
	]})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	//g.getTopToolbar().findById('edit-parent-dmsGroupList').enable();
	g.getTopToolbar().findById('delete-parent-dmsGroupList').enable();
        //g.getTopToolbar().findById('view-dmsGroupList2').enable();
	if(this.getSelections().length > 1){
		//g.getTopToolbar().findById('edit-parent-dmsGroupList').disable();
              //  g.getTopToolbar().findById('view-dmsGroupList2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		//g.getTopToolbar().findById('edit-parent-dmsGroupList').disable();
		g.getTopToolbar().findById('delete-parent-dmsGroupList').enable();
            //    g.getTopToolbar().findById('view-dmsGroupList2').disable();
	}
	else if(this.getSelections().length == 1){
		//g.getTopToolbar().findById('edit-parent-dmsGroupList').enable();
		g.getTopToolbar().findById('delete-parent-dmsGroupList').enable();
             //   g.getTopToolbar().findById('view-dmsGroupList2').enable();
	}
	else{
		//g.getTopToolbar().findById('edit-parent-dmsGroupList').disable();
		g.getTopToolbar().findById('delete-parent-dmsGroupList').disable();
              //  g.getTopToolbar().findById('view-dmsGroupList2').disable();
	}
});



var parentDmsGroupListsViewWindow = new Ext.Window({
	title: 'DmsGroupList Under the selected Item',
	width: 700,
	height:375,
	minWidth: 700,
	minHeight: 400,
	resizable: false,
	plain:true,
	bodyStyle:'padding:5px;',
	buttonAlign:'center',
        modal: true,
	items: [
		g
	],

	buttons: [{
		text: 'Close',
		handler: function(btn){
			parentDmsGroupListsViewWindow.close();
		}
	}]
});

store_parent_dmsGroupLists.load({
    params: {
        start: 0,    
        limit: list_size
    }
});