
var store_ibdInvisiblePermits = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','DATE_OF_ISSUE','NAME_OF_APPLICANT','PERMIT_NO','PURPOSE_OF_PAYMENT','currency_id','FCY_AMOUNT','TT_REFERENCE','FROM_THEIR_LCY_ACCOUNT','REMARK','rate','LCY_AMOUNT'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdInvisiblePermits', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'DATE_OF_ISSUE', direction: "ASC"}
//,groupField: 'NAME_OF_APPLICANT'
});

var  export_all=true;

var ParamStore = new Ext.data.ArrayStore({ fields: ['value', 'text']});

var FROM_THEIR_LCY_ACCOUNT='';
var        		 PERMIT_NO='';
var		  currency_id=null;
var		  FCY_AMOUNT_G="";
var         FCY_AMOUNT_L="";
var         from_date=null;
var         to_date=null;
var NAME_OF_APPLICANT=null;


function AddIbdInvisiblePermit() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdInvisiblePermits', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var ibdInvisiblePermit_data = response.responseText;
			
			eval(ibdInvisiblePermit_data);
			
			IbdInvisiblePermitAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdInvisiblePermit add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditIbdInvisiblePermit(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdInvisiblePermits', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var ibdInvisiblePermit_data = response.responseText;
			
			eval(ibdInvisiblePermit_data);
			
			IbdInvisiblePermitEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdInvisiblePermit edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewIbdInvisiblePermit(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ibdInvisiblePermits', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var ibdInvisiblePermit_data = response.responseText;

            eval(ibdInvisiblePermit_data);

            IbdInvisiblePermitViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdInvisiblePermit view form. Error code'); ?>: ' + response.status);
        }
    });
}

