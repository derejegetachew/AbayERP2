
var store_minerRules = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','mine','tableField','param','value'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'minerRules', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'mine_id', direction: "ASC"},
	groupField: 'tableField'
});


function AddMinerRule() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'minerRules', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var minerRule_data = response.responseText;
			
			eval(minerRule_data);
			
			MinerRuleAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the minerRule add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditMinerRule(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'minerRules', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var minerRule_data = response.responseText;
			
			eval(minerRule_data);
			
			MinerRuleEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the minerRule edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewMinerRule(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'minerRules', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var minerRule_data = response.responseText;

            eval(minerRule_data);

            MinerRuleViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the minerRule view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteMinerRule(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'minerRules', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('MinerRule successfully deleted!'); ?>');
			RefreshMinerRuleData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the minerRule add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchMinerRule(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'minerRules', 'action' => 'search')); ?>',
		success: function(response, opts){
			var minerRule_data = response.responseText;

			eval(minerRule_data);

			minerRuleSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the minerRule search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByMinerRuleName(value){
	var conditions = '\'MinerRule.name LIKE\' => \'%' + value + '%\'';
	store_minerRules.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshMinerRuleData() {
	store_minerRules.reload();
}


if(center_panel.find('id', 'minerRule-tab') != "") {
	var p = center_panel.findById('minerRule-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Miner Rules'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'minerRule-tab',
		xtype: 'grid',
		store: store_minerRules,
		columns: [
			{header: "<?php __('Mine'); ?>", dataIndex: 'mine', sortable: true},
			{header: "<?php __('TableField'); ?>", dataIndex: 'tableField', sortable: true},
			{header: "<?php __('Param'); ?>", dataIndex: 'param', sortable: true},
			{header: "<?php __('Value'); ?>", dataIndex: 'value', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "MinerRules" : "MinerRule"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewMinerRule(Ext.getCmp('minerRule-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add MinerRules</b><br />Click here to create a new MinerRule'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddMinerRule();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-minerRule',
					tooltip:'<?php __('<b>Edit MinerRules</b><br />Click here to modify the selected MinerRule'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditMinerRule(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-minerRule',
					tooltip:'<?php __('<b>Delete MinerRules(s)</b><br />Click here to remove the selected MinerRule(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove MinerRule'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteMinerRule(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove MinerRule'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected MinerRules'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteMinerRule(sel_ids);
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
					text: '<?php __('View MinerRule'); ?>',
					id: 'view-minerRule',
					tooltip:'<?php __('<b>View MinerRule</b><br />Click here to see details of the selected MinerRule'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewMinerRule(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('Mine'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($mines as $item){if($st) echo ",
							";?>['<?php echo $item['Mine']['id']; ?>' ,'<?php echo $item['Mine']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_minerRules.reload({
								params: {
									start: 0,
									limit: list_size,
									mine_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'minerRule_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByMinerRuleName(Ext.getCmp('minerRule_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'minerRule_go_button',
					handler: function(){
						SearchByMinerRuleName(Ext.getCmp('minerRule_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchMinerRule();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_minerRules,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-minerRule').enable();
		p.getTopToolbar().findById('delete-minerRule').enable();
		p.getTopToolbar().findById('view-minerRule').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-minerRule').disable();
			p.getTopToolbar().findById('view-minerRule').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-minerRule').disable();
			p.getTopToolbar().findById('view-minerRule').disable();
			p.getTopToolbar().findById('delete-minerRule').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-minerRule').enable();
			p.getTopToolbar().findById('view-minerRule').enable();
			p.getTopToolbar().findById('delete-minerRule').enable();
		}
		else{
			p.getTopToolbar().findById('edit-minerRule').disable();
			p.getTopToolbar().findById('view-minerRule').disable();
			p.getTopToolbar().findById('delete-minerRule').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_minerRules.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
