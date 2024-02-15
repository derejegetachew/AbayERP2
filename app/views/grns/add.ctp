//<script>
    <?php
        $this->ExtForm->create('Grn');
        $this->ExtForm->defineFieldFunctions();
    ?>
    var GrnAddForm = new Ext.form.FormPanel({
        baseCls: 'x-plain',
        labelWidth: 100,
        labelAlign: 'right',
        url:'<?php echo $this->Html->url(array('controller' => 'grns', 'action' => 'add')); ?>',
        defaultType: 'textfield',

        items: [
            <?php 
                $options0 = array();
                $this->ExtForm->input('name', $options0);
            ?>,
            <?php 
                $options1 = array();
                $options1['items'] = $suppliers;
                $this->ExtForm->input('supplier_id', $options1);
            ?>,
            <?php 
                $options2 = array();
                if(isset($parent_id))
                    $options2['hidden'] = $parent_id;
                else
                    $options2['items'] = $purchase_orders;
                $this->ExtForm->input('purchase_order_id', $options2);
            ?>,
            <?php 
                $options3 = array();
                $this->ExtForm->input('date_purchased', $options3);
            ?>		
        ]
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
    
    var GrnAddWindow = new Ext.Window({
        title: '<?php __('Add Goods Receiving Notes'); ?>',
        width: 400,
        minWidth: 400,
        autoHeight: true,
        layout: 'fit',
        modal: true,
        resizable: true,
        plain:true,
        bodyStyle:'padding:5px;',
        buttonAlign:'right',
        items: GrnAddForm,
        tools: [{
            id: 'refresh',
            qtip: 'Reset',
            handler: function () {
                GrnAddForm.getForm().reset();
            },
            scope: this
        }, {
            id: 'help',
            qtip: 'Help',
            handler: function () {
                Ext.Msg.show({
                    title: 'Help',
                    buttons: Ext.MessageBox.OK,
                    msg: 'This form is used to insert a new GRN. When you click on "Save and Close" you will be allowed to select the specific items to be purchased from the PO',
                    icon: Ext.MessageBox.INFO
                });
            }
        }, {
            id: 'toggle',
            qtip: 'Collapse / Expand',
            handler: function () {
                if(GrnAddWindow.collapsed)
                    GrnAddWindow.expand(true);
                else
                    GrnAddWindow.collapse(true);
            }
        }],
        buttons: [  {
            text: '<?php __('Save'); ?>',
            handler: function(btn){
                GrnAddForm.getForm().submit({
                    waitMsg: '<?php __('Submitting your data...'); ?>',
                    waitTitle: '<?php __('Wait Please...'); ?>',
                    success: function(f,a){
                        Ext.Msg.show({
                            title: '<?php __('Success'); ?>',
                            buttons: Ext.MessageBox.OK,
                            msg: a.result.msg,
                            icon: Ext.MessageBox.INFO
                        });
                        GrnAddWindow.close();
                        //GrnAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
                        RefreshParentGrnData();
<?php } else { ?>
                        RefreshGrnData();
                        //alert(a.result.grn_id);
                        AddGrnItems(a.result.grn_id);
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
            text: '<?php __('Cancel'); ?>',
            handler: function(btn){
                GrnAddWindow.close();
            }
        }]
    });