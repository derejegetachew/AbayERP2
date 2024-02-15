		<?php
			$this->ExtForm->create('FmsFuel');
			$this->ExtForm->defineFieldFunctions();
		?>
		var FmsFuelAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'fmsFuels', 'action' => 'add')); ?>',
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
					hiddenName:'data[FmsFuel][fms_vehicle_id]',
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
					$options = array('fieldLabel' => 'ነዳጅ የተቀዳበት ቀን', 'anchor' => '80%');
					$this->ExtForm->input('fueled_day', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'ነዳጅ በሊትር', 'anchor' => '60%', 'vtype' => 'Decimal1');
					$options['maskRe'] = '/[0-9.]/i';
					$this->ExtForm->input('litre', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'የ 1 ሊትር ዋጋ (በብር)', 'anchor' => '60%', 'vtype' => 'Decimal1');
					$options['maskRe'] = '/[0-9.]/i';
					$this->ExtForm->input('price', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'ኪሎሜትር', 'anchor' => '60%');
					$options['maskRe'] = '/[0-9.]/i';
					$this->ExtForm->input('kilometer', $options);
				?>,
				{
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							<?php $st = false;foreach ($fms_drivers as $item){if($st) echo ",
							";?>['<?php echo $item['Person']['first_name'].' '.$item['Person']['middle_name'].' '.$item['Person']['last_name']; ?>' ,'<?php echo $item['Person']['first_name'].' '.$item['Person']['middle_name'].' '.$item['Person']['last_name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					hiddenName:'data[FmsFuel][driver]',
					id: 'driver',
					name: 'driver',
					mode : 'local',
					triggerAction: 'all',
					emptyText: 'Select Driver',
					selectOnFocus:false,
					anchor: '80%',
					fieldLabel: '<span style="color:red;">*</span> የአሽከርካሪው ስም',
					allowBlank: false,
					editable: false,
					lazyRender: true,
					blankText: 'Your input is invalid.',
					disableKeyFilter: true,
					forceSelection:true,
					anyMatch : false,
				},
				
				<?php 
					$options = array('fieldLabel' => 'የኩፖን ዙር', 'anchor' => '60%');
					$this->ExtForm->input('round', $options);
				?>  ]
		});
		
		var FmsFuelAddWindow = new Ext.Window({
			title: '<?php __('Add Fuel'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: FmsFuelAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					FmsFuelAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Fuel.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(FmsFuelAddWindow.collapsed)
						FmsFuelAddWindow.expand(true);
					else
						FmsFuelAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					FmsFuelAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FmsFuelAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentFmsFuelData();
<?php } else { ?>
							RefreshFmsFuelData();
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
					FmsFuelAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FmsFuelAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentFmsFuelData();
<?php } else { ?>
							RefreshFmsFuelData();
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
					FmsFuelAddWindow.close();
				}
			}]
		});
