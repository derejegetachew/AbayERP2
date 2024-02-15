//<script>
    <?php
            $this->ExtForm->create('ImsPurchaseOrderItem');
            $this->ExtForm->defineFieldFunctions();
    ?>
    var PurchaseOrderItemEditForm = new Ext.form.FormPanel({
        baseCls: 'x-plain',
        labelWidth: 100,
        labelAlign: 'right',
        url:'<?php echo $this->Html->url(array('controller' => 'ImsPurchaseOrderItems', 'action' => 'edit')); ?>',
        defaultType: 'textfield',

        items: [
            <?php $this->ExtForm->input('id', array('hidden' => $purchase_order_item['ImsPurchaseOrderItem']['id'])); ?>,
            <?php 
                $options = array();
                if(isset($parent_id))
                    $options['hidden'] = $parent_id;
                else
                    $options['items'] = $purchase_orders;
                $options['value'] = $purchase_order_item['ImsPurchaseOrderItem']['ims_purchase_order_id'];
                $this->ExtForm->input('ims_purchase_order_id', $options);
            ?>,
            <?php 
                $optionsI = array();
                if(isset($parent_id))
                    $optionsI['hidden'] = $parent_id;
                else
                    $optionsI['items'] = $items;
                $optionsI['value'] = $purchase_order_item['ImsPurchaseOrderItem']['ims_item_id'];
                $this->ExtForm->input('ims_item_id', $optionsI);
            ?>,
            <?php 
                $optionsM = array('xtype' => 'combo', 'fieldLabel' => 'Measurement', 'anchor' => '60%');
				$optionsM['items'] = array('Pcs' => 'Pcs', 'Pkt' => 'Pkt', 'Pad' => 'Pad', 'Kg' => 'Kg', 'Roll' => 'Roll', 'Ream' => 'Ream','m<sup>2</sup>' => 'm<sup>2</sup>');
                $optionsM['value'] = $purchase_order_item['ImsPurchaseOrderItem']['measurement'];
                $this->ExtForm->input('measurement', $optionsM);
            ?>,
            <?php 
                $optionsO = array();
                $optionsO['value'] = $purchase_order_item['ImsPurchaseOrderItem']['ordered_quantity'];
                $this->ExtForm->input('ordered_quantity', $optionsO);
            ?>,
            <?php 
                $optionsU = array('anchor' => '60%', 'vtype' => 'Currency1');
				$optionsU['maskRe'] = '/[0-9.]/i';
                $optionsU['value'] = $purchase_order_item['ImsPurchaseOrderItem']['unit_price'];
                $this->ExtForm->input('unit_price', $optionsU);
            ?>,
				<?php 
					$options = array();
					$options['value'] = $purchase_order_item['ImsPurchaseOrderItem']['remark'];
					$this->ExtForm->input('remark', $options);
				?>		
        ]
    });
		
    var PurchaseOrderItemEditWindow = new Ext.Window({
        title: '<?php __('Edit Purchase Order Item'); ?>',
        width: 400,
        minWidth: 400,
        autoHeight: true,
        layout: 'fit',
        modal: true,
        resizable: true,
        plain:true,
        bodyStyle:'padding:5px;',
        buttonAlign:'right',
        items: PurchaseOrderItemEditForm,
        tools: [{
                id: 'refresh',
                qtip: 'Reset',
                handler: function () {
                    PurchaseOrderItemEditForm.getForm().reset();
                },
                scope: this
            }, {
                id: 'help',
                qtip: 'Help',
                handler: function () {
                    Ext.Msg.show({
                        title: 'Help',
                        buttons: Ext.MessageBox.OK,
                        msg: 'This form is used to modify an existing Purchase Order Item.',
                        icon: Ext.MessageBox.INFO
                    });
                }
            }, {
                id: 'toggle',
                qtip: 'Collapse / Expand',
                handler: function () {
                    if(PurchaseOrderItemEditWindow.collapsed)
                        PurchaseOrderItemEditWindow.expand(true);
                    else
                        PurchaseOrderItemEditWindow.collapse(true);
                }
        }],
        buttons: [ {
            text: '<?php __('Save'); ?>',
            handler: function(btn){
                PurchaseOrderItemEditForm.getForm().submit({
                    waitMsg: '<?php __('Submitting your data...'); ?>',
                    waitTitle: '<?php __('Wait Please...'); ?>',
                    success: function(f,a){
                        Ext.Msg.show({
                            title: '<?php __('Success'); ?>',
                            buttons: Ext.MessageBox.OK,
                            msg: a.result.msg,
                            icon: Ext.MessageBox.INFO
                        });
                        PurchaseOrderItemEditWindow.close();
<?php if(isset($parent_id)){ ?>
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
                PurchaseOrderItemEditWindow.close();
            }
        }]
    });
