		<?php
			$this->ExtForm->create('CmsReply');
			$this->ExtForm->defineFieldFunctions();
		?>
		var CmsReplyAddForm1 = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'cmsReplies', 'action' => 'add_1')); ?>',
			defaultType: 'textfield',

			items: [				
				<?php 
					$options = array(
						'xtype' => 'textarea',
						'grow' => false,
						'fieldLabel' => 'Message',
						'anchor' => '100%'
						);
					$this->ExtForm->input('content', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $cms_cases;
					$this->ExtForm->input('cms_case_id', $options);
				?>		]
		});
		
		var CmsReplyAddWindow1 = new Ext.Window({
			title: '<?php __('Reply'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: CmsReplyAddForm1,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					CmsReplyAddForm1.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Cms Reply.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(CmsReplyAddWindow1.collapsed)
						CmsReplyAddWindow1.expand(true);
					else
						CmsReplyAddWindow1.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Add Attachments'); ?>',
				handler: function(btn){
					CmsReplyAddForm1.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
						    CmsReplyAddWindow1.close();
							ViewParentAttachments(a.result.msg);
						
							CmsReplyAddForm1.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshCmsReplyData();
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
			}, {
				text: '<?php __('Reply & Close'); ?>',
				handler: function(btn){
					CmsReplyAddForm1.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: 'Reply Saved',
                                icon: Ext.MessageBox.INFO
							});
							CmsReplyAddWindow1.close();
<?php if(isset($parent_id)){ ?>
							RefreshCmsCaseData();
							RefreshCmsReplyData();
<?php } else { ?>
							RefreshCmsCaseData();
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
					CmsReplyAddWindow1.close();
				}
			}]
		});
