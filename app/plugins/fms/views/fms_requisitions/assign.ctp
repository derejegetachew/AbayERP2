		<?php
			$this->ExtForm->create('FmsRequisition');
			$this->ExtForm->defineFieldFunctions();
		?>
		var FmsRequisitionAssignForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'fmsRequisitions', 'action' => 'assign')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $fms_requisition['FmsRequisition']['id'])); ?>,
				<?php $this->ExtForm->input('name', array('hidden' => $fms_requisition['FmsRequisition']['name'])); ?>,
				<?php $this->ExtForm->input('requested_by', array('hidden' => $fms_requisition['FmsRequisition']['requested_by'])); ?>,
				<?php $this->ExtForm->input('branch_id', array('hidden' => $fms_requisition['FmsRequisition']['branch_id'])); ?>,
				<?php $this->ExtForm->input('town', array('hidden' => $fms_requisition['FmsRequisition']['town'])); ?>,
				<?php $this->ExtForm->input('place', array('hidden' => $fms_requisition['FmsRequisition']['place'])); ?>,
				<?php $this->ExtForm->input('travelers', array('hidden' => $fms_requisition['FmsRequisition']['travelers'])); ?>,
				<?php 
					$options = array('anchor' => '80%', 'fieldLabel' => 'አገልግሎቱ የሚፈለግበት ቀን', 'readOnly' => 'true');
					$options['value'] = $fms_requisition['FmsRequisition']['arrival_date'];
					$this->ExtForm->input('arrival_date', $options);
				?>,
				<?php 
					$options = array('anchor' => '80%', 'fieldLabel' => 'መመለሻ ቀን', 'readOnly' => 'true');
					$options['value'] = $fms_requisition['FmsRequisition']['departure_date'];
					$this->ExtForm->input('departure_date', $options);
				?>,
				<?php 
					$options = array('anchor' => '80%', 'fieldLabel' => 'መነሻ ሰዓት', 'readOnly' => 'true');
					$options['value'] = $fms_requisition['FmsRequisition']['departure_time'];
					$this->ExtForm->input('departure_time', $options);
				?>,
				<?php 
					$options = array('anchor' => '80%', 'fieldLabel' => 'መመለሻ ሰዓት', 'readOnly' => 'true');
					$options['value'] = $fms_requisition['FmsRequisition']['arrival_time'];
					$this->ExtForm->input('arrival_time', $options);
				?>,
				
				{
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							<?php $st = false;foreach ($fms_vehicles as $item){if($st) echo ",
							";?>['<?php echo $item['FmsVehicle']['id']; ?>' ,'<?php echo $item['FmsVehicle']['plate_no']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					hiddenName:'data[FmsRequisition][fms_vehicle_id]',
					value:'<?php echo $fms_requisition['FmsRequisition']['fms_vehicle_id'];?>',
					id: 'vehicle',
					name: 'vehicle',
					mode : 'local',
					triggerAction: 'all',
					emptyText: 'Select Vehicle',
					selectOnFocus:false,
					anchor: '80%',
					fieldLabel: '<span style="color:red;">*</span> ተሽከርካሪ',
					allowBlank: false,
					editable: false,
					lazyRender: true,
					blankText: 'Your input is invalid.',
					disableKeyFilter: true,
					forceSelection:true,
					anyMatch : false,
				},
				
				<?php 
					$options = array('anchor' => '80%', 'fieldLabel' => 'ሲነሳ የነበረው ኪሎ ሜትር');
					$options['value'] = $fms_requisition['FmsRequisition']['start_odometer'];
					$this->ExtForm->input('start_odometer', $options);
				?>,
				
				<?php 
					$options = array('anchor' => '80%', 'fieldLabel' => 'ሲመለስ የነበረው ኪሎ ሜትር');
					$options['value'] = $fms_requisition['FmsRequisition']['end_odometer'];
					$this->ExtForm->input('end_odometer', $options);
				?>
					]
		});
		
		var FmsRequisitionEditWindow = new Ext.Window({
			title: '<?php __('Assign Requisition'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: FmsRequisitionAssignForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					FmsRequisitionAssignForm.getForm().reset();
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
					FmsRequisitionAssignForm.getForm().submit({
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
