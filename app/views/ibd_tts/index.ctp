
var store_ibdTts = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','DATE_OF_ISSUE','NAME_OF_APPLICANT','currency_id','FCY_AMOUNT','FROM_LCY_ACCOUNT','rate','LCY_AMOUNT','TT_REFERENCE','PERMIT_NO','FCY_APPROVAL_DATE','FCY_APPROVAL_INTIAL_ORDER_NO','FROM_THEIR_FCY_ACCOUNT','REMARK','REIBURSING_BANK','permitType','beneficiary_name'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdTts', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'DATE_OF_ISSUE', direction: "ASC"}
//,groupField: 'NAME_OF_APPLICANT'
});

var  export_all=true;

var ParamStore = new Ext.data.ArrayStore({ fields: ['value', 'text']});

 var FROM_THEIR_FCY_ACCOUNT='';
  var          		 TT_REFERENCE='';
     var    		 currency_id=null;
     var    		  FCY_AMOUNT_G="";
      var            FCY_AMOUNT_L="";
     var             from_date=null;
       var           to_date=null;
var NAME_OF_APPLICANT=null;

function AddIbdTt() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdTts', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var ibdTt_data = response.responseText;
			
			eval(ibdTt_data);
			
			IbdTtAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdTt add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditIbdTt(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdTts', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var ibdTt_data = response.responseText;
			
			eval(ibdTt_data);
			
			IbdTtEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdTt edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewIbdTt(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ibdTts', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var ibdTt_data = response.responseText;

            eval(ibdTt_data);

            IbdTtViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdTt view form. Error code'); ?>: ' + response.status);
        }
    });
}

function ViewLocalSearch() {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ibdTts', 'action' => 'search_local')); ?>',
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

function DeleteIbdTt(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdTts', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('IbdTt successfully deleted!'); ?>');
			RefreshIbdTtData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdTt add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchIbdTt(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdTts', 'action' => 'search')); ?>',
		success: function(response, opts){
			var ibdTt_data = response.responseText;

			eval(ibdTt_data);

			ibdTtSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the ibdTt search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByIbdTtName(value){
	var conditions = '\'IbdTt.name LIKE\' => \'%' + value + '%\'';
	store_ibdTts.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshIbdTtData() {
	store_ibdTts.reload();
}

function ExportToExcel(){
	var obj=	Object.values(store_ibdTts.data.items);
	var ob=Array();
	for (var i =0; i<obj.length;  i++) {
		 
		  ob[i]=obj[i]['json'];
		console.log(obj[i]['json']['IMPORT_PERMIT_NO']);
	}
	
		ob=JSON.stringify(ob);
		 console.log(ob);

		 Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdTts', 'action' => 'set_data')); ?>',
		method: 'POST', 
		params:{o:ob,sent:export_all},
		success: function(response, opts){
window.open('<?php echo $this->Html->url(array('controller' => 'ibdTts', 'action' => 'export')); ?>');
		},
			
		failure: function(response, opts) {
		
		}
	});
	
 	
}


if(center_panel.find('id', 'ibdTt-tab') != "") {
	var p = center_panel.findById('ibdTt-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('TT Registration'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'ibdTt-tab',
		xtype: 'grid',
		store: store_ibdTts,
		columns: [
			{header: "<?php __('DATE OF ISSUE'); ?>", dataIndex: 'DATE_OF_ISSUE', sortable: true},
			{header: "<?php __('NAME OF APPLICANT'); ?>", dataIndex: 'NAME_OF_APPLICANT', sortable: true},
			{header: "<?php __('beneficiary name'); ?>", dataIndex: 'beneficiary_name', sortable: true},
			{header: "<?php __('Currency Id'); ?>", dataIndex: 'currency_id', sortable: true},
			{header: "<?php __('FCY AMOUNT'); ?>", dataIndex: 'FCY_AMOUNT', sortable: true},
			{header: "<?php __('Rate'); ?>", dataIndex: 'rate', sortable: true},
			{header: "<?php __('LCY AMOUNT'); ?>", dataIndex: 'LCY_AMOUNT', sortable: true},
			{header: "<?php __('TT REFERENCE'); ?>", dataIndex: 'TT_REFERENCE', sortable: true},
			{header: "<?php __('Permit Type'); ?>", dataIndex: 'permitType', sortable: true},
			{header: "<?php __('REIBURSING BANK'); ?>", dataIndex: 'REIBURSING_BANK', sortable: true},
			{header: "<?php __('PERMIT NO'); ?>", dataIndex: 'PERMIT_NO', sortable: true},
			{header: "<?php __('FCY APPROVAL DATE'); ?>", dataIndex: 'FCY_APPROVAL_DATE', sortable: true},
			{header: "<?php __('FCY APPROVAL INTIAL ORDER NO'); ?>", dataIndex: 'FCY_APPROVAL_INTIAL_ORDER_NO', sortable: true},
			{header: "<?php __('FROM THEIR FCY ACCOUNT'); ?>", dataIndex: 'FROM_THEIR_FCY_ACCOUNT', sortable: true},
			{header: "<?php __('FROM LCY ACCOUNT'); ?>", dataIndex: 'FROM_LCY_ACCOUNT', sortable: true},
			{header: "<?php __('REMARK'); ?>", dataIndex: 'REMARK', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "TTs" : "TT"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewIbdTt(Ext.getCmp('ibdTt-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add IbdTts</b><br />Click here to create a new IbdTt'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddIbdTt();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-ibdTt',
					tooltip:'<?php __('<b>Edit IbdTts</b><br />Click here to modify the selected IbdTt'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditIbdTt(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-ibdTt',
					tooltip:'<?php __('<b>Delete IbdTts(s)</b><br />Click here to remove the selected IbdTt(s)'); ?>',
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
									title: '<?php __('Remove IbdTt'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteIbdTt(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove IbdTt'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected IbdTts'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteIbdTt(sel_ids);
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
					id: 'ibdTt_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByIbdTtName(Ext.getCmp('ibdTt_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'ibdTt_go_button',
					handler: function(){
						SearchByIbdTtName(Ext.getCmp('ibdTt_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchIbdTt();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_ibdTts,
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


         		store_ibdTts.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
  			}
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-ibdTt').enable();
		p.getTopToolbar().findById('delete-ibdTt').enable();
		p.getTopToolbar().findById('view-ibdTt').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-ibdTt').disable();
			p.getTopToolbar().findById('view-ibdTt').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-ibdTt').disable();
			p.getTopToolbar().findById('view-ibdTt').disable();
			p.getTopToolbar().findById('delete-ibdTt').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-ibdTt').enable();
			p.getTopToolbar().findById('view-ibdTt').enable();
			p.getTopToolbar().findById('delete-ibdTt').enable();
		}
		else{
			p.getTopToolbar().findById('edit-ibdTt').disable();
			p.getTopToolbar().findById('view-ibdTt').disable();
			p.getTopToolbar().findById('delete-ibdTt').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_ibdTts.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
