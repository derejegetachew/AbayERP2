		<?php
			$this->ExtForm->create('IbdOdbc');
			$this->ExtForm->defineFieldFunctions();
		?>
		var IbdOdbcEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ibdOdbcs', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $ibd_odbc['IbdOdbc']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_odbc['IbdOdbc']['Exporter_Name'];
					$this->ExtForm->input('Exporter_Name', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $payment_terms;
					$options['value'] = $ibd_odbc['IbdOdbc']['payment_term_id'];
					$this->ExtForm->input('payment_term_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_odbc['IbdOdbc']['Doc_Ref'];
					$this->ExtForm->input('Doc_Ref', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_odbc['IbdOdbc']['Permit_No'];
					$this->ExtForm->input('Permit_No', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_odbc['IbdOdbc']['NBE_Permit_no'];
					$this->ExtForm->input('NBE_Permit_no', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_odbc['IbdOdbc']['Branch_Name'];
					$this->ExtForm->input('Branch_Name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_odbc['IbdOdbc']['ODBC_DD'];
					$this->ExtForm->input('ODBC_DD', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_odbc['IbdOdbc']['Destination'];
					$this->ExtForm->input('Destination', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_odbc['IbdOdbc']['Single_Ent'];
					$this->ExtForm->input('Single_Ent', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $currencies;
					$options['value'] = $ibd_odbc['IbdOdbc']['currency_id'];
					$this->ExtForm->input('currency_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_odbc['IbdOdbc']['doc_permitt_amount'];
					$this->ExtForm->input('doc_permitt_amount', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_odbc['IbdOdbc']['value_date'];
					$this->ExtForm->input('value_date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_odbc['IbdOdbc']['proceed_amount'];
					$this->ExtForm->input('proceed_amount', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_odbc['IbdOdbc']['rate'];
					$this->ExtForm->input('rate', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_odbc['IbdOdbc']['lcy'];
					$this->ExtForm->input('lcy', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_odbc['IbdOdbc']['Deduction'];
					$this->ExtForm->input('Deduction', $options);
				?>			]
		});
		
		var IbdOdbcEditWindow = new Ext.Window({
			title: '<?php __('Edit Ibd Odbc'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: IbdOdbcEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					IbdOdbcEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ibd Odbc.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(IbdOdbcEditWindow.collapsed)
						IbdOdbcEditWindow.expand(true);
					else
						IbdOdbcEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					IbdOdbcEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdOdbcEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentIbdOdbcData();
<?php } else { ?>
							RefreshIbdOdbcData();
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
					IbdOdbcEditWindow.close();
				}
			}]
		});
