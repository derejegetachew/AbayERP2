//<script>
    var store_grn_items = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: ['id','grn_id','item','ordered_quantity','purchased_quantity','ordered_unit_price','purchased_unit_price']
        }),
        proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'grns', 'action' => 'list_data2', $grn_id)); ?>'
        })
    });
    
    function checkquanitity(val){
        var sm = GrnAddItemsWindow.findById('mygrid').getSelectionModel();
        var sel = sm.getSelected();
        if (sm.hasSelection()){
            order=sel.data.ordered_quantity;
                msg = "";
            purchased = Ext.getCmp('data[purchased]').getValue();
            if(purchased > order){
                msg = 'Purchased more than Ordered';

                return msg; 
            }else 
                return true;
        }
    }

    function SaveStore(){
        var records = store_grn_items.getModifiedRecords(), fields = store_grn_items.fields;
        var param = {};        
        for(var i = 0; i < records.length; i++) {
            for(var j = 0; j < fields.length; j++){
                param[ i + '^' + fields['items'][j]['name']] = Ext.encode(records[i].get(fields['items'][j]['name']));
            }
        }
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'grns', 'action' => 'add_grn_items', $grn_id)); ?>',
            params: param,
            method: 'POST',
            success: function(){
                store_grn_items.commitChanges();
            },
            failure: function(){
                // do stuff	
            }
        });
    }
    
    var editor = new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
    
    var grn_items_grid_panel = new Ext.TabPanel({
        activeTab: 0,
        anchor: '100%',
        height:370,
        plain:true,
        defaults:{autoScroll: true},
        items:[{
            xtype: 'grid',
            loadMask: true,
            id:'mygrid',
            stripeRows: true,
            store: store_grn_items,
            title: '<?php __('GRN Items'); ?>',
            enableColumnMove: false,
            plugins: [editor],
            sm: new Ext.grid.RowSelectionModel({
                    singleSelect: false
            }),
            columns: [
                {header: "<?php __('Item'); ?>", dataIndex: 'item', sortable: true},
                {header: "<?php __('Ordered Qty'); ?>", dataIndex: 'ordered_quantity', sortable: true},
                {header: "<?php __('Purchased Qty'); ?>", dataIndex: 'purchased_quantity', sortable: true, editor: { id:'data[purchased]', xtype: 'numberfield', allowBlank: false, validator:checkquanitity }, align:'right'},
                {header: "<?php __('Ordered Unit Price'); ?>", dataIndex: 'ordered_unit_price', sortable: true},
                {header: "<?php __('Purchased Unit Price'); ?>", dataIndex: 'purchased_unit_price', sortable: true, editor: {  xtype: 'numberfield', allowBlank: false }, align:'right'}
            ],
            viewConfig: {
                forceFit: true
            },
            tbar: new Ext.Toolbar({
                items: [' ', {
                        xtype: 'tbbutton',
                        text: '<?php __('Save Changes'); ?>',
                        tooltip:'<?php __('<b>Save Changes</b><br />Click here to Save Changes'); ?>',
                        icon: 'img/table_edit.png',
                        cls: 'x-btn-text-icon',
                        handler: function(btn) {
                            SaveStore();
                        }
                    }
                ]
            })
        }]
    });
    
    var GrnAddItemsWindow = new Ext.Window({
        title: '<?php __('Add GRN Items'); ?>',
        width: 500,
        height:450,
        minWidth: 500,
        minHeight: 450,
        resizable: true,
        plain:true,
        bodyStyle:'padding:5px;',
        buttonAlign:'center',
        modal: true,
        items: [
            grn_items_grid_panel
        ],

        buttons: [{
            text: '<?php __('Close'); ?>',
            handler: function(btn){
                GrnAddItemsWindow.close();
            }
        }]
    });
    
    store_grn_items.load({
        params: {
            start: 0,          
            limit: list_size
        }
    });