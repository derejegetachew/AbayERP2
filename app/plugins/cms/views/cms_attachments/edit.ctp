		<?php
			$this->ExtForm->create('CmsAttachment');
			$this->ExtForm->defineFieldFunctions();
		?>
		var CmsAttachmentEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'cmsAttachments', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $cms_attachment['CmsAttachment']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $cms_attachment['CmsAttachment']['file'];
					$this->ExtForm->input('file', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $cms_attachment['CmsAttachment']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $cms_replies;
					$options['value'] = $cms_attachment['CmsAttachment']['cms_reply_id'];
					$this->ExtForm->input('cms_reply_id', $options);
				?>			]
		});
		
		var CmsAttachmentEditWindow = new Ext.Window({
			title: '<?php __('Edit Cms Attachment'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: CmsAttachmentEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					CmsAttachmentEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Cms Attachment.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(CmsAttachmentEditWindow.collapsed)
						CmsAttachmentEditWindow.expand(true);
					else
						CmsAttachmentEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					CmsAttachmentEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							CmsAttachmentEditWindow.close();
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
					CmsAttachmentEditWindow.close();
				}
			}]
		});
