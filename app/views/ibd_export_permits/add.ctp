		<?php
			$this->ExtForm->create('IbdExportPermit');
			$this->ExtForm->defineFieldFunctions();
		?>
		var IbdExportPermitAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 150,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ibdExportPermits', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				
				<?php 
					$options = array('allowBlank'=>false);
					$this->ExtForm->input('EXPORTER_NAME', $options);
				?>,
				<?php 
					$options = array('allowBlank'=>false);
					$this->ExtForm->input('PERMIT_ISSUE_DATE', $options);
				?>,
				<?php 
					$options = array();
					$options['readOnly']=true;
					$options['value']=$permit;
					$this->ExtForm->input('EXPORT_PERMIT_NO', $options);
				?>,
				<?php 
					$options = array('allowBlank'=>false);
					$this->ExtForm->input('COMMODITY', $options);
				?>,
				<?php 
					$options = array('allowBlank'=>false);
					$this->ExtForm->input('BUYER_NAME', $options);
				?>,
				<?php 
					$options = array('allowBlank'=>false);
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $payment_terms;
					$this->ExtForm->input('payment_term_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $currencies;
					$this->ExtForm->input('currency_id', $options);
				?>,
				<?php 
					$options = array('xtype'=>'combo','id'=>'LC_REF_NO','valueField'=>'name');
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $lcs;
					$this->ExtForm->input('LC_REF_NO', $options);
				?>,
				<?php 
					$options = array('id'=>'Advance_amount','fieldLabel'=>'Advance');
					$this->ExtForm->input('Advance_amount', $options);
				?>,
				{
          id:'FCY_AMOUNT',
					xtype:'textfield',
					fieldLabel:'FCY_AMOUNT',
					anchor:'100%',
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
			},
				<?php 
					$options = array('allowBlank'=>false);
					$options['id']="LCY_AMOUNT";
					$this->ExtForm->input('LCY_AMOUNT', $options);
				?>,
				<?php 
					$options = array('allowBlank'=>false);
					$this->ExtForm->input('REMARK', $options);
				?>			]
		});
		
		var IbdExportPermitAddWindow = new Ext.Window({
			title: '<?php __('Add Ibd Export Permit'); ?>',
			width: 500,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: IbdExportPermitAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					IbdExportPermitAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Ibd Export Permit.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(IbdExportPermitAddWindow.collapsed)
						IbdExportPermitAddWindow.expand(true);
					else
						IbdExportPermitAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					IbdExportPermitAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdExportPermitAddForm.getForm().reset();
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
			}, {
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
					IbdExportPermitAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdExportPermitAddWindow.close();
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
					IbdExportPermitAddWindow.close();
				}
			}]
		});
