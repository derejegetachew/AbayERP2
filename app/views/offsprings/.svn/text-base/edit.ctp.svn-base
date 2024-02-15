		<?php
			$this->ExtForm->create('Offspring');
			$this->ExtForm->defineFieldFunctions();
		?>
		var OffspringEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'offsprings', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $offspring['Offspring']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $offspring['Offspring']['first_name'];
					$this->ExtForm->input('first_name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $offspring['Offspring']['last_name'];
					$this->ExtForm->input('last_name', $options);
				?>,
				<?php 
					$options = array();
                                        
                                $options = array('xtype' => 'combo', 'anchor' => '50%', 'fieldLabel' => 'Sex');
                                $options['items'] = array('M' => 'Male', 'F' => 'Female');
					$options['value'] = $offspring['Offspring']['sex'];
					$this->ExtForm->input('sex', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $offspring['Offspring']['birth_date'];
					$this->ExtForm->input('birth_date', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $employees;
					$options['value'] = $offspring['Offspring']['employee_id'];
					$this->ExtForm->input('employee_id', $options);
				?>			]
		});
		
		var OffspringEditWindow = new Ext.Window({
			title: '<?php __('Edit Offspring'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: OffspringEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					OffspringEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Offspring.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(OffspringEditWindow.collapsed)
						OffspringEditWindow.expand(true);
					else
						OffspringEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					OffspringEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							OffspringEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentOffspringData();
<?php } else { ?>
							RefreshOffspringData();
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
					OffspringEditWindow.close();
				}
			}]
		});
