
var store_taxRules = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','min','max','percent','payroll','deductable'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'taxRules', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"}
});


function AddTaxRule() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'taxRules', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var taxRule_data = response.responseText;
			
			eval(taxRule_data);
			
			TaxRuleAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the taxRule add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditTaxRule(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'taxRules', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var taxRule_data = response.responseText;
			
			eval(taxRule_data);
			
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

function DeleteTaxRule(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'taxRules', 'action' => 'remove')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('TaxRule successfully deleted!'); ?>');
			RefreshTaxRuleData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the taxRule add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchTaxRule(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'taxRules', 'action' => 'search')); ?>',
		success: function(response, opts){
			var taxRule_data = response.responseText;

			eval(taxRule_data);

			taxRuleSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the taxRule search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByTaxRuleName(value){
	var conditions = '\'TaxRule.name LIKE\' => \'%' + value + '%\'';
	store_taxRules.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshTaxRuleData() {
	store_taxRules.reload();
}


if(center_panel.find('id', 'taxRule-tab') != "") {
	var p = center_panel.findById('taxRule-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Tax Rules'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'taxRule-tab',
		xtype: 'grid',
		store: store_taxRules,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Min'); ?>", dataIndex: 'min', sortable: true},
			{header: "<?php __('Max'); ?>", dataIndex: 'max', sortable: true},
			{header: "<?php __('Percent'); ?>", dataIndex: 'percent', sortable: true},
                        {header: "<?php __('Deductable'); ?>", dataIndex: 'deductable', sortable: true},
			{header: "<?php __('Payroll'); ?>", dataIndex: 'payroll', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "TaxRules" : "TaxRule"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewTaxRule(Ext.getCmp('taxRule-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add TaxRules</b><br />Click here to create a new TaxRule'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddTaxRule();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-taxRule',
					tooltip:'<?php __('<b>Edit TaxRules</b><br />Click here to modify the selected TaxRule'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditTaxRule(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-taxRule',
					tooltip:'<?php __('<b>Delete TaxRules(s)</b><br />Click here to remove the selected TaxRule(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove TaxRule'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteTaxRule(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove TaxRule'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected TaxRules'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteTaxRule(sel_ids);
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
					text: '<?php __('View TaxRule'); ?>',
					id: 'view-taxRule',
					tooltip:'<?php __('<b>View TaxRule</b><br />Click here to see details of the selected TaxRule'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewTaxRule(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-', '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'taxRule_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByTaxRuleName(Ext.getCmp('taxRule_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'taxRule_go_button',
					handler: function(){
						SearchByTaxRuleName(Ext.getCmp('taxRule_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchTaxRule();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_taxRules,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-taxRule').enable();
		p.getTopToolbar().findById('delete-taxRule').enable();
		p.getTopToolbar().findById('view-taxRule').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-taxRule').disable();
			p.getTopToolbar().findById('view-taxRule').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-taxRule').disable();
			p.getTopToolbar().findById('view-taxRule').disable();
			p.getTopToolbar().findById('delete-taxRule').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-taxRule').enable();
			p.getTopToolbar().findById('view-taxRule').enable();
			p.getTopToolbar().findById('delete-taxRule').enable();
		}
		else{
			p.getTopToolbar().findById('edit-taxRule').disable();
			p.getTopToolbar().findById('view-taxRule').disable();
			p.getTopToolbar().findById('delete-taxRule').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_taxRules.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
