


function AddSpItemGroup(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spItemGroups', 'action' => 'add')); ?>/'+id,
		success: function(response, opts) {
			var spItemGroup_data = response.responseText;
			
			eval(spItemGroup_data);
			
			SpItemGroupAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spItemGroup add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditSpItemGroup(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spItemGroups', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var spItemGroup_data = response.responseText;
			
			eval(spItemGroup_data);
			
			SpItemGroupEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spItemGroup edit form. Error code'); ?>: ' + response.status);
		}
	});
}




function DeleteSpItemGroup(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'spItemGroups', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('SpItemGroup successfully deleted!'); ?>');
			RefreshSpItemGroupData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the spItemGroup add form. Error code'); ?>: ' + response.status);
		}
	});
}



function RefreshSpItemGroupData() {
	store_spItemGroups.reload();

	var p = center_panel.findById('spItemGroup-tab');
	p.getRootNode().reload();
}


if(center_panel.find('id', 'spItemGroup-tab') != "") {
	var p = center_panel.findById('spItemGroup-tab');
	center_panel.setActiveTab(p);
} 
else {
	var p = center_panel.add(
	 new Ext.ux.tree.TreeGrid({
		title: '<?php __('Categories'); ?>',
		closable: true,
		forceFit:true,
		id: 'spItemGroup-tab',
		columns: [
			{header: "<?php __('Name'); ?>",width: 500, dataIndex: 'name', sortable: true},
			{header: "<?php __('Created'); ?>",width: 300, dataIndex: 'created', sortable: true}
		],
		dataUrl: '<?php echo $this->Html->url(array('controller' => 'spItemGroups', 'action' => 'list_data')); ?>',
		listeners: {
			click: function(n) {
                        selected_item_id = n.attributes.id;
                        selected_item_name = n.attributes.name;
                        p.getTopToolbar().findById('add_item_category').enable();
                        p.getTopToolbar().findById('edit_item_category').enable();
                        if(n.attributes.name == 'All'){
                            p.getTopToolbar().findById('edit_item_category').disable();
                        }
                    }
		},
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton', 
					id: 'add_item_category',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add SpItemGroups</b><br />Click here to create a new SpItemGroup'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						 if (selected_item_id != 0){
							AddSpItemGroup(selected_item_id);
						}
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					id: 'edit_item_category',
					text: '<?php __('Edit'); ?>',
					tooltip:'<?php __('<b>Edit SpItemGroups</b><br />Click here to modify the selected SpItemGroup'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						 if (selected_item_id != 0){
							EditSpItemGroup(selected_item_id);
						}
					}
				}
				]
	})
		
	})
	);
	
	center_panel.setActiveTab(p);
	
	
}
