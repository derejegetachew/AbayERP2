		<?php
			$this->ExtForm->create('IbdOdbp');
			$this->ExtForm->defineFieldFunctions();
		?>
		var IbdOdbpAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 150,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ibdOdbps', 'action' => 'add')); ?>',
			

			items: [
			{
			layout:'column',
            items:[{

			         columnWidth:.5,
						layout: 'form',
						items: [
			<?php 
					$options = array('allowBlank'=>false);
					$this->ExtForm->input('name_of_exporter', $options);
				?>,
				<?php 
					$options = array('fieldLabel'=>'ODBP Date','allowBlank'=>false);
					$this->ExtForm->input('date', $options);
				?>,
				
				<?php 
					$options = array('readOnly'=>true);
					$options['value']=$refno;
					$this->ExtForm->input('ref_no', $options);
				?>,
				<?php 
					$options = array('fieldLabel'=>'NBE Reference','allowBlank'=>false);
					$this->ExtForm->input('NBE_Ref_no', $options);
				?>,
<?php 
					$options = array('fieldLabel'=>'Permit No','xtype'=>'combo','valueField'=>'name');
					$options['items']=$permits;
					$this->ExtForm->input('permit_no', $options);
				?>
				,
				<?php 
					$options = array('xtype'=>'combo','fieldLabel'=>'Type','allowBlank'=>false);
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $payment_terms;
					$this->ExtForm->input('type', $options);
				?>,
				<?php 
					$options = array('xtype'=>'combo','fieldLabel'=>'Currency Type','allowBlank'=>false);
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $currencies;
					$this->ExtForm->input('currency_code', $options);
				?>,
				<?php 
					$options = array('fieldLabel'=>'Branch Name','allowBlank'=>false);
					$this->ExtForm->input('Branch_Name', $options);
				?>
				]},{
                        columnWidth:.5,
						layout: 'form',
						items: [
							<?php 
					$options = array('fieldLabel'=>'Destination','allowBlank'=>false);
					$this->ExtForm->input('Destination', $options);
				?>,
				
				{
				    id:'fct',
					xtype:'textfield',
					fieldLabel:'Doc. Permitted Amount',
					anchor:'100%',
					name :'data[IbdOdbp][fct]',
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
					$this->ExtForm->input('lcy', $options);
				?>
				,
				<?php 
					$options = array('fieldLabel'=>'Value Date','allowBlank'=>true);
					$this->ExtForm->input('sett_date', $options);
				?>	,
				{
				    id:'sett_fcy',
					xtype:'textfield',
					fieldLabel:'Proceed Amount',
					anchor:'100%',
					name :'data[IbdOdbp][sett_fcy]',
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
					$this->ExtForm->input('Deduction', $options);
				?>]}

				]}

					]
		});
		
		var IbdOdbpAddWindow = new Ext.Window({
			title: '<?php __('Add Ibd Odbp'); ?>',
			width: 800,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: IbdOdbpAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					IbdOdbpAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Ibd Odbp.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(IbdOdbpAddWindow.collapsed)
						IbdOdbpAddWindow.expand(true);
					else
						IbdOdbpAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					IbdOdbpAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdOdbpAddForm.getForm().reset();
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
			}, {
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
					IbdOdbpAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdOdbpAddWindow.close();
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
					IbdOdbpAddWindow.close();
				}
			}]
		});
