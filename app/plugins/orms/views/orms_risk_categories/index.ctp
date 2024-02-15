
var store_ormsRiskCategories = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','parent_orms_risk_category','lft','rght','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'ormsRiskCategories', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'parent_id'
});


function AddRiskCategory(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ormsRiskCategories', 'action' => 'add')); ?>/'+id,
		success: function(response, opts) {
			var ormsRiskCategory_data = response.responseText;
			
			eval(ormsRiskCategory_data);
			
			OrmsRiskCategoryAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ormsRiskCategory add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditRiskCategory(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ormsRiskCategories', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var ormsRiskCategory_data = response.responseText;
			
			eval(ormsRiskCategory_data);
			
			OrmsRiskCategoryEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ormsRiskCategory edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewOrmsRiskCategory(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ormsRiskCategories', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var ormsRiskCategory_data = response.responseText;

            eval(ormsRiskCategory_data);

            OrmsRiskCategoryViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ormsRiskCategory view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentOrmsRiskCategories(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'childOrmsRiskCategories', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_childOrmsRiskCategories_data = response.responseText;

            eval(parent_childOrmsRiskCategories_data);

            parentOrmsRiskCategoriesViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}

function ViewParentOrmsRisks(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ormsRisks', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_ormsRisks_data = response.responseText;

            eval(parent_ormsRisks_data);

            parentOrmsRisksViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteRiskCategory(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'orms_risk_categories', 'action' => 'delete')); ?>/'+id,
            success: function(response, opts) {
				var obj = JSON.parse(response.responseText);				
				if(obj.success == "false"){
					Ext.Msg.alert('<?php __('Error'); ?>', obj.errormsg);
				} else if(obj.success == "true"){
					Ext.Msg.alert('<?php __('Success'); ?>', obj.msg);
					RefreshOrmsRiskCategoryData();
					p.getRootNode().reload();
				}
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the riskCategory add form. Error code'); ?>: ' + response.status);
            }
	});
}

function SearchOrmsRiskCategory(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ormsRiskCategories', 'action' => 'search')); ?>',
		success: function(response, opts){
			var ormsRiskCategory_data = response.responseText;

			eval(ormsRiskCategory_data);

			ormsRiskCategorySearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the ormsRiskCategory search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByOrmsRiskCategoryName(value){
	var conditions = '\'OrmsRiskCategory.name LIKE\' => \'%' + value + '%\'';
	store_ormsRiskCategories.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshOrmsRiskCategoryData() {
	store_ormsRiskCategories.reload();
}

var selected_item_id = 0;
    var selected_item_name = '';


if(center_panel.find('id', 'ormsRiskCategory-tab') != "") {
	var p = center_panel.findById('ormsRiskCategory-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add(
            new Ext.ux.tree.TreeGrid({
                title: '<?php __('Risk Categories'); ?>',
                closable: true,
                forceFit:true,
                id: 'riskCategory-tab',
                columns: [
                    {header: "<?php __('Name'); ?>", width: 900, dataIndex: 'name', sortable: false},
					{header: "<?php __('ID'); ?>", dataIndex: 'id', sortable: true, hidden: true},
                ],
                dataUrl: '<?php echo $this->Html->url(array('controller' => 'orms_risk_categories', 'action' => 'list_data')); ?>',
                listeners: {
                    click: function(n) {
                        selected_item_id = n.attributes.id;
                        selected_item_name = n.attributes.name;
                        p.getTopToolbar().findById('add_risk_category').enable();
                        p.getTopToolbar().findById('edit_risk_category').enable();
                        p.getTopToolbar().findById('delete_risk_category').enable();
                        if(n.attributes.name == 'Root Risk Category'){
                            p.getTopToolbar().findById('edit_risk_category').disable();
                            p.getTopToolbar().findById('delete_risk_category').disable();
                        }
                    }
                },
                tbar: new Ext.Toolbar({

                    items: [{
                            xtype: 'tbbutton',
                            id: 'add_risk_category',
                            text: '<?php __('Add'); ?>',
                            tooltip:'<?php __('<b>Add RiskCategories</b><br />Click here to create a new RiskCategory'); ?>',
                            icon: 'img/table_add.png',
                            cls: 'x-btn-text-icon',
                            disabled: true,
                            handler: function(btn) {
                                if (selected_item_id != 0){
                                    AddRiskCategory(selected_item_id);
                                }
                            }
                        }, ' ', '-', ' ', {
                            xtype: 'tbbutton',
                            text: '<?php __('Edit'); ?>',
                            id: 'edit_risk_category',
                            tooltip:'<?php __('<b>Edit RiskCategories</b><br />Click here to modify the selected RiskCategory'); ?>',
                            icon: 'img/table_edit.png',
                            cls: 'x-btn-text-icon',
                            disabled: true,
                            handler: function(btn) {
                                if (selected_item_id != 0){
                                    EditRiskCategory(selected_item_id);
                                };
                            }
                        }, ' ', '-', ' ', {
                            xtype: 'tbbutton',
                            text: '<?php __('Delete'); ?>',
                            id: 'delete_risk_category',
                            tooltip:'<?php __('<b>Delete Risk Category</b><br />Click here to remove the selected Risk Category'); ?>',
                            icon: 'img/table_delete.png',
                            cls: 'x-btn-text-icon',
                            disabled: true,
                            handler: function(btn) {
                                if (selected_item_id != 0){
                                    Ext.Msg.show({
                                        title: '<?php __('Remove Risk Category'); ?>',
                                        buttons: Ext.MessageBox.YESNO,
                                        msg: '<?php __('Remove'); ?> '+selected_item_name+' ?',
                                        fn: function(btn){
                                            if (btn == 'yes'){
                                                DeleteRiskCategory(selected_item_id);
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
