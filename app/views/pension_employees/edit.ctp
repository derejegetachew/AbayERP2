		<?php
			$this->ExtForm->create('PensionEmployee');
			$this->ExtForm->defineFieldFunctions();
		?>
		var PensionEmployeeEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'pensionEmployees', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
                        <?php if(is_array($pension_employee)){
                            $this->ExtForm->input('id', array('hidden' => $pension_employee['PensionEmployee']['id'])); echo ",";
                            }
                        ?>
                        <?php $this->ExtForm->input('employee_id', array('hidden' =>$employee['Employee']['id']));   ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $pensions;
					$options['value'] = $pension_employee['PensionEmployee']['pension_id'];
					$this->ExtForm->input('pension_id', $options);
				?>		]
		});
		
		var PensionEmployeeEditWindow = new Ext.Window({
			title: '<?php __('Assign PF/Pension'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: PensionEmployeeEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					PensionEmployeeEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Pension Employee.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(PensionEmployeeEditWindow.collapsed)
						PensionEmployeeEditWindow.expand(true);
					else
						PensionEmployeeEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					PensionEmployeeEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							PensionEmployeeEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentPensionEmployeeData();
<?php } else { ?>
							RefreshPensionEmployeeData();
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
					PensionEmployeeEditWindow.close();
				}
			}]
		});
