//<script>
    <?php
            $this->ExtForm->create('Grn');
            $this->ExtForm->defineFieldFunctions();
    ?>
    var GrnEditForm = new Ext.form.FormPanel({
            baseCls: 'x-plain',
            labelWidth: 100,
            labelAlign: 'right',
            url:'<?php echo $this->Html->url(array('controller' => 'grns', 'action' => 'edit')); ?>',
            defaultType: 'textfield',

            items: [
                    <?php $this->ExtForm->input('id', array('hidden' => $grn['Grn']['id'])); ?>,
                    <?php 
                            $options = array();
                            $options['value'] = $grn['Grn']['name'];
                            $this->ExtForm->input('name', $options);
                    ?>,
                    <?php 
                            $options = array();
                            if(isset($parent_id))
                                    $options['hidden'] = $parent_id;
                            else
                                    $options['items'] = $suppliers;
                            $options['value'] = $grn['Grn']['supplier_id'];
                            $this->ExtForm->input('supplier_id', $options);
                    ?>,
                    <?php 
                            $options = array();
                            if(isset($parent_id))
                                    $options['hidden'] = $parent_id;
                            else
                                    $options['items'] = $purchase_orders;
                            $options['value'] = $grn['Grn']['purchase_order_id'];
                            $this->ExtForm->input('purchase_order_id', $options);
                    ?>,
                    <?php 
                            $options = array();
                            $options['value'] = $grn['Grn']['date_purchased'];
                            $this->ExtForm->input('date_purchased', $options);
                    ?>			]
    });
function AddGrnItems(grn_id) {
Ext.Ajax.request({
url: '<?php echo $this->Html->url(array('controller' => 'grns', 'action' => 'add_grn_items')); ?>/'+grn_id,
success: function(response, opts) {
    var grn_items_data = response.responseText;

    eval(grn_items_data);

    GrnAddItemsWindow.show();
},
failure: function(response, opts) {
    Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the GRN Items Add form. Error code'); ?>: ' + response.status);
}
});
}
    var GrnEditWindow = new Ext.Window({
            title: '<?php __('Edit Grn'); ?>',
            width: 400,
            minWidth: 400,
            autoHeight: true,
            layout: 'fit',
            modal: true,
            resizable: true,
            plain:true,
            bodyStyle:'padding:5px;',
            buttonAlign:'right',
            items: GrnEditForm,
            tools: [{
                    id: 'refresh',
                    qtip: 'Reset',
                    handler: function () {
                            GrnEditForm.getForm().reset();
                    },
                    scope: this
            }, {
                    id: 'help',
                    qtip: 'Help',
                    handler: function () {
                            Ext.Msg.show({
                                    title: 'Help',
                                    buttons: Ext.MessageBox.OK,
                                    msg: 'This form is used to modify an existing Grn.',
                                    icon: Ext.MessageBox.INFO
                            });
                    }
            }, {
                    id: 'toggle',
                    qtip: 'Collapse / Expand',
                    handler: function () {
                            if(GrnEditWindow.collapsed)
                                    GrnEditWindow.expand(true);
                            else
                                    GrnEditWindow.collapse(true);
                    }
            }],
            buttons: [ {
                text: '<?php __('Save'); ?>',
                handler: function(btn){
                    GrnEditForm.getForm().submit({
                        waitMsg: '<?php __('Submitting your data...'); ?>',
                        waitTitle: '<?php __('Wait Please...'); ?>',
                        success: function(f,a){
                            Ext.Msg.show({
                                title: '<?php __('Success'); ?>',
                                buttons: Ext.MessageBox.OK,
                                msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
                            });
                            GrnEditWindow.close();
<?php if(isset($parent_id)){ ?>
                            RefreshParentGrnData();
<?php } else { ?>
                            RefreshGrnData();

                            AddGrnItems(<?php echo $grn['Grn']['id'] ?>);
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
                    GrnEditWindow.close();
                }
            }]
    });
