
var store_imsTransferStoreItems = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','from_store','to_store','from_store_keeper','to_store_keeper','remark','status','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferStoreItems', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'from_store'
});


function AddImsTransferStoreItem() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferStoreItems', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var imsTransferStoreItem_data = response.responseText;
			
			eval(imsTransferStoreItem_data);
			
			ImsTransferStoreItemAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransferStoreItem add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditImsTransferStoreItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferStoreItems', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var imsTransferStoreItem_data = response.responseText;
			
			eval(imsTransferStoreItem_data);
			
			ImsTransferStoreItemEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransferStoreItem edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsTransferStoreItem(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsTransferStoreItems', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var imsTransferStoreItem_data = response.responseText;

            eval(imsTransferStoreItem_data);

            ImsTransferStoreItemViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransferStoreItem view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentImsTransferStoreItemDetails(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsTransferStoreItemDetails', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_imsTransferStoreItemDetails_data = response.responseText;

            eval(parent_imsTransferStoreItemDetails_data);

            parentImsTransferStoreItemDetailsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteImsTransferStoreItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferStoreItems', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			var obj = JSON.parse(response.responseText);
				if(obj.success == "false"){
					Ext.Msg.alert('<?php __('Error'); ?>', obj.errormsg);
				} else if(obj.success == "true"){
					Ext.Msg.alert('<?php __('Success'); ?>', obj.msg);
					RefreshImsTransferStoreItemData();
				}			
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransferStoreItem add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchImsTransferStoreItem(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferStoreItems', 'action' => 'search')); ?>',
		success: function(response, opts){
			var imsTransferStoreItem_data = response.responseText;

			eval(imsTransferStoreItem_data);

			imsTransferStoreItemSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the imsTransferStoreItem search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByImsTransferStoreItemName(value){
	var conditions = '\'ImsTransferStoreItem.name LIKE\' => \'%' + value + '%\'';
	store_imsTransferStoreItems.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshImsTransferStoreItemData() {
	store_imsTransferStoreItems.reload();
}

function PostTransferStoreItem(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'imsTransferStoreItems', 'action' => 'post')); ?>/'+id,
            success: function(response, opts) {
                Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Transfer Store Items successfully posted!'); ?>');
                RefreshImsTransferStoreItemData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Please report this error to Administrator. Cannot post the Transfer Store Items. Error code'); ?>: ' + response.status);
            }
	});
}

function AcceptTransferStoreItem(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'imsTransferStoreItems', 'action' => 'accept')); ?>/'+id,
            success: function(response, opts) {
			var purchaseOrder_data = response.responseText;
			
                eval(purchaseOrder_data);
               
                RefreshImsTransferStoreItemData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Please report this error to Administrator. Cannot accept the Transfer Store Item. Error code'); ?>: ' + response.status);
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

    function PrintTransfer(id) {
	url = '<?php echo $this->Html->url(array('controller' => 'imsTransferStoreItems', 'action' => 'print_transfer')); ?>/' + id;

        popUpWindow(url, 200, 20, 900, 600);
    }

 function showMenu(grid, index, event) {
        event.stopEvent();
        var record = grid.getStore().getAt(index);
        var menu = new Ext.menu.Menu({
            items: [{
                    text: 'Print Transfer',
                    icon: 'img/table_print.png',                
                    handler: function() {
                        PrintTransfer(record.get('id'));
                    }
                }
				
            ]
        }).showAt(event.xy);
    }


