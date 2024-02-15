		<?php
			$this->ExtForm->create('ImsMaintenanceRequest');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ImsMaintenanceRequestEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'imsMaintenanceRequests', 'action' => 'edit_1')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $ims_maintenance_request['ImsMaintenanceRequest']['id'])); ?>,				
				
				<?php 
					$options = array(
						'xtype' => 'textarea',
						'grow' => true,
						'fieldLabel' => 'Technician Recommendation',
						'anchor' => '100%',
						'allowBlank' => false
					);
					$options['value'] = $ims_maintenance_request['ImsMaintenanceRequest']['technician_recommendation'];
					$this->ExtForm->input('technician_recommendation', $options);
				?>,
				<?php 
					$options = array(
						'xtype' => 'textarea',
						'grow' => true,
						'fieldLabel' => 'Remark',
						'anchor' => '100%'
					);
					$options['value'] = $ims_maintenance_request['ImsMaintenanceRequest']['remark'];
					$this->ExtForm->input('remark', $options);
				?>		]
		});
		
		var ImsMaintenanceRequestEditWindow = new Ext.Window({
			title: '<?php __('Recommendation'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ImsMaintenanceRequestEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ImsMaintenanceRequestEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ims Maintenance Request.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ImsMaintenanceRequestEditWindow.collapsed)
						ImsMaintenanceRequestEditWindow.expand(true);
					else
						ImsMaintenanceRequestEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ImsMaintenanceRequestEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ImsMaintenanceRequestEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsMaintenanceRequestData();
<?php } else { ?>
							RefreshImsMaintenanceRequestData();
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
					ImsMaintenanceRequestEditWindow.close();
				}
			}]
		});
