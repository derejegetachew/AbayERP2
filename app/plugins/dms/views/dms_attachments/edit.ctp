		<?php
			$this->ExtForm->create('DmsAttachment');
			$this->ExtForm->defineFieldFunctions();
		?>
		var DmsAttachmentEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'dmsAttachments', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $dms_attachment['DmsAttachment']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $dms_attachment['DmsAttachment']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $dms_attachment['DmsAttachment']['file'];
					$this->ExtForm->input('file', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $dms_messages;
					$options['value'] = $dms_attachment['DmsAttachment']['dms_message_id'];
					$this->ExtForm->input('dms_message_id', $options);
				?>			]
		});
		
		var DmsAttachmentEditWindow = new Ext.Window({
			title: '<?php __('Edit Dms Attachment'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: DmsAttachmentEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					DmsAttachmentEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Dms Attachment.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(DmsAttachmentEditWindow.collapsed)
						DmsAttachmentEditWindow.expand(true);
					else
						DmsAttachmentEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					DmsAttachmentEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							DmsAttachmentEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentDmsAttachmentData();
<?php } else { ?>
							RefreshDmsAttachmentData();
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
					DmsAttachmentEditWindow.close();
				}
			}]
		});
