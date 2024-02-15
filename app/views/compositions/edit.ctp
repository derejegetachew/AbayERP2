		<?php
			$this->ExtForm->create('Composition');
			$this->ExtForm->defineFieldFunctions();
		?>
		var CompositionEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'compositions', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $composition['Composition']['id'])); ?>,
				<?php 
					$options = array();
					$options['items'] = $positions;
					$options['value'] = $composition['Composition']['position_id'];
					$options['fieldLabel']="Job Title";
					$this->ExtForm->input('position_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $branches;
					$options['value'] = $composition['Composition']['branch_id'];
					$this->ExtForm->input('branch_id', $options);
				?>,
				{
					xtype: 'numberfield',
					fieldLabel: 'Number of Positions',
					name: 'data[Composition][count]',
					anchor: '100%',
					value: '<?php echo $composition['Composition']['count'] ?>',
					minValue:0,
					allowNegative:false,
					allowBlank:false,
					validator() {
						value = this.getValue();
						if (value > 0) {
							return true;
						}
						return 'Not valid';
					}
				}		]
		});
		
		var CompositionEditWindow = new Ext.Window({
			title: '<?php __('Edit - Position'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: CompositionEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					CompositionEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Composition.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(CompositionEditWindow.collapsed)
						CompositionEditWindow.expand(true);
					else
						CompositionEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					CompositionEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							CompositionEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentCompositionData();
<?php } else { ?>
							RefreshCompositionData();
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
					CompositionEditWindow.close();
				}
			}]
		});
