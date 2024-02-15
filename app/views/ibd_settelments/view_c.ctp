var settlment_store = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','reference','rate','lcy_amount','fcy_amount','date'	]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php  if(sizeof($ibdSettelments)>0){$id=$ibdSettelments[0]['IbdSettelment']['reference'];}else{$id="-1";} echo $this->Html->url(array('controller' => 'ibdSettelments', 'action' => 'list_data_c',str_replace("/",")", $id))); ?>'	})
});
		
<?php
 if(sizeof($ibdSettelments)>0){


  $total_fcy=0;
   $total_lcy=0;
 	foreach($ibdSettelments as $s){
 		//var_dump($ibdSettelments);die();
 		$total_fcy+=$s['IbdSettelment']['fcy_amount'];
 		$total_lcy+=$s['IbdSettelment']['lcy_amount'];
 	}

 $ibdSettelment_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('PO Number', true) . ":</th><td><b>" . $ibdSettelments[0]['IbdSettelment']['reference'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Total Cancellation FCT', true) . ":</th><td><b>" . $total_fcy . "</b></td></tr>". 
		"<tr><th align=right>" . __('Total Cancellation LCY', true) . ":</th><td><b>" . $total_lcy . "</b></td></tr>". 
		
"</table>"; 
 }
 else{
	$ibdSettelment_html="";
 }
?>
		var ibdSettelment_view_panel_1 = {
			html : '<?php echo $ibdSettelment_html; ?>',
			frame : true,
			height: 80
		}
		var ibdSettelment_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:330,
			plain:true,
			defaults:{autoScroll: true},
			items:[	{
				xtype: 'grid',
				width: 500,
				loadMask: true,
				stripeRows: true,
				store: settlment_store,
				title: '<?php __('Settelment'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(settlment_store.getCount() == '')
						settlment_store.reload();
					}
				},
				columns: [
					{header: "<?php __('Id'); ?>", dataIndex: 'id', sortable: true,hidden:true},		
					{header: "<?php __('Reference'); ?>", dataIndex: 'reference', sortable: true},
					{header: "<?php __('Date'); ?>", dataIndex: 'date', sortable: true},
					{header: "<?php __('FCY Amount'); ?>", dataIndex: 'fcy_amount', sortable: true},					
					//{header: "<?php __('Rate'); ?>", dataIndex: 'rate', sortable: true},
					{header: "<?php __('LCY Amount'); ?>", dataIndex: 'lcy_amount', sortable: true},
				//	{header: "<?php __('IBC No'); ?>", dataIndex: 'ibc_no', sortable: true},
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: list_size,
					store: settlment_store,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}		]
		});

		var IbdSettelmentViewWindow = new Ext.Window({
			title: '<?php __('View IbdSettelment'); ?>: <?php if(sizeof($ibdSettelments)>0) {echo $ibdSettelments[0]['IbdSettelment']['id'];} ?>',
			width: 600,
			height:400,
			minWidth: 500,
			minHeight: 345,
			resizable: false,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'center',
                        modal: true,
			items: [ 
				ibdSettelment_view_panel_1,
				ibdSettelment_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					IbdSettelmentViewWindow.close();
				}
			}]
		});
