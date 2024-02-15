		<?php
			$this->ExtForm->create('Allocatedtraining');
			$this->ExtForm->defineFieldFunctions();
		?>
		var AllocatedtrainingEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'allocatedtrainings', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $allocatedtraining['Allocatedtraining']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $budget_years;
					$options['value'] = $allocatedtraining['Allocatedtraining']['budget_year_id'];
					$this->ExtForm->input('budget_year_id', $options);
				?>,
				<?php 
					// $options = array();
					// $options['value'] = $allocatedtraining['Allocatedtraining']['quarter'];
					// $this->ExtForm->input('quarter', $options);

					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Quarter');
					if($allocatedtraining['Allocatedtraining']['quarter'] == 1){
						$options['items'] = array(1 => "I", 2 => "II", 3 => "III", 4 => "IV");
					}
					if($allocatedtraining['Allocatedtraining']['quarter'] == 2){
						$options['items'] = array( 2 => "II", 1 => "I", 3 => "III", 4 => "IV");
					}
					if($allocatedtraining['Allocatedtraining']['quarter'] == 3){
						$options['items'] = array( 3 => "III",  1 => "I", 2 => "II",  4 => "IV");
					}
					if($allocatedtraining['Allocatedtraining']['quarter'] == 4){
						$options['items'] = array(  4 => "IV" , 1 => "I", 2 => "II" , 3 => "III");
					}
					
					$options['value'] = $allocatedtraining['Allocatedtraining']['quarter'];
					$this->ExtForm->input('quarter', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						// $options['items'] = $employees;
						$options['items'] = $emps;
					$options['value'] = $allocatedtraining['Allocatedtraining']['employee_id'];
					$this->ExtForm->input('employee_id', $options);
				?>,
				<?php 
					// $options = array();
					// $options['value'] = $allocatedtraining['Allocatedtraining']['training1'];
					// $this->ExtForm->input('training1', $options);
					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Training1');
					
					$options['items'] = $training_list;
					$options['value'] = $allocatedtraining['Allocatedtraining']['training1'];
					$this->ExtForm->input('training1', $options);
				?>,
				<?php 
					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Training2');
					
					$options['items'] = $training_list;
					$options['value'] = $allocatedtraining['Allocatedtraining']['training2'];
					$this->ExtForm->input('training2', $options);
				?>,
				<?php 
					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Training3');
					
					$options['items'] = $training_list;
					$options['value'] = $allocatedtraining['Allocatedtraining']['training3'];
					$this->ExtForm->input('training3', $options);
				?>
							]
		});
		
		var AllocatedtrainingEditWindow = new Ext.Window({
			title: '<?php __('Edit Allocatedtraining'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: AllocatedtrainingEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					AllocatedtrainingEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Allocatedtraining.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(AllocatedtrainingEditWindow.collapsed)
						AllocatedtrainingEditWindow.expand(true);
					else
						AllocatedtrainingEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					AllocatedtrainingEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							AllocatedtrainingEditWindow.close();
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
					AllocatedtrainingEditWindow.close();
				}
			}]
		});
