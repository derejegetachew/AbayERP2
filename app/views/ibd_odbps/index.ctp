
var store_ibdOdbps = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','date','name_of_exporter','ref_no','permit_no','type','currency_code','fct','rate','lcy','sett_fcy','Deduction','sett_date'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdOdbps', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'date', direction: "ASC"}
//,groupField: 'name_of_exporter'
});

var  export_all=true;

var ParamStore = new Ext.data.ArrayStore({ fields: ['value', 'text']});

 var permit_no='';
   var      		  currency_id=null;
    var     		  FCY_AMOUNT_G="";
    var              FCY_AMOUNT_L="";
      var            from_date=null;
       var           to_date=null;
        var          NBE_Ref_no=null;
         var         ref_no=null;
         var name_of_exporter=null;


function AddIbdOdbp() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdOdbps', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var ibdOdbp_data = response.responseText;
			
			eval(ibdOdbp_data);
			
			IbdOdbpAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdOdbp add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditIbdOdbp(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdOdbps', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var ibdOdbp_data = response.responseText;
			
			eval(ibdOdbp_data);
			
			IbdOdbpEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdOdbp edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewIbdOdbp(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ibdOdbps', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var ibdOdbp_data = response.responseText;

            eval(ibdOdbp_data);

            IbdOdbpViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdOdbp view form. Error code'); ?>: ' + response.status);
        }
    });
}

function ViewLocalSearch() {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'ibdOdbps', 'action' => 'search_local')); ?>',
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

function DeleteIbdOdbp(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdOdbps', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('IbdOdbp successfully deleted!'); ?>');
			RefreshIbdOdbpData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the ibdOdbp add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchIbdOdbp(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdOdbps', 'action' => 'search')); ?>',
		success: function(response, opts){
			var ibdOdbp_data = response.responseText;

			eval(ibdOdbp_data);

			ibdOdbpSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the ibdOdbp search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByIbdOdbpName(value){
	var conditions = '\'IbdOdbp.name LIKE\' => \'%' + value + '%\'';
	store_ibdOdbps.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshIbdOdbpData() {
	store_ibdOdbps.reload();
}

function ExportToExcel(){
	var obj=	Object.values(store_ibdOdbps.data.items);
	var ob=Array();
	for (var i =0; i<obj.length;  i++) {
		 
		  ob[i]=obj[i]['json'];
		
	}
	
		ob=JSON.stringify(ob);
		 console.log(ob);

		 Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'ibdOdbps', 'action' => 'set_data')); ?>',
		method: 'POST', 
		params:{o:ob,sent:export_all},
		success: function(response, opts){
window.open('<?php echo $this->Html->url(array('controller' => 'ibdOdbps', 'action' => 'export')); ?>');
		},
			
		failure: function(response, opts) {
		
		}
	});
}


if(center_panel.find('id', 'ibdOdbp-tab') != "") {
	var p = center_panel.findById('ibdOdbp-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Ibd Odbps'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'ibdOdbp-tab',
		xtype: 'grid',
		store: store_ibdOdbps,
		columns: [
		//    {header: "<?php __('Serial No'); ?>", dataIndex: 'id', sortable: true},
			{header: "<?php __('ODBC Date'); ?>", dataIndex: 'date', sortable: true},
			{header: "<?php __('Name Of Exporter'); ?>", dataIndex: 'name_of_exporter', sortable: true},
			{header: "<?php __('Ref No'); ?>", dataIndex: 'ref_no', sortable: true},
			{header: "<?php __('Permit No'); ?>", dataIndex: 'permit_no', sortable: true},
			{header: "<?php __('Type'); ?>", dataIndex: 'type', sortable: true},
			{header: "<?php __('Currency Code'); ?>", dataIndex: 'currency_code', sortable: true},
			{header: "<?php __('Fct'); ?>", dataIndex: 'fct', sortable: true},
			{header: "<?php __('Rate'); ?>", dataIndex: 'rate', sortable: true},
			{header: "<?php __('Lcy'); ?>", dataIndex: 'lcy', sortable: true},
			{header: "<?php __('Value Date'); ?>", dataIndex: 'sett_date', sortable: true},
			{header: "<?php __('Sett Fcy'); ?>", dataIndex: 'sett_fcy', sortable: true},
			{header: "<?php __('Deduction'); ?>", dataIndex: 'Deduction', sortable: true},
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "IbdOdbps" : "IbdOdbp"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewIbdOdbp(Ext.getCmp('ibdOdbp-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add IbdOdbps</b><br />Click here to create a new IbdOdbp'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddIbdOdbp();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-ibdOdbp',
					tooltip:'<?php __('<b>Edit IbdOdbps</b><br />Click here to modify the selected IbdOdbp'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditIbdOdbp(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-ibdOdbp',
					tooltip:'<?php __('<b>Delete IbdOdbps(s)</b><br />Click here to remove the selected IbdOdbp(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove IbdOdbp'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteIbdOdbp(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove IbdOdbp'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected IbdOdbps'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteIbdOdbp(sel_ids);
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
					id: 'ibdOdbp_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByIbdOdbpName(Ext.getCmp('ibdOdbp_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'ibdOdbp_go_button',
					handler: function(){
						SearchByIbdOdbpName(Ext.getCmp('ibdOdbp_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchIbdOdbp();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_ibdOdbps,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>',
			doRefresh : function(){

         		 permit_no='';
         		  currency_id=null;
         		  FCY_AMOUNT_G="";
                  FCY_AMOUNT_L="";
                  from_date=null;
                  to_date=null;
                  NBE_Ref_no=null;
                  ref_no=null;
                  name_of_exporter=null;


         		store_ibdOdbps.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
  			}
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-ibdOdbp').enable();
		p.getTopToolbar().findById('delete-ibdOdbp').enable();
		p.getTopToolbar().findById('view-ibdOdbp').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-ibdOdbp').disable();
			p.getTopToolbar().findById('view-ibdOdbp').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-ibdOdbp').disable();
			p.getTopToolbar().findById('view-ibdOdbp').disable();
			p.getTopToolbar().findById('delete-ibdOdbp').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-ibdOdbp').enable();
			p.getTopToolbar().findById('view-ibdOdbp').enable();
			p.getTopToolbar().findById('delete-ibdOdbp').enable();
		}
		else{
			p.getTopToolbar().findById('edit-ibdOdbp').disable();
			p.getTopToolbar().findById('view-ibdOdbp').disable();
			p.getTopToolbar().findById('delete-ibdOdbp').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_ibdOdbps.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