if(center_panel.find('id', 'imsTransferStoreItem-tab') != "") {
	var p = center_panel.findById('imsTransferStoreItem-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Transfer Store Items'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'imsTransferStoreItem-tab',
		xtype: 'grid',
		store: store_imsTransferStoreItems,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('From Store'); ?>", dataIndex: 'from_store', sortable: true},
			{header: "<?php __('To Store'); ?>", dataIndex: 'to_store', sortable: true},
			{header: "<?php __('From Store Keeper'); ?>", dataIndex: 'from_store_keeper', sortable: true},
			{header: "<?php __('To Store Keeper'); ?>", dataIndex: 'to_store_keeper', sortable: true},
			{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true},
			{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "ImsTransferStoreItems" : "ImsTransferStoreItem"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewImsTransferStoreItem(Ext.getCmp('imsTransferStoreItem-tab').getSelectionModel().getSelected().data.id);
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
					tooltip:'<?php __('<b>Add Transfer Store Items</b><br />Click here to create a new Transfer Store Item'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddImsTransferStoreItem();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-imsTransferStoreItem',
					tooltip:'<?php __('<b>Edit Transfer Store Items</b><br />Click here to modify the selected Transfer Store Item'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditImsTransferStoreItem(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-imsTransferStoreItem',
					tooltip:'<?php __('<b>Delete Transfer Store Items(s)</b><br />Click here to remove the selected Transfer Store Item(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Transfer Store Item'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteImsTransferStoreItem(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove ImsTransferStoreItem'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected ImsTransferStoreItems'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteImsTransferStoreItem(sel_ids);
										}
									}
								});
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Post'); ?>',
					id: 'post-imsTransferStoreItem',
					tooltip:'<?php __('<b>Post Transfer Store Item</b><br />Click here to post the selected Transfer Store Item'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							PostTransferStoreItem(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
                        xtype: 'tbbutton',
                        text: '<?php __('Accept'); ?>',
                        id: 'accept-imsTransferStoreItem',
                        tooltip:'<?php __('<b>Accept Transfer Store Item</b><br />Click here to accept the selected Transfer Store Item'); ?>',
                        icon: 'img/table_approve.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelected();
                            if (sm.hasSelection()){
                                Ext.Msg.show({
                                    title: '<?php __('Accept Transfer Store Item'); ?>',
                                    buttons: Ext.MessageBox.YESNO,
                                    msg: '<?php __('Accept'); ?> '+sel.data.name+'?',
                                    icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
                                        if (btn == 'yes'){
                                            AcceptTransferStoreItem(sel.data.id);
                                        }
                                    }
                                });
                            };
                        }
                }, ' ', '-', ' ', {
					xtype: 'tbsplit',
					text: '<?php __('View Transfer Store Item'); ?>',
					id: 'view-imsTransferStoreItem',
					tooltip:'<?php __('<b>View Transfer Store Item</b><br />Click here to see details of the selected Transfer Store Item'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewImsTransferStoreItem(sel.data.id);
						};
					},
					menu : {
						items: [
{
							text: '<?php __('View Transfer Store Item Details'); ?>',						
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentImsTransferStoreItemDetails(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'imsTransferStoreItem_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByImsTransferStoreItemName(Ext.getCmp('imsTransferStoreItem_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'imsTransferStoreItem_go_button',
					handler: function(){
						SearchByImsTransferStoreItemName(Ext.getCmp('imsTransferStoreItem_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchImsTransferStoreItem();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_imsTransferStoreItems,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		if(this.getSelections()[0].data.status == '<font color=#DF7401>posted</font>' || this.getSelections()[0].data.status == '<font color=green>accepted</font>'){
			p.getTopToolbar().findById('edit-imsTransferStoreItem').disable();
			p.getTopToolbar().findById('delete-imsTransferStoreItem').disable();
			p.getTopToolbar().findById('view-imsTransferStoreItem').disable();
		}
		else{
			p.getTopToolbar().findById('edit-imsTransferStoreItem').enable();
			p.getTopToolbar().findById('delete-imsTransferStoreItem').enable();
			p.getTopToolbar().findById('post-imsTransferStoreItem').enable();
			p.getTopToolbar().findById('view-imsTransferStoreItem').enable();
		}
		if(this.getSelections()[0].data.status == '<font color=#DF7401>posted</font>'){
			p.getTopToolbar().findById('accept-imsTransferStoreItem').enable();
		}
		else if(this.getSelections()[0].data.status != '<font color=#DF7401>posted</font>'){
			p.getTopToolbar().findById('accept-imsTransferStoreItem').disable();
		}
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsTransferStoreItem').disable();
			p.getTopToolbar().findById('view-imsTransferStoreItem').disable();
			p.getTopToolbar().findById('delete-imsTransferStoreItem').disable();
			p.getTopToolbar().findById('post-imsTransferStoreItem').disable();
			p.getTopToolbar().findById('accept-imsTransferStoreItem').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-imsTransferStoreItem').disable();
			p.getTopToolbar().findById('view-imsTransferStoreItem').disable();
			p.getTopToolbar().findById('delete-imsTransferStoreItem').disable();
			p.getTopToolbar().findById('post-imsTransferStoreItem').disable();
			p.getTopToolbar().findById('accept-imsTransferStoreItem').disable();
		}
		else if(this.getSelections().length == 1){			
			if(this.getSelections()[0].data.status == 'created'){
				p.getTopToolbar().findById('edit-imsTransferStoreItem').enable();			
				p.getTopToolbar().findById('delete-imsTransferStoreItem').enable();
				p.getTopToolbar().findById('post-imsTransferStoreItem').enable();
				p.getTopToolbar().findById('view-imsTransferStoreItem').enable();
			}
			else if(this.getSelections()[0].data.status == '<font color=#DF7401>posted</font>'){
				p.getTopToolbar().findById('accept-imsTransferStoreItem').enable();
			}
		}
		else{
			p.getTopToolbar().findById('edit-imsTransferStoreItem').disable();
			p.getTopToolbar().findById('view-imsTransferStoreItem').disable();
			p.getTopToolbar().findById('delete-imsTransferStoreItem').disable();
			p.getTopToolbar().findById('post-imsTransferStoreItem').disable();
			p.getTopToolbar().findById('accept-imsTransferStoreItem').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_imsTransferStoreItems.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
