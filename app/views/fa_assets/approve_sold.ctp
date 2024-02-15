
var store_faAssets = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','reference','name','location','original_cost','book_date','sold','sold_date','sold_amount']
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'faAssets', 'action' => 'list_data_s')); ?>'
	})

});


function AddFaAsset() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'faAssets', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var faAsset_data = response.responseText;
			
			eval(faAsset_data);
			
			FaAssetAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the faAsset add form. Error code'); ?>: ' + response.status);
		}
	});
}

function FetchFaAsset() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'faAssets', 'action' => 'fetch')); ?>',
		success: function(response, opts) {
			var faAsset_data = response.responseText;
			
			eval(faAsset_data);
			
			FaAssetAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Asset fetch form. Error code'); ?>: ' + response.status);
		}
	});
}

function ApproveFaAsset(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'faAssets', 'action' => 'approveassetsold')); ?>/'+id,
		success: function(response, opts) {
			
			Ext.Msg.alert("Info","The selected asset has been approved");
			RefreshFaAssetData();
			
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the faAsset edit form. Error code'); ?>: ' + response.status);
		}
	});
}
function ApproveAllFaAsset() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'faAssets', 'action' => 'approveallasset')); ?>',
		success: function(response, opts) {
			
			Ext.Msg.alert("Info","The selected asset has been approved");
			RefreshFaAssetData();
			
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the faAsset edit form. Error code'); ?>: ' + response.status);
		}
	});
}
function EditFaAsset(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'faAssets', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var faAsset_data = response.responseText;
			
			eval(faAsset_data);
			
			FaAssetEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the faAsset edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewFaAsset(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'faAssets', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var faAsset_data = response.responseText;

            eval(faAsset_data);

            FaAssetViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the faAsset view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteFaAsset(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'faAssets', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('FaAsset successfully deleted!'); ?>');
			RefreshFaAssetData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the faAsset add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchFaAsset(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'faAssets', 'action' => 'search')); ?>',
		success: function(response, opts){
			var faAsset_data = response.responseText;

			eval(faAsset_data);

			faAssetSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the faAsset search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByFaAssetName(value){
	var conditions = '\'FaAsset.name LIKE\' => \'%' + value + '%\'';
	store_faAssets.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshFaAssetData() {
	store_faAssets.reload();
}


if(center_panel.find('id', 'faAsset-tab-approve-sold') != "") {
	var p = center_panel.findById('faAsset-tab-approve-sold');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Approve Sold Asset'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'faAsset-tab-approve-sold',
		xtype: 'grid',
		store: store_faAssets,
		columns: [
			{header: "<?php __('Reference'); ?>", dataIndex: 'reference', sortable: true},
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Location'); ?>", dataIndex: 'location', sortable: true},
			{header: "<?php __('Original Cost'); ?>", dataIndex: 'original_cost', sortable: true},
			{header: "<?php __('Booking Date'); ?>", dataIndex: 'book_date', sortable: true},
			{header: "<?php __('Sold'); ?>", dataIndex: 'sold', sortable: true},
			{header: "<?php __('Sold Date'); ?>", dataIndex: 'sold_date', sortable: true},
  	  {header: "<?php __('Sold Amount'); ?>", dataIndex: 'sold_amount', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "FaAssets" : "FaAsset"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewFaAsset(Ext.getCmp('faAsset-tab-approve-sold').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Approve All'); ?>',
					id: 'approve_app-faAsset',
					tooltip:'<?php __('<b>Edit Assets</b><br />Click here to modify the selected Asset'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
					
							ApproveAllFaAsset();
						
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Approve'); ?>',
					id: 'approve-faAsset',
					tooltip:'<?php __('<b>Edit Assets</b><br />Click here to modify the selected Asset'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ApproveFaAsset(sel.data.id);
						};
					}
				}, ' ', '-', ' ',  {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-faAsset',
					tooltip:'<?php __('<b>Edit Assets</b><br />Click here to modify the selected Asset'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditFaAsset(sel.data.id);
						};
					}
				},  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'faAsset_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByFaAssetName(Ext.getCmp('faAsset_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'faAsset_go_button',
					handler: function(){
						SearchByFaAssetName(Ext.getCmp('faAsset_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchFaAsset();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_faAssets,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-faAsset').enable();
	    p.getTopToolbar().findById('approve-faAsset').enable();
		p.getTopToolbar().findById('delete-faAsset').enable();
		p.getTopToolbar().findById('view-faAsset').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-faAsset').disable();
			 p.getTopToolbar().findById('approve-faAsset').disable();
			p.getTopToolbar().findById('view-faAsset').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-faAsset').disable();
			 p.getTopToolbar().findById('approve-faAsset').disable();
			p.getTopToolbar().findById('view-faAsset').disable();
			p.getTopToolbar().findById('delete-faAsset').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-faAsset').enable();
			 p.getTopToolbar().findById('approve-faAsset').enable();
			p.getTopToolbar().findById('view-faAsset').enable();
			p.getTopToolbar().findById('delete-faAsset').enable();
		}
		else{
			p.getTopToolbar().findById('edit-faAsset').disable();
			 p.getTopToolbar().findById('approve-faAsset').disable();
			p.getTopToolbar().findById('view-faAsset').disable();
			p.getTopToolbar().findById('delete-faAsset').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_faAssets.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
