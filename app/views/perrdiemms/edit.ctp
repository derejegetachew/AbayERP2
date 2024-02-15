		<?php
			$this->ExtForm->create('Perrdiemm');
			$this->ExtForm->defineFieldFunctions();
		?>
		var PerrdiemmEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'perrdiemms', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $perrdiemm['Perrdiemm']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $employees;
					$options['value'] = $perrdiemm['Perrdiemm']['employee_id'];
					$this->ExtForm->input('employee_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $payrolls;
					$options['value'] = $perrdiemm['Perrdiemm']['payroll_id'];
					$this->ExtForm->input('payroll_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $perrdiemm['Perrdiemm']['days'];
					$this->ExtForm->input('days', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $perrdiemm['Perrdiemm']['rate'];
					$this->ExtForm->input('rate', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $perrdiemm['Perrdiemm']['taxable'];
					$this->ExtForm->input('taxable', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $perrdiemm['Perrdiemm']['date'];
					$this->ExtForm->input('date', $options);
				?>			]
		});
		
		var PerrdiemmEditWindow = new Ext.Window({
			title: '<?php __('Edit Perdium'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: PerrdiemmEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					PerrdiemmEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Perrdiemm.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(PerrdiemmEditWindow.collapsed)
						PerrdiemmEditWindow.expand(true);
					else
						PerrdiemmEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					PerrdiemmEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							PerrdiemmEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentPerrdiemmData();
<?php } else { ?>
							RefreshPerrdiemmData();
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
					PerrdiemmEditWindow.close();
				}
			}]
		});
