//<script>
    <?php
        $this->ExtForm->create('ImsPurchaseOrder');
        $this->ExtForm->defineFieldFunctions();
    ?>
    var PurchaseOrderAddForm = new Ext.form.FormPanel({
        baseCls: 'x-plain',
        labelWidth: 100,
        labelAlign: 'right',
        url: '<?php echo $this->Html->url(array('controller' => 'ims_purchase_orders', 'action' => 'add')); ?>',
        defaultType: 'textfield',
        items: [
                <?php
                    $options = array('fieldLabel' => 'Ref Number','readOnly' => 'true');
                    date_default_timezone_set("Africa/Addis_Ababa");  
                    $options['value'] = date("Ymd").'/'.str_pad(($count + 1), 3,'0',STR_PAD_LEFT);
                    $this->ExtForm->input('name', $options);
                ?>,
				{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						sortInfo: { field: "name", direction: "ASC" },
						storeId: 'my_array_store',
						id: 0,
						fields: ['id','name'],
						
						data: [
						<?php foreach($suppliers as $supplier){?>
						['<?php echo $supplier['ImsSupplier']['id']?>','<?php echo $supplier['ImsSupplier']['name']?>'],
						<?php
						}
						?>
						]
						
					}),					
					displayField: 'name',
					typeAhead: true,
					typeAheadDelay: 15000,					
					hiddenName:'data[ImsPurchaseOrder][ims_supplier_id]',
					id: 'supplier',
					name: 'supplier',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select Supplier',
					selectOnFocus:false,
					valueField: 'id',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Supplier',
					allowBlank: false,
					editable: true,
					lazyRender: true,
					blankText: 'Your input is invalid.',
					disableKeyFilter: true,
					forceSelection:true,
					anyMatch : true,
				},
				{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						sortInfo: { field: "name", direction: "ASC" },
						storeId: 'my_array_store',
						id: 0,
						fields: ['id','name'],
						
						data: [[1,'Planned'],[0,'Unplanned'],]
						
					}),					
					displayField: 'name',
					typeAhead: false,
					hiddenName:'data[ImsPurchaseOrder][planned]',
					id: 'planned',
					name: 'planned',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select one',
					selectOnFocus:false,
					valueField: 'id',
					anchor: '60%',
					fieldLabel: '<span style="color:red;">*</span> Is Planned?',
					allowBlank: false,
					editable: false,
					forceSelection: false,
					lazyRender: true,
					blankText: 'Your input is invalid.'
				}]
    }
    );

    var PurchaseOrderAddWindow = new Ext.Window({
        title: '<?php __('Add Purchase Order'); ?>',
        width: 400,
        minWidth: 400,
        autoHeight: true,
        layout: 'fit',
        modal: true,
        resizable: true,
        plain: true,
        bodyStyle: 'padding:5px;',
        buttonAlign: 'right',
        items: PurchaseOrderAddForm,
        tools: [{
                id: 'refresh',
                qtip: 'Reset',
                handler: function() {
                    PurchaseOrderAddForm.getForm().reset();
                },
                scope: this
            }, {
                id: 'help',
                qtip: 'Help',
                handler: function() {
                    Ext.Msg.show({
                        title: 'Help',
                        buttons: Ext.MessageBox.OK,
                        msg: 'This form is used to insert a new Purchase Order.',
                        icon: Ext.MessageBox.INFO
                    });
                }
            }, {
                id: 'toggle',
                qtip: 'Collapse / Expand',
                handler: function() {
                    if (PurchaseOrderAddWindow.collapsed)
                        PurchaseOrderAddWindow.expand(true);
                    else
                        PurchaseOrderAddWindow.collapse(true);
                }
            }],
        buttons: [{
                text: '<?php __('Save'); ?>',
                handler: function(btn) {
                    PurchaseOrderAddForm.getForm().submit({
                        waitMsg: '<?php __('Submitting your data...'); ?>',
                        waitTitle: '<?php __('Wait Please...'); ?>',
                        success: function(f, a) {
                            Ext.Msg.show({
                                title: '<?php __('Success'); ?>',
                                buttons: Ext.MessageBox.OK,
                                msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
                            });
                            PurchaseOrderAddForm.getForm().reset();
                            PurchaseOrderAddWindow.close();
                            RefreshPurchaseOrderData();

                            //AddPurchaseOrderItems(a.result.po_id);
                            ViewParentPurchaseOrderItems(a.result.po_id);
                        },
                        failure: function(f, a) {
                            Ext.Msg.show({
                                title: '<?php __('Warning'); ?>',
                                buttons: Ext.MessageBox.OK,
                                msg: a.result.errormsg,
                                icon: Ext.MessageBox.ERROR
                            });
                        }
                    });
                }
            }/*, {
             text: '<?php //__('Save & Close'); ?>',
             handler: function(btn){
             PurchaseOrderAddForm.getForm().submit({
             waitMsg: '<?php //__('Submitting your data...'); ?>',
             waitTitle: '<?php //__('Wait Please...'); ?>',
             success: function(f,a){
             Ext.Msg.show({
             title: '<?php// __('Success'); ?>',
             buttons: Ext.MessageBox.OK,
             msg: a.result.msg,
             icon: Ext.MessageBox.INFO
             });
             PurchaseOrderAddWindow.close();
             RefreshPurchaseOrderData();
             
             },
             failure: function(f,a){
             Ext.Msg.show({
             title: '<?php //__('Warning'); ?>',
             buttons: Ext.MessageBox.OK,
             msg: a.result.errormsg,
             icon: Ext.MessageBox.ERROR
             });
             }
             });
             }
             }*/, {
                text: '<?php __('Cancel'); ?>',
                handler: function(btn) {
                    PurchaseOrderAddWindow.close();
                }
            }]
    });
