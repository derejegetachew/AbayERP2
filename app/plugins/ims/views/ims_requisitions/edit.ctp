		<?php
			$this->ExtForm->create('ImsRequisition');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ImsRequisitionEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'imsRequisitions', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $ims_requisition['ImsRequisition']['id'])); ?>,
				<?php 
					$options = array('fieldLabel' => 'Ref Number','readOnly' => 'true');
					$options['value'] = $ims_requisition['ImsRequisition']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array(
						'xtype' => 'textarea',
						'grow' => true,
						'fieldLabel' => 'Purpose',
						'anchor' => '100%'
					);
					$options['value'] = $ims_requisition['ImsRequisition']['purpose'];
					$this->ExtForm->input('purpose', $options);
				?>			
				
							]
		});
		
		var ImsRequisitionEditWindow = new Ext.Window({
			title: '<?php __('Edit Ims Requisition'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ImsRequisitionEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ImsRequisitionEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ims Requisition.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ImsRequisitionEditWindow.collapsed)
						ImsRequisitionEditWindow.expand(true);
					else
						ImsRequisitionEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ImsRequisitionEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ImsRequisitionEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsRequisitionData();
<?php } else { ?>
							RefreshImsRequisitionData();
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
					ImsRequisitionEditWindow.close();
				}
			}]
		});
