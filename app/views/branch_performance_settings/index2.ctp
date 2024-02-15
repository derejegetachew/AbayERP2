var store_parent_branchPerformanceSettings = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','position','goal','measure','target','weight','five_pointer_min','five_pointer_max_included','four_pointer_min','four_pointer_max_included','three_pointer_min','three_pointer_max_included','two_pointer_min','two_pointer_max_included','one_pointer_min','one_pointer_max_included','is_active'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceSettings', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentBranchPerformanceSetting() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceSettings', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_branchPerformanceSetting_data = response.responseText;
			
			eval(parent_branchPerformanceSetting_data);
			
			BranchPerformanceSettingAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformanceSetting add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentBranchPerformanceSetting(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceSettings', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_branchPerformanceSetting_data = response.responseText;
			
			eval(parent_branchPerformanceSetting_data);
			
			BranchPerformanceSettingEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformanceSetting edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewBranchPerformanceSetting(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceSettings', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var branchPerformanceSetting_data = response.responseText;

			eval(branchPerformanceSetting_data);

			BranchPerformanceSettingViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformanceSetting view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentBranchPerformanceSetting(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceSettings', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('BranchPerformanceSetting(s) successfully deleted!'); ?>');
			RefreshParentBranchPerformanceSettingData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformanceSetting to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentBranchPerformanceSettingName(value){
	var conditions = '\'BranchPerformanceSetting.name LIKE\' => \'%' + value + '%\'';
	store_parent_branchPerformanceSettings.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentBranchPerformanceSettingData() {
	store_parent_branchPerformanceSettings.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('BranchPerformanceSettings'); ?>',
	store: store_parent_branchPerformanceSettings,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'branchPerformanceSettingGrid',
	columns: [
		{header:"<?php __('position'); ?>", dataIndex: 'position', sortable: true},
		{header: "<?php __('Goal'); ?>", dataIndex: 'goal', sortable: true},
		{header: "<?php __('Measure'); ?>", dataIndex: 'measure', sortable: true},
		{header: "<?php __('Target'); ?>", dataIndex: 'target', sortable: true},
		{header: "<?php __('Weight'); ?>", dataIndex: 'weight', sortable: true},
		{header: "<?php __('Five Pointer Min'); ?>", dataIndex: 'five_pointer_min', sortable: true},
		{header: "<?php __('Five Pointer Max Included'); ?>", dataIndex: 'five_pointer_max_included', sortable: true},
		{header: "<?php __('Four Pointer Min'); ?>", dataIndex: 'four_pointer_min', sortable: true},
		{header: "<?php __('Four Pointer Max Included'); ?>", dataIndex: 'four_pointer_max_included', sortable: true},
		{header: "<?php __('Three Pointer Min'); ?>", dataIndex: 'three_pointer_min', sortable: true},
		{header: "<?php __('Three Pointer Max Included'); ?>", dataIndex: 'three_pointer_max_included', sortable: true},
		{header: "<?php __('Two Pointer Min'); ?>", dataIndex: 'two_pointer_min', sortable: true},
		{header: "<?php __('Two Pointer Max Included'); ?>", dataIndex: 'two_pointer_max_included', sortable: true},
		{header: "<?php __('One Pointer Min'); ?>", dataIndex: 'one_pointer_min', sortable: true},
		{header: "<?php __('One Pointer Max Included'); ?>", dataIndex: 'one_pointer_max_included', sortable: true},
		{header: "<?php __('Is Active'); ?>", dataIndex: 'is_active', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewBranchPerformanceSetting(Ext.getCmp('branchPerformanceSettingGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add BranchPerformanceSetting</b><br />Click here to create a new BranchPerformanceSetting'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentBranchPerformanceSetting();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-branchPerformanceSetting',
				tooltip:'<?php __('<b>Edit BranchPerformanceSetting</b><br />Click here to modify the selected BranchPerformanceSetting'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentBranchPerformanceSetting(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-branchPerformanceSetting',
				tooltip:'<?php __('<b>Delete BranchPerformanceSetting(s)</b><br />Click here to remove the selected BranchPerformanceSetting(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove BranchPerformanceSetting'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentBranchPerformanceSetting(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove BranchPerformanceSetting'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected BranchPerformanceSetting'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentBranchPerformanceSetting(sel_ids);
											}
									}
							});
						}
					} else {
						Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
					};
				}
			}, ' ','-',' ', {
				xtype: 'tbsplit',
				text: '<?php __('View BranchPerformanceSetting'); ?>',
				id: 'view-branchPerformanceSetting2',
				tooltip:'<?php __('<b>View BranchPerformanceSetting</b><br />Click here to see details of the selected BranchPerformanceSetting'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewBranchPerformanceSetting(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_branchPerformanceSetting_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentBranchPerformanceSettingName(Ext.getCmp('parent_branchPerformanceSetting_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_branchPerformanceSetting_go_button',
				handler: function(){
					SearchByParentBranchPerformanceSettingName(Ext.getCmp('parent_branchPerformanceSetting_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_branchPerformanceSettings,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-branchPerformanceSetting').enable();
	g.getTopToolbar().findById('delete-parent-branchPerformanceSetting').enable();
        g.getTopToolbar().findById('view-branchPerformanceSetting2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-branchPerformanceSetting').disable();
                g.getTopToolbar().findById('view-branchPerformanceSetting2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-branchPerformanceSetting').disable();
		g.getTopToolbar().findById('delete-parent-branchPerformanceSetting').enable();
                g.getTopToolbar().findById('view-branchPerformanceSetting2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-branchPerformanceSetting').enable();
		g.getTopToolbar().findById('delete-parent-branchPerformanceSetting').enable();
                g.getTopToolbar().findById('view-branchPerformanceSetting2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-branchPerformanceSetting').disable();
		g.getTopToolbar().findById('delete-parent-branchPerformanceSetting').disable();
                g.getTopToolbar().findById('view-branchPerformanceSetting2').disable();
	}
});



var parentBranchPerformanceSettingsViewWindow = new Ext.Window({
	title: 'BranchPerformanceSetting Under the selected Item',
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
			parentBranchPerformanceSettingsViewWindow.close();
		}
	}]
});

store_parent_branchPerformanceSettings.load({
    params: {
        start: 0,    
        limit: list_size
    }
});