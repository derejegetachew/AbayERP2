//<script>
    var store_grns_approve = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id','name','supplier','purchase_order','date_purchased','created','modified','status'		]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_grns', 'action' => 'list_data_2')); ?>'
	}),	
        sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'supplier'
    });
   
    function ApproveGrn(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_grns', 'action' => 'approve')); ?>/'+id,
            success: function(response, opts) {
                Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Grn successfully approved!');?>');
                RefreshGrnData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Please report this error to Administrator. Cannot approve the Grn. Error code'); ?>: ' + response.status);
            }
	});
    }    

    function ViewGrn(id) {
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_grns', 'action' => 'view')); ?>/'+id,
            success: function(response, opts) {
                var grn_data = response.responseText;

                eval(grn_data);

                GrnViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the GRN view form. Error code'); ?>: ' + response.status);
            }
        });
    }

    var popUpWin=0;

    function popUpWindow(URLStr, left, top, width, height) {
        if(popUpWin){
            if(!popUpWin.closed) popUpWin.close();
        }
        popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
    }

    function PrintGrn(id) {
	url = '<?php echo $this->Html->url(array('controller' => 'ims_grns', 'action' => 'print_grn1')); ?>/' + id;

        popUpWindow(url, 200, 20, 900, 600);
    }

    function SearchGrn(){
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_grns', 'action' => 'search')); ?>',
            success: function(response, opts){
                var grn_data = response.responseText;

                eval(grn_data);

                grnSearchWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the GRN search form. Error Code'); ?>: ' + response.status);
            }
	});
    }

    function SearchByGrnName(value){
	var conditions = '\'ImsGrn.name LIKE\' => \'%' + value + '%\'';
	store_grns_approve.reload({
            params: {
                start: 0,
                limit: list_size,
                conditions: conditions
	    }
	});
    }

    function RefreshGrnData() {
	store_grns_approve.reload();
    }
    
	function AdjustGrn(id) {
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_grn_items', 'action' => 'index_3')); ?>/'+id,
            success: function(response, opts) {
                var grn_item_data = response.responseText;

                eval(grn_item_data);

                parentImsGRNItemsViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the GRN item form. Error code'); ?>: ' + response.status);
            }
        });
}

    function showMenu(grid, index, event) {
        event.stopEvent();
        var record = grid.getStore().getAt(index);
        //alert(record.get('rejected'));
        
        var menu = new Ext.menu.Menu({
            items: [{
                    text: 'Print Grn',
                    icon: 'img/table_print.png',                
                    handler: function() {
                        PrintGrn(record.get('id'));
                    },
                }
            ]
        }).showAt(event.xy);

    }


    if(center_panel.find('id', 'all-grn-tab') != "") {
	var p = center_panel.findById('all-grn-tab');
	center_panel.setActiveTab(p);
    } else {
	var p = center_panel.add({
            title: '<?php __('All GRNs'); ?>',
            closable: true,
            loadMask: true,
            stripeRows: true,
            id: 'all-grn-tab',
            xtype: 'grid',
            store: store_grns_approve,
            columns: [
                {header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
                {header: "<?php __('Supplier'); ?>", dataIndex: 'supplier', sortable: true},
                {header: "<?php __('Purchase Order'); ?>", dataIndex: 'purchase_order', sortable: true},
                {header: "<?php __('Date Purchased'); ?>", dataIndex: 'date_purchased', sortable: true},
                {header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
                {header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true,  renderer: function(value){
                    if(value == 'posted')
                        return '<span style="color:blue;">' + value + '</span>';
                    else if(value == 'approved')
                        return '<span style="color:green;">' + value + '</span>';
                    else
                        return value;   
                }}
            ],
            view: new Ext.grid.GroupingView({
                forceFit:true,
                groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "GRNs" : "GRN"]})'
            }),
            listeners: {
                celldblclick: function(){
                    PrintGrn(Ext.getCmp('all-grn-tab').getSelectionModel().getSelected().data.id);
                },
                'rowcontextmenu': function(grid, index, event) {
                    showMenu(grid, index, event);
                }
            },
            sm: new Ext.grid.RowSelectionModel({
                singleSelect: false
            }),
            tbar: new Ext.Toolbar({
                items: [{
                        xtype: 'tbbutton',
                        text: '<?php __('View Grn'); ?>',
                        id: 'view-grn-approve',
                        tooltip:'<?php __('<b>View Grn</b><br />Click here to see details of the selected Grn'); ?>',
                        icon: 'img/table_view.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelected();
                            if (sm.hasSelection()){
                                ViewGrn(sel.data.id);
                            };
                        }
                    }, '->', {
                        xtype: 'textfield',
                        emptyText: '<?php __('[Search By Name]'); ?>',
                        id: 'grn_search_field',
                        listeners: {
                            specialkey: function(field, e){
                                if (e.getKey() == e.ENTER) {
                                    SearchByGrnName(Ext.getCmp('grn_search_field').getValue());
                                }
                            }
                        }
                    }, {
                        xtype: 'tbbutton',
                        icon: 'img/search.png',
                        cls: 'x-btn-text-icon',
                        text: '<?php __('GO'); ?>',
                        tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
                        id: 'grn_go_button',
                        handler: function(){
                            SearchByGrnName(Ext.getCmp('grn_search_field').getValue());
                        }
                    }, '-', {
                        xtype: 'tbbutton',
                        icon: 'img/table_search.png',
                        cls: 'x-btn-text-icon',
                        text: '<?php __('Advanced Search'); ?>',
                        tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
                        handler: function(){
                            SearchGrn();
                        }
                    }
                ]}),
            bbar: new Ext.PagingToolbar({
                pageSize: list_size,
                store: store_grns_approve,
                displayInfo: true,
                displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
                beforePageText: '<?php __('Page'); ?>',
                afterPageText: '<?php __('of {0}'); ?>',
                emptyMsg: '<?php __('No data to display'); ?>'
            })
        });
        p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
        if(r.get('status')=='created' || r.get('status')=='approved'){
            p.getTopToolbar().findById('view-grn-approve').enable();           
            if(this.getSelections().length > 1){
                p.getTopToolbar().findById('view-grn-approve').disable();
            }
        }
        else if(r.get('status')=='posted'){
            p.getTopToolbar().findById('view-grn-approve').enable();
            if(this.getSelections().length > 1){
                p.getTopToolbar().findById('view-grn-approve').disable();
            }
        }
        });
        p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
            if(this.getSelections().length > 1){
                p.getTopToolbar().findById('view-grn-approve').disable();
            }
            else if(this.getSelections().length == 1){
                if(r.get('status')=='created' || r.get('status')=='approved'){
                    p.getTopToolbar().findById('view-grn-approve').enable();
                 }
                 else if (r.get('status')=='posted'){
                    p.getTopToolbar().findById('view-grn-approve').enable();
                 }
            }
            else{
                p.getTopToolbar().findById('view-grn-approve').disable();
            }
        });
        center_panel.setActiveTab(p);

        store_grns_approve.load({
            params: {
                start: 0,          
                limit: list_size
            }
        });

    }
