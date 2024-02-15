		<?php
			$this->ExtForm->create('IbdExportPermit');
			$this->ExtForm->defineFieldFunctions();
		?>
		var IbdExportPermitEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 160,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ibdExportPermits', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $ibd_export_permit['IbdExportPermit']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_export_permit['IbdExportPermit']['PERMIT_ISSUE_DATE'];
					$this->ExtForm->input('PERMIT_ISSUE_DATE', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_export_permit['IbdExportPermit']['EXPORTER_NAME'];
					$this->ExtForm->input('EXPORTER_NAME', $options);
				?>,
				<?php 
					$options = array('readOnly'=>'true');
					$options['value'] = $ibd_export_permit['IbdExportPermit']['EXPORT_PERMIT_NO'];
					$this->ExtForm->input('EXPORT_PERMIT_NO', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_export_permit['IbdExportPermit']['COMMODITY'];
					$this->ExtForm->input('COMMODITY', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_export_permit['IbdExportPermit']['BUYER_NAME'];
					$this->ExtForm->input('BUYER_NAME', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $payment_terms;
					$options['value'] = $ibd_export_permit['IbdExportPermit']['payment_term_id'];
					$this->ExtForm->input('payment_term_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $currencies;
					$options['value'] = $ibd_export_permit['IbdExportPermit']['currency_id'];
					$this->ExtForm->input('currency_id', $options);
				?>,
				{
				    id:'FCY_AMOUNT',
					xtype:'textfield',
					fieldLabel:'FCY_AMOUNT',
					anchor:'100%',
					value:<?php echo  $ibd_export_permit['IbdExportPermit']['FCY_AMOUNT'];?>,
					name :'data[IbdExportPermit][FCY_AMOUNT]',
					enableKeyEvents:true,
					listeners : {
						 keyup: function(field,e){
							 var value=e.target.value;
							 var other=Ext.getCmp('BUYING_RATE').getValue();
							 var result=value*other;
                             Ext.getCmp('LCY_AMOUNT').setValue(result);

						}
					}
			},
			{
				    id:'BUYING_RATE',
					xtype:'textfield',
					fieldLabel:'BUYING_RATE',
					anchor:'100%',
					value:<?php echo $ibd_export_permit['IbdExportPermit']['BUYING_RATE']; ?>,
					name : 'data[IbdExportPermit][BUYING_RATE]',
					enableKeyEvents:true,
					listeners : {
						 keyup: function(field,e){
							 var value=e.target.value;
							 var other=Ext.getCmp('FCY_AMOUNT').getValue();
							 var result=value*other;
                             Ext.getCmp('LCY_AMOUNT').setValue(result);
						}
					}
			}
				,
				<?php 
					$options = array('readOnly'=>'true','id'=>'LCY_AMOUNT');
					$options['value'] = $ibd_export_permit['IbdExportPermit']['LCY_AMOUNT'];
					$this->ExtForm->input('LCY_AMOUNT', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_export_permit['IbdExportPermit']['REMARK'];
					$this->ExtForm->input('REMARK', $options);
				?>			]
		});
		
		var IbdExportPermitEditWindow = new Ext.Window({
			title: '<?php __('Edit Ibd Export Permit'); ?>',
			width: 500,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: IbdExportPermitEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					IbdExportPermitEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ibd Export Permit.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(IbdExportPermitEditWindow.collapsed)
						IbdExportPermitEditWindow.expand(true);
					else
						IbdExportPermitEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					IbdExportPermitEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdExportPermitEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentIbdExportPermitData();
<?php } else { ?>
							RefreshIbdExportPermitData();
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
					IbdExportPermitEditWindow.close();
				}
			}]
		});
