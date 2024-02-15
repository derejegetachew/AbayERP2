
var store_ibdLcs = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','LC_ISSUE_DATE','NAME_OF_IMPORTER','LC_REF_NO','PERMIT_NO','currency_type','FCY_AMOUNT','OPENING_RATE','LCY_AMOUNT','MARGIN_AMT','OPEN_THROUGH','REIBURSING_BANK','MARGIN_AMOUNT','EXPIRY_DATE','SETT_DATE','SETT_FCY_AMOUNT','SETT_Rate','SETT_LCY_Amt','SETT_Margin_Amt','OUT_FCY_AMOUNT','OUT_BIRR_VALUE','OUT_Margin_Amt'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdLcs', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'LC_ISSUE_DATE', direction: "ASC"}
	//,groupField: 'NAME_OF_IMPORTER'
});

var  export_all=true;

var ParamStore = new Ext.data.ArrayStore({ fields: ['value', 'text']});

 var PERMIT_NO='';
   var     LC_REF_NO='';
      var  currency_id=null;
      var  FCY_AMOUNT_G="";
      var       FCY_AMOUNT_L="";
      var      from_date=null;
       var     to_date=null;
      var  ext_from_date=null;
            var      ext_to_date=null;
          var   OPEN_THROUGH='';
             var     REIBURSING_BANK='';
 var NAME_OF_IMPORTER=null;

