		<?php
			$this->ExtForm->create('Lease');
			$this->ExtForm->defineFieldFunctions();
		?>
		var LeaseEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'leases', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $lease['Lease']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $lease['Lease']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $lease['Lease']['branch_code'];
					$this->ExtForm->input('branch_code', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $lease['Lease']['contract_years'];
					$this->ExtForm->input('contract_years', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $lease['Lease']['start_date'];
					$this->ExtForm->input('start_date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $lease['Lease']['end_date'];
					$this->ExtForm->input('end_date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $lease['Lease']['total_amount'];
					$this->ExtForm->input('total_amount', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $lease['Lease']['paid_years'];
					$this->ExtForm->input('paid_years', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $lease['Lease']['paid_amount'];
					$this->ExtForm->input('paid_amount', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $lease['Lease']['rent_amount'];
					$this->ExtForm->input('rent_amount', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $lease['Lease']['expensed'];
					$this->ExtForm->input('expensed', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $lease['Lease']['is_lease'];
					$this->ExtForm->input('is_lease', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $lease['Lease']['discount'];
					$this->ExtForm->input('discount', $options);
				?>			]
		});
		
		var LeaseEditWindow = new Ext.Window({
			title: '<?php __('Edit Lease'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: LeaseEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					LeaseEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Lease.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(LeaseEditWindow.collapsed)
						LeaseEditWindow.expand(true);
					else
						LeaseEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					LeaseEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							LeaseEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentLeaseData();
<?php } else { ?>
							RefreshLeaseData();
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
					LeaseEditWindow.close();
				}
			}]
		});
