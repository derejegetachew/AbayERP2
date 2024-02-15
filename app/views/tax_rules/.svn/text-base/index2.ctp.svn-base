var store_parent_taxRules = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','min','max','percent','payroll'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'taxRules', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentTaxRule() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'taxRules', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_taxRule_data = response.responseText;
			
			eval(parent_taxRule_data);
			
			TaxRuleAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the taxRule add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentTaxRule(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'taxRules', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_taxRule_data = response.responseText;
			
			eval(parent_taxRule_data);
			
			TaxRuleEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the taxRule edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewTaxRule(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'taxRules', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var taxRule_data = response.responseText;

			eval(taxRule_data);

			TaxRuleViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the taxRule view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentTaxRule(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'taxRules', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('TaxRule(s) successfully deleted!'); ?>');
			RefreshParentTaxRuleData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the taxRule to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentTaxRuleName(value){
	var conditions = '\'TaxRule.name LIKE\' => \'%' + value + '%\'';
	store_parent_taxRules.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentTaxRuleData() {
	store_parent_taxRules.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('TaxRules'); ?>',
	store: store_parent_taxRules,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'taxRuleGrid',
	columns: [
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header: "<?php __('Min'); ?>", dataIndex: 'min', sortable: true},
		{header: "<?php __('Max'); ?>", dataIndex: 'max', sortable: true},
		{header: "<?php __('Percent'); ?>", dataIndex: 'percent', sortable: true},
		{header:"<?php __('payroll'); ?>", dataIndex: 'payroll', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewTaxRule(Ext.getCmp('taxRuleGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add TaxRule</b><br />Click here to create a new TaxRule'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentTaxRule();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-taxRule',
				tooltip:'<?php __('<b>Edit TaxRule</b><br />Click here to modify the selected TaxRule'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentTaxRule(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-taxRule',
				tooltip:'<?php __('<b>Delete TaxRule(s)</b><br />Click here to remove the selected TaxRule(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove TaxRule'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentTaxRule(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove TaxRule'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected TaxRule'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentTaxRule(sel_ids);
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
				text: '<?php __('View TaxRule'); ?>',
				id: 'view-taxRule2',
				tooltip:'<?php __('<b>View TaxRule</b><br />Click here to see details of the selected TaxRule'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewTaxRule(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_taxRule_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentTaxRuleName(Ext.getCmp('parent_taxRule_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_taxRule_go_button',
				handler: function(){
					SearchByParentTaxRuleName(Ext.getCmp('parent_taxRule_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_taxRules,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-taxRule').enable();
	g.getTopToolbar().findById('delete-parent-taxRule').enable();
        g.getTopToolbar().findById('view-taxRule2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-taxRule').disable();
                g.getTopToolbar().findById('view-taxRule2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-taxRule').disable();
		g.getTopToolbar().findById('delete-parent-taxRule').enable();
                g.getTopToolbar().findById('view-taxRule2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-taxRule').enable();
		g.getTopToolbar().findById('delete-parent-taxRule').enable();
                g.getTopToolbar().findById('view-taxRule2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-taxRule').disable();
		g.getTopToolbar().findById('delete-parent-taxRule').disable();
                g.getTopToolbar().findById('view-taxRule2').disable();
	}
});



var parentTaxRulesViewWindow = new Ext.Window({
	title: 'TaxRule Under the selected Item',
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
			parentTaxRulesViewWindow.close();
		}
	}]
});

store_parent_taxRules.load({
    params: {
        start: 0,    
        limit: list_size
    }
});