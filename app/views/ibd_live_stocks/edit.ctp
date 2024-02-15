		<?php
			$this->ExtForm->create('IbdLiveStock');
			$this->ExtForm->defineFieldFunctions();
		?>
		var IbdLiveStockEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ibdLiveStocks', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $ibd_live_stock['IbdLiveStock']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_live_stock['IbdLiveStock']['exporter_name'];
					$this->ExtForm->input('exporter_name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_live_stock['IbdLiveStock']['contract_date'];
					$this->ExtForm->input('contract_date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_live_stock['IbdLiveStock']['contract_registry_date'];
					$this->ExtForm->input('contract_registry_date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_live_stock['IbdLiveStock']['contract_registration_no'];
					$this->ExtForm->input('contract_registration_no', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_live_stock['IbdLiveStock']['quantity_mt'];
					$this->ExtForm->input('quantity_mt', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_live_stock['IbdLiveStock']['price_mt'];
					$this->ExtForm->input('price_mt', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_live_stock['IbdLiveStock']['type_of_currency'];
					$this->ExtForm->input('type_of_currency', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_live_stock['IbdLiveStock']['total_price'];
					$this->ExtForm->input('total_price', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_live_stock['IbdLiveStock']['shipment_date'];
					$this->ExtForm->input('shipment_date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_live_stock['IbdLiveStock']['delivery_term'];
					$this->ExtForm->input('delivery_term', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_live_stock['IbdLiveStock']['payment_method'];
					$this->ExtForm->input('payment_method', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_live_stock['IbdLiveStock']['sales_contract_reference'];
					$this->ExtForm->input('sales_contract_reference', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_live_stock['IbdLiveStock']['commodity_type'];
					$this->ExtForm->input('commodity_type', $options);
				?>			]
		});
		
		var IbdLiveStockEditWindow = new Ext.Window({
			title: '<?php __('Edit Ibd Live Stock'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: IbdLiveStockEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					IbdLiveStockEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ibd Live Stock.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(IbdLiveStockEditWindow.collapsed)
						IbdLiveStockEditWindow.expand(true);
					else
						IbdLiveStockEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					IbdLiveStockEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdLiveStockEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentIbdLiveStockData();
<?php } else { ?>
							RefreshIbdLiveStockData();
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
					IbdLiveStockEditWindow.close();
				}
			}]
		});
