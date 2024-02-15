
var store_ibdOutstandingExportLcs = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','exporter_name','total_lc_fcy','total_lc_amount','outstanding_lc_fcy','outstanding_lc_amount','issuing_bank_ref_no','our_ref_no','date_of_issue','expire_date','place_of_expire','sett_date','sett_fcy','sett_amount','sett_reference_no','outstanding_remaining_lc_fcy','outstanding_remaining_lc_value'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdOutstandingExportLcs', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'exporter_name', direction: "ASC"}
//,	groupField: 'total_lc_fcy'
});


var  export_all=true;

var ParamStore = new Ext.data.ArrayStore({ fields: ['value', 'text']});

 var our_ref_no='';
      var   		  currency_id=null;
       var  		  FCY_AMOUNT_G="";
        var          FCY_AMOUNT_L="";
        var          from_date=null;
         var         to_date=null;
         var exporter_name=null;


function AddIbdOutstandingExportLc() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdOutstandingExportLcs', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var ibdOutstandingExportLc_data = response.responseText;
			
			eval(ibdOutstandingExportLc_data);
			
			IbdOutstandingExportLcAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdOutstandingExportLc add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditIbdOutstandingExportLc(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdOutstandingExportLcs', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var ibdOutstandingExportLc_data = response.responseText;
			
			eval(ibdOutstandingExportLc_data);
			
			IbdOutstandingExportLcEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdOutstandingExportLc edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewIbdOutstandingExportLc(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ibdOutstandingExportLcs', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var ibdOutstandingExportLc_data = response.responseText;

            eval(ibdOutstandingExportLc_data);

            IbdOutstandingExportLcViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdOutstandingExportLc view form. Error code'); ?>: ' + response.status);
        }
    });
}

