//<script>
var store_imsTransferBefores = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','ims_sirv_before','from_user','to_user','from_branch','to_branch','observer','approved_by','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferBefores', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'from_branch'
});


function AddImsTransferBefore() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferBefores', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var imsTransferBefore_data = response.responseText;
			
			eval(imsTransferBefore_data);
			
			ImsTransferBeforeAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransferBefore add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditImsTransferBefore(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferBefores', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var imsTransferBefore_data = response.responseText;
			
			eval(imsTransferBefore_data);
			
			ImsTransferBeforeEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransferBefore edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsTransferBefore(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsTransferBefores', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var imsTransferBefore_data = response.responseText;

            eval(imsTransferBefore_data);

            ImsTransferBeforeViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransferBefore view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentImsTransferItemBefores(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsTransferItemBefores', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_imsTransferItemBefores_data = response.responseText;

            eval(parent_imsTransferItemBefores_data);

            parentImsTransferItemBeforesViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteImsTransferBefore(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferBefores', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsTransferBefore successfully deleted!'); ?>');
			RefreshImsTransferBeforeData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransferBefore add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchImsTransferBefore(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferBefores', 'action' => 'search')); ?>',
		success: function(response, opts){
			var imsTransferBefore_data = response.responseText;

			eval(imsTransferBefore_data);

			imsTransferBeforeSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the imsTransferBefore search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByImsTransferBeforeName(value){
	var conditions = '\'ImsTransferBefore.name LIKE\' => \'%' + value + '%\'';
	store_imsTransferBefores.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshImsTransferBeforeData() {
	store_imsTransferBefores.reload();
}

var popUpWin=0;
function popUpWindow(URLStr, left, top, width, height) {
        if(popUpWin){
            if(!popUpWin.closed) popUpWin.close();
        }
        popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
    }

function PrintTransferBefore(id) {
        url = '<?php echo $this->Html->url(array('controller' => 'imsTransferBefores', 'action' => 'print_transfer_before')); ?>/' + id;	
       
        popUpWindow(url, 250, 20, 900, 600);
}

if(center_panel.find('id', 'imsTransferBefore-tab') != "") {
	var p = center_panel.findById('imsTransferBefore-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Ims Transfer Befores'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'imsTransferBefore-tab',
		xtype: 'grid',
		store: store_imsTransferBefores,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('ImsSirvBefore'); ?>", dataIndex: 'ims_sirv_before', sortable: true},
			{header: "<?php __('From User'); ?>", dataIndex: 'from_user', sortable: true},
			{header: "<?php __('To User'); ?>", dataIndex: 'to_user', sortable: true},
			{header: "<?php __('From Branch'); ?>", dataIndex: 'from_branch', sortable: true},
			{header: "<?php __('To Branch'); ?>", dataIndex: 'to_branch', sortable: true},
			{header: "<?php __('Observer'); ?>", dataIndex: 'observer', sortable: true},
			{header: "<?php __('Approved By'); ?>", dataIndex: 'approved_by', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "ImsTransferBefores" : "ImsTransferBefore"]})'
        })
,
		listeners: {
			celldblclick: function(){
				//ViewImsTransferBefore(Ext.getCmp('imsTransferBefore-tab').getSelectionModel().getSelected().data.id);
				PrintTransferBefore(Ext.getCmp('imsTransferBefore-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [/*{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add ImsTransferBefores</b><br />Click here to create a new ImsTransferBefore'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddImsTransferBefore();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-imsTransferBefore',
					tooltip:'<?php __('<b>Edit ImsTransferBefores</b><br />Click here to modify the selected ImsTransferBefore'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditImsTransferBefore(sel.data.id);
						};
					}
				}, ' ', '-', ' ',
				*/ 
				// code added @melkamu  //
				 {
					xtype: 'tbbutton',
					text: '<?php __('Remove Last Tranfer'); ?>',
					id: 'delete-imsTransferBefore',
					tooltip:'<?php __('<b>Remove Last ImsTransferBefores(s)</b><br />Click here to remove the selected ImsTransferBefore(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Ims Transfer Before'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove!!!  Are you sure you want to delete Transfer '); ?> '+sel[0].data.name+' ?        This action cannot be undone' ,
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteImsTransferBefore(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Ims Transfer Before'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove Are you sure you want to delete the selected ImsTransferBefores?  This action cannot be undone'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteImsTransferBefore(sel_ids);
										}
									}
								});
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
				},
				// end of remove transfer befor //
				
				{
					xtype: 'tbsplit',
					text: '<?php __('View ImsTransferBefore'); ?>',
					id: 'view-imsTransferBefore',
					tooltip:'<?php __('<b>View ImsTransferBefore</b><br />Click here to see details of the selected ImsTransferBefore'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewImsTransferBefore(sel.data.id);
						};
					},
					menu : {
						items: [
{
							text: '<?php __('View Ims Transfer Item Befores'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentImsTransferItemBefores(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-',  '<?php __('ImsSirvBefore'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($ims_sirv_befores as $item){if($st) echo ",
							";?>['<?php echo $item['ImsSirvBefore']['id']; ?>' ,'<?php echo $item['ImsSirvBefore']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_imsTransferBefores.reload({
								params: {
									start: 0,
									limit: list_size,
									imssirvbefore_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'imsTransferBefore_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByImsTransferBeforeName(Ext.getCmp('imsTransferBefore_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'imsTransferBefore_go_button',
					handler: function(){
						SearchByImsTransferBeforeName(Ext.getCmp('imsTransferBefore_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchImsTransferBefore();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_imsTransferBefores,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		// p.getTopToolbar().findById('edit-imsTransferBefore').enable();
		p.getTopToolbar().findById('delete-imsTransferBefore').enable();
		p.getTopToolbar().findById('view-imsTransferBefore').enable();
		if(this.getSelections().length > 1){
			// p.getTopToolbar().findById('edit-imsTransferBefore').disable();
			p.getTopToolbar().findById('view-imsTransferBefore').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			// p.getTopToolbar().findById('edit-imsTransferBefore').disable();
			p.getTopToolbar().findById('view-imsTransferBefore').disable();
			p.getTopToolbar().findById('delete-imsTransferBefore').enable();
		}
		else if(this.getSelections().length == 1){
			// p.getTopToolbar().findById('edit-imsTransferBefore').enable();
			p.getTopToolbar().findById('view-imsTransferBefore').enable();
			p.getTopToolbar().findById('delete-imsTransferBefore').enable();
		}
		else{
			// p.getTopToolbar().findById('edit-imsTransferBefore').disable();
			p.getTopToolbar().findById('view-imsTransferBefore').disable();
			p.getTopToolbar().findById('delete-imsTransferBefore').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_imsTransferBefores.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
