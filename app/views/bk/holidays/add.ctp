		<?php
			$this->ExtForm->create('Holiday');
			$this->ExtForm->defineFieldFunctions();
		?>
		var HolidayAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'holidays', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
                                        $this->ExtForm->input('employee_id', array('hidden' =>$employee['Employee']['id']));
				?>,
				<?php 
					$options = array();
                                        $options = array('xtype' => 'combo', 'fieldLabel' => 'Type', 'value' => 'Annual Leave');
                                        $options['items'] = array('Annual Leave' => 'Annual Leave', 'Sick Leave' => 'Sick Leave');
					$this->ExtForm->input('type', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('from_date', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('to_date', $options);
				?>			]
		});
		
		var HolidayAddWindow = new Ext.Window({
			title: '<?php __('Add Holiday'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: HolidayAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					HolidayAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Holiday.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(HolidayAddWindow.collapsed)
						HolidayAddWindow.expand(true);
					else
						HolidayAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					HolidayAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							HolidayAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentHolidayData();
<?php } else { ?>
							RefreshHolidayData();
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
					HolidayAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							HolidayAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentHolidayData();
<?php } else { ?>
							RefreshHolidayData();
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
					HolidayAddWindow.close();
				}
			}]
		});
