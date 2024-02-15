
var store_branchCategories = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'branchCategories', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'created'
});


function AddBranchCategory() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchCategories', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var branchCategory_data = response.responseText;
			
			eval(branchCategory_data);
			
			BranchCategoryAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchCategory add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditBranchCategory(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchCategories', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var branchCategory_data = response.responseText;
			
			eval(branchCategory_data);
			
			BranchCategoryEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchCategory edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewBranchCategory(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'branchCategories', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var branchCategory_data = response.responseText;

            eval(branchCategory_data);

            BranchCategoryViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchCategory view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteBranchCategory(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchCategories', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('BranchCategory successfully deleted!'); ?>');
			RefreshBranchCategoryData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchCategory add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchBranchCategory(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branchCategories', 'action' => 'search')); ?>',
		success: function(response, opts){
			var branchCategory_data = response.responseText;

			eval(branchCategory_data);

			branchCategorySearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the branchCategory search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByBranchCategoryName(value){
	var conditions = '\'BranchCategory.name LIKE\' => \'%' + value + '%\'';
	store_branchCategories.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshBranchCategoryData() {
	store_branchCategories.reload();
}


if(center_panel.find('id', 'branchCategory-tab') != "") {
	var p = center_panel.findById('branchCategory-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Branch Categories'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'branchCategory-tab',
		xtype: 'grid',
		store: store_branchCategories,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "BranchCategories" : "BranchCategory"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewBranchCategory(Ext.getCmp('branchCategory-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add BranchCategories</b><br />Click here to create a new BranchCategory'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddBranchCategory();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-branchCategory',
					tooltip:'<?php __('<b>Edit BranchCategories</b><br />Click here to modify the selected BranchCategory'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditBranchCategory(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-branchCategory',
					tooltip:'<?php __('<b>Delete BranchCategories(s)</b><br />Click here to remove the selected BranchCategory(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove BranchCategory'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteBranchCategory(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove BranchCategory'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected BranchCategories'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteBranchCategory(sel_ids);
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
					text: '<?php __('View BranchCategory'); ?>',
					id: 'view-branchCategory',
					tooltip:'<?php __('<b>View BranchCategory</b><br />Click here to see details of the selected BranchCategory'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewBranchCategory(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'branchCategory_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByBranchCategoryName(Ext.getCmp('branchCategory_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'branchCategory_go_button',
					handler: function(){
						SearchByBranchCategoryName(Ext.getCmp('branchCategory_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchBranchCategory();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_branchCategories,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-branchCategory').enable();
		p.getTopToolbar().findById('delete-branchCategory').enable();
		p.getTopToolbar().findById('view-branchCategory').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-branchCategory').disable();
			p.getTopToolbar().findById('view-branchCategory').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-branchCategory').disable();
			p.getTopToolbar().findById('view-branchCategory').disable();
			p.getTopToolbar().findById('delete-branchCategory').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-branchCategory').enable();
			p.getTopToolbar().findById('view-branchCategory').enable();
			p.getTopToolbar().findById('delete-branchCategory').enable();
		}
		else{
			p.getTopToolbar().findById('edit-branchCategory').disable();
			p.getTopToolbar().findById('view-branchCategory').disable();
			p.getTopToolbar().findById('delete-branchCategory').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_branchCategories.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
