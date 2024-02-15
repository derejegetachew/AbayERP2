		<?php
			$this->ExtForm->create('ImsSirvBefore');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ImsSirvBeforeEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'imsSirvBefores', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $ims_sirv_before['ImsSirvBefore']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $ims_sirv_before['ImsSirvBefore']['created'];
					$this->ExtForm->input('created', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ims_sirv_before['ImsSirvBefore']['modified'];
					$this->ExtForm->input('modified', $options);
				?>
				/*<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $branches;
					$options['value'] = $ims_sirv_before['ImsSirvBefore']['branch_id'];
					$this->ExtForm->input('branch_id', $options);
				?>	*/		]
		});
		
		var ImsSirvBeforeEditWindow = new Ext.Window({
			title: '<?php __('Edit Ims Sirv Before'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ImsSirvBeforeEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ImsSirvBeforeEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ims Sirv Before.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ImsSirvBeforeEditWindow.collapsed)
						ImsSirvBeforeEditWindow.expand(true);
					else
						ImsSirvBeforeEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ImsSirvBeforeEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ImsSirvBeforeEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsSirvBeforeData();
<?php } else { ?>
							RefreshImsSirvBeforeData();
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
					ImsSirvBeforeEditWindow.close();
				}
			}]
		});
