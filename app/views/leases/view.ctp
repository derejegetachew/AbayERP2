
var store_lease_leaseTransactions = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','lease','month','payment','disount_factor','npv','lease_liability','interest_charge','asset_nbv_bfwd','amortization','asset_nbv_cfwd'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'leaseTransactions', 'action' => 'list_data', $lease['Lease']['id'])); ?>'	})
});
		
<?php $lease_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $lease['Lease']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Branch Code', true) . ":</th><td><b>" . $lease['Lease']['branch_code'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Contract Years', true) . ":</th><td><b>" . $lease['Lease']['contract_years'] . "</b></td></tr>" . 
   	"<tr><th align=right></th> <td>". $this->Html->link('Click to open in report','http://10.1.85.10:8080/iportal/frameset?__report=C%3A%5CUsers%5CAdministrator%5CWorkspace%5CAbay+Report%5CReport+Designs%5Clease_cal.rptdesign&__format=html&__svg=true&__locale=en_US&__timezone=EAT&__masterpage=true&__rtl=false&__cubememsize=50&__resourceFolder=C%3A%5CUsers%5CAdministrator%5CWorkspace%5CAbay+Report&-1447231237&lease_id='.  $lease['Lease']['id'] ,array('target'=>'_blank') )  ."</td></tr>" . 
		"<tr><th align=right>" . __('Start Date', true) . ":</th><td><b>" . $lease['Lease']['start_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('End Date', true) . ":</th><td><b>" . $lease['Lease']['end_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Total Amount', true) . ":</th><td><b>" . $lease['Lease']['total_amount'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Paid Years', true) . ":</th><td><b>" . $lease['Lease']['paid_years'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Paid Amount', true) . ":</th><td><b>" . $lease['Lease']['paid_amount'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Rent Amount', true) . ":</th><td><b>" . $lease['Lease']['rent_amount'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Expensed', true) . ":</th><td><b>" . $lease['Lease']['expensed'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Is Lease', true) . ":</th><td><b>" . $lease['Lease']['is_lease'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Discount', true) . ":</th><td><b>" . $lease['Lease']['discount'] . "</b></td></tr>" . 
"</table>"; 
?>
		var lease_view_panel_1 = {
			html : '<?php echo $lease_html; ?>',
			frame : true,
			height: 80
		}
		var lease_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:490,
			plain:true,
			defaults:{autoScroll: true},
			items:[
			{
				xtype: 'grid',
				loadMask: true,
				stripeRows: true,
				store: store_lease_leaseTransactions,
				title: '<?php __('LeaseTransactions'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_lease_leaseTransactions.getCount() == '')
							store_lease_leaseTransactions.reload();
					}
				},
				columns: [
					{header: "<?php __('Month'); ?>", dataIndex: 'month', sortable: true},
					{header: "<?php __('Payment'); ?>", dataIndex: 'payment', sortable: true},
					{header: "<?php __('Disount Factor'); ?>", dataIndex: 'disount_factor', sortable: true},
					{header: "<?php __('Npv'); ?>", dataIndex: 'npv', sortable: true},
					{header: "<?php __('Lease Liability'); ?>", dataIndex: 'lease_liability', sortable: true},
					{header: "<?php __('Interest Charge'); ?>", dataIndex: 'interest_charge', sortable: true},
				//	{header: "<?php __('Asset Nbv Bfwd'); ?>", dataIndex: 'asset_nbv_bfwd', sortable: true},
					{header: "<?php __('Amortization'); ?>", dataIndex: 'amortization', sortable: true},
					//{header: "<?php __('Asset Nbv Cfwd'); ?>", dataIndex: 'asset_nbv_cfwd', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: 1,
					store: store_lease_leaseTransactions,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var LeaseViewWindow = new Ext.Window({
			title: '<?php __('View Lease'); ?>: <?php echo $lease['Lease']['name']; ?>',
			width: 850,
			height:645,
			minWidth: 850,
			minHeight: 645,
			resizable: false,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'center',
                        modal: true,
			items: [ 
				lease_view_panel_1,
				lease_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					LeaseViewWindow.close();
				}
			}]
		});
