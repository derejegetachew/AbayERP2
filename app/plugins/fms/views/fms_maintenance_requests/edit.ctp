		<?php
			$this->ExtForm->create('FmsMaintenanceRequest');
			$this->ExtForm->defineFieldFunctions();
		?>
		var FmsMaintenanceRequestEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'fmsMaintenanceRequests', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $fms_maintenance_request['FmsMaintenanceRequest']['id'])); ?>,
				<?php 
					$options = array('xtype' => 'combo', 'fieldLabel' => 'ኩባንያ', 'anchor' => '100%');
					$options['items'] = array('የኢትዮጵያ ሞተርና ኢንጅነሪንግ ኩባንያ/ሞኤንኮ/' => 'የኢትዮጵያ ሞተርና ኢንጅነሪንግ ኩባንያ/ሞኤንኮ/', 
												'ሞኤንኮ - ቃሊቲ ማሽነሪ ቅርንጫፍ' => 'ሞኤንኮ - ቃሊቲ ማሽነሪ ቅርንጫፍ', 
												'ናሽናል ሞተርስ ኮርፖሬሽን' => 'ናሽናል ሞተርስ ኮርፖሬሽን', 
												'ኒያላ ሞተርስ አ.ማ' => 'ኒያላ ሞተርስ አ.ማ', 
												'ታምሪን ኢንተርናሽናል ትሬዲንግ ሃ|የተ|የግ|ማ' => 'ታምሪን ኢንተርናሽናል ትሬዲንግ ሃ|የተ|የግ|ማ', 
												'ማራቶን ሞተር ኢንጅነሪንግ ሃ|የተ|የግ|ማ' => 'ማራቶን ሞተር ኢንጅነሪንግ ሃ|የተ|የግ|ማ', 
												'በላይአብ ሞተርስ አ.ማ' => 'በላይአብ ሞተርስ አ.ማ',
												'አርቢስ የንግድና ቴክኒክ ማዕከል አ.ማ' => 'አርቢስ የንግድና ቴክኒክ ማዕከል አ.ማ',
												'ያንግፋን ሞተርስ' => 'ያንግፋን ሞተርስ',
												'ሰንሰለት ሞተር ኢንጅነሪንግ ሃ|የተ|የግ|ማ' => 'ሰንሰለት ሞተር ኢንጅነሪንግ ሃ|የተ|የግ|ማ',
												'ታደሰ ጋቢሳ' => 'ታደሰ ጋቢሳ',
												'ካኪ ሃ|የተ|የግ|ማ' => 'ካኪ ሃ|የተ|የግ|ማ');
					$options['value'] = $fms_maintenance_request['FmsMaintenanceRequest']['company'];
					$this->ExtForm->input('company', $options);
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
					hiddenName:'data[FmsMaintenanceRequest][fms_vehicle_id]',
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
					value: '<?php echo $fms_maintenance_request['FmsMaintenanceRequest']['fms_vehicle_id'];?>',
					disableKeyFilter: true,
					forceSelection:true,
					anyMatch : false,
				},
				
				<?php 
					$options = array('fieldLabel' => 'ኪሎ ሜትር', 'vtype' => 'Decimal1');
					$options['maskRe'] = '/[0-9.]/i';
					$options['value'] = $fms_maintenance_request['FmsMaintenanceRequest']['km'];
					$this->ExtForm->input('km', $options);
				?>,
				<?php 
					$options = array(
						'xtype' => 'textarea',
						'grow' => true,
						'fieldLabel' => 'የብልሽቱ አይነት',
						'anchor' => '100%');
					$options['value'] = $fms_maintenance_request['FmsMaintenanceRequest']['damage_type'];
					$this->ExtForm->input('damage_type', $options);
				?>,
				<?php 
					$options = array(
						'xtype' => 'textarea',
						'grow' => true,
						'fieldLabel' => 'ምርመራ',
						'anchor' => '100%');
					$options['value'] = $fms_maintenance_request['FmsMaintenanceRequest']['examination'];
					$this->ExtForm->input('examination', $options);
				?>,
				{
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							<?php $st = false;foreach ($people as $person){if($st) echo ",
							";?>['<?php echo $person['People']['first_name'].' '.$person['People']['middle_name']; ?>' ,'<?php echo $person['People']['first_name'].' '.$person['People']['middle_name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					hiddenName:'data[FmsMaintenanceRequest][notifier]',
					id: 'notifier',
					name: 'notifier',
					mode : 'local',
					triggerAction: 'all',
					emptyText: 'Select Notifier',
					selectOnFocus:true,
					anchor: '80%',
					fieldLabel: '<span style="color:red;">*</span> ብልሽቱን የገለጸው አሽከርካሪ',
					allowBlank: false,
					editable: true,
					lazyRender: true,
					blankText: 'Your input is invalid.',
					value: '<?php echo $fms_maintenance_request['FmsMaintenanceRequest']['notifier']?>',
					disableKeyFilter: true,
					forceSelection:true,
					anyMatch : true,
				},
				{
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							<?php $st = false;foreach ($people as $person){if($st) echo ",
							";?>['<?php echo $person['People']['first_name'].' '.$person['People']['middle_name']; ?>' ,'<?php echo $person['People']['first_name'].' '.$person['People']['middle_name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					hiddenName:'data[FmsMaintenanceRequest][confirmer]',
					id: 'confirmer',
					name: 'confirmer',
					mode : 'local',
					triggerAction: 'all',
					emptyText: 'Select Confirmer',
					selectOnFocus:true,
					anchor: '80%',
					fieldLabel: 'ያረጋገጠው መካኒክ',
					allowBlank: true,
					editable: true,
					lazyRender: true,
					blankText: 'Your input is invalid.',
					value: '<?php echo $fms_maintenance_request['FmsMaintenanceRequest']['confirmer']?>',
					disableKeyFilter: true,
					forceSelection:true,
					anyMatch : true,
				},
				{
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							<?php $st = false;foreach ($people as $person){if($st) echo ",
							";?>['<?php echo $person['People']['first_name'].' '.$person['People']['middle_name']; ?>' ,'<?php echo $person['People']['first_name'].' '.$person['People']['middle_name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					hiddenName:'data[FmsMaintenanceRequest][approver]',
					id: 'approver',
					name: 'approver',
					mode : 'local',
					triggerAction: 'all',
					emptyText: 'Select Approver',
					selectOnFocus:true,
					anchor: '80%',
					fieldLabel: 'የፈቀደው የክፍል ኃላፊ',
					allowBlank: true,
					editable: true,
					lazyRender: true,
					blankText: 'Your input is invalid.',
					value: '<?php echo $fms_maintenance_request['FmsMaintenanceRequest']['approver']?>',
					disableKeyFilter: true,
					forceSelection:true,
					anyMatch : true,
				}
							]
		});
		
		var FmsMaintenanceRequestEditWindow = new Ext.Window({
			title: '<?php __('Edit Fms Maintenance Request'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: FmsMaintenanceRequestEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					FmsMaintenanceRequestEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Fms Maintenance Request.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(FmsMaintenanceRequestEditWindow.collapsed)
						FmsMaintenanceRequestEditWindow.expand(true);
					else
						FmsMaintenanceRequestEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					FmsMaintenanceRequestEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FmsMaintenanceRequestEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentFmsMaintenanceRequestData();
<?php } else { ?>
							RefreshFmsMaintenanceRequestData();
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
					FmsMaintenanceRequestEditWindow.close();
				}
			}]
		});
