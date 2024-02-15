
var store_ibdPurchaseOrders = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','PURCHASE_ORDER_ISSUE_DATE','NAME_OF_IMPORTER','PURCHASE_ORDER_NO','currency_id','FCY_AMOUNT','RATE','CAD_PAYABLE_IN_BIRR','ITEM_DESCRIPTION_OF_GOODS','DRAWER_NAME','MINUTE_NO','FCY_APPROVAL_DATE','FCY_APPROVAL_INTIAL_ORDER_NO','FROM_THEIR_FCY_ACCOUNT','SETT_DATE','SETT_FCY_AMOUNT','SETT_PO_ISSUE_DATE_RATE','SETT_CAD_PAYABLE','IBC_NO','REM_FCY_AMOUNT','REM_CAD_PAYABLE_IN_BIRR','EXPIRE_DATE','REMARK','percent','NBE_ACCOUNT'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdPurchaseOrders', 'action' => 'list_data')); ?>'
	})
  ,	sortInfo:{field: 'PURCHASE_ORDER_ISSUE_DATE', direction: "ASC"},
  listeners:{
  
  	load:function(str,rec,obj){
   
  	}
  }
//,groupField: 'NAME_OF_IMPORTER'
});


var  export_all=true;

var ParamStore = new Ext.data.ArrayStore({ fields:['value', 'text']});

var FROM_THEIR_FCY_ACCOUNT='';
var currency_id="";
var FCY_AMOUNT_G="";
var FCY_AMOUNT_L="";
var PURCHASE_ORDER_NO="";
var from_date=null;
var to_date=null;
var  NAME_OF_IMPORTER=null;


function AddIbdPurchaseOrder() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdPurchaseOrders', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var ibdPurchaseOrder_data = response.responseText;
			
			eval(ibdPurchaseOrder_data);
			
			IbdPurchaseOrderAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdPurchaseOrder add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditIbdPurchaseOrder(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdPurchaseOrders', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var ibdPurchaseOrder_data = response.responseText;
			
			eval(ibdPurchaseOrder_data);
			
			IbdPurchaseOrderEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdPurchaseOrder edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewIbdPurchaseOrder(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ibdPurchaseOrders', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var ibdPurchaseOrder_data = response.responseText;

            eval(ibdPurchaseOrder_data);

            IbdPurchaseOrderViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdPurchaseOrder view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewLocalSearch() {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ibdPurchaseOrders', 'action' => 'search_local')); ?>',
        success: function(response, opts) {
            var ibdPurchaseOrder_data = response.responseText;

            eval(ibdPurchaseOrder_data);

            SearchLocalWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdPurchaseOrder view form. Error code'); ?>: ' + response.status);
        }
    });
}


function ViewIbdSettelment(id){
	Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ibdSettelments', 'action' => 'view')); ?>/'+id.split("/").join("<"),
        success: function(response, opts) {
            var ibdPurchaseOrder_data = response.responseText;

            eval(ibdPurchaseOrder_data);

            IbdSettelmentViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdPurchaseOrder view form. Error code'); ?>: ' + response.status);
        }
    });
}

function ViewCancellation(id){
	Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ibdSettelments', 'action' => 'view_c')); ?>/'+id.split("/").join("<"),
        success: function(response, opts) {
            var ibdPurchaseOrder_data = response.responseText;

            eval(ibdPurchaseOrder_data);

            IbdSettelmentViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdPurchaseOrder view form. Error code'); ?>: ' + response.status);
        }
    });
}

