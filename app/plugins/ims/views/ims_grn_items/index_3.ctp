//<script>
var store_parent_imsGrnItems = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','code','description','measurement','quantity','unit_price','remark'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsGrnItems', 'action' => 'list_grn_items_data1', $grn_id)); ?>'	})
});


function ViewImsGrnItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsGrnItems', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var imsGrnItem_data = response.responseText;

			eval(imsGrnItem_data);

			GrnItemViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the GRN Item view form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentImsGrnItemName(value){
	var conditions = '\'ImsGrnItem.name LIKE\' => \'%' + value + '%\'';
	store_parent_imsGrnItems.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentImsGrnItemData() {
	store_parent_imsGrnItems.reload();
}

  var editor = new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	
	function DeleteRow(){		
        var selectedRows = g.getSelectionModel().getSelections();
        
        if(selectedRows.length >0)
            store_parent_imsGrnItems.remove(selectedRows);
        else
            Ext.Msg.alert('Status', 'Please select at least one record to delete!');
	}
	
function AdjustGrn(){
        var records = store_parent_imsGrnItems.data.items, fields = store_parent_imsGrnItems.fields;		
        var param = {};        
        for(var i = 0; i < records.length; i++) {
            for(var j = 0; j < fields.length; j++){
                param[ i + '^' + fields['items'][j]['name']] = Ext.encode(records[i].get(fields['items'][j]['name']));
            }
        }
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_grns', 'action' => 'add_sirv_items', $grn_id)); ?>',
            params: param,
            method: 'POST',
            success: function(response, opts){
                store_parent_imsGrnItems.commitChanges();
				RefreshGrnData();
				var json = eval("(" + response.responseText + ")");
				Ext.Msg.alert('<?php __('Result'); ?>', json.msg);
            },
            failure: function(response, opts){
				var json = eval("(" + response.responseText + ")");
                Ext.Msg.alert('<?php __('Error'); ?>', json.errormsg);
            }
        });
    }

var g = new Ext.grid.GridPanel({
	title: '<?php __('GRN Items'); ?>',
	store: store_parent_imsGrnItems,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'imsGrnItemGrid',
	columns: [
		{header:"<?php __('Id'); ?>", dataIndex: 'id', sortable: true, hidden: true},
		{header:"<?php __('Code'); ?>", dataIndex: 'code', sortable: true},
		{header:"<?php __('description'); ?>", dataIndex: 'description', sortable: true},
		{header: "<?php __('Measurement'); ?>", dataIndex: 'measurement', sortable: true},
		{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true},
		{header: "<?php __('Unit Price'); ?>", dataIndex: 'unit_price', sortable: true},
		{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true} 	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            //ViewImsSirvItem(Ext.getCmp('imsSirvItemGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_imsGrnItems,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	
	if(this.getSelections().length > 1){
		
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		
	}
	else if(this.getSelections().length == 1){
	}
	else{
		
	}
});



var parentImsGRNItemsViewWindow = new Ext.Window({
	title: 'GRN Items for the selected Grn',
	width: 700,
	height:375,
	minWidth: 700,
	minHeight: 400,
	resizable: false,
	plain:true,
	bodyStyle:'padding:5px;',
	buttonAlign:'center',
        modal: true,
	items: [
		g
	],

	buttons: [{
				text: '<?php __('Delete Row'); ?>',
				handler: function(btn){
					DeleteRow();
				}
			},
			{
				text: '<?php __('Adjust and Close'); ?>',
				handler: function(btn){
					AdjustGrn();
					parentImsGRNItemsViewWindow.close();
				}
			}
			,{
				text: 'Close',
				handler: function(btn){
					parentImsGRNItemsViewWindow.close();
				}
			}]
});

store_parent_imsGrnItems.load({
    params: {
        start: 0,    
        limit: list_size
    }
});