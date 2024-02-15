
var store_imsSirvBefores = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','branch','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvBefores', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'branch'
});


function AddImsSirvBefore() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvBefores', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var imsSirvBefore_data = response.responseText;
			
			eval(imsSirvBefore_data);
			
			ImsSirvBeforeAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsSirvBefore add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditImsSirvBefore(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvBefores', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var imsSirvBefore_data = response.responseText;
			
			eval(imsSirvBefore_data);
			
			ImsSirvBeforeEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsSirvBefore edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsSirvBefore(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsSirvBefores', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var imsSirvBefore_data = response.responseText;

            eval(imsSirvBefore_data);

            ImsSirvBeforeViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsSirvBefore view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentImsSirvItemBefores(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsSirvItemBefores', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_imsSirvItemBefores_data = response.responseText;

            eval(parent_imsSirvItemBefores_data);

            parentImsSirvItemBeforesViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteImsSirvBefore(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvBefores', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsSirvBefore successfully deleted!'); ?>');
			RefreshImsSirvBeforeData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsSirvBefore add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchImsSirvBefore(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvBefores', 'action' => 'search')); ?>',
		success: function(response, opts){
			var imsSirvBefore_data = response.responseText;

			eval(imsSirvBefore_data);

			imsSirvBeforeSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the imsSirvBefore search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByImsSirvBeforeName(value){
	var conditions = '\'ImsSirvBefore.name LIKE\' => \'%' + value + '%\'';
	store_imsSirvBefores.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

var popUpWin=0;
function popUpWindow(URLStr, left, top, width, height) {
        if(popUpWin){
            if(!popUpWin.closed) popUpWin.close();
        }
        popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
    }

function PrintSIRV(id) {
        url = '<?php echo $this->Html->url(array('controller' => 'ImsSirvBefores', 'action' => 'print_sirv')); ?>/' + id;	
       
        popUpWindow(url, 250, 20, 900, 600);
}

function CreateTag(id) {
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_sirv_item_befores', 'action' => 'index_6')); ?>/'+id,
            success: function(response, opts) {
                var sirv_item_data = response.responseText;

                eval(sirv_item_data);

                parentImsSirvItemsViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the SIRV item form. Error code'); ?>: ' + response.status);
            }
        });
}

function Transfer(id) {
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_sirv_item_befores', 'action' => 'index_7')); ?>/'+id,
            success: function(response, opts) {
                var sirv_item_data = response.responseText;

                eval(sirv_item_data);

                parentImsSirvItemsViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the SIRV item form. Error code'); ?>: ' + response.status);
            }
        });
}

function Return(id) {
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_sirv_item_befores', 'action' => 'index_8')); ?>/'+id,
            success: function(response, opts) {
                var sirv_item_data = response.responseText;

                eval(sirv_item_data);

                parentImsSirvItemsViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the SIRV item form. Error code'); ?>: ' + response.status);
            }
        });
}

function RefreshImsSirvBeforeData() {
	store_imsSirvBefores.reload();
}

function showMenu(grid, index, event) {
        event.stopEvent();
        var record = grid.getStore().getAt(index);
		var btnStatus1 = true;
		var btnStatus2 = true;
		var btnStatus3 = true;
		<?php foreach($groups as $group){
			if ($group['name'] == 'Stock Record Officer' or $group['name'] == 'Administrators'){
			?>
				btnStatus2 = false;				
			<?php
			}
			else if ($group['name'] == 'Store Keeper'){
			?>
				btnStatus3 = false;				
			<?php
			}
		}
		?>	
        var menu = new Ext.menu.Menu({
            items: [
                {
                    text: '<b>Print SIRV Before</b>',
                    icon: 'img/table_print.png',
                    handler: function() {
                        PrintSIRV(record.get('id'));
                    },
                    disabled: false
                },				
				{
                    text: '<b>Create Tag</b>',
                    icon: 'img/table_add.png',
                    handler: function() {
                        CreateTag(record.get('id'));
                    },
                    disabled: btnStatus2
                },
				{
                    text: '<b>Transfer</b>',
                    icon: 'img/table_add.png',
                    handler: function() {
                        Transfer(record.get('id'));
                    },
                    disabled: btnStatus2
                },
				{
                    text: '<b>Return</b>',
                    icon: 'img/table_add.png',
                    handler: function() {
                        Return(record.get('id'));
                    },
                    disabled: btnStatus3
                }
            ]
        }).showAt(event.xy);
    }

if(center_panel.find('id', 'imsSirvBefore-tab') != "") {
	var p = center_panel.findById('imsSirvBefore-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Ims Sirv Befores'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'imsSirvBefore-tab',
		xtype: 'grid',
		store: store_imsSirvBefores,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "ImsSirvBefores" : "ImsSirvBefore"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewImsSirvBefore(Ext.getCmp('imsSirvBefore-tab').getSelectionModel().getSelected().data.id);
			},
			'rowcontextmenu': function(grid, index, event) {
				showMenu(grid, index, event);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add ImsSirvBefores</b><br />Click here to create a new ImsSirvBefore'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddImsSirvBefore();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-imsSirvBefore',
					tooltip:'<?php __('<b>Edit Sirv Before</b><br />Click here to modify the selected Sirv Before'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditImsSirvBefore(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-imsSirvBefore',
					tooltip:'<?php __('<b>Delete Sirv Before(s)</b><br />Click here to remove the selected Sirv Before(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Sirv Before'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteImsSirvBefore(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Sirv Before'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Sirv Before'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteImsSirvBefore(sel_ids);
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
					text: '<?php __('View ImsSirvBefore'); ?>',
					id: 'view-imsSirvBefore',
					tooltip:'<?php __('<b>View ImsSirvBefore</b><br />Click here to see details of the selected ImsSirvBefore'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewImsSirvBefore(sel.data.id);
						};
					},
					menu : {
						items: [
{
							text: '<?php __('View Ims Sirv Item Befores'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentImsSirvItemBefores(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-',  '<?php __('Branch'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($branches as $item){if($st) echo ",
							";?>['<?php echo $item['Branch']['id']; ?>' ,'<?php echo $item['Branch']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_imsSirvBefores.reload({
								params: {
									start: 0,
									limit: list_size,
									branch_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'imsSirvBefore_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByImsSirvBeforeName(Ext.getCmp('imsSirvBefore_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'imsSirvBefore_go_button',
					handler: function(){
						SearchByImsSirvBeforeName(Ext.getCmp('imsSirvBefore_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchImsSirvBefore();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_imsSirvBefores,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-imsSirvBefore').enable();
		p.getTopToolbar().findById('view-imsSirvBefore').enable();
		p.getTopToolbar().findById('delete-imsSirvBefore').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsSirvBefore').disable();
			p.getTopToolbar().findById('view-imsSirvBefore').disable();
			p.getTopToolbar().findById('delete-imsSirvBefore').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsSirvBefore').disable();
			p.getTopToolbar().findById('view-imsSirvBefore').disable();
			p.getTopToolbar().findById('delete-imsSirvBefore').disable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-imsSirvBefore').enable();
			p.getTopToolbar().findById('view-imsSirvBefore').enable();
			p.getTopToolbar().findById('delete-imsSirvBefore').enable();
		}
		else{
			p.getTopToolbar().findById('edit-imsSirvBefore').disable();
			p.getTopToolbar().findById('view-imsSirvBefore').disable();
			p.getTopToolbar().findById('delete-imsSirvBefore').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_imsSirvBefores.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
