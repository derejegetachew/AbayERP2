//<script>
    <?php
        $this->ExtForm->create('ImsItem');
        $this->ExtForm->defineFieldFunctions();
    ?>
        var ItemEditForm = new Ext.form.FormPanel({
            baseCls: 'x-plain',
            labelWidth: 100,
            labelAlign: 'right',
            url:'<?php echo $this->Html->url(array('controller' => 'ims_items', 'action' => 'edit')); ?>',
            defaultType: 'textfield',

            items: [
                <?php $this->ExtForm->input('id', array('hidden' => $item['ImsItem']['id'])); ?>,
                <?php
                    $options_name = array();
                    $options_name['value'] = $item['ImsItem']['name'];
                    $this->ExtForm->input('name', $options_name);
                ?>,
                <?php
                    $options_description = array('fieldLabel' => "Code");
                    $options_description['value'] = $item['ImsItem']['description'];
                    $this->ExtForm->input('description', $options_description);
                ?>,
                <?php
                    $options_item_category_id = array('fieldLabel' => "Item Category");
                    if (isset($parent_id))
                        $options_item_category_id['hidden'] = $parent_id;
                    else
                        $options_item_category_id['items'] = $item_categories;
						
                    $options_item_category_id['value'] = $item['ImsItem']['ims_item_category_id'];
                    $this->ExtForm->input('ims_item_category_id', $options_item_category_id);
                ?>,
                <?php
                    $options_max_level = array('anchor'=>'65%');
                    $options_max_level['value'] = $item['ImsItem']['max_level'];
                    $this->ExtForm->input('max_level', $options_max_level);
                ?>,
                <?php
                    $options_min_level = array('anchor'=>'65%');
                    $options_min_level['value'] = $item['ImsItem']['min_level'];
                    $this->ExtForm->input('min_level', $options_min_level);
                ?>,
				<?php 
					$options = array();
					$options['value'] = $item['ImsItem']['booked'];
					$this->ExtForm->input('booked', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $item['ImsItem']['fixed_asset'];
					$this->ExtForm->input('fixed_asset', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $item['ImsItem']['tag_code'];
					$this->ExtForm->input('tag_code', $options);
				?>
            ]
        });
		
        var ItemEditWindow = new Ext.Window({
            title: '<?php __('Edit Item'); ?>',
            width: 400,
            minWidth: 400,
            autoHeight: true,
            layout: 'fit',
            modal: true,
            resizable: true,
            plain:true,
            bodyStyle:'padding:5px;',
            buttonAlign:'right',
            items: ItemEditForm,
            tools: [{
                    id: 'refresh',
                    qtip: 'Reset',
                    handler: function () {
                        ItemEditForm.getForm().reset();
                    },
                    scope: this
                }, {
                    id: 'help',
                    qtip: 'Help',
                    handler: function () {
                        Ext.Msg.show({
                            title: 'Help',
                            buttons: Ext.MessageBox.OK,
                            msg: 'This form is used to modify an existing Item.',
                            icon: Ext.MessageBox.INFO
                        });
                    }
                }, {
                    id: 'toggle',
                    qtip: 'Collapse / Expand',
                    handler: function () {
                        if(ItemEditWindow.collapsed)
                            ItemEditWindow.expand(true);
                        else
                            ItemEditWindow.collapse(true);
                    }
                }
            ],
            buttons: [ {
                    text: '<?php __('Save'); ?>',
                    handler: function(btn){
                        ItemEditForm.getForm().submit({
                            waitMsg: '<?php __('Submitting your data...'); ?>',
                            waitTitle: '<?php __('Wait Please...'); ?>',
                            success: function(f,a){
                                Ext.Msg.show({
                                    title: '<?php __('Success'); ?>',
                                    buttons: Ext.MessageBox.OK,
                                    msg: a.result.msg,
                                    icon: Ext.MessageBox.INFO
                                });
                                ItemEditWindow.close();
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
                        ItemEditWindow.close();
                    }
                }]
        });
