
var store_frwfmApplication_frwfmDocuments = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','frwfm_application','name','file_path','file_size','created'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmDocuments', 'action' => 'list_data', $frwfmApplication['FrwfmApplication']['id'])); ?>'	})
});
store_frwfmApplication_frwfmDocuments.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
	function download(id){
		window.open("/AbayERP/frwfm/frwfm_documents/download/"+id);
	}
var store_frwfmApplication_frwfmEvents = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','frwfm_application','user','action','remark','created'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmEvents', 'action' => 'list_data', $frwfmApplication['FrwfmApplication']['id'])); ?>'	})
});
store_frwfmApplication_frwfmEvents.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	var store_frwfmApplication_frwfmAccounts = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','frwfm_application','acc_no','name','branch','amount','currency','type','type_desc','created','modified'	]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'frwfmAccounts', 'action' => 'list_data', $frwfmApplication['FrwfmApplication']['id'])); ?>'	})
});	
function ViewFrwfmEvent(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'frwfmEvents', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var frwfmEvent_data = response.responseText;

            eval(frwfmEvent_data);

            FrwfmEventViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the frwfmEvent view form. Error code'); ?>: ' + response.status);
        }
    });
}
<?php $frwfmApplication_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Branch', true) . ":</th><td><b>" . $frwfmApplication['Branch']['name'] . "</b></td></tr>" . 
"<tr><th align=right>" . __('Customer Name', true) . ":</th><td><b>" .$frwfmApplication['FrwfmApplication']['name']."</b></td></tr>" .
		"<tr><th align=right>" . __('Status', true) . ":</th><td><b>" . $frwfmApplication['FrwfmApplication']['status'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Order', true) . ":</th><td><b>" . $frwfmApplication['FrwfmApplication']['order'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Initial Order', true) . ":</th><td><b>" . $frwfmApplication['FrwfmApplication']['initial_order'] . "</b></td></tr>" .
		"<tr><th align=right>" . __('Date', true) . ":</th><td><b>" . $frwfmApplication['FrwfmApplication']['date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Location', true) . ":</th><td><b>" . $frwfmApplication['Location']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Mobile Phone', true) . ":</th><td><b>" . $frwfmApplication['FrwfmApplication']['mobile_phone'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Email', true) . ":</th><td><b>" . $frwfmApplication['FrwfmApplication']['email'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Amount', true) . ":</th><td><b>" . $frwfmApplication['FrwfmApplication']['amount'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Currency', true) . ":</th><td><b>" . $frwfmApplication['FrwfmApplication']['currency'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Mode Of Payment', true) . ":</th><td><b>" . $frwfmApplication['FrwfmApplication']['mode_of_payment'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('TIN', true) . ":</th><td><b>" . $frwfmApplication['FrwfmApplication']['license'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Account No', true) . ":</th><td><b>" . $frwfmApplication['FrwfmApplication']['account_no'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Relation with Bank', true) . ":</th><td><b>" . $frwfmApplication['FrwfmApplication']['relation_with_bank'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Deposit Amount', true) . ":</th><td><b>" . $frwfmApplication['FrwfmApplication']['deposit_amount'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Types of goods', true) . ":</th><td><b>" . $frwfmApplication['FrwfmApplication']['types_of_goods'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Description of goods', true) . ":</th><td><b>" . $frwfmApplication['FrwfmApplication']['desc_of_goods'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Proforma Invoice No', true) . ":</th><td><b>" . $frwfmApplication['FrwfmApplication']['proforma_invoice_no'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Proforma Date', true) . ":</th><td><b>" . $frwfmApplication['FrwfmApplication']['proforma_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('NBE Account No', true) . ":</th><td><b>" . $frwfmApplication['FrwfmApplication']['nbe_account_no'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Approved Amount', true) . ":</th><td><b>" . $frwfmApplication['FrwfmApplication']['approved_amount'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Approved Date', true) . ":</th><td><b>" . $frwfmApplication['FrwfmApplication']['approved_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Remark', true) . ":</th><td><b>" . $frwfmApplication['FrwfmApplication']['remark'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Record Entered By', true) . ":</th><td><b>" . $frwfmApplication['User']['Person']['first_name'] ." ". $frwfmApplication['User']['Person']['middle_name']."</b></td></tr></table>"; 
?>
		var frwfmApplication_view_panel_1 = {
			html : '<?php echo $frwfmApplication_html; ?>',
			frame : true,
			height: 180,
			autoScroll: true
		}
		var frwfmApplication_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
			{
				xtype: 'grid',
				loadMask: true,
				stripeRows: true,
				store: store_frwfmApplication_frwfmDocuments,
				title: '<?php __('Attachments'); ?>',
				enableColumnMove: false,
				id: 'fr-tab2',
				listeners: {
					activate: function(){
						if(store_frwfmApplication_frwfmDocuments.getCount() == '')
							store_frwfmApplication_frwfmDocuments.reload();
					}
				},
				columns: [
						{header: "<?php __('File Name'); ?>", dataIndex: 'name', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				sm: new Ext.grid.RowSelectionModel({
					singleSelect: false
				}),
				listeners: {
					celldblclick: function(){
						download(Ext.getCmp('fr-tab2').getSelectionModel().getSelected().data.id);
					}
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_frwfmApplication_frwfmDocuments,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			},
{
				xtype: 'grid',
				loadMask: true,
				stripeRows: true,
				store: store_frwfmApplication_frwfmEvents,
				id: 'frwfmEvent-tab',
				title: '<?php __('History'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_frwfmApplication_frwfmEvents.getCount() == '')
							store_frwfmApplication_frwfmEvents.reload();
					}
				},
				columns: [
					{header: "<?php __('User'); ?>", dataIndex: 'user', sortable: true}
,					{header: "<?php __('Action'); ?>", dataIndex: 'action', sortable: true}
,					{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true}
,					{header: "<?php __('Date'); ?>", dataIndex: 'created', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				listeners: {
				celldblclick: function(){
				ViewFrwfmEvent(Ext.getCmp('frwfmEvent-tab').getSelectionModel().getSelected().data.id);
					}
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_frwfmApplication_frwfmEvents,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			},{
				xtype: 'grid',
				loadMask: true,
				stripeRows: true,
				store: store_frwfmApplication_frwfmAccounts,
				title: '<?php __('Accounts'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_frwfmApplication_frwfmAccounts.getCount() == '')
							store_frwfmApplication_frwfmAccounts.reload();
					}
				},
				columns: [
					{header: "<?php __('Acc No'); ?>", dataIndex: 'acc_no', sortable: true},
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true},
		{header: "<?php __('Amount'); ?>", dataIndex: 'amount', sortable: true},
		{header: "<?php __('Currency'); ?>", dataIndex: 'currency', sortable: true},
		{header: "<?php __('Type'); ?>", dataIndex: 'type', sortable: true},
		{header: "<?php __('Account Description'); ?>", dataIndex: 'type_desc', sortable: true},
		{header: "<?php __('Last Updated'); ?>", dataIndex: 'modified', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_frwfmApplication_frwfmAccounts,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var FrwfmApplicationViewWindow = new Ext.Window({
			title: '<?php __('View'); ?>',
			width: 800,
			height:455,
			minWidth: 900,
			minHeight: 345,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'center',
                        modal: true,
			items: [ 
				frwfmApplication_view_panel_1,
				frwfmApplication_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					FrwfmApplicationViewWindow.close();
				}
			}]
		});
