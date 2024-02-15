
var store_ibdOdbcs = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','Exporter_Name','payment_term','Doc_Ref','Permit_No','NBE_Permit_no','Branch_Name','ODBC_DD','Destination','Single_Ent','currency_type','doc_permitt_amount','value_date','proceed_amount','rate','lcy','Deduction'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdOdbcs', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'Exporter_Name', direction: "ASC"}
});

var  export_all=true;

var ParamStore = new Ext.data.ArrayStore({ fields: ['value', 'text']});

	var  Doc_Ref='';
        var 		  currency_id=null;
        var 		  FCY_AMOUNT_G="";
        var          FCY_AMOUNT_L="";
         var         from_date=null;
        var          to_date=null;
         var         NBE_Permit_no=null;
         var          Permit_No=null;
         var         Exporter_Name=null;


function AddIbdOdbc() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdOdbcs', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var ibdOdbc_data = response.responseText;
			
			eval(ibdOdbc_data);
			
			IbdOdbcAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdOdbc add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditIbdOdbc(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdOdbcs', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var ibdOdbc_data = response.responseText;
			
			eval(ibdOdbc_data);
			
			IbdOdbcEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdOdbc edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewIbdOdbc(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ibdOdbcs', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var ibdOdbc_data = response.responseText;

            eval(ibdOdbc_data);

            IbdOdbcViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdOdbc view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewLocalSearch() {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ibdOdbcs', 'action' => 'search_local')); ?>',
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

function DeleteIbdOdbc(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdOdbcs', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('IbdOdbc successfully deleted!'); ?>');
			RefreshIbdOdbcData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdOdbc add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchIbdOdbc(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdOdbcs', 'action' => 'search')); ?>',
		success: function(response, opts){
			var ibdOdbc_data = response.responseText;

			eval(ibdOdbc_data);

			ibdOdbcSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the ibdOdbc search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByIbdOdbcName(value){
	var conditions = '\'IbdOdbc.name LIKE\' => \'%' + value + '%\'';
	store_ibdOdbcs.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshIbdOdbcData() {
	store_ibdOdbcs.reload();
}

function ExportToExcel(){
	var obj=	Object.values(store_ibdOdbcs.data.items);
	var ob=Array();
	for (var i =0; i<obj.length;  i++) {
		 
		  ob[i]=obj[i]['json'];
		
	}
	
		ob=JSON.stringify(ob);
		 console.log(ob);

		 Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdOdbcs', 'action' => 'set_data')); ?>',
		method: 'POST', 
		params:{o:ob,sent:export_all},
		success: function(response, opts){
window.open('<?php echo $this->Html->url(array('controller' => 'ibdOdbcs', 'action' => 'export')); ?>');
		},
			
		failure: function(response, opts) {
		
		}
	});
}


if(center_panel.find('id', 'ibdOdbc-tab') != "") {
	var p = center_panel.findById('ibdOdbc-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Ibd Odbcs'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'ibdOdbc-tab',
		xtype: 'grid',
		store: store_ibdOdbcs,
		columns: [
			{header: "<?php __('Exporter Name'); ?>", dataIndex: 'Exporter_Name', sortable: true},
			{header: "<?php __('PaymentTerm'); ?>", dataIndex: 'payment_term', sortable: true},
			{header: "<?php __('Doc Ref'); ?>", dataIndex: 'Doc_Ref', sortable: true},
			{header: "<?php __('Permit No'); ?>", dataIndex: 'Permit_No', sortable: true},
			{header: "<?php __('NBE Permit No'); ?>", dataIndex: 'NBE_Permit_no', sortable: true},
			{header: "<?php __('Branch Name'); ?>", dataIndex: 'Branch_Name', sortable: true},
			{header: "<?php __('ODBC DD'); ?>", dataIndex: 'ODBC_DD', sortable: true},
			{header: "<?php __('Destination'); ?>", dataIndex: 'Destination', sortable: true},
			{header: "<?php __('Single Ent'); ?>", dataIndex: 'Single_Ent', sortable: true},
			{header: "<?php __('CurrencyType'); ?>", dataIndex: 'currency_type', sortable: true},
			{header: "<?php __('Doc Permitt Amount'); ?>", dataIndex: 'doc_permitt_amount', sortable: true},
			{header: "<?php __('Value Date'); ?>", dataIndex: 'value_date', sortable: true},
			{header: "<?php __('Proceed Amount'); ?>", dataIndex: 'proceed_amount', sortable: true},
			{header: "<?php __('Rate'); ?>", dataIndex: 'rate', sortable: true},
			{header: "<?php __('Lcy'); ?>", dataIndex: 'lcy', sortable: true},
			{header: "<?php __('Deduction'); ?>", dataIndex: 'Deduction', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "IbdOdbcs" : "IbdOdbc"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewIbdOdbc(Ext.getCmp('ibdOdbc-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add IbdOdbcs</b><br />Click here to create a new IbdOdbc'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddIbdOdbc();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-ibdOdbc',
					tooltip:'<?php __('<b>Edit IbdOdbcs</b><br />Click here to modify the selected IbdOdbc'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditIbdOdbc(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-ibdOdbc',
					tooltip:'<?php __('<b>Delete IbdOdbcs(s)</b><br />Click here to remove the selected IbdOdbc(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove IbdOdbc'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteIbdOdbc(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove IbdOdbc'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected IbdOdbcs'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteIbdOdbc(sel_ids);
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
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'ibdOdbc_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByIbdOdbcName(Ext.getCmp('ibdOdbc_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'ibdOdbc_go_button',
					handler: function(){
						SearchByIbdOdbcName(Ext.getCmp('ibdOdbc_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchIbdOdbc();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_ibdOdbcs,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>',
			doRefresh : function(){

         			  Doc_Ref='';
         		  currency_id=null;
         		  FCY_AMOUNT_G="";
                  FCY_AMOUNT_L="";
                  from_date=null;
                  to_date=null;
                  NBE_Permit_no=null;
                   Permit_No=null;
                  Exporter_Name=null;


         		store_ibdOdbcs.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
  			}
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-ibdOdbc').enable();
		p.getTopToolbar().findById('delete-ibdOdbc').enable();
		p.getTopToolbar().findById('view-ibdOdbc').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-ibdOdbc').disable();
			p.getTopToolbar().findById('view-ibdOdbc').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-ibdOdbc').disable();
			p.getTopToolbar().findById('view-ibdOdbc').disable();
			p.getTopToolbar().findById('delete-ibdOdbc').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-ibdOdbc').enable();
			p.getTopToolbar().findById('view-ibdOdbc').enable();
			p.getTopToolbar().findById('delete-ibdOdbc').enable();
		}
		else{
			p.getTopToolbar().findById('edit-ibdOdbc').disable();
			p.getTopToolbar().findById('view-ibdOdbc').disable();
			p.getTopToolbar().findById('delete-ibdOdbc').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_ibdOdbcs.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
