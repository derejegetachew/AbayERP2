//<script>
var store_imsTransfers = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','ims_sirv','from_user','to_user','from_branch','to_branch','observer','approved_by','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransfers', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'from_branch'
});


function AddImsTransfer() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransfers', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var imsTransfer_data = response.responseText;
			
			eval(imsTransfer_data);
			
			ImsTransferAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransfer add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditImsTransfer(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransfers', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var imsTransfer_data = response.responseText;
			
			eval(imsTransfer_data);
			
			ImsTransferEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransfer edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewImsTransfer(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsTransfers', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var imsTransfer_data = response.responseText;

            eval(imsTransfer_data);

            ImsTransferViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransfer view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentImsTransferItems(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsTransferItems', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_imsTransferItems_data = response.responseText;

            eval(parent_imsTransferItems_data);

            parentImsTransferItemsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteImsTransfer(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransfers', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('ImsTransfer successfully deleted!'); ?>');
			RefreshImsTransferData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the imsTransfer add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchImsTransfer(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransfers', 'action' => 'search')); ?>',
		success: function(response, opts){
			var imsTransfer_data = response.responseText;

			eval(imsTransfer_data);

			imsTransferSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the imsTransfer search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByImsTransferName(value){
	var conditions = '\'ImsTransfer.name LIKE\' => \'%' + value + '%\'';
	store_imsTransfers.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshImsTransferData() {
	store_imsTransfers.reload();
}

var popUpWin=0;
function popUpWindow(URLStr, left, top, width, height) {
        if(popUpWin){
            if(!popUpWin.closed) popUpWin.close();
        }
        popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
    }

function PrintTransfer(id) {
        url = '<?php echo $this->Html->url(array('controller' => 'ImsTransfers', 'action' => 'print_transfer')); ?>/' + id;	
       
        popUpWindow(url, 250, 20, 900, 600);
}

function Transfer(id) {
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_transfer_items', 'action' => 'index_3')); ?>/'+id,
            success: function(response, opts) {
                var sirv_item_data = response.responseText;

                eval(sirv_item_data);

                parentimsTransferItemsViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the SIRV item form. Error code'); ?>: ' + response.status);
            }
        });
}

function showMenu(grid, index, event) {
        event.stopEvent();
		var record = grid.getStore().getAt(index);
		var btnStatus2 = true;
		<?php foreach($groups as $group){
			if ($group['name'] == 'Stock Record Officer' or $group['name'] == 'Administrators'){
			?>
				btnStatus2 = false;				
			<?php
			}			
		}
		?>	
        var menu = new Ext.menu.Menu({
            items: [
                {
                    text: '<b>Print Transfer</b>',
                    icon: 'img/table_print.png',
                    handler: function() {
                        PrintTransfer(record.get('id'));
                    },
                    disabled: false
                },				
				{
                    text: '<b>Transfer</b>',
                    icon: 'img/table_add.png',
                    handler: function() {
                        Transfer(record.get('id'));
                    },
                    disabled: btnStatus2
                }
            ]
        }).showAt(event.xy);
    }

if(center_panel.find('id', 'imsTransfer-tab') != "") {
	var p = center_panel.findById('imsTransfer-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Ims Transfers'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'imsTransfer-tab',
		xtype: 'grid',
		store: store_imsTransfers,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('ImsSirv'); ?>", dataIndex: 'ims_sirv', sortable: true},
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
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "ImsTransfers" : "ImsTransfer"]})'
        })
,
		listeners: {
			celldblclick: function(){
				//ViewImsTransfer(Ext.getCmp('imsTransfer-tab').getSelectionModel().getSelected().data.id);
				PrintTransfer(Ext.getCmp('imsTransfer-tab').getSelectionModel().getSelected().data.id);
			},
			'rowcontextmenu': function(grid, index, event) {
				showMenu(grid, index, event);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [ {
					xtype: 'tbsplit',
					text: '<?php __('View ImsTransfer'); ?>',
					id: 'view-imsTransfer',
					tooltip:'<?php __('<b>View ImsTransfer</b><br />Click here to see details of the selected ImsTransfer'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewImsTransfer(sel.data.id);
						};
					},
					menu : {
						items: [
{
							text: '<?php __('View Ims Transfer Items'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentImsTransferItems(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-',  '<?php __('ImsSirv'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($ims_sirvs as $item){if($st) echo ",
							";?>['<?php echo $item['ImsSirv']['id']; ?>' ,'<?php echo $item['ImsSirv']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_imsTransfers.reload({
								params: {
									start: 0,
									limit: list_size,
									imssirv_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'imsTransfer_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByImsTransferName(Ext.getCmp('imsTransfer_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'imsTransfer_go_button',
					handler: function(){
						SearchByImsTransferName(Ext.getCmp('imsTransfer_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchImsTransfer();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_imsTransfers,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		//p.getTopToolbar().findById('edit-imsTransfer').enable();
		//p.getTopToolbar().findById('delete-imsTransfer').enable();
		p.getTopToolbar().findById('view-imsTransfer').enable();
		if(this.getSelections().length > 1){
			//p.getTopToolbar().findById('edit-imsTransfer').disable();
			p.getTopToolbar().findById('view-imsTransfer').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			//p.getTopToolbar().findById('edit-imsTransfer').disable();
			p.getTopToolbar().findById('view-imsTransfer').disable();
			//p.getTopToolbar().findById('delete-imsTransfer').enable();
		}
		else if(this.getSelections().length == 1){
			//p.getTopToolbar().findById('edit-imsTransfer').enable();
			p.getTopToolbar().findById('view-imsTransfer').enable();
			//p.getTopToolbar().findById('delete-imsTransfer').enable();
		}
		else{
			//p.getTopToolbar().findById('edit-imsTransfer').disable();
			p.getTopToolbar().findById('view-imsTransfer').disable();
			//p.getTopToolbar().findById('delete-imsTransfer').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_imsTransfers.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
