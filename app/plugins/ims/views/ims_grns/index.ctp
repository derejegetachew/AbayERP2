//<script>
    var store_grns = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id','name','supplier','purchase_order','date_purchased','created','modified','status','postable'		]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_grns', 'action' => 'list_data')); ?>'
	}),	
        sortInfo:{field: 'created', direction: "DESC"},
	groupField: 'supplier'
    });

    function AddGrn() {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_grns', 'action' => 'add')); ?>',
            success: function(response, opts) {
                var grn_data = response.responseText;
			
                eval(grn_data);
			
                GrnAddWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the GRN add form. Error code'); ?>: ' + response.status);
            }
	});
    }
   
    function PostGrn(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_grns', 'action' => 'post')); ?>/'+id,
            success: function(response, opts) {
                Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Grn successfully posted for approval!'); ?>');
                RefreshGrnData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Please report this error to Administrator. Cannot post the Grn. Error code'); ?>: ' + response.status);
            }
	});
    }

    function EditGrn(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_grns', 'action' => 'edit')); ?>/'+id,
            success: function(response, opts) {
                var grn_data = response.responseText;
			
                eval(grn_data);
			
                GrnEditWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the GRN edit form. Error code'); ?>: ' + response.status);
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
    function ViewParentGrnItems(id) {
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_grn_items', 'action' => 'index2')); ?>/'+id,
            success: function(response, opts) {
                var parent_grnItems_data = response.responseText;

                eval(parent_grnItems_data);

                parentGrnItemsViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the GRN view form. Error code'); ?>: ' + response.status);
            }
        });
    }

    function DeleteGrn(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_grns', 'action' => 'delete')); ?>/'+id,
            success: function(response, opts) {
				var obj = JSON.parse(response.responseText);
				if(obj.success == "false"){
					Ext.Msg.alert('<?php __('Error'); ?>', obj.errormsg);
				} else if(obj.success == "true"){
					Ext.Msg.alert('<?php __('Success'); ?>', obj.msg);
					RefreshGrnData();
				}
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the GRN add form. Error code'); ?>: ' + response.status);
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
	url = '<?php echo $this->Html->url(array('controller' => 'ims_grns', 'action' => 'print_grn')); ?>/' + id;

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
	store_grns.reload({
            params: {
                start: 0,
                limit: list_size,
                conditions: conditions
	    }
	});
    }

    function RefreshGrnData() {
	store_grns.reload();
    }
    
    function showMenu(grid, index, event) {
        event.stopEvent();
        var record = grid.getStore().getAt(index);
        //alert(record.get('rejected'));
        var btnStatus = (record.get('rejected') == '<font color=red>True</font>' || record.get('approved') == '<font color=green>True</font>' || record.get('posted') == '<font color=yellow>True</font>')? true: false;
        //alert(btnStatus);
		var editStatus = (record.get('status') == 'approved' || record.get('status') == 'rejected' || record.get('status') == 'posted')? true: false;
		var printStatus = (record.get('status') == 'approved')? false: true;
        var menu = new Ext.menu.Menu({
            items: [{
                    text: '<b>Details of <i>' + record.get('name') + '</i></b>',
                    icon: 'img/table_view.png',
                    handler: function() {
                        ViewGrn(record.get('id'));
                    }
                }, '-', {
                    text: 'Edit GRN Items',
                    icon: 'img/table_edit.png',
                    handler: function() {
                        ViewParentGrnItems(record.get('id'));
                    },
					disabled: editStatus
                }, '-', {
                    text: 'Print Grn',
                    icon: 'img/table_print.png',                
                    handler: function() {
                        PrintGrn(record.get('id'));
                    },
                    disabled: printStatus
                }
				
            ]
        }).showAt(event.xy);
    }
	
    if(center_panel.find('id', 'grn-tab') != "") {
	var p = center_panel.findById('grn-tab');
	center_panel.setActiveTab(p);
    } else {
	var p = center_panel.add({
            title: '<?php __('GRNs'); ?>',
            closable: true,
            loadMask: true,
            stripeRows: true,
            id: 'grn-tab',
            xtype: 'grid',
            store: store_grns,				
            columns: [
                {header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
                {header: "<?php __('Supplier'); ?>", dataIndex: 'supplier', sortable: true},
                {header: "<?php __('Purchase Order'); ?>", dataIndex: 'purchase_order',sortable: true},
                {header: "<?php __('Date Purchased'); ?>", dataIndex: 'date_purchased', sortable: true},
                {header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true,direction: 'ASC'},
                {header: "<?php __('Status'); ?>", dataIndex: 'status',sortable: true,renderer: function(value){
                    if(value == 'posted')
                        return '<span style="color:blue;">' + value + '</span>';
                    else if(value == 'approved')
                        return '<span style="color:green;">' + value + '</span>';
                    else if(value == 'created')
                        return '<span style="color:aqua;">' + value + '</span>';
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
                    ViewGrn(Ext.getCmp('grn-tab').getSelectionModel().getSelected().data.id);
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
                        text: '<?php __('Add'); ?>',
                        tooltip:'<?php __('<b>Add GRNs</b><br />Click here to create a new GRN'); ?>',
                        icon: 'img/table_add.png',
                        cls: 'x-btn-text-icon',
                        handler: function(btn) {
                            AddGrn();
                        }
                    }, ' ', '-', ' ', {
                        xtype: 'tbbutton',
                        text: '<?php __('Post'); ?>',
                        id: 'post-grn',
                        tooltip:'<?php __('<b>Post GRNs</b><br />Click here to post the selected GRN'); ?>',
                        icon: 'img/table_edit.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                             var sm = p.getSelectionModel();
                                        var sel = sm.getSelected();
                                        if (sm.hasSelection()){
                                       Ext.Msg.show({
                                    title: '<?php __('Post Grn'); ?>',
                                    buttons: Ext.MessageBox.YESNO,
                                    msg: '<?php __('Post'); ?> '+sel.data.name+'?',
                                    icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
                                        if (btn == 'yes'){
                                            PostGrn(sel.data.id);
                                        }
                                    }
                                });
                                }
                        }
                    }, ' ', '-', ' ', {
                        xtype: 'tbbutton',
                        text: '<?php __('Edit Grn Items'); ?>',
                        id: 'edit-grn',
                        tooltip:'<?php __('<b>Edit GRNs</b><br />Click here to modify the selected GRN'); ?>',
                        icon: 'img/table_edit.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                                    var sm = p.getSelectionModel();
                                        var sel = sm.getSelected();
                                        if (sm.hasSelection()){
                                            ViewParentGrnItems(sel.data.id);
                                        };
                        }
                    }, ' ', '-', ' ', {
                        xtype: 'tbbutton',
                        text: '<?php __('Delete'); ?>',
                        id: 'delete-grn',
                        tooltip:'<?php __('<b>Delete GRNs(s)</b><br />Click here to remove the selected GRN(s)'); ?>',
                        icon: 'img/table_delete.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelections();
                            if (sm.hasSelection()){
                                if(sel.length==1){
                                    Ext.Msg.show({
                                        title: '<?php __('Remove GRN'); ?>',
                                        buttons: Ext.MessageBox.YESNO,
                                        msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
                                        icon: Ext.MessageBox.QUESTION,
                                        fn: function(btn){
                                            if (btn == 'yes'){
                                                DeleteGrn(sel[0].data.id);
                                            }
                                        }
                                    });
                                }else{
                                    Ext.Msg.show({
                                        title: '<?php __('Remove GRN'); ?>',
                                        buttons: Ext.MessageBox.YESNO,
                                        msg: '<?php __('Remove the selected GRNs'); ?>?',
                                        icon: Ext.MessageBox.QUESTION,
                                        fn: function(btn){
                                            if (btn == 'yes'){
                                                var sel_ids = '';
                                                for(i=0;i<sel.length;i++){
                                                    if(i>0)
                                                        sel_ids += '_';
                                                    sel_ids += sel[i].data.id;
                                                }
                                                DeleteGrn(sel_ids);
                                            }
                                        }
                                    });
                                }
                            } else {
                                Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
                            };
                        }
                    },  ' ', '-',  '<?php __('Supplier'); ?>: ', {
                        xtype : 'combo',
                        emptyText: 'All',
                        store : new Ext.data.ArrayStore({
                            fields : ['id', 'name'],
                            data : [
                                ['-1', 'All'],
    <?php
    $st = false;
    foreach ($suppliers as $supplier) {
        if ($st)
            echo ",
							";
        ?>['<?php echo $supplier['ImsSupplier']['id']; ?>' ,'<?php echo $supplier['ImsSupplier']['name']; ?>']<?php $st = true;
    }
    ?>                      ]
                        }),
                        displayField : 'name',
                        valueField : 'id',
                        mode : 'local',
                        value : '-1',
                        disableKeyFilter : true,
                        triggerAction: 'all',
                        listeners : {
                            select : function(combo, record, index){
                                store_grns.reload({
                                    params: {
                                        start: 0,
                                        limit: list_size,
                                        supplier_id : combo.getValue()
                                    }
                                });
                            }
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
                store: store_grns,
                displayInfo: true,
                displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
                beforePageText: '<?php __('Page'); ?>',
                afterPageText: '<?php __('of {0}'); ?>',
                emptyMsg: '<?php __('No data to display'); ?>'
            })
        });
        p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('post-grn').disable();
		p.getTopToolbar().findById('post-grn').setTooltip('<?php __('<b>Post GRNs</b><br />Click here to post the selected GRN'); ?>');
        if(this.getSelections()[0].data.status=='created'){

            p.getTopToolbar().findById('edit-grn').enable();
            p.getTopToolbar().findById('delete-grn').enable();
            if(this.getSelections()[0].data.postable == 'True'){
                p.getTopToolbar().findById('post-grn').enable();
				p.getTopToolbar().findById('post-grn').setTooltip('<?php __('<b>Post GRNs</b><br />Click here to post the selected GRN'); ?>');
            }
			else{
				 p.getTopToolbar().findById('post-grn').setTooltip('<?php __('<b>Since the selected GRN has no GRN items you are unable to post it.</b>'); ?>');
			}

            if(this.getSelections().length > 1){
                p.getTopToolbar().findById('edit-grn').disable();  
                p.getTopToolbar().findById('post-grn').disable();
                p.getTopToolbar().findById('delete-grn').disable();
            }
        }
        else if(r.get('status')=='posted' || r.get('status')=='approved'){
            p.getTopToolbar().findById('post-grn').disable();
        }
        });
        p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
            if(this.getSelections().length > 1){
                    p.getTopToolbar().findById('edit-grn').disable();
                    if(this.getSelections()[0].data.status=='created'){ 
                        if(this.getSelections()[0].data.postable == 'True'){
                            p.getTopToolbar().findById('post-grn').enable();
							p.getTopToolbar().findById('post-grn').setTooltip('<?php __('<b>Post GRNs</b><br />Click here to post the selected GRN'); ?>');
                        }
						else{
							p.getTopToolbar().findById('post-grn').setTooltip('<?php __('<b>Since the selected GRN has no GRN items you are unable to post it.</b>'); ?>');
						}
                        p.getTopToolbar().findById('delete-grn').enable();
                    }
                    else if(r.get('status')=='posted' || r.get('status') =='approved'){
                        p.getTopToolbar().findById('post-grn').disable();
                        p.getTopToolbar().findById('delete-grn').disable();
                    }
            }
            else if(this.getSelections().length == 1){
                 if(r.get('status')=='created'){
                    p.getTopToolbar().findById('edit-grn').enable();
                   
                    p.getTopToolbar().findById('delete-grn').enable();
                    if(this.getSelections()[0].data.postable == 'True'){
                        p.getTopToolbar().findById('post-grn').enable();
						p.getTopToolbar().findById('post-grn').setTooltip('<?php __('<b>Post GRNs</b><br />Click here to post the selected GRN'); ?>');
                    }
					else{
						p.getTopToolbar().findById('post-grn').setTooltip('<?php __('<b>Since the selected GRN has no GRN items you are unable to post it.</b>'); ?>');
					}
                 }
            }
            else{
                p.getTopToolbar().findById('edit-grn').disable();
               
                p.getTopToolbar().findById('delete-grn').disable();
            }
        });
        center_panel.setActiveTab(p);

        store_grns.load({
            params: {
                start: 0,          
                limit: list_size
            }
        });

    }
