//<script>
var store_parent_imsSirvItems = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'code','description','measurement','quantity','remark'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvItems', 'action' => 'list_sirv_items_data', $requisition_id)); ?>'	})
});


function ViewImsSirvItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsSirvItems', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var imsSirvItem_data = response.responseText;

			eval(imsSirvItem_data);

			ImsSirvItemViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the SIRV Item view form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentImsSirvItemName(value){
	var conditions = '\'ImsSirvItem.name LIKE\' => \'%' + value + '%\'';
	store_parent_imsSirvItems.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentImsSirvItemData() {
	store_parent_imsSirvItems.reload();
}

  var editor = new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	
	
function ViewImsDelegate(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'imsRequisitions', 'action' => 'delegate', $requisition_id)); ?>',
        success: function(response, opts) {
            var imsRequisition_data = response.responseText;

            eval(imsRequisition_data);

            ImsRequisitionDelegateWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Requisition delegate form. Error code'); ?>: ' + response.status);
        }
    });
}
	
function AcceptSIRV(){        
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_requisitions', 'action' => 'accept_sirv_items', $requisition_id)); ?>',
            method: 'POST',
            success: function(response, opts){
                store_parent_imsSirvItems.commitChanges();
				RefreshImsRequisitionData();
				var json = eval("(" + response.responseText + ")");
				Ext.Msg.alert('<?php __('Success'); ?>', json.msg);
            },
            failure: function(response, opts){
				var json = eval("(" + response.responseText + ")");
                Ext.Msg.alert('<?php __('Error'); ?>', json.errormsg);
            }
        });
    }
	
	function DenySIRV(){        
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_requisitions', 'action' => 'deny_sirv_items', $requisition_id)); ?>',           
            method: 'POST',
            success: function(response, opts){
                store_parent_imsSirvItems.commitChanges();
				RefreshImsRequisitionData();
				var json = eval("(" + response.responseText + ")");
				Ext.Msg.alert('<?php __('Success'); ?>', json.msg);
            },
            failure: function(response, opts){
				var json = eval("(" + response.responseText + ")");
                Ext.Msg.alert('<?php __('Error'); ?>', json.errormsg);
            }
        });
    }

var g = new Ext.grid.GridPanel({
	title: '<?php __('SIRV Items'); ?>',
	store: store_parent_imsSirvItems,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'imsSirvItemGrid',
	columns: [
		{header:"<?php __('Code'); ?>", dataIndex: 'code', sortable: true},
		{header:"<?php __('description'); ?>", dataIndex: 'description', sortable: true},
		{header: "<?php __('Measurement'); ?>", dataIndex: 'measurement', sortable: true},
		{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', sortable: true},
		{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true}	],
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
		store: store_parent_imsSirvItems,
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



var parentImsSirvItemsViewWindow = new Ext.Window({
	title: 'SIRV Items for the selected Requisition',
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
				text: '<?php __('Accept'); ?>',
				id: 'btnAccept',
				handler: function(btn){
					ViewImsDelegate();
					Ext.getCmp('btnAccept').disable();
					Ext.getCmp('btnDeny').disable();
					//parentImsSirvItemsViewWindow.close();
				}
			}
			,{
				text: '<?php __('Deny'); ?>',
				id: 'btnDeny',
				handler: function(btn){
					DenySIRV();
					parentImsSirvItemsViewWindow.close();
				}
			}
			,{
				text: 'Close',
				handler: function(btn){
					parentImsSirvItemsViewWindow.close();
				}
			}]
		});

store_parent_imsSirvItems.load({
    params: {
        start: 0,    
        limit: list_size
    }
});