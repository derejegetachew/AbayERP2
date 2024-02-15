		<?php
			$this->ExtForm->create('FmsDrivertovehicleAssignment');
			$this->ExtForm->defineFieldFunctions();
		?>
		var FmsDrivertovehicleAssignmentAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'fmsDrivertovehicleAssignments', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				{
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							<?php $st = false;foreach ($fms_drivers as $item){if($st) echo ",
							";?>['<?php echo $item['FmsDriver']['id']; ?>' ,'<?php echo $item['Person']['first_name'].' '.$item['Person']['middle_name'].' '.$item['Person']['last_name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					hiddenName:'data[FmsDrivertovehicleAssignment][fms_driver_id]',
					id: 'driver',
					name: 'driver',
					mode : 'local',
					triggerAction: 'all',
					emptyText: 'Select Driver',
					selectOnFocus:false,
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> የአሽከርካሪው ስም',
					allowBlank: false,
					editable: false,
					lazyRender: true,
					blankText: 'Your input is invalid.',
					disableKeyFilter: true,
					forceSelection:true,
					anyMatch : false,
				},
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
					hiddenName:'data[FmsDrivertovehicleAssignment][fms_vehicle_id]',
					id: 'vehicle',
					name: 'vehicle',
					mode : 'local',
					triggerAction: 'all',
					emptyText: 'Select Vehicle',
					selectOnFocus:false,
					anchor: '100%',
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
					$options = array('fieldLabel' => 'የተመደበበት ቀን');
					$this->ExtForm->input('start_date', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'ያበቃበት ቀን');
					$this->ExtForm->input('end_date', $options);
				?>		]
		});
		
		var FmsDrivertovehicleAssignmentAddWindow = new Ext.Window({
			title: '<?php __('Add Driver to vehicle Assignment'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: FmsDrivertovehicleAssignmentAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					FmsDrivertovehicleAssignmentAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Fms Drivertovehicle Assignment.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(FmsDrivertovehicleAssignmentAddWindow.collapsed)
						FmsDrivertovehicleAssignmentAddWindow.expand(true);
					else
						FmsDrivertovehicleAssignmentAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					FmsDrivertovehicleAssignmentAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FmsDrivertovehicleAssignmentAddForm.getForm().reset();
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
			}, {
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
					FmsDrivertovehicleAssignmentAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FmsDrivertovehicleAssignmentAddWindow.close();
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
					FmsDrivertovehicleAssignmentAddWindow.close();
				}
			}]
		});