function ViewLocalSearch() {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ibdInvisiblePermits', 'action' => 'search_local')); ?>',
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

function DeleteIbdInvisiblePermit(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdInvisiblePermits', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('IbdInvisiblePermit successfully deleted!'); ?>');
			RefreshIbdInvisiblePermitData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdInvisiblePermit add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchIbdInvisiblePermit(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdInvisiblePermits', 'action' => 'search')); ?>',
		success: function(response, opts){
			var ibdInvisiblePermit_data = response.responseText;

			eval(ibdInvisiblePermit_data);

			ibdInvisiblePermitSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the ibdInvisiblePermit search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByIbdInvisiblePermitName(value){
	var conditions = '\'IbdInvisiblePermit.name LIKE\' => \'%' + value + '%\'';
	store_ibdInvisiblePermits.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshIbdInvisiblePermitData() {
	store_ibdInvisiblePermits.reload();
}

function ExportToExcel(){
	var obj=	Object.values(store_ibdInvisiblePermits.data.items);
	var ob=Array();
		for (var i =0; i<obj.length;  i++) {
			 
			ob[i]=obj[i]['json'];
			console.log(obj[i]['json']['IMPORT_PERMIT_NO']);
		}
		
		ob=JSON.stringify(ob);
		 console.log(ob);

	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdInvisiblePermits', 'action' => 'set_data')); ?>',
		method: 'POST', 
		params:{o:ob,sent:export_all},
		success: function(response, opts){
window.open('<?php echo $this->Html->url(array('controller' => 'ibdInvisiblePermits', 'action' => 'export')); ?>');
		},
			
		failure: function(response, opts) {
		
		}
	});
	
}


if(center_panel.find('id', 'ibdInvisiblePermit-tab') != "") {
	var p = center_panel.findById('ibdInvisiblePermit-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Ibd Invisible Permits'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'ibdInvisiblePermit-tab',
		xtype: 'grid',
		store: store_ibdInvisiblePermits,
		columns: [
			{header: "<?php __('DATE OF ISSUE'); ?>", dataIndex: 'DATE_OF_ISSUE', sortable: true},
			{header: "<?php __('NAME OF APPLICANT'); ?>", dataIndex: 'NAME_OF_APPLICANT', sortable: true},
			{header: "<?php __('PERMIT NO'); ?>", dataIndex: 'PERMIT_NO', sortable: true},
			{header: "<?php __('PURPOSE OF PAYMENT'); ?>", dataIndex: 'PURPOSE_OF_PAYMENT', sortable: true},
			{header: "<?php __('CurrencyType'); ?>", dataIndex: 'currency_id', sortable: true},
			{header: "<?php __('FCY AMOUNT'); ?>", dataIndex: 'FCY_AMOUNT', sortable: true},
			{header: "<?php __('Rate'); ?>", dataIndex: 'rate', sortable: true},
			{header: "<?php __('LCY AMOUNT'); ?>", dataIndex: 'LCY_AMOUNT', sortable: true},
			{header: "<?php __('TT REFERENCE'); ?>", dataIndex: 'TT_REFERENCE', sortable: true},
			//{header: "<?php __('RETENTION A OR B'); ?>", dataIndex: 'RETENTION_A_OR_B', sortable: true},
			//{header: "<?php __('DIASPORA NRNT'); ?>", dataIndex: 'DIASPORA_NRNT', sortable: true},
			{header: "<?php __('FCY USED FROM'); ?>", dataIndex: 'FROM_THEIR_LCY_ACCOUNT', sortable: true},
			{header: "<?php __('REMARK'); ?>", dataIndex: 'REMARK', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "IbdInvisiblePermits" : "IbdInvisiblePermit"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewIbdInvisiblePermit(Ext.getCmp('ibdInvisiblePermit-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add IbdInvisiblePermits</b><br />Click here to create a new IbdInvisiblePermit'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddIbdInvisiblePermit();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-ibdInvisiblePermit',
					tooltip:'<?php __('<b>Edit IbdInvisiblePermits</b><br />Click here to modify the selected IbdInvisiblePermit'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditIbdInvisiblePermit(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-ibdInvisiblePermit',
					tooltip:'<?php __('<b>Delete IbdInvisiblePermits(s)</b><br />Click here to remove the selected IbdInvisiblePermit(s)'); ?>',
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
									title: '<?php __('Remove IbdInvisiblePermit'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteIbdInvisiblePermit(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove IbdInvisiblePermit'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected IbdInvisiblePermits'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteIbdInvisiblePermit(sel_ids);
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
				}, ' ', '->', '',{
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'ibdInvisiblePermit_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByIbdInvisiblePermitName(Ext.getCmp('ibdInvisiblePermit_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'ibdInvisiblePermit_go_button',
					handler: function(){
						SearchByIbdInvisiblePermitName(Ext.getCmp('ibdInvisiblePermit_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchIbdInvisiblePermit();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_ibdInvisiblePermits,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>',
				doRefresh : function(){
         		 FROM_THEIR_LCY_ACCOUNT='';
            		 PERMIT_NO='';
         		  currency_id=null;
         		  FCY_AMOUNT_G="";
                  FCY_AMOUNT_L="";
                  from_date=null;
                  to_date=null;
                  NAME_OF_APPLICANT=null;

         		store_ibdInvisiblePermits.load({
					params: {
						start: 0,          
						limit: list_size
					}
				});
  			}
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-ibdInvisiblePermit').enable();
		p.getTopToolbar().findById('delete-ibdInvisiblePermit').enable();
		//p.getTopToolbar().findById('view-ibdInvisiblePermit').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-ibdInvisiblePermit').disable();
			p.getTopToolbar().findById('view-ibdInvisiblePermit').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-ibdInvisiblePermit').disable();
			p.getTopToolbar().findById('view-ibdInvisiblePermit').disable();
			//p.getTopToolbar().findById('delete-ibdInvisiblePermit').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-ibdInvisiblePermit').enable();
			p.getTopToolbar().findById('view-ibdInvisiblePermit').enable();
			//p.getTopToolbar().findById('delete-ibdInvisiblePermit').enable();
		}
		else{
			p.getTopToolbar().findById('edit-ibdInvisiblePermit').disable();
			p.getTopToolbar().findById('view-ibdInvisiblePermit').disable();
			p.getTopToolbar().findById('delete-ibdInvisiblePermit').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_ibdInvisiblePermits.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
