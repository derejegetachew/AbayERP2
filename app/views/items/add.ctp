//<script>
    <?php
        $this->ExtForm->create('Item');
        $this->ExtForm->defineFieldFunctions();
    ?>
        var ItemAddForm = new Ext.form.FormPanel({
            baseCls: 'x-plain',
            labelWidth: 100,
            labelAlign: 'right',
            url:'<?php echo $this->Html->url(array('controller' => 'items', 'action' => 'add')); ?>',
            defaultType: 'textfield',

            items: [
                <?php
                    $options_name = array();
                    $this->ExtForm->input('name', $options_name);
                ?>,
                <?php
                    $options_description = array();
                    $this->ExtForm->input('description', $options_description);
                ?>,
                <?php
                    $options_item_category_id = array();
                    if (isset($parent_id))
                        $options_item_category_id['hidden'] = $parent_id;
                    else
                        $options_item_category_id['items'] = $item_categories;
                    $this->ExtForm->input('item_category_id', $options_item_category_id);
                ?>,
                <?php
                    $options_max_level = array('anchor'=>'65%');
                    $this->ExtForm->input('max_level', $options_max_level);
                ?>,
                <?php
                    $options_min_level = array('anchor'=>'65%');
                    $this->ExtForm->input('min_level', $options_min_level);
                ?>
            ]
        });
		
        var ItemAddWindow = new Ext.Window({
            title: '<?php __('Add Item'); ?>',
            width: 400,
            minWidth: 400,
            autoHeight: true,
            layout: 'fit',
            modal: true,
            resizable: true,
            plain:true,
            bodyStyle:'padding:5px;',
            buttonAlign:'right',
            items: ItemAddForm,
            tools: [{
                    id: 'refresh',
                    qtip: 'Reset',
                    handler: function () {
                        ItemAddForm.getForm().reset();
                    },
                    scope: this
                }, {
                    id: 'help',
                    qtip: 'Help',
                    handler: function () {
                        Ext.Msg.show({
                            title: 'Help',
                            buttons: Ext.MessageBox.OK,
                            msg: 'This form is used to insert a new Item.',
                            icon: Ext.MessageBox.INFO
                        });
                    }
                }, {
                    id: 'toggle',
                    qtip: 'Collapse / Expand',
                    handler: function () {
                        if(ItemAddWindow.collapsed)
                            ItemAddWindow.expand(true);
                        else
                            ItemAddWindow.collapse(true);
                    }
                }
            ],
            buttons: [  {
                    text: '<?php __('Save'); ?>',
                    handler: function(btn){
                        ItemAddForm.getForm().submit({
                            waitMsg: '<?php __('Submitting your data...'); ?>',
                            waitTitle: '<?php __('Wait Please...'); ?>',
                            success: function(f,a){
                                Ext.Msg.show({
                                    title: '<?php __('Success'); ?>',
                                    buttons: Ext.MessageBox.OK,
                                    msg: a.result.msg,
                                    icon: Ext.MessageBox.INFO
                                });
                                ItemAddForm.getForm().reset();
                                RefreshItemData();
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
                        ItemAddForm.getForm().submit({
                            waitMsg: '<?php __('Submitting your data...'); ?>',
                            waitTitle: '<?php __('Wait Please...'); ?>',
                            success: function(f,a){
                                Ext.Msg.show({
                                    title: '<?php __('Success'); ?>',
                                    buttons: Ext.MessageBox.OK,
                                    msg: a.result.msg,
                                    icon: Ext.MessageBox.INFO
                                });
                                ItemAddWindow.close();
                                RefreshItemData();
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
                        ItemAddWindow.close();
                    }
                }]
        });
