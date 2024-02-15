//<script>
    <?php
        $this->ExtForm->create('ItemCategory');
        $this->ExtForm->defineFieldFunctions();
    ?>
    var ItemCategoryEditForm = new Ext.form.FormPanel({
        baseCls: 'x-plain',
        labelWidth: 100,
        labelAlign: 'right',
        url:'<?php echo $this->Html->url(array('controller' => 'itemCategories', 'action' => 'edit')); ?>',
        defaultType: 'textfield',

        items: [
            <?php $this->ExtForm->input('id', array('hidden' => $item_category['ItemCategory']['id'])); ?>,
            <?php 
                $options = array();
                $options['value'] = $item_category['ItemCategory']['name'];
                $this->ExtForm->input('name', $options);
            ?>,
            <?php 
                $options = array();
                $options['hidden'] = $parent_id;
                $options['value'] = $item_category['ItemCategory']['parent_id'];
                $this->ExtForm->input('parent_id', $options);
            ?>		
        ]
    });
		
    var ItemCategoryEditWindow = new Ext.Window({
        title: '<?php __('Edit Item Category'); ?>',
        width: 400,
        minWidth: 400,
        autoHeight: true,
        layout: 'fit',
        modal: true,
        resizable: true,
        plain:true,
        bodyStyle:'padding:5px;',
        buttonAlign:'right',
        items: ItemCategoryEditForm,
        tools: [{
            id: 'refresh',
            qtip: 'Reset',
            handler: function () {
                ItemCategoryEditForm.getForm().reset();
            },
            scope: this
        }, {
            id: 'help',
            qtip: 'Help',
            handler: function () {
                Ext.Msg.show({
                    title: 'Help',
                    buttons: Ext.MessageBox.OK,
                    msg: 'This form is used to modify an existing Item Category.',
                    icon: Ext.MessageBox.INFO
                });
            }
        }, {
            id: 'toggle',
            qtip: 'Collapse / Expand',
            handler: function () {
                if(ItemCategoryEditWindow.collapsed)
                    ItemCategoryEditWindow.expand(true);
                else
                    ItemCategoryEditWindow.collapse(true);
            }
        }],
        buttons: [ {
            text: '<?php __('Save'); ?>',
            handler: function(btn){
                ItemCategoryEditForm.getForm().submit({
                    waitMsg: '<?php __('Submitting your data...'); ?>',
                    waitTitle: '<?php __('Wait Please...'); ?>',
                    success: function(f,a){
                        Ext.Msg.show({
                            title: '<?php __('Success'); ?>',
                            buttons: Ext.MessageBox.OK,
                            msg: a.result.msg,
                            icon: Ext.MessageBox.INFO
                        });
                        ItemCategoryEditWindow.close();
                        RefreshItemCategoryData();
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
                ItemCategoryEditWindow.close();
            }
        }]
    });
