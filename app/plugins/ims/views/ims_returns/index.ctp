
var store_imsReturns = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','received_by','approved_by','returned_by','returned_from','status','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsReturns', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'received_by'
});


function AddImsReturn() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsReturns', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var imsReturn_data = response.responseText;
			
			eval(imsReturn_data);
			
			ImsReturnAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsReturn add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditImsReturn(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsReturns', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var imsReturn_data = response.responseText;
			
			eval(imsReturn_data);
			
			ImsReturnEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsReturn edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsReturn(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsReturns', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var imsReturn_data = response.responseText;

            eval(imsReturn_data);

            ImsReturnViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsReturn view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentImsReturnItems(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsReturnItems', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_imsReturnItems_data = response.responseText;

            eval(parent_imsReturnItems_data);

            parentImsReturnItemsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteImsReturn(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsReturns', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsReturn successfully deleted!'); ?>');
			RefreshImsReturnData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsReturn add form. Error code'); ?>: ' + response.status);
		}
	});
}

function DisposeReturnedItem(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'imsReturns', 'action' => 'dispose')); ?>/'+id,
            success: function(response, opts) {
                Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Returned item successfully disposed!'); ?>');
                RefreshImsReturnData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Please report this error to Administrator. Cannot dispose the returned item. Error code'); ?>: ' + response.status);
            }
	});
}

function SearchImsReturn(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsReturns', 'action' => 'search')); ?>',
		success: function(response, opts){
			var imsReturn_data = response.responseText;

			eval(imsReturn_data);

			imsReturnSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the imsReturn search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByImsReturnName(value){
	var conditions = '\'ImsReturn.name LIKE\' => \'%' + value + '%\'';
	store_imsReturns.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshImsReturnData() {
	store_imsReturns.reload();
}

var popUpWin=0;
function popUpWindow(URLStr, left, top, width, height) {
        if(popUpWin){
            if(!popUpWin.closed) popUpWin.close();
        }
        popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
    }

function PrintReturn(id) {
        url = '<?php echo $this->Html->url(array('controller' => 'ImsReturns', 'action' => 'print_return')); ?>/' + id;	
       
        popUpWindow(url, 250, 20, 900, 600);
}


if(center_panel.find('id', 'imsReturn-tab') != "") {
	var p = center_panel.findById('imsReturn-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Returns'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'imsReturn-tab',
		xtype: 'grid',
		store: store_imsReturns,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Received By'); ?>", dataIndex: 'received_by', sortable: true},
			{header: "<?php __('Approved By'); ?>", dataIndex: 'approved_by', sortable: true},
			{header: "<?php __('Returned By'); ?>", dataIndex: 'returned_by', sortable: true},
			{header: "<?php __('Returned From'); ?>", dataIndex: 'returned_from', sortable: true},
			{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "ImsReturns" : "ImsReturn"]})'
        })
,
		listeners: {
			celldblclick: function(){
				//ViewImsReturn(Ext.getCmp('imsReturn-tab').getSelectionModel().getSelected().data.id);
				PrintReturn(Ext.getCmp('imsReturn-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [/*{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Returns</b><br />Click here to create a new ImsReturn'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddImsReturn();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-imsReturn',
					tooltip:'<?php __('<b>Edit Returns</b><br />Click here to modify the selected ImsReturn'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditImsReturn(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-imsReturn',
					tooltip:'<?php __('<b>Delete ImsReturns(s)</b><br />Click here to remove the selected ImsReturn(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove ImsReturn'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteImsReturn(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove ImsReturn'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected ImsReturns'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteImsReturn(sel_ids);
										}
									}
								});
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
				}, ' ', '-', ' ', */{
					xtype: 'tbsplit',
					text: '<?php __('View Return'); ?>',
					id: 'view-imsReturn',
					tooltip:'<?php __('<b>View ImsReturn</b><br />Click here to see details of the selected ImsReturn'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewImsReturn(sel.data.id);
						};
					},
					menu : {
						items: [
{
							text: '<?php __('View Return Items'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentImsReturnItems(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-', ' ', {
                        xtype: 'tbbutton',
                        text: '<?php __('Dispose'); ?>',
                        id: 'dispose-imsReturn',
                        tooltip:'<?php __('<b>Dispose returned item</b><br />Click here to dispose the returned item'); ?>',
                        icon: 'img/table_edit.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelected();
                            if (sm.hasSelection()){
                                Ext.Msg.show({
                                    title: '<?php __('Dispose Returned Item'); ?>',
                                    buttons: Ext.MessageBox.YESNO,
                                    msg: '<?php __('Dispose'); ?> '+sel.data.name+'?',
                                    icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
                                        if (btn == 'yes'){
                                            DisposeReturnedItem(sel.data.id);
                                        }
                                    }
                                });
                            };
                        }
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'imsReturn_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByImsReturnName(Ext.getCmp('imsReturn_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'imsReturn_go_button',
					handler: function(){
						SearchByImsReturnName(Ext.getCmp('imsReturn_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchImsReturn();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_imsReturns,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		if(this.getSelections()[0].data.status == 'approved'){
			p.getTopToolbar().findById('dispose-imsReturn').enable();
		}
		//p.getTopToolbar().findById('delete-imsReturn').enable();
		p.getTopToolbar().findById('view-imsReturn').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('dispose-imsReturn').disable();
			p.getTopToolbar().findById('view-imsReturn').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('dispose-imsReturn').disable();
			p.getTopToolbar().findById('view-imsReturn').disable();
			//p.getTopToolbar().findById('delete-imsReturn').enable();
		}
		else if(this.getSelections().length == 1){
			if(this.getSelections()[0].data.status == 'approved'){
				p.getTopToolbar().findById('dispose-imsReturn').enable();
			}
			p.getTopToolbar().findById('view-imsReturn').enable();
			//p.getTopToolbar().findById('delete-imsReturn').enable();
		}
		else{
			p.getTopToolbar().findById('dispose-imsReturn').disable();
			p.getTopToolbar().findById('view-imsReturn').disable();
			//p.getTopToolbar().findById('delete-imsReturn').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_imsReturns.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
