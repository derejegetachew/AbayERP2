
var store_ibdSesameSeedsExportContracts = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','exporter_name','contract_date','contract_registry_date','contract_registration_no','quantity_mt','price_mt','type_of_currency','total_price','shipment_date','delivery_term','payment_method','sales_contract_reference'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdSesameSeedsExportContracts', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'exporter_name', direction: "ASC"}
//,	groupField: 'contract_date'
});

var  export_all=true;

var ParamStore = new Ext.data.ArrayStore({ fields: ['value', 'text']});

 var contract_registration_no='';
    var     		  currency_id=null;
    var     		  FCY_AMOUNT_G="";
      var            FCY_AMOUNT_L="";
      var            from_date=null;
       var           to_date=null;
       var           exporter_name=null;


function AddIbdSesameSeedsExportContract() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdSesameSeedsExportContracts', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var ibdSesameSeedsExportContract_data = response.responseText;
			
			eval(ibdSesameSeedsExportContract_data);
			
			IbdSesameSeedsExportContractAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdSesameSeedsExportContract add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditIbdSesameSeedsExportContract(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdSesameSeedsExportContracts', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var ibdSesameSeedsExportContract_data = response.responseText;
			
			eval(ibdSesameSeedsExportContract_data);
			
			IbdSesameSeedsExportContractEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdSesameSeedsExportContract edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewIbdSesameSeedsExportContract(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ibdSesameSeedsExportContracts', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var ibdSesameSeedsExportContract_data = response.responseText;

            eval(ibdSesameSeedsExportContract_data);

            IbdSesameSeedsExportContractViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdSesameSeedsExportContract view form. Error code'); ?>: ' + response.status);
        }
    });
}

