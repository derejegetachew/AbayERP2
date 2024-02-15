
var store_fields = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','type','store'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'fields', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'type'
});


function AddField() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fields', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var field_data = response.responseText;
			
			eval(field_data);
			
			FieldAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the field add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditField(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fields', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var field_data = response.responseText;
			
			eval(field_data);
			
			FieldEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the field edit form. Error code'); ?>: ' + response.status);
		}
	});
}
function EditSQL(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fields', 'action' => 'editsql')); ?>/'+id,
		success: function(response, opts) {
			var field_data = response.responseText;
			
			eval(field_data);
			
			FieldEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the field edit form. Error code'); ?>: ' + response.status);
		}
	});
}
function EditPHP(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fields', 'action' => 'editphp')); ?>/'+id,
		success: function(response, opts) {
			var field_data = response.responseText;
			
			eval(field_data);
			
			FieldEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the field edit form. Error code'); ?>: ' + response.status);
		}
	});
}
function EditChoices(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fields', 'action' => 'editchoices')); ?>/'+id,
		success: function(response, opts) {
			var field_data = response.responseText;
			
			eval(field_data);
			
			FieldEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the field edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewField(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'fields', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var field_data = response.responseText;

            eval(field_data);

            FieldViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the field view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentReports(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_reports_data = response.responseText;

            eval(parent_reports_data);

            parentReportsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteField(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fields', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Field successfully deleted!'); ?>');
			RefreshFieldData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the field add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchField(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'fields', 'action' => 'search')); ?>',
		success: function(response, opts){
			var field_data = response.responseText;

			eval(field_data);

			fieldSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the field search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByFieldName(value){
	var conditions = '\'Field.name LIKE\' => \'%' + value + '%\'';
	store_fields.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshFieldData() {
	store_fields.reload();
}


if(center_panel.find('id', 'field-tab') != "") {
	var p = center_panel.findById('field-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Fields'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'field-tab',
		xtype: 'grid',
		store: store_fields,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Type'); ?>", dataIndex: 'type', sortable: true},
			{header: "<?php __('Store'); ?>", dataIndex: 'store', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Fields" : "Field"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewField(Ext.getCmp('field-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Fields</b><br />Click here to create a new Field'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddField();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-field',
					tooltip:'<?php __('<b>Edit Fields</b><br />Click here to modify the selected Field'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditField(sel.data.id);
						};
					}
				},' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit SQL'); ?>',
					id: 'edit-sql',
					tooltip:'<?php __('<b>Edit Fields</b><br />Click here to modify the selected Field'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditSQL(sel.data.id);
						};
					}
				},' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit PHP'); ?>',
					id: 'edit-php',
					tooltip:'<?php __('<b>Edit Fields</b><br />Click here to modify the selected Field'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditPHP(sel.data.id);
						};
					}
				},' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit Choices'); ?>',
					id: 'edit-choices',
					tooltip:'<?php __('<b>Edit Fields</b><br />Click here to modify the selected Field'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditChoices(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-field',
					tooltip:'<?php __('<b>Delete Fields(s)</b><br />Click here to remove the selected Field(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Field'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteField(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Field'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Fields'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteField(sel_ids);
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
					text: '<?php __('View Field'); ?>',
					id: 'view-field',
					tooltip:'<?php __('<b>View Field</b><br />Click here to see details of the selected Field'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewField(sel.data.id);
						};
					},
					menu : {
						items: [
{
							text: '<?php __('View Reports'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentReports(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'field_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByFieldName(Ext.getCmp('field_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'field_go_button',
					handler: function(){
						SearchByFieldName(Ext.getCmp('field_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchField();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_fields,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-field').enable();
                p.getTopToolbar().findById('edit-sql').enable();
                p.getTopToolbar().findById('edit-php').enable();
                p.getTopToolbar().findById('edit-choices').enable();
		p.getTopToolbar().findById('delete-field').enable();
		p.getTopToolbar().findById('view-field').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-field').disable();
                         p.getTopToolbar().findById('edit-sql').disable();
                p.getTopToolbar().findById('edit-php').disable();
                p.getTopToolbar().findById('edit-choices').disable();
			p.getTopToolbar().findById('view-field').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-field').disable();
                         p.getTopToolbar().findById('edit-sql').disable();
                p.getTopToolbar().findById('edit-php').disable();
                p.getTopToolbar().findById('edit-choices').disable();
			p.getTopToolbar().findById('view-field').disable();
			p.getTopToolbar().findById('delete-field').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-field').enable();
                         p.getTopToolbar().findById('edit-sql').enable();
                p.getTopToolbar().findById('edit-php').enable();
                p.getTopToolbar().findById('edit-choices').enable();
			p.getTopToolbar().findById('view-field').enable();
			p.getTopToolbar().findById('delete-field').enable();
		}
		else{
			p.getTopToolbar().findById('edit-field').disable();
                         p.getTopToolbar().findById('edit-sql').disable();
                p.getTopToolbar().findById('edit-php').disable();
                p.getTopToolbar().findById('edit-choices').disable();
			p.getTopToolbar().findById('view-field').disable();
			p.getTopToolbar().findById('delete-field').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_fields.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
