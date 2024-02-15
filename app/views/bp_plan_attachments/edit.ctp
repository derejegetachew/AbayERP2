		<?php
			$this->ExtForm->create('BpPlanAttachment');
			$this->ExtForm->defineFieldFunctions();
		?>
		var BpPlanAttachmentEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'bpPlanAttachments', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $bp_plan_attachment['BpPlanAttachment']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $plans;
					$options['value'] = $bp_plan_attachment['BpPlanAttachment']['plan_id'];
					$this->ExtForm->input('plan_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $bp_plan_attachment['BpPlanAttachment']['file_name'];
					$this->ExtForm->input('file_name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $bp_plan_attachment['BpPlanAttachment']['path'];
					$this->ExtForm->input('path', $options);
				?>			]
		});
		
		var BpPlanAttachmentEditWindow = new Ext.Window({
			title: '<?php __('Edit Bp Plan Attachment'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: BpPlanAttachmentEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					BpPlanAttachmentEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Bp Plan Attachment.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(BpPlanAttachmentEditWindow.collapsed)
						BpPlanAttachmentEditWindow.expand(true);
					else
						BpPlanAttachmentEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					BpPlanAttachmentEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BpPlanAttachmentEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentBpPlanAttachmentData();
<?php } else { ?>
							RefreshBpPlanAttachmentData();
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
					BpPlanAttachmentEditWindow.close();
				}
			}]
		});
