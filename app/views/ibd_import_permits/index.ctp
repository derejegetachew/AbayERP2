
var store_ibdImportPermits = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','PERMIT_ISSUE_DATE','NAME_OF_IMPORTER','IMPORT_PERMIT_NO','currency_id','FCY_AMOUNT','PREVAILING_RATE','LCY_AMOUNT','payment_term_id','ITEM_DESCRIPTION_OF_GOODS','SUPPLIERS_NAME','MINUTE_NO','FCY_APPROVAL_DATE','FCY_APPROVAL_INTIAL_ORDER_NO','FROM_THEIR_FCY_ACCOUNT','THE_PRICE_AS_PER_NBE_SELLECTED','NBE_UNDERTAKING','SUPPLIERS_CREDIT','REMARK','EXPIRE_DTAE','REF_NO','NBE_ACCOUNT'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdImportPermits', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'PERMIT_ISSUE_DATE', direction: "ASC"}
//,	groupField: 'NAME_OF_IMPORTER'
});

var  export_all=true;

var ParamStore = new Ext.data.ArrayStore({ fields: ['value', 'text']});

 var FROM_THEIR_FCY_ACCOUNT='';
            	var	 IMPORT_PERMIT_NO='';
         		var  currency_id=null;
         		var  FCY_AMOUNT_G="";
               var   FCY_AMOUNT_L="";
               var   from_date=null;
               var   to_date=null;
               var NAME_OF_IMPORTER=null;


function AddIbdImportPermit() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdImportPermits', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var ibdImportPermit_data = response.responseText;
			
			eval(ibdImportPermit_data);
			IbdImportPermitAddWindow.show();
	
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdImportPermit add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditIbdImportPermit(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdImportPermits', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var ibdImportPermit_data = response.responseText;
			
			eval(ibdImportPermit_data);
			
			IbdImportPermitEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdImportPermit edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewIbdImportPermit(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ibdImportPermits', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var ibdImportPermit_data = response.responseText;

            eval(ibdImportPermit_data);
			
            IbdImportPermitViewWindow.show();
		
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdImportPermit view form. Error code'); ?>: ' + response.status);
        }
    });
}