function AddIbdLc() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdLcs', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var ibdLc_data = response.responseText;
			
			eval(ibdLc_data);
			
			IbdLcAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdLc add form. Error code'); ?>: ' + response.status);
		}
	});
}
function AddSettelment(id){
	 
	 Ext.Ajax.request({
		 url: '<?php echo $this->Html->url(array('controller' => 'IbdSettelments', 'action' => 'add_lc')); ?>/'+id.split("/").join("<"),
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

function EditIbdLc(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdLcs', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var ibdLc_data = response.responseText;
			
			eval(ibdLc_data);
			
			IbdLcEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdLc edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewIbdLc(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ibdLcs', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var ibdLc_data = response.responseText;

            eval(ibdLc_data);

            IbdLcViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdLc view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewLocalSearch() {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ibdLcs', 'action' => 'search_local')); ?>',
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
        url: '<?php echo $this->Html->url(array('controller' => 'ibdSettelments', 'action' => 'view_lc')); ?>/'+id.split("/").join("<"),
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
        url: '<?php echo $this->Html->url(array('controller' => 'ibdLcs', 'action' => 'add_c')); ?>/'+id.split("/").join("<"),
        success: function(response, opts) {
            var ibdPurchaseOrder_data = response.responseText;

            eval(ibdPurchaseOrder_data);

            IbdLcAddWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdPurchaseOrder view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteIbdLc(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdLcs', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('IbdLc successfully deleted!'); ?>');
			RefreshIbdLcData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdLc add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchIbdLc(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdLcs', 'action' => 'search')); ?>',
		success: function(response, opts){
			var ibdLc_data = response.responseText;

			eval(ibdLc_data);

			ibdLcSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the ibdLc search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByIbdLcName(value){
	var conditions = '\'IbdLc.name LIKE\' => \'%' + value + '%\'';
	store_ibdLcs.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshIbdLcData() {
	store_ibdLcs.reload();
}

function ExportToExcel(){
	var obj=	Object.values(store_ibdLcs.data.items);
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
		url: '<?php echo $this->Html->url(array('controller' => 'ibdLcs', 'action' => 'set_data')); ?>',
		method: 'POST', 
		params:{o:ob,sent:export_all},
		success: function(response, opts){
window.open('<?php echo $this->Html->url(array('controller' => 'ibdLcs', 'action' => 'export')); ?>');
		},
			
		failure: function(response, opts) {
		
		}
	});

 	
}


if(center_panel.find('id', 'ibdLc-tab') != "") {
	var p = center_panel.findById('ibdLc-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('LC Registration'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'ibdLc-tab',
		xtype: 'grid',
		store: store_ibdLcs,
		columns: [
			{header: "<?php __('LC ISSUE DATE'); ?>", dataIndex: 'LC_ISSUE_DATE', sortable: true},
			{header: "<?php __('NAME OF IMPORTER'); ?>", dataIndex: 'NAME_OF_IMPORTER', sortable: true},
			{header: "<?php __('LC REF NO'); ?>", dataIndex: 'LC_REF_NO', sortable: true},
			{header: "<?php __('PERMIT NO'); ?>", dataIndex: 'PERMIT_NO', sortable: true},
			{header: "<?php __('Currency Type'); ?>", dataIndex: 'currency_type', sortable: true},
			{header: "<?php __('FCY AMOUNT'); ?>", dataIndex: 'FCY_AMOUNT', sortable: true},
			{header: "<?php __('OPENING RATE'); ?>", dataIndex: 'OPENING_RATE', sortable: true},
			{header: "<?php __('LCY AMOUNT'); ?>", dataIndex: 'LCY_AMOUNT', sortable: true},
			{header: "<?php __('MARGIN %'); ?>", dataIndex: 'SETT_Margin_Amt', sortable: true},
			{header: "<?php __('MARGIN AMT'); ?>", dataIndex: 'MARGIN_AMT', sortable: true},
			{header: "<?php __('OPEN THROUGH'); ?>", dataIndex: 'OPEN_THROUGH', sortable: true},
			{header: "<?php __('REIBURSING BANK'); ?>", dataIndex: 'REIBURSING_BANK', sortable: true},
			{header: "<?php __('EXPIRY DATE'); ?>", dataIndex: 'EXPIRY_DATE', sortable: true},
			//{header: "<?php __('SETT DATE'); ?>", dataIndex: 'SETT_DATE', sortable: true},
			//{header: "<?php __('SETT FCY AMOUNT'); ?>", dataIndex: 'SETT_FCY_AMOUNT', sortable: true},
			//{header: "<?php __('SETT Rate'); ?>", dataIndex: 'SETT_Rate', sortable: true},
			//{header: "<?php __('SETT LCY Amt'); ?>", dataIndex: 'SETT_LCY_Amt', sortable: true},
			//{header: "<?php __('SETT Margin Amt'); ?>", dataIndex: 'SETT_Margin_Amt', sortable: true},
			{header: "<?php __('OUT FCY AMOUNT'); ?>", dataIndex: 'OUT_FCY_AMOUNT', sortable: true},
			{header: "<?php __('OUT BIRR VALUE'); ?>", dataIndex: 'OUT_BIRR_VALUE', sortable: true},
			{header: "<?php __('OUT Margin Amt'); ?>", dataIndex: 'OUT_Margin_Amt', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "LCs" : "LC"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewIbdLc(Ext.getCmp('ibdLc-tab').getSelectionModel().getSelected().data.id);
			},'rowcontextmenu': function(grid,index,event){
			event.stopEvent();
			var record=grid.getStore().getAt(index);
			var menu = new Ext.menu.Menu({
            items: [
				{
                    text: '<b>Add Settelment</b>',
                    icon: 'img/table_add.png',
                    handler: function() {
                        AddSettelment(record.get('LC_REF_NO'));
                    },
                    disabled: false
                },{
                    text: '<b>View Settelment</b>',
                    icon: 'img/table_view.png',
                    handler: function() {
                         
                        ViewIbdSettelment(record.get('LC_REF_NO'));
                    },
                    disabled: false
                },{
                    text: '<b>Cancellation</b>',
                    icon: 'img/table_delete.png',
                    handler: function() {
                         
                        Cancellation(record.get('LC_REF_NO'));
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
					tooltip:'<?php __('<b>Add IbdLcs</b><br />Click here to create a new IbdLc'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddIbdLc();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-ibdLc',
					tooltip:'<?php __('<b>Edit IbdLcs</b><br />Click here to modify the selected IbdLc'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditIbdLc(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-ibdLc',
					tooltip:'<?php __('<b>Delete IbdLcs(s)</b><br />Click here to remove the selected IbdLc(s)'); ?>',
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
									title: '<?php __('Remove IbdLc'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteIbdLc(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove IbdLc'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected IbdLcs'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteIbdLc(sel_ids);
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
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'ibdLc_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByIbdLcName(Ext.getCmp('ibdLc_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'ibdLc_go_button',
					handler: function(){
						SearchByIbdLcName(Ext.getCmp('ibdLc_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchIbdLc();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_ibdLcs,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>',
			doRefresh : function(){

         		 PERMIT_NO='';
            		 LC_REF_NO='';
         		 currency_id=null;
         		  FCY_AMOUNT_G="";
                  FCY_AMOUNT_L="";
                  from_date=null;
                  to_date=null;
                   ext_from_date=null;
                  ext_to_date=null;
                   OPEN_THROUGH='';
                  REIBURSING_BANK='';
                   NAME_OF_IMPORTER=null;

         		store_ibdLcs.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
  			}
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-ibdLc').enable();
		p.getTopToolbar().findById('delete-ibdLc').enable();
		//p.getTopToolbar().findById('view-ibdLc').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-ibdLc').disable();
			p.getTopToolbar().findById('view-ibdLc').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-ibdLc').disable();
			p.getTopToolbar().findById('view-ibdLc').disable();
			//p.getTopToolbar().findById('delete-ibdLc').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-ibdLc').enable();
			p.getTopToolbar().findById('view-ibdLc').enable();
			//p.getTopToolbar().findById('delete-ibdLc').enable();
		}
		else{
			p.getTopToolbar().findById('edit-ibdLc').disable();
			p.getTopToolbar().findById('view-ibdLc').disable();
			p.getTopToolbar().findById('delete-ibdLc').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_ibdLcs.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
