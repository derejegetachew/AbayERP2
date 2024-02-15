//<script>
    var store_itemCategories = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id','name','parent_item_category','lft','rght','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_item_categories', 'action' => 'list_data')); ?>'
	}),	
        sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'parent_id'
    });

    function AddItemCategory(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_item_categories', 'action' => 'add')); ?>/'+id,
            success: function(response, opts) {
                var itemCategory_data = response.responseText;
			
                eval(itemCategory_data);
			
                ItemCategoryAddWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the itemCategory add form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function EditItemCategory(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_item_categories', 'action' => 'edit')); ?>/'+id,
            success: function(response, opts) {
                var itemCategory_data = response.responseText;
			
                eval(itemCategory_data);
			
                ItemCategoryEditWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the itemCategory edit form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function DeleteItemCategory(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_item_categories', 'action' => 'delete')); ?>/'+id,
            success: function(response, opts) {
				var obj = JSON.parse(response.responseText);				
				if(obj.success == "false"){
					Ext.Msg.alert('<?php __('Error'); ?>', obj.errormsg);
				} else if(obj.success == "true"){
					Ext.Msg.alert('<?php __('Success'); ?>', obj.msg);
					RefreshItemCategoryData();
				}
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the itemCategory add form. Error code'); ?>: ' + response.status);
            }
	});
    }

    var selected_item_id = 0;
    var selected_item_name = '';

    function RefreshItemCategoryData() {
	store_itemCategories.reload();
    }


    if(center_panel.find('id', 'itemCategory-tab') != "") {
	var p = center_panel.findById('itemCategory-tab');
	center_panel.setActiveTab(p);
    } else {
        var p = center_panel.add(
            new Ext.ux.tree.TreeGrid({
                title: '<?php __('Item Categories'); ?>',
                closable: true,
                forceFit:true,
                id: 'itemCategory-tab',
                columns: [
                    {header: "<?php __('Name'); ?>", width: 900, dataIndex: 'name', sortable: true}
                ],
                dataUrl: '<?php echo $this->Html->url(array('controller' => 'ims_item_categories', 'action' => 'list_data')); ?>',
                listeners: {
                    click: function(n) {
                        selected_item_id = n.attributes.id;
                        selected_item_name = n.attributes.name;
                        p.getTopToolbar().findById('add_item_category').enable();
                        p.getTopToolbar().findById('edit_item_category').enable();
                        p.getTopToolbar().findById('delete_item_category').enable();
                        if(n.attributes.name == 'Root Item Category'){
                            p.getTopToolbar().findById('edit_item_category').disable();
                            p.getTopToolbar().findById('delete_item_category').disable();
                        }
                    }
                },
                tbar: new Ext.Toolbar({

                    items: [{
                            xtype: 'tbbutton',
                            id: 'add_item_category',
                            text: '<?php __('Add'); ?>',
                            tooltip:'<?php __('<b>Add ItemCategories</b><br />Click here to create a new ItemCategory'); ?>',
                            icon: 'img/table_add.png',
                            cls: 'x-btn-text-icon',
                            disabled: true,
                            handler: function(btn) {
                                if (selected_item_id != 0){
                                    AddItemCategory(selected_item_id);
                                }
                            }
                        }, ' ', '-', ' ', {
                            xtype: 'tbbutton',
                            text: '<?php __('Edit'); ?>',
                            id: 'edit_item_category',
                            tooltip:'<?php __('<b>Edit ItemCategories</b><br />Click here to modify the selected ItemCategory'); ?>',
                            icon: 'img/table_edit.png',
                            cls: 'x-btn-text-icon',
                            disabled: true,
                            handler: function(btn) {
                                if (selected_item_id != 0){
                                    EditItemCategory(selected_item_id);
                                };
                            }
                        }, ' ', '-', ' ', {
                            xtype: 'tbbutton',
                            text: '<?php __('Delete'); ?>',
                            id: 'delete_item_category',
                            tooltip:'<?php __('<b>Delete Item Category</b><br />Click here to remove the selected Item Category'); ?>',
                            icon: 'img/table_delete.png',
                            cls: 'x-btn-text-icon',
                            disabled: true,
                            handler: function(btn) {
                                if (selected_item_id != 0){
                                    Ext.Msg.show({
                                        title: '<?php __('Remove Item Category'); ?>',
                                        buttons: Ext.MessageBox.YESNO,
                                        msg: '<?php __('Remove'); ?> '+selected_item_name+' ?',
                                        fn: function(btn){
                                            if (btn == 'yes'){
                                                DeleteItemCategory(selected_item_id);
                                            }
                                        }
                                    });
                                } else {
                                    Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
                                }
                            }
                        }
                    ]})
            })
        );
        center_panel.setActiveTab(p);
    }