function ViewLocalSearch() {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ibdOutstandingExportLcs', 'action' => 'search_local')); ?>',
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

function DeleteIbdOutstandingExportLc(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdOutstandingExportLcs', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('IbdOutstandingExportLc successfully deleted!'); ?>');
			RefreshIbdOutstandingExportLcData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdOutstandingExportLc add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchIbdOutstandingExportLc(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdOutstandingExportLcs', 'action' => 'search')); ?>',
		success: function(response, opts){
			var ibdOutstandingExportLc_data = response.responseText;

			eval(ibdOutstandingExportLc_data);

			ibdOutstandingExportLcSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the ibdOutstandingExportLc search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByIbdOutstandingExportLcName(value){
	var conditions = '\'IbdOutstandingExportLc.name LIKE\' => \'%' + value + '%\'';
	store_ibdOutstandingExportLcs.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshIbdOutstandingExportLcData() {
	store_ibdOutstandingExportLcs.reload();
}

function ExportToExcel(){
	var obj=	Object.values(store_ibdOutstandingExportLcs.data.items);
	var ob=Array();
	for (var i =0; i<obj.length;  i++) {
		 
		  ob[i]=obj[i]['json'];
		
	}
	
		ob=JSON.stringify(ob);
		 console.log(ob);

		 Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdOutstandingExportLcs', 'action' => 'set_data')); ?>',
		method: 'POST', 
		params:{o:ob,sent:export_all},
		success: function(response, opts){
window.open('<?php echo $this->Html->url(array('controller' => 'ibdOutstandingExportLcs', 'action' => 'export')); ?>');
		},
			
		failure: function(response, opts) {
		
		}
	});
}


if(center_panel.find('id', 'ibdOutstandingExportLc-tab') != "") {
	var p = center_panel.findById('ibdOutstandingExportLc-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Ibd Outstanding Export Lcs'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'ibdOutstandingExportLc-tab',
		xtype: 'grid',
		store: store_ibdOutstandingExportLcs,
		columns: [
			{header: "<?php __('Exporter Name'); ?>", dataIndex: 'exporter_name', sortable: true},
			{header: "<?php __('Total Lc Fcy'); ?>", dataIndex: 'total_lc_fcy', sortable: true},
			//{header: "<?php __('Total Lc Amount'); ?>", dataIndex: 'total_lc_amount', sortable: true},
			//{header: "<?php __('Outstanding Lc Fcy'); ?>", dataIndex: 'outstanding_lc_fcy', sortable: true},
			//{header: "<?php __('Outstanding Lc Amount'); ?>", dataIndex: 'outstanding_lc_amount', sortable: true},
			{header: "<?php __('Issuing Bank Ref No'); ?>", dataIndex: 'issuing_bank_ref_no', sortable: true},
			{header: "<?php __('Our Ref No'); ?>", dataIndex: 'our_ref_no', sortable: true},
			{header: "<?php __('Date Of Issue'); ?>", dataIndex: 'date_of_issue', sortable: true},
			{header: "<?php __('Expire Date'); ?>", dataIndex: 'expire_date', sortable: true},
			{header: "<?php __('Place Of Expire'); ?>", dataIndex: 'place_of_expire', sortable: true},
			//{header: "<?php __('Sett Date'); ?>", dataIndex: 'sett_date', sortable: true},
			//{header: "<?php __('Sett Fcy'); ?>", dataIndex: 'sett_fcy', sortable: true},
			//{header: "<?php __('Sett Amount'); ?>", dataIndex: 'sett_amount', sortable: true},
			//{header: "<?php __('Sett Reference No'); ?>", dataIndex: 'sett_reference_no', sortable: true},
			{header: "<?php __('Outstanding Remaining Lc Fcy'); ?>", dataIndex: 'outstanding_remaining_lc_fcy', sortable: true},
			//{header: "<?php __('Outstanding Remaining Lc Value'); ?>", dataIndex: 'outstanding_remaining_lc_value', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "IbdOutstandingExportLcs" : "IbdOutstandingExportLc"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewIbdOutstandingExportLc(Ext.getCmp('ibdOutstandingExportLc-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add IbdOutstandingExportLcs</b><br />Click here to create a new IbdOutstandingExportLc'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddIbdOutstandingExportLc();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-ibdOutstandingExportLc',
					tooltip:'<?php __('<b>Edit IbdOutstandingExportLcs</b><br />Click here to modify the selected IbdOutstandingExportLc'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditIbdOutstandingExportLc(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-ibdOutstandingExportLc',
					tooltip:'<?php __('<b>Delete IbdOutstandingExportLcs(s)</b><br />Click here to remove the selected IbdOutstandingExportLc(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove IbdOutstandingExportLc'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteIbdOutstandingExportLc(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove IbdOutstandingExportLc'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected IbdOutstandingExportLcs'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteIbdOutstandingExportLc(sel_ids);
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
					id: 'ibdOutstandingExportLc_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByIbdOutstandingExportLcName(Ext.getCmp('ibdOutstandingExportLc_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'ibdOutstandingExportLc_go_button',
					handler: function(){
						SearchByIbdOutstandingExportLcName(Ext.getCmp('ibdOutstandingExportLc_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchIbdOutstandingExportLc();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_ibdOutstandingExportLcs,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>',
				doRefresh : function(){

         		  our_ref_no='';
         		  currency_id=null;
         		  FCY_AMOUNT_G="";
                  FCY_AMOUNT_L="";
                  from_date=null;
                  to_date=null;
                  exporter_name=null;


         		store_ibdOutstandingExportLcs.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
  			}
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-ibdOutstandingExportLc').enable();
		p.getTopToolbar().findById('delete-ibdOutstandingExportLc').enable();
		p.getTopToolbar().findById('view-ibdOutstandingExportLc').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-ibdOutstandingExportLc').disable();
			p.getTopToolbar().findById('view-ibdOutstandingExportLc').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-ibdOutstandingExportLc').disable();
			p.getTopToolbar().findById('view-ibdOutstandingExportLc').disable();
			p.getTopToolbar().findById('delete-ibdOutstandingExportLc').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-ibdOutstandingExportLc').enable();
			p.getTopToolbar().findById('view-ibdOutstandingExportLc').enable();
			p.getTopToolbar().findById('delete-ibdOutstandingExportLc').enable();
		}
		else{
			p.getTopToolbar().findById('edit-ibdOutstandingExportLc').disable();
			p.getTopToolbar().findById('view-ibdOutstandingExportLc').disable();
			p.getTopToolbar().findById('delete-ibdOutstandingExportLc').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_ibdOutstandingExportLcs.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
