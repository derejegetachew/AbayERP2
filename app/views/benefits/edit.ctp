		<?php
			$this->ExtForm->create('Benefit');
			$this->ExtForm->defineFieldFunctions();
		?>
		var BenefitEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'benefits', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $benefit['Benefit']['id'])); ?>,
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
                                            );
					$options['value'] = $benefit['Benefit']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
                                        $options = array('xtype' => 'combo', 'anchor' => '100%', 'fieldLabel' => 'Measurement', 'value' => '');
                                        $options['items'] = array('Birr' => 'Birr', 'Percentile' => 'Percentile','Gas'=>'Gas');
					$options['value'] = $benefit['Benefit']['Measurement'];
					$this->ExtForm->input('Measurement', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $benefit['Benefit']['amount'];
					$this->ExtForm->input('amount', $options);
				?>,
				<?php 
					$options = array();
                                        $options['value'] = $benefit['Benefit']['taxable'];
					$this->ExtForm->input('taxable', $options);
				?>,
				<?php 
					$options = array();
                                        $options=array('fieldLabel' => 'Taxable Rule');
                                        $options['value'] = $benefit['Benefit']['over'];
					$this->ExtForm->input('over', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $grades;
					$options['value'] = $benefit['Benefit']['grade_id'];
					$this->ExtForm->input('grade_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $benefit['Benefit']['start_date'];
					$this->ExtForm->input('start_date', $options);
				?>,
				<?php 
					$options = array();
                                        if($benefit['Benefit']['end_date']=='0000-00-00')
                                        $options['value']='';
                                        else
					$options['value'] = $benefit['Benefit']['end_date'];
					$this->ExtForm->input('end_date', $options);
				?>			]
		});
		
		var BenefitEditWindow = new Ext.Window({
			title: '<?php __('Edit Benefit'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: BenefitEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					BenefitEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Benefit.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(BenefitEditWindow.collapsed)
						BenefitEditWindow.expand(true);
					else
						BenefitEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					BenefitEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BenefitEditWindow.close();
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
					BenefitEditWindow.close();
				}
			}]
		});
