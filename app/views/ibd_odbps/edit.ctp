		<?php
			$this->ExtForm->create('IbdOdbp');
			$this->ExtForm->defineFieldFunctions();
		?>
		var IbdOdbpEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 150,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ibdOdbps', 'action' => 'edit')); ?>',
			

			items: [
			{
			layout:'column',
            items:[{

			         columnWidth:.5,
						layout: 'form',
						items: [
						<?php $this->ExtForm->input('id', array('hidden' => $ibd_odbp['IbdOdbp']['id'])); ?>,
			<?php 
					$options = array();
					$options['value']=$ibd_odbp['IbdOdbp']['name_of_exporter'];
					$this->ExtForm->input('name_of_exporter', $options);
				?>,
				<?php 
					$options = array('fieldLabel'=>'ODBP Date');
					$options['value']=$ibd_odbp['IbdOdbp']['date'];
					$this->ExtForm->input('date', $options);
				?>,
				
				<?php 
					$options = array('readOnly'=>true);
					$options['value']=$ibd_odbp['IbdOdbp']['ref_no'];
					$this->ExtForm->input('ref_no', $options);
				?>,
				<?php 
					$options = array('fieldLabel'=>'NBE Reference');
					$options['value']=$ibd_odbp['IbdOdbp']['NBE_Ref_no'];
					$this->ExtForm->input('NBE_Ref_no', $options);
				?>,
<?php 
					$options = array('fieldLabel'=>'Permit No');
					$options['value']=$ibd_odbp['IbdOdbp']['permit_no'];
					$this->ExtForm->input('permit_no', $options);
				?>
				,
				<?php 
					$options = array('xtype'=>'combo','fieldLabel'=>'Type');
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $payment_terms;

					$options['value']=$ibd_odbp['IbdOdbp']['type'];
					$this->ExtForm->input('type', $options);
				?>,
				<?php 
					$options = array('xtype'=>'combo','fieldLabel'=>'Currency Type');
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $currencies;
					$options['value']=$ibd_odbp['IbdOdbp']['currency_code'];
					$this->ExtForm->input('currency_code', $options);
				?>,
				<?php 
					$options = array('fieldLabel'=>'Branch Name',);
					$options['value']=$ibd_odbp['IbdOdbp']['Branch_Name'];
					$this->ExtForm->input('Branch_Name', $options);
				?>]},{
                        columnWidth:.5,
						layout: 'form',
						items: [
						<?php 
					$options = array('fieldLabel'=>'Destination',);
					$options['value']=$ibd_odbp['IbdOdbp']['Destination'];
					$this->ExtForm->input('Destination', $options);
				?>,
				
				{
				    id:'fct',
					xtype:'textfield',
					fieldLabel:'Doc. Permitted Amount',
					anchor:'100%',
					name :'data[IbdOdbp][fct]',
					value: '<?php echo $ibd_odbp['IbdOdbp']['fct']; ?>',
					enableKeyEvents:true,
					listeners : {
						 keyup: function(field,e){
							 var value=e.target.value;
							 var other=Ext.getCmp('rate').getValue();
							 var proceed=Ext.getCmp('sett_fcy').getValue();
							 var result=value*other;
							 var ded=proceed-value;
                             Ext.getCmp('lcy').setValue(result);
                             Ext.getCmp('Deduction').setValue(ded);
						}
					}
			     }
				,
				{
				    id:'rate',
					xtype:'textfield',
					fieldLabel:'Rate',
					anchor:'100%',
					name :'data[IbdOdbp][rate]',
					value: '<?php echo $ibd_odbp['IbdOdbp']['rate']; ?>',
					enableKeyEvents:true,
					listeners : {
						 keyup: function(field,e){
							 var value=e.target.value;
							 var other=Ext.getCmp('fct').getValue();
							 var result=value*other;
                             Ext.getCmp('lcy').setValue(result);
						}
					}
			     }
				,
				<?php 
					$options = array('fieldLabel'=>'LCY','id'=>'lcy');
					$options['value']=$ibd_odbp['IbdOdbp']['lcy'];
					$this->ExtForm->input('lcy', $options);
				?>
				,
				<?php 
					$options = array('fieldLabel'=>'Value Date','allowBlank'=>true);
					$options['value']=$ibd_odbp['IbdOdbp']['sett_date'];
					$this->ExtForm->input('sett_date', $options);
				?>	,
				{
				    id:'sett_fcy',
					xtype:'textfield',
					fieldLabel:'Proceed Amount',
					anchor:'100%',
					name :'data[IbdOdbp][sett_fcy]',
					value: '<?php echo $ibd_odbp['IbdOdbp']['sett_fcy']; ?>',
					enableKeyEvents:true,
					listeners : {
						 keyup: function(field,e){
							 var value=e.target.value;
							 var other=Ext.getCmp('fct').getValue();
							 var result=value-other;
                             Ext.getCmp('Deduction').setValue(result);
						}
					}
			     }
				,<?php 
					$options = array('fieldLabel'=>'Deduction','id'=>'Deduction');
					$options['value']=$ibd_odbp['IbdOdbp']['Deduction'];
					$this->ExtForm->input('Deduction', $options);
				?>]}

				]}
					]
		});
		
		var IbdOdbpEditWindow = new Ext.Window({
			title: '<?php __('Edit Ibd Odbp'); ?>',
			width: 700,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: IbdOdbpEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					IbdOdbpEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ibd Odbp.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(IbdOdbpEditWindow.collapsed)
						IbdOdbpEditWindow.expand(true);
					else
						IbdOdbpEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					IbdOdbpEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdOdbpEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentIbdOdbpData();
<?php } else { ?>
							RefreshIbdOdbpData();
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
					IbdOdbpEditWindow.close();
				}
			}]
		});
