		<?php
			$this->ExtForm->create('FmsDrivertovehicleAssignment');
			$this->ExtForm->defineFieldFunctions();
		?>
		var FmsDrivertovehicleAssignmentEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'fmsDrivertovehicleAssignments', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $fms_drivertovehicle_assignment['FmsDrivertovehicleAssignment']['id'])); ?>,
				<?php $this->ExtForm->input('fms_driver_id', array('hidden' => $fms_drivertovehicle_assignment['FmsDrivertovehicleAssignment']['fms_driver_id'])); ?>,
				<?php $this->ExtForm->input('fms_vehicle_id', array('hidden' => $fms_drivertovehicle_assignment['FmsDrivertovehicleAssignment']['fms_vehicle_id'])); ?>,
				{
					xtype: 'combo',					
					id: 'driver',
					name: 'driver',
					triggerAction: 'all',
					value: '<?php echo $fms_drivertovehicle_assignment['FmsDriver']['Person']['first_name'].' '.$fms_drivertovehicle_assignment['FmsDriver']['Person']['middle_name']?>',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Driver',
					editable: false,
				},
				{
					xtype: 'combo',									
					id: 'vehicle',
					name: 'vehicle',
					triggerAction: 'all',
					value: '<?php echo $fms_drivertovehicle_assignment['FmsVehicle']['plate_no']?>',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Vehicle',
					editable: false,
				},
				<?php 
					$options = array('readOnly' => true);
					$options['value'] = $fms_drivertovehicle_assignment['FmsDrivertovehicleAssignment']['start_date'];
					$this->ExtForm->input('start_date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $fms_drivertovehicle_assignment['FmsDrivertovehicleAssignment']['end_date'];
					$this->ExtForm->input('end_date', $options);
				?>		]
		});
		
		var FmsDrivertovehicleAssignmentEditWindow = new Ext.Window({
			title: '<?php __('Edit Driver to vehicle Assignment'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: FmsDrivertovehicleAssignmentEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					FmsDrivertovehicleAssignmentEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Fms Drivertovehicle Assignment.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(FmsDrivertovehicleAssignmentEditWindow.collapsed)
						FmsDrivertovehicleAssignmentEditWindow.expand(true);
					else
						FmsDrivertovehicleAssignmentEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					FmsDrivertovehicleAssignmentEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FmsDrivertovehicleAssignmentEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentFmsDrivertovehicleAssignmentData();
<?php } else { ?>
							RefreshFmsDrivertovehicleAssignmentData();
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
					FmsDrivertovehicleAssignmentEditWindow.close();
				}
			}]
		});
