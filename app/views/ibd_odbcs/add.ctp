		<?php
			$this->ExtForm->create('IbdOdbc');
			$this->ExtForm->defineFieldFunctions();
		?>
		var IbdOdbcAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 150,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ibdOdbcs', 'action' => 'add')); ?>',
			

			items: [
			{
			layout:'column',
            items:[
            {

			         columnWidth:.5,
						layout: 'form',
						items: [
				<?php 
					$options = array('allowBlank'=>false);
					$this->ExtForm->input('Exporter_Name', $options);
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
					$options = array('readOnly'=>true);
					$options['value']=$permit_no;
					$this->ExtForm->input('Doc_Ref', $options);
				?>,
				<?php 
					$options = array('xtype'=>'combo','allowBlank'=>false);
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $permit;
					$this->ExtForm->input('Permit_No', $options);
				?>,
				<?php 
					$options = array('allowBlank'=>false);
					$this->ExtForm->input('NBE_Permit_no', $options);
				?>,
				<?php 
					$options = array('allowBlank'=>false);
					$this->ExtForm->input('Branch_Name', $options);
				?>,
				<?php 
					$options = array('allowBlank'=>false);
					$this->ExtForm->input('ODBC_DD', $options);
				?>,
				<?php 
					$options = array('allowBlank'=>false);
					$this->ExtForm->input('Destination', $options);
				?>
				
				]},
				{
                   columnWidth:.5,
						layout: 'form',
						items: [
						<?php 
					$options = array('allowBlank'=>false);
					$this->ExtForm->input('Single_Ent', $options);
				?>,
				
				<?php 
					$options = array('allowBlank'=>false);
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $currency_types;
					$this->ExtForm->input('currency_id', $options);
				?>,
				{
				    id:'doc_permitt_amount',
					xtype:'textfield',
					fieldLabel:'Doc. Permitted Amount',
					anchor:'100%',
					name :'data[IbdOdbc][doc_permitt_amount]',
					enableKeyEvents:true,
					listeners : {
						 keyup: function(field,e){
							 var value=e.target.value;
							 var other=Ext.getCmp('rate').getValue();
							 var proceed=Ext.getCmp('proceed_amount').getValue();
							 var result=value*other;
							 var ded=proceed-value;
                             Ext.getCmp('lcy').setValue(result);
                             Ext.getCmp('Deduction').setValue(ded);
						}
					}
			     },
				<?php 
					$options = array('allowBlank'=>false);
					$this->ExtForm->input('value_date', $options);
				?>,
				{
				    id:'proceed_amount',
					xtype:'textfield',
					fieldLabel:'Proceed Amount',
					anchor:'100%',
					name :'data[IbdOdbc][proceed_amount]',
					enableKeyEvents:true,
					listeners : {
						 keyup: function(field,e){
							 var value=e.target.value;
							 var other=Ext.getCmp('doc_permitt_amount').getValue();
							 var result=value-other;
                             Ext.getCmp('Deduction').setValue(result);
						}
					}
			     },
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
							 var other=Ext.getCmp('doc_permitt_amount').getValue();
							 var result=value*other;
                             Ext.getCmp('lcy').setValue(result);
						}
					}
			     }
				,
				<?php 
					$options = array('id'=>'lcy','allowBlank'=>false);
					$this->ExtForm->input('lcy', $options);
				?>,
				<?php 
					$options = array('id'=>'Deduction','allowBlank'=>false);
					$this->ExtForm->input('Deduction', $options);
				?>		
				]}
					]

				}]

		});
		
		var IbdOdbcAddWindow = new Ext.Window({
			title: '<?php __('Add Ibd Odbc'); ?>',
			width: 700,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: IbdOdbcAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					IbdOdbcAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Ibd Odbc.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(IbdOdbcAddWindow.collapsed)
						IbdOdbcAddWindow.expand(true);
					else
						IbdOdbcAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					IbdOdbcAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdOdbcAddForm.getForm().reset();
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
			}, {
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
					IbdOdbcAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdOdbcAddWindow.close();
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
					IbdOdbcAddWindow.close();
				}
			}]
		});
