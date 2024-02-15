		<?php
			$this->ExtForm->create('Deduction');
			$this->ExtForm->defineFieldFunctions();
		?>
		var DeductionEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'deductions', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $deduction['Deduction']['id'])); ?>,
				<?php 
					$options = array();
                                        $options = array('xtype' => 'combo', 'anchor' => '100%', 'fieldLabel' => 'Name', 'value' => '');
                                        $options['items'] = array(
                                            'Agar children Aid' => 'Agar children Aid',
                                            'Social Contribution' => 'Social contribution',
                                            'Cost Sharing'=>'Cost Sharing',
											'Penality'=>'Penality',
											'Excess Telephone'=>'Excess Telephone'
                                            );
					$options['value'] = $deduction['Deduction']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
                                        $options = array('xtype' => 'combo', 'anchor' => '100%', 'fieldLabel' => 'Measurement', 'value' => '');
                                        $options['items'] = array('Birr' => 'Birr', 'Percentile: Basic Salary' => 'Percentile: Basic Salary','Percentile: Gross Salary'=>'Percentile: Gross Salary');
					$options['value'] = $deduction['Deduction']['Measurement'];
					$this->ExtForm->input('Measurement', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $deduction['Deduction']['amount'];
					$this->ExtForm->input('amount', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $grades;
					$options['value'] = $deduction['Deduction']['grade_id'];
					$this->ExtForm->input('grade_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $deduction['Deduction']['start_date'];
					$this->ExtForm->input('start_date', $options);
				?>,
				<?php 
					$options = array();
                                        if($deduction['Deduction']['end_date']=='0000-00-00')
                                        $options['value']='';
                                        else
					$options['value'] = $deduction['Deduction']['end_date'];
					$this->ExtForm->input('end_date', $options);
				?>			]
		});
		
		var DeductionEditWindow = new Ext.Window({
			title: '<?php __('Edit Deduction'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: DeductionEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					DeductionEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Deduction.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(DeductionEditWindow.collapsed)
						DeductionEditWindow.expand(true);
					else
						DeductionEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					DeductionEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							DeductionEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentDeductionData();
<?php } else { ?>
							RefreshDeductionData();
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
					DeductionEditWindow.close();
				}
			}]
		});
