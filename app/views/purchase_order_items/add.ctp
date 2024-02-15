//<script>
    <?php
        $this->ExtForm->create('PurchaseOrderItem');
        $this->ExtForm->defineFieldFunctions();
    ?>
    Ext.apply(Ext.form.VTypes, {
        Number:  function(v) {
            return /^\d+$/.test(v);
        },
        NumberText: 'Must be a numeric IP address',
        NumberMask: /[0-9]/i
    });
    
    var PurchaseOrderItemAddForm = new Ext.form.FormPanel({
        baseCls: 'x-plain',
        labelWidth: 150,
        labelAlign: 'right',
        url:'<?php echo $this->Html->url(array('controller' => 'purchaseOrderItems', 'action' => 'add')); ?>',
        defaultType: 'textfield',

        items: [
            <?php
                $options = array();
                if (isset($parent_id))
                    $options['hidden'] = $parent_id;
                else
                    $options['items'] = $purchase_orders;
                $this->ExtForm->input('purchase_order_id', $options);
            ?>,
            <?php
                $options = array();
                $options['items'] = $items;
                $this->ExtForm->input('item_id', $options);
            ?>,
            <?php
                $options = array('xtype' => 'combo', 'fieldLabel' => 'Measurement', 'anchor' => '60%');
                $options['items'] = array('Pcs' => 'Pcs', 'Pkt' => 'Pkt');
                $this->ExtForm->input('measurement', $options);
            ?>,
            <?php
                $options = array('anchor' => '60%', 'vtype' => 'Number');
                $options['maskRe'] = '/[0-9]/i';
                $this->ExtForm->input('ordered_quantity', $options);
            ?>,
            <?php
                $options = array('anchor' => '60%', 'xtype' => 'hidden', 'value' => '0');
                $this->ExtForm->input('purchased_quantity', $options);
            ?>,
            <?php
                $options = array('anchor' => '60%', 'vtype' => 'Currency');
                $options['maskRe'] = '/[0-9.]/i';
                $this->ExtForm->input('unit_price', $options);
            ?>			
        ]
    });
		
    var PurchaseOrderItemAddWindow = new Ext.Window({
        title: '<?php __('Add Purchase Order Item'); ?>',
        width: 500,
        minWidth: 500,
        autoHeight: true,
        layout: 'fit',
        modal: true,
        resizable: true,
        plain:true,
        bodyStyle:'padding:5px;',
        buttonAlign:'right',
        items: PurchaseOrderItemAddForm,
        tools: [{
                id: 'refresh',
                qtip: 'Reset',
                handler: function () {
                    PurchaseOrderItemAddForm.getForm().reset();
                },
                scope: this
            }, {
                id: 'help',
                qtip: 'Help',
                handler: function () {
                    Ext.Msg.show({
                        title: 'Help',
                        buttons: Ext.MessageBox.OK,
                        msg: 'This form is used to insert a new Purchase Order Item.',
                        icon: Ext.MessageBox.INFO
                    });
                }
            }, {
                id: 'toggle',
                qtip: 'Collapse / Expand',
                handler: function () {
                    if(PurchaseOrderItemAddWindow.collapsed)
                        PurchaseOrderItemAddWindow.expand(true);
                    else
                        PurchaseOrderItemAddWindow.collapse(true);
                }
            }],
        buttons: [  {
                text: '<?php __('Save'); ?>',
                handler: function(btn){
                    PurchaseOrderItemAddForm.getForm().submit({
                        waitMsg: '<?php __('Submitting your data...'); ?>',
                        waitTitle: '<?php __('Wait Please...'); ?>',
                        success: function(f,a){
                            
                            Ext.Msg.show({
                                title: '<?php __('Success'); ?>',
                                buttons: Ext.MessageBox.OK,
                                msg: a.result.msg,
                                icon: a.result.flag
                            });
                            PurchaseOrderItemAddForm.getForm().reset();
<?php if (isset($parent_id)) { ?>
                            RefreshParentPurchaseOrderItemData();
<?php } else { ?>
                            RefreshPurchaseOrderItemData();
<?php } ?>
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
                    PurchaseOrderItemAddForm.getForm().submit({
                        waitMsg: '<?php __('Submitting your data...'); ?>',
                        waitTitle: '<?php __('Wait Please...'); ?>',
                        success: function(f,a){
                            Ext.Msg.show({
                                title: '<?php __('Success'); ?>',
                                buttons: Ext.MessageBox.OK,
                                msg: a.result.msg,
                                icon: a.result.flag
                            });
                            PurchaseOrderItemAddWindow.close();
<?php if (isset($parent_id)) { ?>
                            RefreshParentPurchaseOrderItemData();
<?php } else { ?>
                            RefreshPurchaseOrderItemData();
<?php } ?>
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
                    PurchaseOrderItemAddWindow.close();
                }
            }
        ]
    });
