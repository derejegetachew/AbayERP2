		<?php
			$this->ExtForm->create('LeaveAnnualSetup');
			$this->ExtForm->defineFieldFunctions();
		?>
		var HolidayAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'holidays', 'action' => 'set_leave')); ?>',
			defaultType: 'textfield',

			items: [
				<?php if(isset($id)){ $this->ExtForm->input('id', array('hidden' => $id)); echo ',';}?>
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $employees;
					$this->ExtForm->input('employee_id', $options);
				?>,
				<?php 
					$options = array();
					$options['fieldLabel']='Leave taken before AbayERP';
                                          if(isset($taken))
                                            $options['value']=$taken;  
					$this->ExtForm->input('taken', $options);
				?>,<?php 
					$options = array(); 
					$options['fieldLabel']='Saturday as full working day';
					if(isset($saturday))
					$options['value'] = $saturday;
					$this->ExtForm->input('saturday', $options);
				?>			]
		});
		
		var LeaveAddWindow = new Ext.Window({
			title: '<?php __('Initial Leave Setup for employee'); ?>',
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
					LeaveAddForm.getForm().reset();
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
					if(LeaveAddWindow.collapsed)
						LeaveAddWindow.expand(true);
					else
						LeaveAddWindow.collapse(true);
				}
			}],
			buttons: [   {
				text: '<?php __('Set'); ?>',
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
							LeaveAddWindow.close();
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
					LeaveAddWindow.close();
				}
			}]
		});
