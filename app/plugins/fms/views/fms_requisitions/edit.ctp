		<?php
			$this->ExtForm->create('FmsRequisition');
			$this->ExtForm->defineFieldFunctions();
		?>
		var FmsRequisitionEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'fmsRequisitions', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $fms_requisition['FmsRequisition']['id'])); ?>,
				<?php $this->ExtForm->input('name', array('hidden' => $fms_requisition['FmsRequisition']['name'])); ?>,
				<?php $this->ExtForm->input('requested_by', array('hidden' => $fms_requisition['FmsRequisition']['requested_by'])); ?>,
				<?php $this->ExtForm->input('branch_id', array('hidden' => $fms_requisition['FmsRequisition']['branch_id'])); ?>,				
				
				<?php 
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Town', 'anchor' => '80%');
					$options['items'] = array('Addis Ababa' => 'Addis Ababa', 'Out of Addis Ababa' => 'Out of Addis Ababa');
					$options['value'] = $fms_requisition['FmsRequisition']['town'];
					$this->ExtForm->input('town', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $fms_requisition['FmsRequisition']['place'];
					$this->ExtForm->input('place', $options);
				?>,
				<?php 
					$options = array('anchor' => '80%');
					$options['value'] = $fms_requisition['FmsRequisition']['departure_date'];
					$this->ExtForm->input('departure_date', $options);
				?>,
				<?php 
					$options = array('xtype' => 'timefield', 'anchor' => '80%', 'fieldLabel' => 'Departure Time', 'minValue' => '6:00 AM', 'maxValue' => '6:00 PM');
					$options['value'] = $fms_requisition['FmsRequisition']['departure_time'];
					$this->ExtForm->input('departure_time', $options);
				?>,
				<?php 
					$options = array('anchor' => '80%', 'fieldLabel' => 'Return Date');
					$options['value'] = $fms_requisition['FmsRequisition']['arrival_date'];
					$this->ExtForm->input('arrival_date', $options);
				?>,				
				<?php 
					$options = array('xtype' => 'timefield', 'anchor' => '80%', 'fieldLabel' => 'Arrival Time', 'minValue' => '6:00 AM', 'maxValue' => '6:00 PM');
					$options['value'] = $fms_requisition['FmsRequisition']['arrival_time'];
					$this->ExtForm->input('arrival_time', $options);
				?>,
				<?php 
					$options = array(
						'xtype' => 'textarea',
						'grow' => true,
						'fieldLabel' => 'Travelers Full Name',
						'anchor' => '100%'
					);
					$options['value'] = $fms_requisition['FmsRequisition']['travelers'];
					$this->ExtForm->input('travelers', $options);
				?>		]
		});
		
		var FmsRequisitionEditWindow = new Ext.Window({
			title: '<?php __('Edit Fms Requisition'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: FmsRequisitionEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					FmsRequisitionEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Fms Requisition.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(FmsRequisitionEditWindow.collapsed)
						FmsRequisitionEditWindow.expand(true);
					else
						FmsRequisitionEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					FmsRequisitionEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FmsRequisitionEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentFmsRequisitionData();
<?php } else { ?>
							RefreshFmsRequisitionData();
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
					FmsRequisitionEditWindow.close();
				}
			}]
		});
