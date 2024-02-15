
var store_spItems = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','desc','price','um','sp_item_group','created','modified','cat'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'spItems', 'action' => 'list_data')); ?>'
	})
});


function AddSpItem() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spItems', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var spItem_data = response.responseText;
			
			eval(spItem_data);
			
			SpItemAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spItem add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditSpItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spItems', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var spItem_data = response.responseText;
			
			eval(spItem_data);
			
			SpItemEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spItem edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewSpItem(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'spItems', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var spItem_data = response.responseText;

            eval(spItem_data);

            SpItemViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spItem view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteSpItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spItems', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('SpItem successfully deleted!'); ?>');
			RefreshSpItemData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spItem add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchSpItem(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spItems', 'action' => 'search')); ?>',
		success: function(response, opts){
			var spItem_data = response.responseText;

			eval(spItem_data);

			spItemSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the spItem search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchBySpItemName(value){
	var conditions = '\'SpItem.name LIKE\' => \'%' + value + '%\'';
	store_spItems.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshSpItemData() {
	store_spItems.reload();
}


if(center_panel.find('id', 'spItem-tab') != "") {
	var p = center_panel.findById('spItem-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Listings'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'spItem-tab',
		xtype: 'grid',
		store: store_spItems,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Category'); ?>", dataIndex: 'sp_item_group', sortable: true},
			{header: "<?php __('Amount'); ?>", dataIndex: 'price', sortable: true},
			{header: "<?php __('Calculation'); ?>", dataIndex: 'um', sortable: true},
			{header: "<?php __('Requested By'); ?>", dataIndex: 'cat', sortable: true},
			//{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			//{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "SpItems" : "SpItem"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewSpItem(Ext.getCmp('spItem-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add SpItems</b><br />Click here to create a new SpItem'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddSpItem();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-spItem',
					tooltip:'<?php __('<b>Edit SpItems</b><br />Click here to modify the selected SpItem'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditSpItem(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-spItem',
					tooltip:'<?php __('<b>Delete SpItems(s)</b><br />Click here to remove the selected SpItem(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove SpItem'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteSpItem(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove SpItem'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected SpItems'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteSpItem(sel_ids);
										}
									}
								});
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
				},  
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'spItem_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchBySpItemName(Ext.getCmp('spItem_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'spItem_go_button',
					handler: function(){
						SearchBySpItemName(Ext.getCmp('spItem_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchSpItem();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_spItems,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-spItem').enable();
		p.getTopToolbar().findById('delete-spItem').disable();
		p.getTopToolbar().findById('view-spItem').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-spItem').disable();
			p.getTopToolbar().findById('view-spItem').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-spItem').disable();
			p.getTopToolbar().findById('view-spItem').disable();
			p.getTopToolbar().findById('delete-spItem').disable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-spItem').enable();
			p.getTopToolbar().findById('view-spItem').enable();
			p.getTopToolbar().findById('delete-spItem').disable();
		}
		else{
			p.getTopToolbar().findById('edit-spItem').disable();
			p.getTopToolbar().findById('view-spItem').disable();
			p.getTopToolbar().findById('delete-spItem').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_spItems.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