function Cancellation(id){
	Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ibdPurchaseOrders', 'action' => 'add_c')); ?>/'+id.split("/").join("<"),
        success: function(response, opts) {
            var ibdPurchaseOrder_data = response.responseText;

            eval(ibdPurchaseOrder_data);

            IbdIbcAddWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdPurchaseOrder view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteIbdPurchaseOrder(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdPurchaseOrders', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('IbdPurchaseOrder successfully deleted!'); ?>');
			RefreshIbdPurchaseOrderData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdPurchaseOrder add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchIbdPurchaseOrder(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdPurchaseOrders', 'action' => 'search')); ?>',
		success: function(response, opts){
			var ibdPurchaseOrder_data = response.responseText;

			eval(ibdPurchaseOrder_data);

			ibdPurchaseOrderSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the ibdPurchaseOrder search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByIbdPurchaseOrderName(value){
	var conditions = '\'IbdPurchaseOrder.name LIKE\' => \'%' + value + '%\'';
	store_ibdPurchaseOrders.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshIbdPurchaseOrderData() {
	store_ibdPurchaseOrders.reload();

}

function AddSettelment(id){
	 
	 Ext.Ajax.request({
		 url: '<?php echo $this->Html->url(array('controller' => 'IbdSettelments', 'action' => 'add')); ?>/'+id.split("/").join("<"),
		 success: function(response, opts) {
			var settelment_data = response.responseText;
			
			eval(settelment_data);
			
			
			IbdSettelmentAddWindow.show();
			 
		 },
		 failure: function(response, opts) {
			 Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpActual to be deleted. Error code'); ?>: ' + response.status);
		 }
	 });
 }

 function ExportToExcel(){
	var obj=	Object.values(store_ibdPurchaseOrders.data.items);
	var ob=Array();
	for (var i =0; i<obj.length;  i++) {
		 
		  ob[i]=obj[i]['json'];
		console.log(obj[i]['json']['IMPORT_PERMIT_NO']);
	}
		
		ob=JSON.stringify(ob);
		 console.log(ob);

		 Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdPurchaseOrders', 'action' => 'set_data')); ?>',
		method: 'POST', 
		params:{o:ob,sent:export_all},
		success: function(response, opts){
window.open('<?php echo $this->Html->url(array('controller' => 'ibdPurchaseOrders', 'action' => 'export')); ?>');
		},
			
		failure: function(response, opts) {
		
		}
	});
	
 	
}


if(center_panel.find('id', 'ibdPurchaseOrder-tab') != "") {
	var p = center_panel.findById('ibdPurchaseOrder-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Purchase Orders'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'ibdPurchaseOrder-tab',
		xtype: 'grid',
		store: store_ibdPurchaseOrders,
		columns: [
			{header: "<?php __('PURCHASE ORDER ISSUE DATE'); ?>", dataIndex: 'PURCHASE_ORDER_ISSUE_DATE', sortable: true},
			{header: "<?php __('NAME OF IMPORTER'); ?>", dataIndex: 'NAME_OF_IMPORTER', sortable: true},
			{header: "<?php __('PURCHASE ORDER NO'); ?>", dataIndex: 'PURCHASE_ORDER_NO', sortable: true},
			{header: "<?php __('Currency Id'); ?>", dataIndex: 'currency_id', sortable: true},
			{header: "<?php __('FCY AMOUNT'); ?>", dataIndex: 'FCY_AMOUNT', sortable: true},
			{header: "<?php __('RATE'); ?>", dataIndex: 'RATE', sortable: true},
			{header: "<?php __('CAD PAYABLE IN BIRR'); ?>", dataIndex: 'CAD_PAYABLE_IN_BIRR', sortable: true},
			{header: "<?php __('Collected %'); ?>", dataIndex: 'percent', sortable: true},
			{header: "<?php __('ITEM DESCRIPTION OF GOODS'); ?>", dataIndex: 'ITEM_DESCRIPTION_OF_GOODS', sortable: true},
			{header: "<?php __('DRAWER NAME'); ?>", dataIndex: 'DRAWER_NAME', sortable: true},
			{header: "<?php __('MINUTE NO'); ?>", dataIndex: 'MINUTE_NO', sortable: true},
			{header: "<?php __('FCY APPROVAL DATE'); ?>", dataIndex: 'FCY_APPROVAL_DATE', sortable: true},
				
			{header: "<?php __('FCY APPROVAL INTIAL ORDER NO'); ?>", dataIndex: 'FCY_APPROVAL_INTIAL_ORDER_NO', sortable: true},
			{header: "<?php __('FROM THEIR FCY ACCOUNT'); ?>", dataIndex: 'FROM_THEIR_FCY_ACCOUNT', sortable: true},
			{header: "<?php __('EXPIRE DATE'); ?>", dataIndex: 'EXPIRE_DATE', sortable: true},
		//	{header: "<?php __('SETT FCY AMOUNT'); ?>", dataIndex: 'SETT_FCY_AMOUNT', sortable: true},
		//	{header: "<?php __('SETT PO ISSUE DATE RATE'); ?>", dataIndex: 'SETT_PO_ISSUE_DATE_RATE', sortable: true},
		//	{header: "<?php __('SETT CAD PAYABLE'); ?>", dataIndex: 'SETT_CAD_PAYABLE', sortable: true},
		//	{header: "<?php __('IBC NO'); ?>", dataIndex: 'IBC_NO', sortable: true},
			{header: "<?php __('REM FCY AMOUNT'); ?>", dataIndex: 'REM_FCY_AMOUNT', sortable: true},
			{header: "<?php __('REM CAD PAYABLE IN BIRR'); ?>", dataIndex: 'REM_CAD_PAYABLE_IN_BIRR', sortable: true},
			{header: "<?php __('NBE ACCOUNT'); ?>", dataIndex: 'NBE_ACCOUNT', sortable: true},
			{header: "<?php __('REMARK'); ?>", dataIndex: 'REMARK', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Purchase Orders" : "Purchase Order"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewIbdPurchaseOrder(Ext.getCmp('ibdPurchaseOrder-tab').getSelectionModel().getSelected().data.id);
			},
			'rowcontextmenu': function(grid,index,event){
						event.stopEvent();
						var record=grid.getStore().getAt(index);
						var menu = new Ext.menu.Menu({
			            items: [
							{
			                    text: '<b>View Settelment</b>',
			                    icon: 'img/table_view.png',
			                    handler: function() {
			                         
			                        ViewIbdSettelment(record.get('PURCHASE_ORDER_NO'));
			                    },
			                    disabled: false
			                },
			                {
			                    text: '<b>View Cancellation</b>',
			                    icon: 'img/table_view.png',
			                    handler: function() {
			                         
			                        ViewCancellation(record.get('PURCHASE_ORDER_NO'));
			                    },
			                    disabled: false
			                },
			                {
			                    text: '<b>Cancellation</b>',
			                    icon: 'img/table_delete.png',
			                    handler: function() {
			                         
			                        Cancellation(record.get('PURCHASE_ORDER_NO'));
			                    },
			                    disabled: false
			                }
			            ]
			        }).showAt(event.xy);
		}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add IbdPurchaseOrders</b><br />Click here to create a new IbdPurchaseOrder'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddIbdPurchaseOrder();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-ibdPurchaseOrder',
					tooltip:'<?php __('<b>Edit IbdPurchaseOrders</b><br />Click here to modify the selected IbdPurchaseOrder'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditIbdPurchaseOrder(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-ibdPurchaseOrder',
					tooltip:'<?php __('<b>Delete IbdPurchaseOrders(s)</b><br />Click here to remove the selected IbdPurchaseOrder(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					hidden:true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove IbdPurchaseOrder'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteIbdPurchaseOrder(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove IbdPurchaseOrder'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected IbdPurchaseOrders'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteIbdPurchaseOrder(sel_ids);
										}
									}
								});
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
				}, ' ', '-', ' ',{
					xtype: 'tbbutton',
					text: '<?php __('Export To Excel'); ?>',
					tooltip:'<?php __('<b>Add IbdImportPermits</b><br />Click here to create a new IbdImportPermit'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						ExportToExcel();
					}
				} , ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Search'); ?>',
					id: 'view-ibdPurchaseOrder',
					tooltip:'<?php __('<b>View IbdPurchaseOrder</b><br />Click here to see details of the selected IbdPurchaseOrder'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
					
						
							ViewLocalSearch();
						
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'ibdPurchaseOrder_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByIbdPurchaseOrderName(Ext.getCmp('ibdPurchaseOrder_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'ibdPurchaseOrder_go_button',
					handler: function(){
						SearchByIbdPurchaseOrderName(Ext.getCmp('ibdPurchaseOrder_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchIbdPurchaseOrder();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_ibdPurchaseOrders,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>',
			doRefresh : function(){
         		 FROM_THEIR_FCY_ACCOUNT='';
         		 currency_id=null;
         		  FCY_AMOUNT_G="";
                  FCY_AMOUNT_L="";
                  PURCHASE_ORDER_NO='';
                  from_date=null;
                  to_date=null;
                   NAME_OF_IMPORTER=null;
         		store_ibdPurchaseOrders.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
  			}
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-ibdPurchaseOrder').enable();
		p.getTopToolbar().findById('delete-ibdPurchaseOrder').enable();
		p.getTopToolbar().findById('view-ibdPurchaseOrder').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-ibdPurchaseOrder').disable();
			p.getTopToolbar().findById('view-ibdPurchaseOrder').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-ibdPurchaseOrder').disable();
			p.getTopToolbar().findById('view-ibdPurchaseOrder').disable();
			p.getTopToolbar().findById('delete-ibdPurchaseOrder').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-ibdPurchaseOrder').enable();
			p.getTopToolbar().findById('view-ibdPurchaseOrder').enable();
			p.getTopToolbar().findById('delete-ibdPurchaseOrder').enable();
		}
		else{
			p.getTopToolbar().findById('edit-ibdPurchaseOrder').disable();
			p.getTopToolbar().findById('view-ibdPurchaseOrder').disable();
			p.getTopToolbar().findById('delete-ibdPurchaseOrder').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_ibdPurchaseOrders.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
