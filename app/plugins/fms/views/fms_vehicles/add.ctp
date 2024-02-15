		<?php
			$this->ExtForm->create('FmsVehicle');
			$this->ExtForm->defineFieldFunctions();
		?>
		var FmsVehicleAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'fmsVehicles', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array('xtype' => 'combo', 'fieldLabel' => 'የተሽከርካሪው ዓይነት', 'anchor' => '100%', 'editable' => true);
					$options['items'] = array('Abarth' => 'Abarth', 'AC' => 'AC', 'Aixam' => 'Aixam', 'Alfa Romeo' => 'Alfa Romeo', 'Asia' => 'Asia',
					'Aston Martin' => 'Aston Martin','Audi' => 'Audi','Austin' => 'Austin','Bentley' => 'Bentley', 'BMW' => 'BMW',  'BMW Alpina' => 'BMW Alpina',
					'Bristol' => 'Bristol','Cadillac' => 'Cadillac','Caterham' => 'Caterham','Chevrolet' => 'Chevrolet', 'Chrysler' => 'Chrysler',  'Citroen' => 'Citroen',
					'Coleman Milne' => 'Coleman Milne','Corvette' => 'Corvette','Dacia' => 'Dacia','Daewoo' => 'Daewoo', 'Daihatsu' => 'Daihatsu',  'Daimler' => 'Daimler',
					'De Tomaso' => 'De Tomaso','Dodge' => 'Dodge','DS' => 'DS','Eagle' => 'Eagle', 'Farbio' => 'Farbio',  'FBS' => 'FBS', 'Ferrari' => 'Ferrari',
					'Fiat' => 'Fiat','Ford' => 'Ford','FSO' => 'FSO','Honda' => 'Honda', 'Hummer' => 'Hummer',  'Hyundai' => 'Hyundai', 'Infiniti' => 'Infiniti',
					'Invicta' => 'Invicta','Isuzu' => 'Isuzu','Jaguar' => 'Jaguar','Jeep' => 'Jeep', 'Jensen' => 'Jensen',  'Kia' => 'Kia', 'KTM' => 'KTM',
					'Lada' => 'Lada','Lamborghini' => 'Lamborghini','Lancia' => 'Lancia','Land Rover' => 'Land Rover', 'Lexus' => 'Lexus',  'Ligier' => 'Ligier', 'Lotus' => 'Lotus',
					'LTI' => 'LTI','Marcos' => 'Marcos','Marlin' => 'Marlin','Maserati' => 'Maserati', 'Maybach' => 'Maybach',  'Mazda' => 'Mazda', 'McLaren' => 'McLaren',
					'Mercedes-Benz' => 'Mercedes-Benz','MG' => 'MG','MG Motor UK' => 'MG Motor UK','MIA' => 'MIA', 'Microcar' => 'Microcar',  'MINI' => 'MINI', 'Mitsubishi' => 'Mitsubishi',
					'Morgan' => 'Morgan','Nissan' => 'Nissan','Noble' => 'Noble','Opel' => 'Opel', 'Perodua' => 'Perodua',  'Peugeot' => 'Peugeot', 'PGO' => 'PGO',
					'Porsche' => 'Porsche','PRINDIVILLE' => 'PRINDIVILLE','Proton' => 'Proton','Reliant' => 'Reliant', 'Renault' => 'Renault',  'Rolls-Royce' => 'Rolls-Royce', 'Rover' => 'Rover',
					'Saab' => 'Saab','San' => 'San','SAO' => 'SAO','SEAT' => 'SEAT', 'Skoda' => 'Skoda',  'Smart' => 'Smart', 'SsangYong' => 'SsangYong',
					'Subaru' => 'Subaru','Suzuki' => 'Suzuki','Talbot' => 'Talbot','TD Cars' => 'TD Cars', 'Tesla' => 'Tesla',  'Toyota' => 'Toyota', 'TVR' => 'TVR',
					'Vauxhall' => 'Vauxhall','Volkswagen' => 'Volkswagen','Volvo' => 'Volvo','Westfield' => 'Westfield', 'Yugo' => 'Yugo');
					$this->ExtForm->input('vehicle_type', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'የሰሌዳ ቁጥር');
					$this->ExtForm->input('plate_no', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'ሞዴል');
					$this->ExtForm->input('model', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'የሞተር ቁጥር');
					$this->ExtForm->input('engine_no', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'የሻንሲ ቁጥር');
					$this->ExtForm->input('chassis_no', $options);
				?>,
				<?php 
					$options = array('xtype' => 'combo', 'fieldLabel' => 'የነዳጅ ዓይነት');
					$options['items'] = array('Gasoline' => 'Gasoline', 'Diesel' => 'Diesel', 'Liquefied Petroleum' => 'Liquefied Petroleum', 'Compressed Natural Gas' => 'Compressed Natural Gas', 'Ethanol' => 'Ethanol', 'Bio-diesel' => 'Bio-diesel');
					$this->ExtForm->input('fuel_type', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'የጎማ ብዛት');
					$this->ExtForm->input('no_of_tyre', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'የፈረስ ጉልበት');
					$this->ExtForm->input('horsepower', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'የመጫን አቅም (ሰው)');
					$this->ExtForm->input('carload_people', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'የመጫን አቅም (ኩንታል)');
					$this->ExtForm->input('carload_goods', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'የተገዛበት ዋጋ', 'allowBlank' => true);
					$this->ExtForm->input('purchase_amount', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'የተገዛበት ቀን');
					$this->ExtForm->input('purchase_date', $options);
				?>,
				<?php 
					$options = array(
							'fieldLabel' => 'ሌሎች',
							'xtype' => 'textarea',
							'grow' => true,
							'anchor' => '100%'
						);
					$this->ExtForm->input('remark', $options);
				?>		]
		});
		
		var FmsVehicleAddWindow = new Ext.Window({
			title: '<?php __('Add Fms Vehicle'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: FmsVehicleAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					FmsVehicleAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Fms Vehicle.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(FmsVehicleAddWindow.collapsed)
						FmsVehicleAddWindow.expand(true);
					else
						FmsVehicleAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					FmsVehicleAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FmsVehicleAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentFmsVehicleData();
<?php } else { ?>
							RefreshFmsVehicleData();
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
					FmsVehicleAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FmsVehicleAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentFmsVehicleData();
<?php } else { ?>
							RefreshFmsVehicleData();
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
					FmsVehicleAddWindow.close();
				}
			}]
		});
