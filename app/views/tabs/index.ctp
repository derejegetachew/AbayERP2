
var store_tabs = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','content','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'tabs', 'action' => 'list_data')); ?>'
	})
});


function AddTab() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'tabs', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var tab_data = response.responseText;
			
			eval(tab_data);
			
			TabAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the tab add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditTab(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'tabs', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var tab_data = response.responseText;
			
			eval(tab_data);
			
			TabEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the tab edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewTab(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'tabs', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var tab_data = response.responseText;

            eval(tab_data);

            TabViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the tab view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteTab(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'tabs', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Tab successfully deleted!'); ?>');
			RefreshTabData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the tab add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchTab(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'tabs', 'action' => 'search')); ?>',
		success: function(response, opts){
			var tab_data = response.responseText;

			eval(tab_data);

			tabSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the tab search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByTabName(value){
	var conditions = '\'Tab.name LIKE\' => \'%' + value + '%\'';
	store_tabs.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshTabData() {
	store_tabs.reload();
}


if(center_panel.find('id', 'tab-tab') != "") {
	var p = center_panel.findById('tab-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Tabs'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'tab-tab',
		xtype: 'grid',
		store: store_tabs,
		columns: [
			{header: "<?php __('ID'); ?>", dataIndex: 'id', sortable: true},
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Content'); ?>", dataIndex: 'content', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Tabs" : "Tab"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewTab(Ext.getCmp('tab-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Tabs</b><br />Click here to create a new Tab'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddTab();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-tab',
					tooltip:'<?php __('<b>Edit Tabs</b><br />Click here to modify the selected Tab'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditTab(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-tab',
					tooltip:'<?php __('<b>Delete Tabs(s)</b><br />Click here to remove the selected Tab(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Tab'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteTab(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Tab'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Tabs'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteTab(sel_ids);
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
					text: '<?php __('View Tab'); ?>',
					id: 'view-tab',
					tooltip:'<?php __('<b>View Tab</b><br />Click here to see details of the selected Tab'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewTab(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'tab_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByTabName(Ext.getCmp('tab_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'tab_go_button',
					handler: function(){
						SearchByTabName(Ext.getCmp('tab_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchTab();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_tabs,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-tab').enable();
		p.getTopToolbar().findById('delete-tab').enable();
		p.getTopToolbar().findById('view-tab').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-tab').disable();
			p.getTopToolbar().findById('view-tab').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-tab').disable();
			p.getTopToolbar().findById('view-tab').disable();
			p.getTopToolbar().findById('delete-tab').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-tab').enable();
			p.getTopToolbar().findById('view-tab').enable();
			p.getTopToolbar().findById('delete-tab').enable();
		}
		else{
			p.getTopToolbar().findById('edit-tab').disable();
			p.getTopToolbar().findById('view-tab').disable();
			p.getTopToolbar().findById('delete-tab').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_tabs.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
