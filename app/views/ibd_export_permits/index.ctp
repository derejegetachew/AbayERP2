
var store_ibdExportPermits = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','PERMIT_ISSUE_DATE','EXPORTER_NAME','EXPORT_PERMIT_NO','COMMODITY','BUYER_NAME','payment_term_id','currency_id','Advance_amount','FCY_AMOUNT','BUYING_RATE','LCY_AMOUNT','REMARK','LC_REF_NO'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdExportPermits', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'PERMIT_ISSUE_DATE', direction: "ASC"}
//,	groupField: 'EXPORTER_NAME'
});

var  export_all=true;
var ParamStore = new Ext.data.ArrayStore({ fields: ['value', 'text']});

 var EXPORT_PERMIT_NO='';
     var    		  currency_id=null;
     var    		  FCY_AMOUNT_G="";
      var            FCY_AMOUNT_L="";
      var            from_date=null;
      var            to_date=null;
      var            LC_REF_NO=null;
     var EXPORTER_NAME=null;


function AddIbdExportPermit() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdExportPermits', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var ibdExportPermit_data = response.responseText;
			
			eval(ibdExportPermit_data);
			
			IbdExportPermitAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdExportPermit add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditIbdExportPermit(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdExportPermits', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var ibdExportPermit_data = response.responseText;
			
			eval(ibdExportPermit_data);
			
			IbdExportPermitEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdExportPermit edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewIbdExportPermit(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ibdExportPermits', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var ibdExportPermit_data = response.responseText;

            eval(ibdExportPermit_data);

            IbdExportPermitViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdExportPermit view form. Error code'); ?>: ' + response.status);
        }
    });
}

function ViewLocalSearch() {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ibdExportPermits', 'action' => 'search_local')); ?>',
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

function DeleteIbdExportPermit(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdExportPermits', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('IbdExportPermit successfully deleted!'); ?>');
			RefreshIbdExportPermitData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdExportPermit add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchIbdExportPermit(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdExportPermits', 'action' => 'search')); ?>',
		success: function(response, opts){
			var ibdExportPermit_data = response.responseText;

			eval(ibdExportPermit_data);

			ibdExportPermitSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the ibdExportPermit search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByIbdExportPermitName(value){
	var conditions = '\'IbdExportPermit.name LIKE\' => \'%' + value + '%\'';
	store_ibdExportPermits.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshIbdExportPermitData() {
	store_ibdExportPermits.reload();
}

function ExportToExcel(){
	var obj=	Object.values(store_ibdExportPermits.data.items);
	var ob=Array();
	for (var i =0; i<obj.length;  i++) {
		 
		  ob[i]=obj[i]['json'];
	
	}
	
		ob=JSON.stringify(ob);
		 console.log(ob);

	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdExportPermits', 'action' => 'set_data')); ?>',
		method: 'POST', 
		params:{o:ob,sent:export_all},
		success: function(response, opts){
    window.open('<?php echo $this->Html->url(array('controller' => 'ibdExportPermits', 'action' => 'export')); ?>');
		},
			
		failure: function(response, opts) {
		
		}
	});

 	
}


if(center_panel.find('id', 'ibdExportPermit-tab') != "") {
	var p = center_panel.findById('ibdExportPermit-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Ibd Export Permits'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'ibdExportPermit-tab',
		xtype: 'grid',
		store: store_ibdExportPermits,
		columns: [
			{header: "<?php __('PERMIT ISSUE DATE'); ?>", dataIndex: 'PERMIT_ISSUE_DATE', sortable: true},
			{header: "<?php __('EXPORTER NAME'); ?>", dataIndex: 'EXPORTER_NAME', sortable: true},
			{header: "<?php __('EXPORT PERMIT NO'); ?>", dataIndex: 'EXPORT_PERMIT_NO', sortable: true},
			{header: "<?php __('LC No'); ?>", dataIndex: 'LC_REF_NO', sortable: true},
			{header: "<?php __('COMMODITY'); ?>", dataIndex: 'COMMODITY', sortable: true},
			{header: "<?php __('BUYER NAME'); ?>", dataIndex: 'BUYER_NAME', sortable: true},
			{header: "<?php __('Payment Term Id'); ?>", dataIndex: 'payment_term_id', sortable: true},
			{header: "<?php __('Currency Id'); ?>", dataIndex: 'currency_id', sortable: true},
			{header: "<?php __('Advance Amount'); ?>", dataIndex: 'Advance_amount', sortable: true},
			{header: "<?php __('FCY AMOUNT'); ?>", dataIndex: 'FCY_AMOUNT', sortable: true},
			{header: "<?php __('BUYING RATE'); ?>", dataIndex: 'BUYING_RATE', sortable: true},
			{header: "<?php __('LCY AMOUNT'); ?>", dataIndex: 'LCY_AMOUNT', sortable: true},
			{header: "<?php __('REMARK'); ?>", dataIndex: 'REMARK', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "IbdExportPermits" : "IbdExportPermit"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewIbdExportPermit(Ext.getCmp('ibdExportPermit-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add IbdExportPermits</b><br />Click here to create a new IbdExportPermit'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddIbdExportPermit();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-ibdExportPermit',
					tooltip:'<?php __('<b>Edit IbdExportPermits</b><br />Click here to modify the selected IbdExportPermit'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditIbdExportPermit(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-ibdExportPermit',
					tooltip:'<?php __('<b>Delete IbdExportPermits(s)</b><br />Click here to remove the selected IbdExportPermit(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove IbdExportPermit'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteIbdExportPermit(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove IbdExportPermit'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected IbdExportPermits'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteIbdExportPermit(sel_ids);
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
					id: 'ibdExportPermit_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByIbdExportPermitName(Ext.getCmp('ibdExportPermit_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'ibdExportPermit_go_button',
					handler: function(){
						SearchByIbdExportPermitName(Ext.getCmp('ibdExportPermit_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchIbdExportPermit();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_ibdExportPermits,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>',
			doRefresh : function(){
         		 	  EXPORT_PERMIT_NO='';
         		  currency_id=null;
         		  FCY_AMOUNT_G="";
                  FCY_AMOUNT_L="";
                  from_date=null;
                  to_date=null;
                  LC_REF_NO=null;
                  EXPORTER_NAME=null;

         		store_ibdExportPermits.load({
					params: {
						start: 0,          
						limit: list_size
					}
				});
  			}
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-ibdExportPermit').enable();
		p.getTopToolbar().findById('delete-ibdExportPermit').enable();
		p.getTopToolbar().findById('view-ibdExportPermit').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-ibdExportPermit').disable();
			p.getTopToolbar().findById('view-ibdExportPermit').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-ibdExportPermit').disable();
			p.getTopToolbar().findById('view-ibdExportPermit').disable();
			p.getTopToolbar().findById('delete-ibdExportPermit').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-ibdExportPermit').enable();
			p.getTopToolbar().findById('view-ibdExportPermit').enable();
			p.getTopToolbar().findById('delete-ibdExportPermit').enable();
		}
		else{
			p.getTopToolbar().findById('edit-ibdExportPermit').disable();
			p.getTopToolbar().findById('view-ibdExportPermit').disable();
			p.getTopToolbar().findById('delete-ibdExportPermit').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_ibdExportPermits.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
