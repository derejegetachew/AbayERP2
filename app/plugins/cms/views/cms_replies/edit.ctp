		<?php
			$this->ExtForm->create('CmsReply');
			$this->ExtForm->defineFieldFunctions();
		?>
		var CmsReplyEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'cmsReplies', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $cms_reply['CmsReply']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $cms_reply['CmsReply']['content'];
					$this->ExtForm->input('content', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $cms_cases;
					$options['value'] = $cms_reply['CmsReply']['cms_case_id'];
					$this->ExtForm->input('cms_case_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $users;
					$options['value'] = $cms_reply['CmsReply']['user_id'];
					$this->ExtForm->input('user_id', $options);
				?>			]
		});
		
		var CmsReplyEditWindow = new Ext.Window({
			title: '<?php __('Edit Cms Reply'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: CmsReplyEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					CmsReplyEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Cms Reply.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(CmsReplyEditWindow.collapsed)
						CmsReplyEditWindow.expand(true);
					else
						CmsReplyEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					CmsReplyEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							CmsReplyEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentCmsReplyData();
<?php } else { ?>
							RefreshCmsReplyData();
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
					CmsReplyEditWindow.close();
				}
			}]
		});
