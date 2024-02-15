
var store_misLetter_misLetterDetails = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','mis_letter','type','account_of','account_number','amount','branch','status','created_by','replied_by','completed_by','letter_prepared_by','remark','file','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'misLetterDetails', 'action' => 'list_data', $misLetter['MisLetter']['id'])); ?>'	})
});
		
<?php $misLetter_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Ref No', true) . ":</th><td><b>" . $misLetter['MisLetter']['ref_no'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Applicant', true) . ":</th><td><b>" . $misLetter['MisLetter']['applicant'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Defendant', true) . ":</th><td><b>" . $misLetter['MisLetter']['defendant'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Letter No', true) . ":</th><td><b>" . $misLetter['MisLetter']['letter_no'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Date', true) . ":</th><td><b>" . $misLetter['MisLetter']['date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Deadline', true) . ":</th><td><b>" . $misLetter['MisLetter']['deadline'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Source', true) . ":</th><td><b>" . $misLetter['MisLetter']['source'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Office', true) . ":</th><td><b>" . $misLetter['MisLetter']['office'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Messenger', true) . ":</th><td><b>" . $misLetter['MisLetter']['messenger'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('File', true) . ":</th><td><b>" . $misLetter['MisLetter']['file'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Status', true) . ":</th><td><b>" . $misLetter['MisLetter']['status'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created By', true) . ":</th><td><b>" . $misLetter['MisLetter']['created_by'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $misLetter['MisLetter']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $misLetter['MisLetter']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var misLetter_view_panel_1 = {
			html : '<?php echo $misLetter_html; ?>',
			frame : true,
			height: 80
		}
		var misLetter_view_panel_2 = new Ext.TabPanel({
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
				store: store_misLetter_misLetterDetails,
				title: '<?php __('MisLetterDetails'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_misLetter_misLetterDetails.getCount() == '')
							store_misLetter_misLetterDetails.reload();
					}
				},
				columns: [
					{header: "<?php __('Mis Letter'); ?>", dataIndex: 'mis_letter', sortable: true, hidden: true}
,					{header: "<?php __('Type'); ?>", dataIndex: 'type', sortable: true}
,					{header: "<?php __('Account Of'); ?>", dataIndex: 'account_of', sortable: true}
,					{header: "<?php __('Account Number'); ?>", dataIndex: 'account_number', sortable: true}
,					{header: "<?php __('Amount'); ?>", dataIndex: 'amount', sortable: true}
,					{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true}
,					{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true}
,					{header: "<?php __('Created By'); ?>", dataIndex: 'created_by', sortable: true}
,					{header: "<?php __('Replied By'); ?>", dataIndex: 'replied_by', sortable: true}
,					{header: "<?php __('Completed By'); ?>", dataIndex: 'completed_by', sortable: true}
,					{header: "<?php __('Letter Prepared By'); ?>", dataIndex: 'letter_prepared_by', sortable: true}
,					{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true}
,					{header: "<?php __('File'); ?>", dataIndex: 'file', sortable: true}
,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
,					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_misLetter_misLetterDetails,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var MisLetterViewWindow = new Ext.Window({
			title: '<?php __('View MisLetter'); ?>: <?php echo $misLetter['MisLetter']['id']; ?>',
			width: 700,
			height:345,
			minWidth: 500,
			minHeight: 345,
			resizable: false,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'center',
                        modal: true,
			items: [ 
				misLetter_view_panel_1,
				misLetter_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					MisLetterViewWindow.close();
				}
			}]
		});
