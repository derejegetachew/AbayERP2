 		<?php
			$this->ExtForm->create('DmsAttachment');
			$this->ExtForm->defineFieldFunctions();
		?>
		var DmsAttachmentAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'dmsAttachments', 'action' => 'add')); ?>',
			defaultType: 'textfield',
			fileUpload: true,
			
			items: [
				{
					xtype: 'fileuploadfield',
					id: 'form-file',
					emptyText: 'Select File',
					fieldLabel: 'File',
					name: 'data[DmsAttachment][file]',
					buttonText: 'Browse',
					anchor:'100%',
					multiple: true
				},
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					/*else
						$options['items'] = $dms_messages;*/
					$this->ExtForm->input('dms_message_id', $options);
				?>			]
		});
		
		var DmsAttachmentAddWindow = new Ext.Window({
			title: '<?php __('Upload Attachment'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: DmsAttachmentAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					DmsAttachmentAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Dms Attachment.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(DmsAttachmentAddWindow.collapsed)
						DmsAttachmentAddWindow.expand(true);
					else
						DmsAttachmentAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Upload'); ?>',
				handler: function(btn){
					DmsAttachmentAddForm.getForm().submit({
						waitMsg: '<?php __('Uploading your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							DmsAttachmentAddWindow.close();
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
					DmsAttachmentAddWindow.close();
				}
			}]
		});
