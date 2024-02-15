
var store_ibdIbcs = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','ISSUE_DATE','NAME_OF_IMPORTER','IBC_REFERENCE','currency_id','FCY_AMOUNT','REMITTING_BANK','REIBURSING_BANK','PURCHASE_ORDER_NO','FCY_APPROVAL_INITIAL_NO','REM_FCY_AMOUNT','REM_CAD_PAYABLE_IN_BIRR','SETT_FCY','SETT_Date','SETT_Amount','PERMIT_NO','po_updated','IBC']
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdIbcs', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'ISSUE_DATE', direction: "ASC"}
//,	groupField: 'NAME_OF_IMPORTER'
});

var  export_all=true;
var ParamStore = new Ext.data.ArrayStore({ fields: ['value', 'text']});

   var	            REIBURSING_BANK='';
   var    		    PURCHASE_ORDER_NO='';
   var         	    currency_id=null;
   var      	    FCY_AMOUNT_G="";
   var              FCY_AMOUNT_L="";
   var              from_date=null;
   var              to_date=null;
   var              IBC_REFERENCE=null;
   var              NAME_OF_IMPORTER=null;


function AddIbdIbc() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdIbcs', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var ibdIbc_data = response.responseText;
			
			eval(ibdIbc_data);
			
			IbdIbcAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdIbc add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditIbdIbc(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdIbcs', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var ibdIbc_data = response.responseText;
			
			eval(ibdIbc_data);
			
			IbdIbcEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdIbc edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewIbdIbc(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ibdIbcs', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var ibdIbc_data = response.responseText;

            eval(ibdIbc_data);

            IbdIbcViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdIbc view form. Error code'); ?>: ' + response.status);
        }
    });
}

