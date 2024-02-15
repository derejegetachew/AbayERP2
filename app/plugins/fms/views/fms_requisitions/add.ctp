		<?php
			$this->ExtForm->create('FmsRequisition');
			$this->ExtForm->defineFieldFunctions();
		?>
		var FmsRequisitionAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'fmsRequisitions', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array('fieldLabel' => 'Ref Number','readOnly' => 'true', 'anchor' => '80%');
					date_default_timezone_set("Africa/Addis_Ababa");  
                    $options['value'] = date("Ymd").'/'.str_pad(($count + 1), 3,'0',STR_PAD_LEFT);
					$this->ExtForm->input('name', $options);
				?>,				
				<?php 
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Town', 'anchor' => '80%');
					$options['items'] = array('Addis Ababa' => 'Addis Ababa', 'Out of Addis Ababa' => 'Out of Addis Ababa');
					$this->ExtForm->input('town', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('place', $options);
				?>,
				<?php 
					$options = array('anchor' => '80%');
					$this->ExtForm->input('departure_date', $options);
				?>,
				<?php 
					$options = array('xtype' => 'timefield', 'anchor' => '80%', 'fieldLabel' => 'Departure Time', 'minValue' => '6:00 AM', 'maxValue' => '6:00 PM');
					$this->ExtForm->input('departure_time', $options);
				?>,
				<?php 
					$options = array('anchor' => '80%', 'fieldLabel' => 'Return Date');
					$this->ExtForm->input('arrival_date', $options);
				?>,				
				<?php 
					$options = array('xtype' => 'timefield', 'anchor' => '80%', 'fieldLabel' => 'Arrival Time', 'minValue' => '6:00 AM', 'maxValue' => '6:00 PM');
					$this->ExtForm->input('arrival_time', $options);
				?>,
				<?php 
					$options = array(
						'xtype' => 'textarea',
						'grow' => true,
						'fieldLabel' => 'Travelers Full Name',
						'anchor' => '100%'
					);
					$this->ExtForm->input('travelers', $options);
				?>			]
		});
		
		var FmsRequisitionAddWindow = new Ext.Window({
			title: '<?php __('Add Fms Requisition'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: FmsRequisitionAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					FmsRequisitionAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Fms Requisition.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(FmsRequisitionAddWindow.collapsed)
						FmsRequisitionAddWindow.expand(true);
					else
						FmsRequisitionAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					FmsRequisitionAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FmsRequisitionAddForm.getForm().reset();
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
			}, {
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
					FmsRequisitionAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FmsRequisitionAddWindow.close();
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
					FmsRequisitionAddWindow.close();
				}
			}]
		});
