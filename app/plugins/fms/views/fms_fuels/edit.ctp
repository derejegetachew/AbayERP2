		<?php
			$this->ExtForm->create('FmsFuel');
			$this->ExtForm->defineFieldFunctions();
		?>
		var FmsFuelEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'fmsFuels', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $fms_fuel['FmsFuel']['id'])); ?>,
				
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
					value:'<?php echo $fms_fuel['FmsFuel']['fms_vehicle_id'];?>',
					blankText: 'Your input is invalid.',
					disableKeyFilter: true,
					forceSelection:true,
					anyMatch : false,
				},
				<?php 
					$options = array('fieldLabel' => 'ነዳጅ የተቀዳበት ቀን', 'anchor' => '80%');
					$options['value'] = $fms_fuel['FmsFuel']['fueled_day'];
					$this->ExtForm->input('fueled_day', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'ነዳጅ በሊትር', 'anchor' => '60%', 'vtype' => 'Decimal1');
					$options['maskRe'] = '/[0-9.]/i';
					$options['value'] = $fms_fuel['FmsFuel']['litre'];
					$this->ExtForm->input('litre', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'የ 1 ሊትር ዋጋ (በብር)', 'anchor' => '60%', 'vtype' => 'Decimal1');
					$options['maskRe'] = '/[0-9.]/i';
					$options['value'] = $fms_fuel['FmsFuel']['price'];
					$this->ExtForm->input('price', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'ኪሎሜትር', 'anchor' => '60%');
					$options['maskRe'] = '/[0-9.]/i';
					$options['value'] = $fms_fuel['FmsFuel']['kilometer'];
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
					value:'<?php echo $fms_fuel['FmsFuel']['driver'];?>',
					blankText: 'Your input is invalid.',
					disableKeyFilter: true,
					forceSelection:true,
					anyMatch : false,
				},
				
				<?php 
					$options = array('fieldLabel' => 'የኩፖን ዙር', 'anchor' => '60%');
					$options['value'] = $fms_fuel['FmsFuel']['round'];
					$this->ExtForm->input('round', $options);
				?>			]
		});
		
		var FmsFuelEditWindow = new Ext.Window({
			title: '<?php __('Edit Fuel'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: FmsFuelEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					FmsFuelEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Fms Fuel.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(FmsFuelEditWindow.collapsed)
						FmsFuelEditWindow.expand(true);
					else
						FmsFuelEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					FmsFuelEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FmsFuelEditWindow.close();
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
					FmsFuelEditWindow.close();
				}
			}]
		});