function ViewLocalSearch() {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ibdIbcs', 'action' => 'search_local')); ?>',
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
        url: '<?php echo $this->Html->url(array('controller' => 'ibdSettelments', 'action' => 'view_ibcs')); ?>/'+id.split("/").join("<"),
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

function DeleteIbdIbc(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdIbcs', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('IbdIbc successfully deleted!'); ?>');
			RefreshIbdIbcData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdIbc add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchIbdIbc(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdIbcs', 'action' => 'search')); ?>',
		success: function(response, opts){
			var ibdIbc_data = response.responseText;

			eval(ibdIbc_data);

			ibdIbcSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the ibdIbc search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByIbdIbcName(value){
	var conditions = '\'IbdIbc.name LIKE\' => \'%' + value + '%\'';
	store_ibdIbcs.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function AddSettelment(id){
	 
	 Ext.Ajax.request({
		 url: '<?php echo $this->Html->url(array('controller' => 'IbdSettelments', 'action' => 'add_ibcs')); ?>/'+id.split("/").join("<"),
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

function RefreshIbdIbcData() {
	store_ibdIbcs.reload();
}

function ExportToExcel(){
	var obj=	Object.values(store_ibdIbcs.data.items);
	var ob=Array();
	for (var i =0; i<obj.length;  i++) {
		 
		  ob[i]=obj[i]['json'];
		console.log(obj[i]['json']['IMPORT_PERMIT_NO']);
	}
	
		ob=JSON.stringify(ob);
		 console.log(ob);

	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdIbcs', 'action' => 'set_data')); ?>',
		method: 'POST', 
		params:{o:ob,sent:export_all},
		success: function(response, opts){
    window.open('<?php echo $this->Html->url(array('controller' => 'ibdIbcs', 'action' => 'export')); ?>');
		},
			
		failure: function(response, opts) {
		
		}
	});

 	
}


function updatePo(ibc_no){
		Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdIbcs', 'action' => 'update_po')); ?>/'+ibc_no.split("/").join("<"),
		success: function(response, opts) {
			var ibdIbc_data = response.responseText;
			RefreshIbdIbcData();
			eval(ibdIbc_data);
			
			IbdIbcAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Can not update po.'); ?>: ' + response.status);
		}
	});
}


if(center_panel.find('id', 'ibdIbc-tab') != "") {
	var p = center_panel.findById('ibdIbc-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Ibcs Registration'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'ibdIbc-tab',
		xtype: 'grid',
		store: store_ibdIbcs,
		columns: [
			{header: "<?php __('ISSUE DATE'); ?>", dataIndex: 'ISSUE_DATE', sortable: true},
			{header: "<?php __('NAME OF IMPORTER'); ?>", dataIndex: 'NAME_OF_IMPORTER', sortable: true},
			{header: "<?php __('IBC REFERENCE'); ?>", dataIndex: 'IBC_REFERENCE', sortable: true},
			{header: "<?php __('Currency Id'); ?>", dataIndex: 'currency_id', sortable: true},
			{header: "<?php __('PERMIT NO'); ?>", dataIndex: 'PERMIT_NO', sortable: true},
			{header: "<?php __('DRAWER BANK'); ?>", dataIndex: 'REMITTING_BANK', sortable: true},
			{header: "<?php __('REIBURSING BANK'); ?>", dataIndex: 'REIBURSING_BANK', sortable: true},
			{header: "<?php __('PURCHASE ORDER NO'); ?>", dataIndex: 'PURCHASE_ORDER_NO', sortable: true},
			{header: "<?php __('FCY APPROVAL INITIAL NO'); ?>", dataIndex: 'FCY_APPROVAL_INITIAL_NO', sortable: true},
			{header: "<?php __('SETT FCY'); ?>", dataIndex: 'SETT_FCY', sortable: true},
			{header: "<?php __('SETT LCY Amount'); ?>", dataIndex: 'SETT_Amount', sortable: true},
			//{header: "<?php __('SETT Date'); ?>", dataIndex: 'SETT_Date', sortable: true},
			{header: "<?php __('Remaining FCY Amount'); ?>", dataIndex: 'REM_FCY_AMOUNT', sortable: true},
			{header: "<?php __('Remaining in Birr'); ?>", dataIndex: 'REM_CAD_PAYABLE_IN_BIRR', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "IBCs" : "IBC"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewIbdIbc(Ext.getCmp('ibdIbc-tab').getSelectionModel().getSelected().data.id);
			},
			'rowcontextmenu': function(grid,index,event){
				event.stopEvent();
				var record=grid.getStore().getAt(index);
				Status = record.get('po_updated') == '1' ? true: false;
				var menu = new Ext.menu.Menu({
	            items: [
					{
	                    text: '<b>Update PO</b>',
	                    icon: 'img/table_edit.png',
	                    handler: function() {
	                    updatePo(record.get('IBC'));
	                    },
	                    disabled: Status
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
					tooltip:'<?php __('<b>Add IbdIbcs</b><br />Click here to create a new IbdIbc'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddIbdIbc();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-ibdIbc',
					tooltip:'<?php __('<b>Edit IbdIbcs</b><br />Click here to modify the selected IbdIbc'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditIbdIbc(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-ibdIbc',
					tooltip:'<?php __('<b>Delete IbdIbcs(s)</b><br />Click here to remove the selected IbdIbc(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					hidden:true,
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove IbdIbc'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteIbdIbc(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove IbdIbc'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected IbdIbcs'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteIbdIbc(sel_ids);
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
				}, ' ', '-', ' ', {
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
					id: 'ibdIbc_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByIbdIbcName(Ext.getCmp('ibdIbc_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'ibdIbc_go_button',
					handler: function(){
						SearchByIbdIbcName(Ext.getCmp('ibdIbc_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchIbdIbc();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_ibdIbcs,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>',
				doRefresh : function(){
         		 	 REIBURSING_BANK='';
            		 PURCHASE_ORDER_NO='';
         		  currency_id=null;
         		  FCY_AMOUNT_G="";
                  FCY_AMOUNT_L="";
                  from_date=null;
                  to_date=null;
                  IBC_REFERENCE=null;
                   NAME_OF_IMPORTER=null;

         		store_ibdIbcs.load({
					params: {
						start: 0,          
						limit: list_size
					}
				});
  			}
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-ibdIbc').enable();
		//p.getTopToolbar().findById('delete-ibdIbc').enable();
		p.getTopToolbar().findById('view-ibdIbc').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-ibdIbc').disable();
			p.getTopToolbar().findById('view-ibdIbc').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-ibdIbc').disable();
			p.getTopToolbar().findById('view-ibdIbc').disable();
			//p.getTopToolbar().findById('delete-ibdIbc').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-ibdIbc').enable();
			p.getTopToolbar().findById('view-ibdIbc').enable();
			//p.getTopToolbar().findById('delete-ibdIbc').enable();
		}
		else{
			p.getTopToolbar().findById('edit-ibdIbc').disable();
			p.getTopToolbar().findById('view-ibdIbc').disable();
			p.getTopToolbar().findById('delete-ibdIbc').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_ibdIbcs.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
