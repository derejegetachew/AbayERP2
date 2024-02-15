		<?php
			$this->ExtForm->create('IbdSesameSeedsExportContract');
			$this->ExtForm->defineFieldFunctions();
		?>
		var IbdSesameSeedsExportContractEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ibdSesameSeedsExportContracts', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $ibd_sesame_seeds_export_contract['IbdSesameSeedsExportContract']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_sesame_seeds_export_contract['IbdSesameSeedsExportContract']['exporter_name'];
					$this->ExtForm->input('exporter_name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_sesame_seeds_export_contract['IbdSesameSeedsExportContract']['contract_date'];
					$this->ExtForm->input('contract_date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_sesame_seeds_export_contract['IbdSesameSeedsExportContract']['contract_registry_date'];
					$this->ExtForm->input('contract_registry_date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_sesame_seeds_export_contract['IbdSesameSeedsExportContract']['contract_registration_no'];
					$this->ExtForm->input('contract_registration_no', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_sesame_seeds_export_contract['IbdSesameSeedsExportContract']['quantity_mt'];
					$this->ExtForm->input('quantity_mt', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_sesame_seeds_export_contract['IbdSesameSeedsExportContract']['price_mt'];
					$this->ExtForm->input('price_mt', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_sesame_seeds_export_contract['IbdSesameSeedsExportContract']['type_of_currency'];
					$this->ExtForm->input('type_of_currency', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_sesame_seeds_export_contract['IbdSesameSeedsExportContract']['total_price'];
					$this->ExtForm->input('total_price', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_sesame_seeds_export_contract['IbdSesameSeedsExportContract']['shipment_date'];
					$this->ExtForm->input('shipment_date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_sesame_seeds_export_contract['IbdSesameSeedsExportContract']['delivery_term'];
					$this->ExtForm->input('delivery_term', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_sesame_seeds_export_contract['IbdSesameSeedsExportContract']['payment_method'];
					$this->ExtForm->input('payment_method', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_sesame_seeds_export_contract['IbdSesameSeedsExportContract']['sales_contract_reference'];
					$this->ExtForm->input('sales_contract_reference', $options);
				?>			]
		});
		
		var IbdSesameSeedsExportContractEditWindow = new Ext.Window({
			title: '<?php __('Edit Ibd Sesame Seeds Export Contract'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: IbdSesameSeedsExportContractEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					IbdSesameSeedsExportContractEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ibd Sesame Seeds Export Contract.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(IbdSesameSeedsExportContractEditWindow.collapsed)
						IbdSesameSeedsExportContractEditWindow.expand(true);
					else
						IbdSesameSeedsExportContractEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					IbdSesameSeedsExportContractEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdSesameSeedsExportContractEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentIbdSesameSeedsExportContractData();
<?php } else { ?>
							RefreshIbdSesameSeedsExportContractData();
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
					IbdSesameSeedsExportContractEditWindow.close();
				}
			}]
		});
