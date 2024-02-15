		<?php
			$this->ExtForm->create('Trainingtarget');
			$this->ExtForm->defineFieldFunctions();
		?>
		var TrainingtargetEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'trainingtargets', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $trainingtarget['Trainingtarget']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $trainingtarget['Trainingtarget']['name'];
					$this->ExtForm->input('name', $options);
				?>			]
		});
		
		var TrainingtargetEditWindow = new Ext.Window({
			title: '<?php __('Edit Trainingtarget'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: TrainingtargetEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					TrainingtargetEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Trainingtarget.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(TrainingtargetEditWindow.collapsed)
						TrainingtargetEditWindow.expand(true);
					else
						TrainingtargetEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					TrainingtargetEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							TrainingtargetEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentTrainingtargetData();
<?php } else { ?>
							RefreshTrainingtargetData();
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
					TrainingtargetEditWindow.close();
				}
			}]
		});
