
var store_imsRequisitions = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id',{name: 'name', sortType: Ext.data.SortTypes.asUCString},'budget_year','branch','purpose','requested_by','approved/rejected_by','status','created','modified','action_dt'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitions', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'branch'
});

var filter_conditions = '';


function AddImsRequisition() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitions', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var imsRequisition_data = response.responseText;
			
			eval(imsRequisition_data);
			
			ImsRequisitionAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Requisition add form. Error code'); ?>: ' + response.status);
		}
	});
}

function AddManualImsRequisition() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitions', 'action' => 'add_manual_requisitions')); ?>',
		success: function(response, opts) {
			var imsRequisition_data = response.responseText;
			
			eval(imsRequisition_data);
			
			ImsRequisitionManualAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Requisition add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditImsRequisition(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitions', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var imsRequisition_data = response.responseText;
			
			eval(imsRequisition_data);
			
			ImsRequisitionEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Requisition edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditManualImsRequisition(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitions', 'action' => 'edit_manual_requisitions')); ?>/'+id,
		success: function(response, opts) {
			var imsRequisition_data = response.responseText;
			
			eval(imsRequisition_data);
			
			ImsRequisitionManualEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Requisition edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsRequisition(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitions', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var imsRequisition_data = response.responseText;

            eval(imsRequisition_data);

            ImsRequisitionViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Requisition view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentImsRequisitionItems(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitionItems', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_imsRequisitionItems_data = response.responseText;

            eval(parent_imsRequisitionItems_data);

            parentImsRequisitionItemsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteImsRequisition(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitions', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Requisition successfully deleted!'); ?>');
			RefreshImsRequisitionData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Requisition add form. Error code'); ?>: ' + response.status);
		}
	});
}

function DeleteManualImsRequisition(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitions', 'action' => 'delete_manual_requisitions')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Requisition successfully deleted!'); ?>');
			RefreshImsRequisitionData();
			p.getTopToolbar().findById('delete-imsRequisition').disable();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Requisition add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchImsRequisition(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitions', 'action' => 'search')); ?>',
		success: function(response, opts){
			var imsRequisition_data = response.responseText;

			eval(imsRequisition_data);

			imsRequisitionSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the Requisition search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByImsRequisitionName(value){
	var conditions = '\'ImsRequisition.name LIKE\' => \'%' + value + '%\'';
	filter_conditions = conditions;
	store_imsRequisitions.setBaseParam('query', filter_conditions);
	store_imsRequisitions.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshImsRequisitionData() {
	store_imsRequisitions.reload();
	p.getTopToolbar().findById('edit-imsRequisition').disable();
	p.getTopToolbar().findById('delete-imsRequisition').disable();
	Ext.getCmp('view-imsRequisitionItems').disable();
}

function CompleteSIRV(id) {

 Ext.Msg.alert('<?php __('Info'); ?>', '<?php __('Completing SIRV is temporarily disabled for Year End purpose!'); ?> ');
       
       
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_sirv_items', 'action' => 'index_2')); ?>/'+id,
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

function CreateSIRV(id) {

  //  Ext.Msg.alert('<?php __('Info'); ?>', '<?php __('Creating SIRV is temporarily disabled for Year End purpose!'); ?> ');
       
      Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_sirv_items', 'action' => 'index_3')); ?>/'+id,
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

var popUpWin=0;
function popUpWindow(URLStr, left, top, width, height) {
	if(popUpWin){
		if(!popUpWin.closed) popUpWin.close();
	}
	popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
}
	
function PrintSIRV(id) {
        url = '<?php echo $this->Html->url(array('controller' => 'imsRequisitions', 'action' => 'print_sirv')); ?>/' + id;	
       
        popUpWindow(url, 250, 20, 900, 600);
}

function showMenu(grid, index, event) {
        event.stopEvent();
        var record = grid.getStore().getAt(index);
        var btnStatus = true;
		var btnStatus1 = true;
		var btnStatus2 = true;

		<?php foreach($groups as $group){
			if($group['name'] == 'Stock Record Officer'){
			?>
				btnStatus1 = (record.get('status') == '<font color=#DF7401>approved</font>')? false: true;
				btnStatus2 = (record.get('status') == '<font color=green>accepted</font>' || record.get('status') == '<font color=green>received</font>')? false: true;
			<?php
			}
			else if($group['name'] == 'Stock Supervisor'){
			?>
				btnStatus2 = (record.get('status') == '<font color=green>accepted</font>' || record.get('status') == '<font color=green>received</font>')? false: true;
			<?php
			}
			else if($group['name'] == 'Store Keeper'){?>
				btnStatus = (record.get('status') == '<font color=green>received</font>')? false: true;
				btnStatus2 = (record.get('status') == '<font color=green>accepted</font>' || record.get('status') == '<font color=green>received</font>')? false: true;
			<?php
			}
			else if ($group['name'] == 'Administrators'){
			?>
				btnStatus1 = (record.get('status') == '<font color=#DF7401>approved</font>')? false: true;
				btnStatus = (record.get('status') == '<font color=green>received</font>')? false: true;
				btnStatus2 = (record.get('status') == '<font color=green>accepted</font>' || record.get('status') == '<font color=green>received</font>')? false: true;
			<?php
			}			
			else if ($username == 'sbelay' || $username == 'selam16'){
			?>
				btnStatus1 = (record.get('status') == '<font color=green>accepted</font>' || record.get('status') == 'SIRV created' || record.get('status') == '<font color=green>received</font>')? false: true;
				btnStatus2 = (record.get('status') == 'SIRV created')? false: true;
			<?php
			}
		}
		?>			
        var menu = new Ext.menu.Menu({
            items: [
				{
                    text: '<b>Create SIRV</b>',
                    icon: 'img/table_edit.png',
                    handler: function() {
                        CreateSIRV(record.get('id'));
                    },
                    disabled: btnStatus1
                },{
                    text: '<b>Print SIRV</b>',
                    icon: 'img/table_print.png',
                    handler: function() {
                        PrintSIRV(record.get('id'));
                    },
                    disabled: btnStatus2
                },{
                    text: '<b>Complete SIRV</b>',
                    icon: 'img/table_edit.png',
                    handler: function() {
                        CompleteSIRV(record.get('id'));
                    },
					<!-- modified btnStatus to btnStatus2 -->
                    disabled: btnStatus2
                }
            ]
        }).showAt(event.xy);
    }


if(center_panel.find('id', 'imsRequisition-tab') != "") {
	var p = center_panel.findById('imsRequisition-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Requisitions'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'imsRequisition-tab',
		xtype: 'grid',
		store: store_imsRequisitions,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('BudgetYear'); ?>", dataIndex: 'budget_year', sortable: true},
			{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true},
			{header: "<?php __('Purpose'); ?>", dataIndex: 'purpose', sortable: true},
			{header: "<?php __('Requested By'); ?>", dataIndex: 'requested_by', sortable: true},			
			{header: "<?php __('Approved By'); ?>", dataIndex: 'approved/rejected_by', sortable: true},
			{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true, hidden: false},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
      {header: "<?php __('Approved'); ?>", dataIndex: 'action_dt', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Requisitions" : "Requisition"]})'
        })
,
		

		listeners: {
			celldblclick: function(){			
				ViewImsRequisition(Ext.getCmp('imsRequisition-tab').getSelectionModel().getSelected().data.id);
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
					xtype: 'tbsplit',
					text: '<?php __('View Requisition'); ?>',
					id: 'view-imsRequisition',
					tooltip:'<?php __('<b>View Requisition</b><br />Click here to see details of the selected Requisition'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewImsRequisition(sel.data.id);
						};
					},
					menu : {
						items: [
{
							text: '<?php __('View Requisition Items'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							id: 'view-imsRequisitionItems',
							disabled: true,
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){								
									ViewParentImsRequisitionItems(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-',  '<?php __('BudgetYear'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($budget_years as $item){if($st) echo ",
							";?>['<?php echo $item['BudgetYear']['id']; ?>' ,'<?php echo $item['BudgetYear']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							filter_conditions = combo.getValue();
							store_imsRequisitions.setBaseParam('query', filter_conditions);
								
							store_imsRequisitions.reload({
								params: {
									start: 0,
									limit: list_size,
									budgetyear_id : combo.getValue()
								}
							});
						}
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Manual Requisitions to the System </b><br />Click here to create a new Requisition'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddManualImsRequisition();
					}
				}, ' ', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-imsRequisition',
					tooltip:'<?php __('<b>Edit Manual Requisitions</b><br />Click here to modify the selected Requisition'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditManualImsRequisition(sel.data.id);
						};
					}
				}, ' ', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-imsRequisition',
					tooltip:'<?php __('<b>Delete Manual Requisitions(s)</b><br />Click here to remove the selected Requisition(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Requisition'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteManualImsRequisition(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Requisition'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Requisitions'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteManualImsRequisition(sel_ids);
										}
									}
								});
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
				}, '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'imsRequisition_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByImsRequisitionName(Ext.getCmp('imsRequisition_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'imsRequisition_go_button',
					handler: function(){
						SearchByImsRequisitionName(Ext.getCmp('imsRequisition_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchImsRequisition();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_imsRequisitions,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>',
			listeners: {
				beforechange: function() { 
					store_imsRequisitions.setBaseParam('limit', list_size);
				}
			}
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('view-imsRequisition').enable();		
		if(this.getSelections()[0].data.status == '<font color=#DF7401>approved</font>'){
			p.getTopToolbar().findById('delete-imsRequisition').enable();
		}
		if(this.getSelections()[0].data.requested_by == this.getSelections()[0].get('approved/rejected_by')){
			p.getTopToolbar().findById('edit-imsRequisition').enable();	
			p.getTopToolbar().findById('delete-imsRequisition').enable();
			Ext.getCmp('view-imsRequisitionItems').enable();
		}		
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('view-imsRequisition').disable();
			p.getTopToolbar().findById('edit-imsRequisition').disable();
			p.getTopToolbar().findById('delete-imsRequisition').disable();
			Ext.getCmp('view-imsRequisitionItems').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('view-imsRequisition').disable();
			p.getTopToolbar().findById('edit-imsRequisition').disable();
			p.getTopToolbar().findById('delete-imsRequisition').disable();
			Ext.getCmp('view-imsRequisitionItems').disable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('view-imsRequisition').enable();
			if(this.getSelections()[0].data.status == '<font color=#DF7401>approved</font>'){
				p.getTopToolbar().findById('delete-imsRequisition').enable();
			}
			if(this.getSelections()[0].data.requested_by == this.getSelections()[0].get('approved/rejected_by')){
				p.getTopToolbar().findById('edit-imsRequisition').enable();
				p.getTopToolbar().findById('delete-imsRequisition').enable();
				Ext.getCmp('view-imsRequisitionItems').enable();
			}			
		}
		else{
			p.getTopToolbar().findById('view-imsRequisition').disable();
			p.getTopToolbar().findById('edit-imsRequisition').disable();
			p.getTopToolbar().findById('delete-imsRequisition').disable();
			Ext.getCmp('view-imsRequisitionItems').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_imsRequisitions.setBaseParam('query', filter_conditions);
	
	store_imsRequisitions.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
