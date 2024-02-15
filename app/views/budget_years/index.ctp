
var store_budgetYears = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','from_date','to_date','name'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'budgetYears', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'from_date', direction: "ASC"},
	groupField: 'to_date'
});


function AddBudgetYear() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'budgetYears', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var budgetYear_data = response.responseText;
			
			eval(budgetYear_data);
			
			BudgetYearAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the budgetYear add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditBudgetYear(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'budgetYears', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var budgetYear_data = response.responseText;
			
			eval(budgetYear_data);
			
			BudgetYearEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the budgetYear edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewBudgetYear(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'budgetYears', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var budgetYear_data = response.responseText;

            eval(budgetYear_data);

            BudgetYearViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the budgetYear view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentCelebrationDays(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'celebrationDays', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_celebrationDays_data = response.responseText;

            eval(parent_celebrationDays_data);

            parentCelebrationDaysViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteBudgetYear(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'budgetYears', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('BudgetYear successfully deleted!'); ?>');
			RefreshBudgetYearData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the budgetYear add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchBudgetYear(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'budgetYears', 'action' => 'search')); ?>',
		success: function(response, opts){
			var budgetYear_data = response.responseText;

			eval(budgetYear_data);

			budgetYearSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the budgetYear search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByBudgetYearName(value){
	var conditions = '\'BudgetYear.name LIKE\' => \'%' + value + '%\'';
	store_budgetYears.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshBudgetYearData() {
	store_budgetYears.reload();
}


if(center_panel.find('id', 'budgetYear-tab') != "") {
	var p = center_panel.findById('budgetYear-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Budget Years'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'budgetYear-tab',
		xtype: 'grid',
		store: store_budgetYears,
		columns: [
			{header: "<?php __('From Date'); ?>", dataIndex: 'from_date', sortable: true},
			{header: "<?php __('To Date'); ?>", dataIndex: 'to_date', sortable: true},
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "BudgetYears" : "BudgetYear"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewBudgetYear(Ext.getCmp('budgetYear-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add BudgetYears</b><br />Click here to create a new BudgetYear'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddBudgetYear();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-budgetYear',
					tooltip:'<?php __('<b>Edit BudgetYears</b><br />Click here to modify the selected BudgetYear'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditBudgetYear(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-budgetYear',
					tooltip:'<?php __('<b>Delete BudgetYears(s)</b><br />Click here to remove the selected BudgetYear(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove BudgetYear'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteBudgetYear(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove BudgetYear'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected BudgetYears'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteBudgetYear(sel_ids);
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
					text: '<?php __('View BudgetYear'); ?>',
					id: 'view-budgetYear',
					tooltip:'<?php __('<b>View BudgetYear</b><br />Click here to see details of the selected BudgetYear'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewBudgetYear(sel.data.id);
						};
					},
					menu : {
						items: [
{
							text: '<?php __('View Celebration Days'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentCelebrationDays(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'budgetYear_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByBudgetYearName(Ext.getCmp('budgetYear_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'budgetYear_go_button',
					handler: function(){
						SearchByBudgetYearName(Ext.getCmp('budgetYear_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchBudgetYear();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_budgetYears,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-budgetYear').enable();
		p.getTopToolbar().findById('delete-budgetYear').enable();
		p.getTopToolbar().findById('view-budgetYear').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-budgetYear').disable();
			p.getTopToolbar().findById('view-budgetYear').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-budgetYear').disable();
			p.getTopToolbar().findById('view-budgetYear').disable();
			p.getTopToolbar().findById('delete-budgetYear').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-budgetYear').enable();
			p.getTopToolbar().findById('view-budgetYear').enable();
			p.getTopToolbar().findById('delete-budgetYear').enable();
		}
		else{
			p.getTopToolbar().findById('edit-budgetYear').disable();
			p.getTopToolbar().findById('view-budgetYear').disable();
			p.getTopToolbar().findById('delete-budgetYear').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_budgetYears.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