function ViewLocalSearch() {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ibdSesameSeedsExportContracts', 'action' => 'search_local')); ?>',
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

function DeleteIbdSesameSeedsExportContract(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdSesameSeedsExportContracts', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('IbdSesameSeedsExportContract successfully deleted!'); ?>');
			RefreshIbdSesameSeedsExportContractData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdSesameSeedsExportContract add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchIbdSesameSeedsExportContract(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdSesameSeedsExportContracts', 'action' => 'search')); ?>',
		success: function(response, opts){
			var ibdSesameSeedsExportContract_data = response.responseText;

			eval(ibdSesameSeedsExportContract_data);

			ibdSesameSeedsExportContractSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the ibdSesameSeedsExportContract search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByIbdSesameSeedsExportContractName(value){
	var conditions = '\'IbdSesameSeedsExportContract.name LIKE\' => \'%' + value + '%\'';
	store_ibdSesameSeedsExportContracts.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshIbdSesameSeedsExportContractData() {
	store_ibdSesameSeedsExportContracts.reload();
}
function ExportToExcel(){
	var obj=	Object.values(store_ibdSesameSeedsExportContracts.data.items);
	var ob=Array();
	for (var i =0; i<obj.length;  i++) {
		 
		  ob[i]=obj[i]['json'];
		
	}
	
		ob=JSON.stringify(ob);
		 console.log(ob);

		 Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdSesameSeedsExportContracts', 'action' => 'set_data')); ?>',
		method: 'POST', 
		params:{o:ob,sent:export_all},
		success: function(response, opts){
window.open('<?php echo $this->Html->url(array('controller' => 'ibdSesameSeedsExportContracts', 'action' => 'export')); ?>');
		},
			
		failure: function(response, opts) {
		
		}
	});
}


if(center_panel.find('id', 'ibdSesameSeedsExportContract-tab') != "") {
	var p = center_panel.findById('ibdSesameSeedsExportContract-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Ibd Sesame Seeds Export Contracts'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'ibdSesameSeedsExportContract-tab',
		xtype: 'grid',
		store: store_ibdSesameSeedsExportContracts,
		columns: [
			{header: "<?php __('Exporter Name'); ?>", dataIndex: 'exporter_name', sortable: true},
			{header: "<?php __('Contract Date'); ?>", dataIndex: 'contract_date', sortable: true},
			{header: "<?php __('Contract Registry Date'); ?>", dataIndex: 'contract_registry_date', sortable: true},
			{header: "<?php __('Contract Registration No'); ?>", dataIndex: 'contract_registration_no', sortable: true},
			{header: "<?php __('Quantity Mt'); ?>", dataIndex: 'quantity_mt', sortable: true},
			{header: "<?php __('Price Mt'); ?>", dataIndex: 'price_mt', sortable: true},
			{header: "<?php __('Type Of Currency'); ?>", dataIndex: 'type_of_currency', sortable: true},
			{header: "<?php __('Total Price'); ?>", dataIndex: 'total_price', sortable: true},
			{header: "<?php __('Shipment Date'); ?>", dataIndex: 'shipment_date', sortable: true},
			{header: "<?php __('Delivery Term'); ?>", dataIndex: 'delivery_term', sortable: true},
			{header: "<?php __('Payment Method'); ?>", dataIndex: 'payment_method', sortable: true},
			{header: "<?php __('Sales Contract Reference'); ?>", dataIndex: 'sales_contract_reference', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "IbdSesameSeedsExportContracts" : "IbdSesameSeedsExportContract"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewIbdSesameSeedsExportContract(Ext.getCmp('ibdSesameSeedsExportContract-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add IbdSesameSeedsExportContracts</b><br />Click here to create a new IbdSesameSeedsExportContract'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddIbdSesameSeedsExportContract();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-ibdSesameSeedsExportContract',
					tooltip:'<?php __('<b>Edit IbdSesameSeedsExportContracts</b><br />Click here to modify the selected IbdSesameSeedsExportContract'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditIbdSesameSeedsExportContract(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-ibdSesameSeedsExportContract',
					tooltip:'<?php __('<b>Delete IbdSesameSeedsExportContracts(s)</b><br />Click here to remove the selected IbdSesameSeedsExportContract(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove IbdSesameSeedsExportContract'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteIbdSesameSeedsExportContract(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove IbdSesameSeedsExportContract'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected IbdSesameSeedsExportContracts'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteIbdSesameSeedsExportContract(sel_ids);
										}
									}
								});
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
				},' ', '-', ' ',{
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
					id: 'ibdSesameSeedsExportContract_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByIbdSesameSeedsExportContractName(Ext.getCmp('ibdSesameSeedsExportContract_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'ibdSesameSeedsExportContract_go_button',
					handler: function(){
						SearchByIbdSesameSeedsExportContractName(Ext.getCmp('ibdSesameSeedsExportContract_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchIbdSesameSeedsExportContract();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_ibdSesameSeedsExportContracts,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>',
			doRefresh : function(){

         		 FROM_THEIR_FCY_ACCOUNT='';
            		 TT_REFERENCE='';
         		 currency_id=null;
         		  FCY_AMOUNT_G="";
                  FCY_AMOUNT_L="";
                  from_date=null;
                  to_date=null;
                  NAME_OF_APPLICANT=null;


         		store_ibdSesameSeedsExportContracts.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
  			}
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-ibdSesameSeedsExportContract').enable();
		p.getTopToolbar().findById('delete-ibdSesameSeedsExportContract').enable();
		p.getTopToolbar().findById('view-ibdSesameSeedsExportContract').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-ibdSesameSeedsExportContract').disable();
			p.getTopToolbar().findById('view-ibdSesameSeedsExportContract').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-ibdSesameSeedsExportContract').disable();
			p.getTopToolbar().findById('view-ibdSesameSeedsExportContract').disable();
			p.getTopToolbar().findById('delete-ibdSesameSeedsExportContract').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-ibdSesameSeedsExportContract').enable();
			p.getTopToolbar().findById('view-ibdSesameSeedsExportContract').enable();
			p.getTopToolbar().findById('delete-ibdSesameSeedsExportContract').enable();
		}
		else{
			p.getTopToolbar().findById('edit-ibdSesameSeedsExportContract').disable();
			p.getTopToolbar().findById('view-ibdSesameSeedsExportContract').disable();
			p.getTopToolbar().findById('delete-ibdSesameSeedsExportContract').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_ibdSesameSeedsExportContracts.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
