		<?php
			$this->ExtForm->create('CmsAttachment');
			$this->ExtForm->defineFieldFunctions();
		?>
		var CmsAttachmentAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'cmsAttachments', 'action' => 'add')); ?>',
			defaultType: 'textfield',
			fileUpload: true,
			
			items: [
				{
					xtype: 'fileuploadfield',
					id: 'form-file',
					emptyText: 'Select File',
					fieldLabel: 'File',
					name: 'data[CmsAttachment][file]',
					buttonText: '',
					anchor:'100%',
					buttonCfg: {
						iconCls: 'upload-icon'
					}
				},
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $cms_replies;
					$this->ExtForm->input('cms_reply_id', $options);
				?>			]
		});
		
		var CmsAttachmentAddWindow = new Ext.Window({
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
			items: CmsAttachmentAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					CmsAttachmentAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Cms Attachment.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(CmsAttachmentAddWindow.collapsed)
						CmsAttachmentAddWindow.expand(true);
					else
						CmsAttachmentAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Upload'); ?>',
				handler: function(btn){
					CmsAttachmentAddForm.getForm().submit({
						waitMsg: '<?php __('Uploading your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							CmsAttachmentAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentCmsAttachmentData();
<?php } else { ?>
							RefreshCmsAttachmentData();
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
					CmsAttachmentAddWindow.close();
				}
			}]
		});
