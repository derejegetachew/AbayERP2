		<?php
			$this->ExtForm->create('Field');
			$this->ExtForm->defineFieldFunctions();
		?>
		var FieldEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'fields', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $field['Field']['id'])); ?>,
				<?php 
					$options = array();
                                                       $options = array(
                                    'xtype' => 'textarea',
                                    'height' => 370,
                                    'anchor' => '99%',
                                    'fieldLabel' => 'Choices',
                                    'enableFont' => true,
                                    'enableFontSize' => true,
                                                'id'=>'data[Field][Choices]'
                                );
                                        $field['Field']['choices'] = addslashes($field['Field']['choices']);
                                        $field['Field']['choices'] = str_replace(array("\n","\r"),array("\\n","\\r"),$field['Field']['choices']);               
					$options['value'] = $field['Field']['choices'];
					$this->ExtForm->input('choices', $options);
				?>			]
		});
		
		var FieldEditWindow = new Ext.Window({
			title: '<?php __('Edit Field'); ?>',
			width: 640,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: FieldEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					FieldEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Field.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(FieldEditWindow.collapsed)
						FieldEditWindow.expand(true);
					else
						FieldEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					FieldEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FieldEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentFieldData();
<?php } else { ?>
							RefreshFieldData();
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
					FieldEditWindow.close();
				}
			}]
		});
