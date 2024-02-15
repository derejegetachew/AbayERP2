		<?php
			$this->ExtForm->create('FmsMaintenance');
			$this->ExtForm->defineFieldFunctions();
		?>
		var FmsMaintenanceAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'fmsMaintenances', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [				
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
					hiddenName:'data[FmsMaintenance][fms_vehicle_id]',
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
					$options = array('fieldLabel' => 'የዕቃው አይነት');
					$this->ExtForm->input('item', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'መለያ ቁጥር');
					$this->ExtForm->input('serial', $options);
				?>,
				<?php 
					$options = array('xtype' => 'combo', 'fieldLabel' => 'መለኪያ', 'anchor' => '60%');
					$options['items'] = array('None' => 'None', 'Pcs' => 'Pcs', 'Litter' => 'Litter', 'Pkt' => 'Pkt', 'Pad' => 'Pad', 'Kg' => 'Kg',
					'Roll' => 'Roll','Ream' => 'Ream','m<sup>2</sup>' => 'm<sup>2</sup>','M' => 'M','Set' => 'Set','Hr' => 'Hr');
					$this->ExtForm->input('measurement', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'ብዛት');
					$this->ExtForm->input('quantity', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'የ አንዱ ዋጋ', 'vtype' => 'Decimal1');
					$options['maskRe'] = '/[0-9.]/i';
					$this->ExtForm->input('unit_price', $options);
				?>		]
		});
		
		var FmsMaintenanceAddWindow = new Ext.Window({
			title: '<?php __('Add Maintenance'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: FmsMaintenanceAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					FmsMaintenanceAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Fms Maintenance.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(FmsMaintenanceAddWindow.collapsed)
						FmsMaintenanceAddWindow.expand(true);
					else
						FmsMaintenanceAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					FmsMaintenanceAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FmsMaintenanceAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentFmsMaintenanceData();
<?php } else { ?>
							RefreshFmsMaintenanceData();
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
					FmsMaintenanceAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FmsMaintenanceAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentFmsMaintenanceData();
<?php } else { ?>
							RefreshFmsMaintenanceData();
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
					FmsMaintenanceAddWindow.close();
				}
			}]
		});
