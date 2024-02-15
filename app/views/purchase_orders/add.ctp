//<script>
    <?php
        $this->ExtForm->create('PurchaseOrder');
        $this->ExtForm->defineFieldFunctions();
    ?>
        var PurchaseOrderAddForm = new Ext.form.FormPanel({
            baseCls: 'x-plain',
            labelWidth: 100,
            labelAlign: 'right',
            url:'<?php echo $this->Html->url(array('controller' => 'purchaseOrders', 'action' => 'add')); ?>',
            defaultType: 'textfield',

            items: [
                <?php
                    $options = array();
                    $this->ExtForm->input('name', $options);
                ?>]
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
            plain:true,
            bodyStyle:'padding:5px;',
            buttonAlign:'right',
            items: PurchaseOrderAddForm,
            tools: [{
                    id: 'refresh',
                    qtip: 'Reset',
                    handler: function () {
                        PurchaseOrderAddForm.getForm().reset();
                    },
                    scope: this
                }, {
                    id: 'help',
                    qtip: 'Help',
                    handler: function () {
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
                    handler: function () {
                        if(PurchaseOrderAddWindow.collapsed)
                            PurchaseOrderAddWindow.expand(true);
                        else
                            PurchaseOrderAddWindow.collapse(true);
                    }
                }],
            buttons: [  {
                    text: '<?php __('Save'); ?>',
                    handler: function(btn){
                        PurchaseOrderAddForm.getForm().submit({
                            waitMsg: '<?php __('Submitting your data...'); ?>',
                            waitTitle: '<?php __('Wait Please...'); ?>',
                            success: function(f,a){
                                Ext.Msg.show({
                                    title: '<?php __('Success'); ?>',
                                    buttons: Ext.MessageBox.OK,
                                    msg: a.result.msg,
                                    icon: Ext.MessageBox.INFO
                                });
                                PurchaseOrderAddForm.getForm().reset();
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
                    text: '<?php __('Save & Close'); ?>',
                    handler: function(btn){
                        PurchaseOrderAddForm.getForm().submit({
                            waitMsg: '<?php __('Submitting your data...'); ?>',
                            waitTitle: '<?php __('Wait Please...'); ?>',
                            success: function(f,a){
                                Ext.Msg.show({
                                    title: '<?php __('Success'); ?>',
                                    buttons: Ext.MessageBox.OK,
                                    msg: a.result.msg,
                                    icon: Ext.MessageBox.INFO
                                });
                                PurchaseOrderAddWindow.close();
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
                },{
                    text: '<?php __('Cancel'); ?>',
                    handler: function(btn){
                        PurchaseOrderAddWindow.close();
                    }
                }]
        });
