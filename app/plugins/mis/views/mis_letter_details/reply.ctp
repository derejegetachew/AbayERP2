		<?php
			$this->ExtForm->create('MisLetterDetail');
			$this->ExtForm->defineFieldFunctions();
		?>
		var MisLetterDetailReplyForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'misLetterDetails', 'action' => 'reply')); ?>',
			defaultType: 'textfield',
			fileUpload: true,

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $mis_letter_detail['MisLetterDetail']['id'])); ?>,
				<?php $this->ExtForm->input('status', array('hidden' => $mis_letter_detail['MisLetterDetail']['status'])); ?>,
				<?php $this->ExtForm->input('mis_letter_id', array('hidden' => $mis_letter_detail['MisLetterDetail']['mis_letter_id'])); ?>,
				
				<?php 
					$options = array(
						'xtype' => 'textarea',
						'grow' => true,
						'fieldLabel' => 'Remark',
						'anchor' => '100%'
					);
					$options['value'] = $mis_letter_detail['MisLetterDetail']['remark'];
					$this->ExtForm->input('remark', $options);
				?>,
				{
					xtype: 'fileuploadfield',
					id: 'form-file',
					emptyText: 'Select File',
					fieldLabel: 'File',
					name: 'data[MisLetterDetail][file]',
					buttonText: 'Browse',
					anchor:'100%',
					multiple: true,
					allowBlank: true,
					value: '<?php echo $mis_letter_detail['MisLetterDetail']['file']; ?>'
				}			]
		});
		
		var MisLetterDetailReplyWindow = new Ext.Window({
			title: '<?php __('Reply Mis Letter Detail'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: MisLetterDetailReplyForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					MisLetterDetailReplyForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Mis Letter Detail.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(MisLetterDetailReplyWindow.collapsed)
						MisLetterDetailReplyWindow.expand(true);
					else
						MisLetterDetailReplyWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					MisLetterDetailReplyForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							MisLetterDetailReplyWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentMisLetterDetailData();
<?php } else { ?>
							RefreshMisLetterDetailData();
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
					MisLetterDetailReplyWindow.close();
				}
			}]
		});
