
var store_ormsRiskCategory_childOrmsRiskCategories = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','parent','lft','rght','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'childOrmsRiskCategories', 'action' => 'list_data', $ormsRiskCategory['OrmsRiskCategory']['id'])); ?>'	})
});
var store_ormsRiskCategory_ormsRisks = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','description','orms_risk_category','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'ormsRisks', 'action' => 'list_data', $ormsRiskCategory['OrmsRiskCategory']['id'])); ?>'	})
});
		
<?php $ormsRiskCategory_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $ormsRiskCategory['OrmsRiskCategory']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Parent Orms Risk Category', true) . ":</th><td><b>" . $ormsRiskCategory['ParentOrmsRiskCategory']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Lft', true) . ":</th><td><b>" . $ormsRiskCategory['OrmsRiskCategory']['lft'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Rght', true) . ":</th><td><b>" . $ormsRiskCategory['OrmsRiskCategory']['rght'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $ormsRiskCategory['OrmsRiskCategory']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $ormsRiskCategory['OrmsRiskCategory']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var ormsRiskCategory_view_panel_1 = {
			html : '<?php echo $ormsRiskCategory_html; ?>',
			frame : true,
			height: 80
		}
		var ormsRiskCategory_view_panel_2 = new Ext.TabPanel({
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
				store: store_ormsRiskCategory_childOrmsRiskCategories,
				title: '<?php __('ChildOrmsRiskCategories'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_ormsRiskCategory_childOrmsRiskCategories.getCount() == '')
							store_ormsRiskCategory_childOrmsRiskCategories.reload();
					}
				},
				columns: [
					{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}
,					{header: "<?php __('Parent'); ?>", dataIndex: 'parent', sortable: true}
,					{header: "<?php __('Lft'); ?>", dataIndex: 'lft', sortable: true}
,					{header: "<?php __('Rght'); ?>", dataIndex: 'rght', sortable: true}
,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
,					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_ormsRiskCategory_childOrmsRiskCategories,
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
				store: store_ormsRiskCategory_ormsRisks,
				title: '<?php __('OrmsRisks'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_ormsRiskCategory_ormsRisks.getCount() == '')
							store_ormsRiskCategory_ormsRisks.reload();
					}
				},
				columns: [
					{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}
,					{header: "<?php __('Description'); ?>", dataIndex: 'description', sortable: true}
,					{header: "<?php __('Orms Risk Category'); ?>", dataIndex: 'orms_risk_category', sortable: true}
,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
,					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_ormsRiskCategory_ormsRisks,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var OrmsRiskCategoryViewWindow = new Ext.Window({
			title: '<?php __('View OrmsRiskCategory'); ?>: <?php echo $ormsRiskCategory['OrmsRiskCategory']['name']; ?>',
			width: 500,
			height:345,
			minWidth: 500,
			minHeight: 345,
			resizable: false,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'center',
                        modal: true,
			items: [ 
				ormsRiskCategory_view_panel_1,
				ormsRiskCategory_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					OrmsRiskCategoryViewWindow.close();
				}
			}]
		});
