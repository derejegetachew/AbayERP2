		<?php
			$this->ExtForm->create('Allocatedtraining');
			$this->ExtForm->defineFieldFunctions();
		?>
		var AllocatedtrainingAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'allocatedtrainings', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $budget_years;
					$this->ExtForm->input('budget_year_id', $options);
				?>,
				<?php 
					
					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Quarter');
					$options['items'] = array(1 => "I", 2 => "II", 3 => "III", 4 => "IV");
					$this->ExtForm->input('quarter', $options);
				
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
					//	$options['items'] = $employees;
					$options['items'] = $emps;
					$this->ExtForm->input('employee_id', $options);
				?>,
				<?php 
				
					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Training1');
					
					$options['items'] = $training_list;
					$options['value'] = 0;
					$this->ExtForm->input('training1', $options);
				?>,
				<?php 
					// $options = array();
					// $this->ExtForm->input('training2', $options);
					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Training2');
					
					$options['items'] = $training_list;
					$options['value'] = 0;
					$this->ExtForm->input('training2', $options);
				?>,
				<?php 
					// $options = array();
					// $this->ExtForm->input('training3', $options);
					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Training3');
					
					$options['items'] = $training_list;
					$options['value'] = 0;
					$this->ExtForm->input('training3', $options);
				?>
							]
		});
		
		var AllocatedtrainingAddWindow = new Ext.Window({
			title: '<?php __('Add Allocatedtraining'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: AllocatedtrainingAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					AllocatedtrainingAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Allocatedtraining.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(AllocatedtrainingAddWindow.collapsed)
						AllocatedtrainingAddWindow.expand(true);
					else
						AllocatedtrainingAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					AllocatedtrainingAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							AllocatedtrainingAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentAllocatedtrainingData();
<?php } else { ?>
							RefreshAllocatedtrainingData();
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
					AllocatedtrainingAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							AllocatedtrainingAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentAllocatedtrainingData();
<?php } else { ?>
							RefreshAllocatedtrainingData();
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
					AllocatedtrainingAddWindow.close();
				}
			}]
		});
