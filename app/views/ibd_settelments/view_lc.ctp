var settlment_store = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','reference','rate','lcy_amount','fcy_amount','margin_amount'	]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php  if(sizeof($ibdSettelment)>0){$id=$ibdSettelment[0]['IbdSettelment']['reference'];}else{$id="-1";} echo $this->Html->url(array('controller' => 'ibdSettelments', 'action' => 'list_data',str_replace("/",")", $id))); ?>'	})
});
		
<?php
 if(sizeof($ibdSettelment)>0){
 $ibdSettelment_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Reference', true) . ":</th><td><b>" . $ibdSettelment[0]['IbdSettelment']['reference'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Date', true) . ":</th><td><b>" . $ibdSettelment[0]['IbdSettelment']['date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Opening Date', true) . ":</th><td><b>" . $ibdSettelment[0]['IbdSettelment']['opening_date'] . "</b></td></tr>" . 
	
		
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
					{header: "<?php __('FCY Amount'); ?>", dataIndex: 'fcy_amount', sortable: true},					
					{header: "<?php __('Rate'); ?>", dataIndex: 'rate', sortable: true},
					{header: "<?php __('LCY Amount'); ?>", dataIndex: 'lcy_amount', sortable: true},
					{header: "<?php __('Margin Amount'); ?>", dataIndex: 'margin_amount', sortable: true},
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
			title: '<?php __('View IbdSettelment'); ?>: <?php if(sizeof($ibdSettelment)>0) {echo $ibdSettelment[0]['IbdSettelment']['id'];} ?>',
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
				//ibdSettelment_view_panel_1,
				ibdSettelment_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					IbdSettelmentViewWindow.close();
				}
			}]
		});
