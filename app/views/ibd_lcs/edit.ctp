		<?php
			$this->ExtForm->create('IbdLc');
			$this->ExtForm->defineFieldFunctions();
		?>
		var IbdLcEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 180,
			
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ibdLcs', 'action' => 'edit')); ?>',
			

			items: [
				{
			layout:'column',
            items:[{
						columnWidth:.5,
						layout: 'form',
						items: [
				<?php $this->ExtForm->input('id', array('hidden' => $ibd_lc['IbdLc']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_lc['IbdLc']['LC_ISSUE_DATE'];
					$this->ExtForm->input('LC_ISSUE_DATE', $options);
				?>
				,
				<?php 
					$options = array();
					$options['value'] = $ibd_lc['IbdLc']['NAME_OF_IMPORTER'];
					$this->ExtForm->input('NAME_OF_IMPORTER', $options);
				?>
				,
				<?php 
					$options = array('readOnly'=>'true');
					$options['value'] = $ibd_lc['IbdLc']['LC_REF_NO'];
					$this->ExtForm->input('LC_REF_NO', $options);
				?>
				,
				<?php 
					$options = array();
					$options['value'] = $ibd_lc['IbdLc']['PERMIT_NO'];
					$this->ExtForm->input('PERMIT_NO', $options);
				?>
				,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $currency_types;
					$options['value'] = $ibd_lc['IbdLc']['currency_id'];
					$this->ExtForm->input('currency_id', $options);
				?>
				,
				{
				    id:'FCY_AMOUNT',
					xtype:'textfield',
					fieldLabel:'FCY_AMOUNT',
					anchor:'100%',
					value:'<?php echo $ibd_lc['IbdLc']['FCY_AMOUNT']; ?>',
					name :'data[IbdLc][FCY_AMOUNT]',
					enableKeyEvents:true,
					listeners : {
						 keyup: function(field,e){
							 var value=e.target.value;
							 var other=Ext.getCmp('OPENING_RATE').getValue();
							 
							 var result=value*other;
							 Ext.getCmp('LCY_AMOUNT').setValue(result);
                             Ext.getCmp('OUT_FCY_AMOUNT').setValue(value);
							 Ext.getCmp('OUT_BIRR_VALUE').setValue(result);
							 
						}
					}
			    }
				,

				{
				    id:'OPENING_RATE',
					xtype:'textfield',
					fieldLabel:'OPENING_RATE',
					anchor:'100%',
					value:'<?php echo  $ibd_lc['IbdLc']['OPENING_RATE'];  ?>',
					name : 'data[IbdLc][OPENING_RATE]',
					enableKeyEvents:true,
					listeners : {
						 keyup: function(field,e){
							 var value=e.target.value;
							 var other=Ext.getCmp('FCY_AMOUNT').getValue();
							 
							 var result=value*other;
                             Ext.getCmp('LCY_AMOUNT').setValue(result);
							 Ext.getCmp('OUT_BIRR_VALUE').setValue(result);
						}
					}
			}
				,
				<?php 
					$options = array('id'=>'LCY_AMOUNT','readOnly'=>'true');
					$options['value'] = $ibd_lc['IbdLc']['LCY_AMOUNT'];
					$this->ExtForm->input('LCY_AMOUNT', $options);
				?>
				,
				{
				    id:'Margin Amount',
					xtype:'spinnerfield',
					fieldLabel:'Margin %',
					minValue:'0',
					name : 'data[IbdLc][SETT_Margin_Amt]',
					value:'<?php echo  $ibd_lc['IbdLc']['SETT_Margin_Amt']; ?>',
					maxValue:'100',
					anchor:'100%',
					enableKeyEvents:true,
					listeners : {
						 keyup: function(field,e){
							 var value=e.target.value;
							 var other=Ext.getCmp('LCY_AMOUNT').getValue();
							 other=(other*value)/100;
                             Ext.getCmp('OUT_Margin_Amt').setValue(other);
                              Ext.getCmp('MARGIN_AMT').setValue(other);
						}
					}
			    }
				,
				{
				    id:'MARGIN_AMT',
					xtype:'textfield',
					fieldLabel:'MARGIN AMT',
					anchor:'100%',
					value:'<?php echo  $ibd_lc['IbdLc']['MARGIN_AMT']; ?>',
					name : 'data[IbdLc][MARGIN_AMT]',
					enableKeyEvents:true,
					listeners : {
						 keyup: function(field,e){
							 var value=e.target.value;
							 var other=Ext.getCmp('SETT_Margin_Amt').getValue();
                             Ext.getCmp('OUT_Margin_Amt').setValue(value-other);
						}
					}
			}
				
					]
						}
						,
						{
						columnWidth:.5,
						layout: 'form',
						items: [

				
				<?php 
					$options = array('xtype'=>'combo','allowBlank'=>true);
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else	
						$options['items'] = $banks;
					$options['value'] = $ibd_lc['IbdLc']['OPEN_THROUGH'];
					$this->ExtForm->input('OPEN_THROUGH', $options);
				?>
				,
				<?php 
					$options = array('xtype'=>'combo','allowBlank'=>true);
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else	
						$options['items'] = $banks;
					$options['value'] = $ibd_lc['IbdLc']['REIBURSING_BANK'];
					$this->ExtForm->input('REIBURSING_BANK', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_lc['IbdLc']['EXPIRY_DATE'];
					$this->ExtForm->input('EXPIRY_DATE', $options);
				?>
					]
             	  }
             	  
             	  

             	  ,
             	  {
						columnWidth:.5,
						layout: 'form',
						items: [	
				<?php 
					$options = array('id'=>'OUT_FCY_AMOUNT','readOnly'=>'true');
					$options['value'] = $ibd_lc['IbdLc']['OUT_FCY_AMOUNT'];
					$this->ExtForm->input('OUT_FCY_AMOUNT', $options);
				?>
				,
				<?php 
					$options = array('id'=>'OUT_BIRR_VALUE','readOnly'=>'true');
					$options['value'] = $ibd_lc['IbdLc']['OUT_BIRR_VALUE'];
					$this->ExtForm->input('OUT_BIRR_VALUE', $options);
				?>
				,
				<?php 
					$options = array('id'=>'OUT_Margin_Amt','readOnly'=>'true');
					$options['value'] = $ibd_lc['IbdLc']['OUT_Margin_Amt'];
					$this->ExtForm->input('OUT_Margin_Amt', $options);
				?>			
					]
					}]
				}
		 ]
		});
		
		var IbdLcEditWindow = new Ext.Window({
			title: '<?php __('Edit LC Entry'); ?>',
			width: 800,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: IbdLcEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					IbdLcEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ibd Lc.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(IbdLcEditWindow.collapsed)
						IbdLcEditWindow.expand(true);
					else
						IbdLcEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					IbdLcEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdLcEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentIbdLcData();
<?php } else { ?>
							RefreshIbdLcData();
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
					IbdLcEditWindow.close();
				}
			}]
		});
