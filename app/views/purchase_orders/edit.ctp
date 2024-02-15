//<script>
    <?php
        $this->ExtForm->create('PurchaseOrder');
        $this->ExtForm->defineFieldFunctions();
    ?>
    var PurchaseOrderEditForm = new Ext.form.FormPanel({
        baseCls: 'x-plain',
        labelWidth: 100,
        labelAlign: 'right',
        url:'<?php echo $this->Html->url(array('controller' => 'purchaseOrders', 'action' => 'edit')); ?>',
        defaultType: 'textfield',

        items: [
            <?php $this->ExtForm->input('id', array('hidden' => $purchase_order['PurchaseOrder']['id'])); ?>,
            <?php
                $options = array();
                $options['value'] = $purchase_order['PurchaseOrder']['name'];
                $this->ExtForm->input('name', $options);
            ?>		
        ]
    });
		
    var PurchaseOrderEditWindow = new Ext.Window({
        title: '<?php __('Edit Purchase Order'); ?>',
        width: 400,
        minWidth: 400,
        autoHeight: true,
        layout: 'fit',
        modal: true,
        resizable: true,
        plain:true,
        bodyStyle:'padding:5px;',
        buttonAlign:'right',
        items: PurchaseOrderEditForm,
        tools: [{
                id: 'refresh',
                qtip: 'Reset',
                handler: function () {
                    PurchaseOrderEditForm.getForm().reset();
                },
                scope: this
            }, {
                id: 'help',
                qtip: 'Help',
                handler: function () {
                    Ext.Msg.show({
                        title: 'Help',
                        buttons: Ext.MessageBox.OK,
                        msg: 'This form is used to modify an existing Purchase Order.',
                        icon: Ext.MessageBox.INFO
                    });
                }
            }, {
                id: 'toggle',
                qtip: 'Collapse / Expand',
                handler: function () {
                    if(PurchaseOrderEditWindow.collapsed)
                        PurchaseOrderEditWindow.expand(true);
                    else
                        PurchaseOrderEditWindow.collapse(true);
                }
            }],
        buttons: [{
                text: '<?php __('Save'); ?>',
                handler: function(btn){
                    PurchaseOrderEditForm.getForm().submit({
                        waitMsg: '<?php __('Submitting your data...'); ?>',
                        waitTitle: '<?php __('Wait Please...'); ?>',
                        success: function(f,a){
                            Ext.Msg.show({
                                title: '<?php __('Success'); ?>',
                                buttons: Ext.MessageBox.OK,
                                msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
                            });
                            PurchaseOrderEditWindow.close();
                            RefreshPurchaseOrderData();
                    },
                    failure: function(f,a){
                        Ext.Msg.show({
                            title: '<?php __('Warning'); ?>',
                            buttons: Ext.MessageBox.OK,
                            msg: a.result.errormsg,
                            icon: Ext.MessageBox.ERROR
                        });
                    }
                });
            }
        }, {
            text: '<?php __('Cancel'); ?>',
            handler: function(btn){
                PurchaseOrderEditWindow.close();
            }
        }]
    });
