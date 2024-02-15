//<script>
    <?php
        $this->ExtForm->create('Store');
        $this->ExtForm->defineFieldFunctions();
    ?>
    var StoreEditForm = new Ext.form.FormPanel({
        baseCls: 'x-plain',
        labelWidth: 100,
        labelAlign: 'right',
        url:'<?php echo $this->Html->url(array('controller' => 'stores', 'action' => 'edit')); ?>',
        defaultType: 'textfield',

        items: [
            <?php $this->ExtForm->input('id', array('hidden' => $store['Store']['id'])); ?>,
            <?php 
                $options = array();
                $options['value'] = $store['Store']['name'];
                $this->ExtForm->input('name', $options);
            ?>,
            <?php 
                $options = array();
                $options['value'] = $store['Store']['address'];
                $this->ExtForm->input('address', $options);
            ?>			
        ]
    });
		
    var StoreEditWindow = new Ext.Window({
        title: '<?php __('Edit Store'); ?>',
        width: 400,
        minWidth: 400,
        autoHeight: true,
        layout: 'fit',
        modal: true,
        resizable: true,
        plain:true,
        bodyStyle:'padding:5px;',
        buttonAlign:'right',
        items: StoreEditForm,
        tools: [{
            id: 'refresh',
            qtip: 'Reset',
            handler: function () {
                StoreEditForm.getForm().reset();
            },
            scope: this
        }, {
            id: 'help',
            qtip: 'Help',
            handler: function () {
                Ext.Msg.show({
                    title: 'Help',
                    buttons: Ext.MessageBox.OK,
                    msg: 'This form is used to modify an existing Store.',
                    icon: Ext.MessageBox.INFO
                });
            }
        }, {
            id: 'toggle',
            qtip: 'Collapse / Expand',
            handler: function () {
                if(StoreEditWindow.collapsed)
                    StoreEditWindow.expand(true);
                else
                    StoreEditWindow.collapse(true);
            }
        }],
        buttons: [ {
            text: '<?php __('Save'); ?>',
            handler: function(btn){
                StoreEditForm.getForm().submit({
                    waitMsg: '<?php __('Submitting your data...'); ?>',
                    waitTitle: '<?php __('Wait Please...'); ?>',
                    success: function(f,a){
                        Ext.Msg.show({
                            title: '<?php __('Success'); ?>',
                            buttons: Ext.MessageBox.OK,
                            msg: a.result.msg,
                            icon: Ext.MessageBox.INFO
                        });
                        StoreEditWindow.close();
                        RefreshStoreData();
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
                StoreEditWindow.close();
            }
        }]
    });
