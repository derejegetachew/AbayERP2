
var store_imsBudgets = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','budget_year','branch','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsBudgets', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'branch', direction: "ASC"},
	groupField: 'budget_year'
});


function AddImsBudget() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsBudgets', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var imsBudget_data = response.responseText;
			
			eval(imsBudget_data);
			
			ImsBudgetAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Budget add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditImsBudget(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsBudgets', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var imsBudget_data = response.responseText;
			
			eval(imsBudget_data);
			
			ImsBudgetEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Budget edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsBudget(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsBudgets', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var imsBudget_data = response.responseText;

            eval(imsBudget_data);

            ImsBudgetViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Budget view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentImsBudgetItems(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsBudgetItems', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_imsBudgetItems_data = response.responseText;

            eval(parent_imsBudgetItems_data);

            parentImsBudgetItemsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteImsBudget(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsBudgets', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Budget successfully deleted!'); ?>');
			RefreshImsBudgetData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Budget add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchImsBudget(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsBudgets', 'action' => 'search')); ?>',
		success: function(response, opts){
			var imsBudget_data = response.responseText;

			eval(imsBudget_data);

			imsBudgetSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the Budget search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByImsBudgetName(value){
	var conditions = '\'Branch.name LIKE\' => \'%' + value + '%\'';
	store_imsBudgets.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshImsBudgetData() {
	store_imsBudgets.reload();
}


if(center_panel.find('id', 'imsBudget-tab') != "") {
	var p = center_panel.findById('imsBudget-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Budgets'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'imsBudget-tab',
		xtype: 'grid',
		store: store_imsBudgets,
		columns: [
			{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true},			
			{header: "<?php __('BudgetYear'); ?>", dataIndex: 'budget_year', sortable: true,hidden: true},
			{header: "<?php __('Description'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Budgets" : "Budget"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewImsBudget(Ext.getCmp('imsBudget-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Budgets</b><br />Click here to create a new Budget'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddImsBudget();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-imsBudget',
					tooltip:'<?php __('<b>Edit Budgets</b><br />Click here to modify the selected Budget'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditImsBudget(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-imsBudget',
					tooltip:'<?php __('<b>Delete Budgets(s)</b><br />Click here to remove the selected Budget(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Budget'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.branch+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteImsBudget(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Budget'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Budgets'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteImsBudget(sel_ids);
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
					text: '<?php __('View Budget'); ?>',
					id: 'view-imsBudget',
					tooltip:'<?php __('<b>View Budget</b><br />Click here to see details of the selected Budget'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewImsBudget(sel.data.id);
						};
					},
					menu : {
						items: [
{
							text: '<?php __('View Budget Items'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentImsBudgetItems(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-',  '<?php __('BudgetYear'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($budget_years as $item){if($st) echo ",
							";?>['<?php echo $item['BudgetYear']['id']; ?>' ,'<?php echo $item['BudgetYear']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_imsBudgets.reload({
								params: {
									start: 0,
									limit: list_size,
									budget_year_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Branch]'); ?>',
					id: 'imsBudget_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByImsBudgetName(Ext.getCmp('imsBudget_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'imsBudget_go_button',
					handler: function(){
						SearchByImsBudgetName(Ext.getCmp('imsBudget_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchImsBudget();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_imsBudgets,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-imsBudget').enable();
		p.getTopToolbar().findById('delete-imsBudget').enable();
		p.getTopToolbar().findById('view-imsBudget').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsBudget').disable();
			p.getTopToolbar().findById('view-imsBudget').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsBudget').disable();
			p.getTopToolbar().findById('view-imsBudget').disable();
			p.getTopToolbar().findById('delete-imsBudget').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-imsBudget').enable();
			p.getTopToolbar().findById('view-imsBudget').enable();
			p.getTopToolbar().findById('delete-imsBudget').enable();
		}
		else{
			p.getTopToolbar().findById('edit-imsBudget').disable();
			p.getTopToolbar().findById('view-imsBudget').disable();
			p.getTopToolbar().findById('delete-imsBudget').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_imsBudgets.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
