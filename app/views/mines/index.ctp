
var store_mines = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','field'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'mines', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'field'
});


function AddMine() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'mines', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var mine_data = response.responseText;
			
			eval(mine_data);
			
			MineAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the mine add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditMine(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'mines', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var mine_data = response.responseText;
			
			eval(mine_data);
			
			MineEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the mine edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewMine(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'mines', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var mine_data = response.responseText;

            eval(mine_data);

            MineViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the mine view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentMinerRules(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'minerRules', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_minerRules_data = response.responseText;

            eval(parent_minerRules_data);

            parentMinerRulesViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteMine(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'mines', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Mine successfully deleted!'); ?>');
			RefreshMineData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the mine add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchMine(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'mines', 'action' => 'search')); ?>',
		success: function(response, opts){
			var mine_data = response.responseText;

			eval(mine_data);

			mineSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the mine search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByMineName(value){
	var conditions = '\'Mine.name LIKE\' => \'%' + value + '%\'';
	store_mines.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshMineData() {
	store_mines.reload();
}


if(center_panel.find('id', 'mine-tab') != "") {
	var p = center_panel.findById('mine-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Reports'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'mine-tab',
		xtype: 'grid',
		store: store_mines,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Field'); ?>", dataIndex: 'field', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Mines" : "Mine"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewMine(Ext.getCmp('mine-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Mines</b><br />Click here to create a new Mine'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddMine();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-mine',
					tooltip:'<?php __('<b>Edit Mines</b><br />Click here to modify the selected Mine'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditMine(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-mine',
					tooltip:'<?php __('<b>Delete Mines(s)</b><br />Click here to remove the selected Mine(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Mine'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteMine(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Mine'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Mines'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteMine(sel_ids);
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
					text: '<?php __('View Mine'); ?>',
					id: 'view-mine',
					tooltip:'<?php __('<b>View Mine</b><br />Click here to see details of the selected Mine'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewMine(sel.data.id);
						};
					},
					menu : {
						items: [
{
							text: '<?php __('View Miner Rules'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentMinerRules(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'mine_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByMineName(Ext.getCmp('mine_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'mine_go_button',
					handler: function(){
						SearchByMineName(Ext.getCmp('mine_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchMine();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_mines,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-mine').enable();
		p.getTopToolbar().findById('delete-mine').enable();
		p.getTopToolbar().findById('view-mine').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-mine').disable();
			p.getTopToolbar().findById('view-mine').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-mine').disable();
			p.getTopToolbar().findById('view-mine').disable();
			p.getTopToolbar().findById('delete-mine').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-mine').enable();
			p.getTopToolbar().findById('view-mine').enable();
			p.getTopToolbar().findById('delete-mine').enable();
		}
		else{
			p.getTopToolbar().findById('edit-mine').disable();
			p.getTopToolbar().findById('view-mine').disable();
			p.getTopToolbar().findById('delete-mine').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_mines.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
