		<?php
			$this->ExtForm->create('Benefit');
			$this->ExtForm->defineFieldFunctions();
		?>
		var BenefitAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'benefits', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
                                <?php $this->ExtForm->input('apply_to', array('hidden' => 'employee')); ?>,
				<?php 
					$options = array();
                                        $options = array('xtype' => 'combo', 'anchor' => '100%', 'fieldLabel' => 'Name', 'value' => '');
                                        $options['items'] = array(
                                            'Transport Allowance' => 'Transport Allowance',
                                            'Housing Allowance' => 'Housing Allowance',
                                            'Representation Allowance'=>'Representation Allowance',
                                            'Telephone Allowance'=>'Telephone Allowance',
                                            'Additional Transport Allowance'=>'Additional Transport Allowance',
                                            'Cash Indeminity'=>'Cash Indeminity',
                                            'IT Transportation'=>'IT Transportation',
											'Other Benefits'=>'Other Benefits',
                                            ''=>''
                                            );
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
                                        $options = array('xtype' => 'combo', 'anchor' => '100%', 'fieldLabel' => 'Measurement', 'value' => '');
                                        $options['items'] = array('Birr' => 'Birr', 'Percentile' => 'Percentile','Gas'=>'Gas');
					$this->ExtForm->input('Measurement', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('amount', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('taxable', $options);
				?>,
                                <?php 
					$options = array();
                                        $options=array('fieldLabel' => 'Taxable Rule');
                                        $options['value'] = 0;
					$this->ExtForm->input('over', $options);
				?>,
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
                                        if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $payrolls;
					$options['value'] = $this->Session->read('Auth.User.payroll_id');
					$this->ExtForm->input('payroll_id', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('start_date', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('end_date', $options);
				?>			]
		});
		
		var BenefitAddWindow = new Ext.Window({
			title: '<?php __('Add Benefit'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: BenefitAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					BenefitAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Benefit.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(BenefitAddWindow.collapsed)
						BenefitAddWindow.expand(true);
					else
						BenefitAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					BenefitAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BenefitAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentBenefitData();
<?php } else { ?>
							RefreshBenefitData();
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
					BenefitAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BenefitAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentBenefitData();
<?php } else { ?>
							RefreshBenefitData();
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
					BenefitAddWindow.close();
				}
			}]
		});
