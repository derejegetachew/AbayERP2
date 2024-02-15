		<?php
			$this->ExtForm->create('Pension');
			$this->ExtForm->defineFieldFunctions();
		?>
		var PensionEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'pensions', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $pension['Pension']['id'])); ?>,
                                <?php $this->ExtForm->input('payroll_id', array('hidden' => $pension['Pension']['payroll_id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $pension['Pension']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
                                        $options = array('fieldLabel'=>'PF: Staff %');
                                        $options['value'] = $pension['Pension']['pf_staff'];
					$this->ExtForm->input('pf_staff', $options);
				?>,
				<?php 
					$options = array();
                                        $options = array('fieldLabel'=>'PF: Company %');
					$options['value'] = $pension['Pension']['pf_company'];
					$this->ExtForm->input('pf_company', $options);
				?>,
				<?php 
					$options = array();
                                        $options = array('fieldLabel'=>'Pension: Staff %');
					$options['value'] = $pension['Pension']['pen_staff'];
					$this->ExtForm->input('pen_staff', $options);
				?>,
				<?php 
					$options = array();
                                        $options = array('fieldLabel'=>'Pension: Company %');
					$options['value'] = $pension['Pension']['pen_company'];
					$this->ExtForm->input('pen_company', $options);
				?>
                                ]
		});
		
		var PensionEditWindow = new Ext.Window({
			title: '<?php __('Edit PF/Pension'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: PensionEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					PensionEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Pension.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(PensionEditWindow.collapsed)
						PensionEditWindow.expand(true);
					else
						PensionEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					PensionEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							PensionEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentPensionData();
<?php } else { ?>
							RefreshPensionData();
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
					PensionEditWindow.close();
				}
			}]
		});
