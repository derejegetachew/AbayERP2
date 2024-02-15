//<script>
    <?php
    $this->ExtForm->create('Position');
    $this->ExtForm->defineFieldFunctions();
    ?>
                    var PositionAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'positions', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
    <?php
    $options = array();
    $this->ExtForm->input('name', $options);
    ?>,
    <?php
    $options = array();
    if (isset($parent_id))
        $options['hidden'] = $parent_id;
    else
        $options['items'] = $grades;
    $this->ExtForm->input('grade_id', $options);
    ?>,
	<?php
    $options = array();
    $this->ExtForm->input('is_managerial', $options);
    ?>,
            <?php 
                $options = array();
                $options = array('xtype' => 'combo', 'anchor' => '100%', 'fieldLabel' => 'Job Classification');
              $options['items'] = array('Managerial'=>'Managerial','Senior Officer'=>'Senior Officer','Officer'=>'Officer','Junior Officer'=>'Junior Officer','Technical'=>'Technical','Non-Clerical'=>'Non-Clerical');
                $this->ExtForm->input('classification', $options);
                ?>,
				<?php 
					$options = array();
					$options = array('xtype' => 'textarea');
					$this->ExtForm->input('requirements', $options);
				?>
                                        ]
                                        });
		
                                        var PositionAddWindow = new Ext.Window({
                                            title: '<?php __('Add Position'); ?>',
                                            width: 400,
                                            minWidth: 400,
                                            autoHeight: true,
                                            layout: 'fit',
                                            modal: true,
                                            resizable: true,
                                            plain:true,
                                            bodyStyle:'padding:5px;',
                                            buttonAlign:'right',
                                            items: PositionAddForm,
                                            tools: [{
                                                    id: 'refresh',
                                                    qtip: 'Reset',
                                                    handler: function () {
                                                        PositionAddForm.getForm().reset();
                                                    },
                                                    scope: this
                                                }, {
                                                    id: 'help',
                                                    qtip: 'Help',
                                                    handler: function () {
                                                        Ext.Msg.show({
                                                            title: 'Help',
                                                            buttons: Ext.MessageBox.OK,
                                                            msg: 'This form is used to insert a new Position.',
                                                            icon: Ext.MessageBox.INFO
                                                        });
                                                    }
                                                }, {
                                                    id: 'toggle',
                                                    qtip: 'Collapse / Expand',
                                                    handler: function () {
                                                        if(PositionAddWindow.collapsed)
                                                            PositionAddWindow.expand(true);
                                                        else
                                                            PositionAddWindow.collapse(true);
                                                    }
                                                }],
                                            buttons: [  {
                                                    text: '<?php __('Save'); ?>',
                                                    handler: function(btn){
                                                        PositionAddForm.getForm().submit({
                                                            waitMsg: '<?php __('Submitting your data...'); ?>',
                                                            waitTitle: '<?php __('Wait Please...'); ?>',
                                                            success: function(f,a){
                                                                Ext.Msg.show({
                                                                    title: '<?php __('Success'); ?>',
                                                                    buttons: Ext.MessageBox.OK,
                                                                    msg: a.result.msg,
                                                                    icon: Ext.MessageBox.INFO
                                                                });
                                                                PositionAddForm.getForm().reset();
    <?php if (isset($parent_id)) { ?>
                                    RefreshParentPositionData();
    <?php } else { ?>
                                    RefreshPositionData();
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
                        PositionAddForm.getForm().submit({
                            waitMsg: '<?php __('Submitting your data...'); ?>',
                            waitTitle: '<?php __('Wait Please...'); ?>',
                            success: function(f,a){
                                Ext.Msg.show({
                                    title: '<?php __('Success'); ?>',
                                    buttons: Ext.MessageBox.OK,
                                    msg: a.result.msg,
                                    icon: Ext.MessageBox.INFO
                                });
                                PositionAddWindow.close();
    <?php if (isset($parent_id)) { ?>
                                    RefreshParentPositionData();
    <?php } else { ?>
                                    RefreshPositionData();
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
                        PositionAddWindow.close();
                    }
                }]
        });