function ViewLocalSearch() {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ibdImportPermits', 'action' => 'search_local')); ?>',
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

function DeleteIbdImportPermit(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdImportPermits', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('IbdImportPermit successfully deleted!'); ?>');
			RefreshIbdImportPermitData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdImportPermit add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchIbdImportPermit(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdImportPermits', 'action' => 'search')); ?>',
		success: function(response, opts){
			var ibdImportPermit_data = response.responseText;

			eval(ibdImportPermit_data);

			ibdImportPermitSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the ibdImportPermit search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByIbdImportPermitName(value){
	var conditions = '\'IbdImportPermit.name LIKE\' => \'%' + value + '%\'';
	store_ibdImportPermits.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function ExportToExcel(){
	var obj=	Object.values(store_ibdImportPermits.data.items);
	var ob=Array();
	for (var i =0; i<obj.length;  i++) {
		 
		  ob[i]=obj[i]['json'];
		console.log(obj[i]['json']['IMPORT_PERMIT_NO']);
	}
		/*Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdImportPermits', 'action' => 'export')); ?>/',
		method:'POST',
		params:{'ob':JSON.stringify(ob)},
		success:function (response, opts){
			// var uri = 'data:application/csv;charset=UTF-8,' + encodeURIComponent(response);
           // window.open('<?php echo $this->Html->url(array('controller' => 'ibdImportPermits', 'action' => 'export')); ?>', 'tiketi.csv');
			//window.open('<?php echo $this->Html->url(array('controller' => 'ibdImportPermits', 'action' => 'export')); ?>');
		}
	});*/
	
		// console.log(ob);
		ob=JSON.stringify(ob);
		 console.log(ob);
		 
		  Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdImportPermits', 'action' => 'set_data')); ?>',
		method: 'POST', 
		params:{o:ob,sent:export_all},
		success: function(response, opts){
window.open('<?php echo $this->Html->url(array('controller' => 'ibdImportPermits', 'action' => 'export')); ?>');
		},
			
		failure: function(response, opts) {
		
		}
	});
	

 	
}

function RefreshIbdImportPermitData() {
	store_ibdImportPermits.reload();
}


if(center_panel.find('id', 'ibdImportPermit-tab') != "") {
	var p = center_panel.findById('ibdImportPermit-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Ibd Import Permits'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'ibdImportPermit-tab',
		xtype: 'grid',
		store: store_ibdImportPermits,
		columns: [
			{header: "<?php __('PERMIT ISSUE DATE'); ?>", dataIndex: 'PERMIT_ISSUE_DATE', sortable: true},
			{header: "<?php __('NAME OF IMPORTER'); ?>", dataIndex: 'NAME_OF_IMPORTER', sortable: true},
			{header: "<?php __('IMPORT PERMIT NO'); ?>", dataIndex: 'IMPORT_PERMIT_NO', sortable: true},
			{header: "<?php __('Currency Id'); ?>", dataIndex: 'currency_id', sortable: true},
			{header: "<?php __('FCY AMOUNT'); ?>", dataIndex: 'FCY_AMOUNT', sortable: true},
			{header: "<?php __('PREVAILING RATE'); ?>", dataIndex: 'PREVAILING_RATE', sortable: true},
			{header: "<?php __('LCY AMOUNT'); ?>", dataIndex: 'LCY_AMOUNT', sortable: true},
			{header: "<?php __('Payment Term Id'); ?>", dataIndex: 'payment_term_id', sortable: true},
				{header: "<?php __('Reference No'); ?>", dataIndex: 'REF_NO', sortable: true},
			{header: "<?php __('ITEM DESCRIPTION OF GOODS'); ?>", dataIndex: 'ITEM_DESCRIPTION_OF_GOODS', sortable: true},
			{header: "<?php __('SUPPLIERS NAME'); ?>", dataIndex: 'SUPPLIERS_NAME', sortable: true},
			{header: "<?php __('MINUTE NO'); ?>", dataIndex: 'MINUTE_NO', sortable: true},
			{header: "<?php __('EXPIRE DATE'); ?>", dataIndex: 'EXPIRE_DTAE', sortable: true},
			{header: "<?php __('FCY APPROVAL DATE'); ?>", dataIndex: 'FCY_APPROVAL_DATE', sortable: true},
			{header: "<?php __('FCY APPROVAL INTIAL ORDER NO'); ?>", dataIndex: 'FCY_APPROVAL_INTIAL_ORDER_NO', sortable: true},
			{header: "<?php __('FROM THEIR FCY ACCOUNT'); ?>", dataIndex: 'FROM_THEIR_FCY_ACCOUNT', sortable: true},
			{header: "<?php __('THE PRICE AS PER NBE SELLECTED'); ?>", dataIndex: 'THE_PRICE_AS_PER_NBE_SELLECTED', sortable: true},
			{header: "<?php __('NBE UNDERTAKING'); ?>", dataIndex: 'NBE_UNDERTAKING', sortable: true},
                       {header: "<?php __('NBE ACCOUNT'); ?>", dataIndex: 'NBE_ACCOUNT', sortable: true},
			//{header: "<?php __('SUPPLIERS CREDIT'); ?>", dataIndex: 'SUPPLIERS_CREDIT', sortable: true},
			{header: "<?php __('REMARK'); ?>", dataIndex: 'REMARK', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Import Permits" : "Import Permit"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewIbdImportPermit(Ext.getCmp('ibdImportPermit-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add IbdImportPermits</b><br />Click here to create a new IbdImportPermit'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddIbdImportPermit();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-ibdImportPermit',
					tooltip:'<?php __('<b>Edit IbdImportPermits</b><br />Click here to modify the selected IbdImportPermit'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditIbdImportPermit(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-ibdImportPermit',
					tooltip:'<?php __('<b>Delete IbdImportPermits(s)</b><br />Click here to remove the selected IbdImportPermit(s)'); ?>',
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
									title: '<?php __('Remove IbdImportPermit'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteIbdImportPermit(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove IbdImportPermit'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected IbdImportPermits'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteIbdImportPermit(sel_ids);
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
					id: 'ibdImportPermit_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByIbdImportPermitName(Ext.getCmp('ibdImportPermit_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'ibdImportPermit_go_button',
					handler: function(){
						SearchByIbdImportPermitName(Ext.getCmp('ibdImportPermit_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchIbdImportPermit();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_ibdImportPermits,
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
                  IMPORT_PERMIT_NO='';
                  from_date=null;
                  to_date=null;
                  NAME_OF_IMPORTER=null;

         		store_ibdImportPermits.load({
					params: {
						start: 0,          
						limit: list_size
					}
				});
  			}
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-ibdImportPermit').enable();
		p.getTopToolbar().findById('delete-ibdImportPermit').enable();
		//p.getTopToolbar().findById('view-ibdImportPermit').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-ibdImportPermit').disable();
			p.getTopToolbar().findById('view-ibdImportPermit').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-ibdImportPermit').disable();
			p.getTopToolbar().findById('view-ibdImportPermit').disable();
			//p.getTopToolbar().findById('delete-ibdImportPermit').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-ibdImportPermit').enable();
			p.getTopToolbar().findById('view-ibdImportPermit').enable();
			//p.getTopToolbar().findById('delete-ibdImportPermit').enable();
		}
		else{
			p.getTopToolbar().findById('edit-ibdImportPermit').disable();
			p.getTopToolbar().findById('view-ibdImportPermit').disable();
			p.getTopToolbar().findById('delete-ibdImportPermit').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_ibdImportPermits.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
