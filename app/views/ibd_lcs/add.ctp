		<?php
			$this->ExtForm->create('IbdLc');
			$this->ExtForm->defineFieldFunctions();
		?>
		var IbdLcAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 180,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ibdLcs', 'action' => 'add')); ?>',
			

			items: [
				{
			layout:'column',
            items:[{
						columnWidth:.5,
						layout: 'form',
						items: [
						{
							store: new Ext.data.ArrayStore({ 
								
								fields: [ 'name' ], 
								data: [<?php  echo $permits;  ?>]
							}), 
							xtype: 'combo', 
							name: 'PERMIT_NO', 
							hiddenName: 'data[IbdLc][PERMIT_NO]', 
							fieldLabel: '* PERMIT', 
							typeAhead: true, 
							emptyText: 'Select One', 
							editable: true, 
							forceSelection: true, 
							triggerAction: 'all', 
							lazyRender: true, 
							mode: 'local', 
							valueField: 'name', 
							displayField: 'name', 
							allowBlank: false, 
							anchor: '100%',
							listeners:{

								'select':function(combo,r,i){
									permit=r.data.name;
									 permit=permit.replace(/\//g,"(");
                    Ext.Ajax.request({
		                         url:'<?php echo $this->Html->url(array('controller' => 'IbdLcs', 'action' => 'get_permit_detail')); ?>/'+permit,
		                         success:function(data,opts){
		                            var jsonData = Ext.util.JSON.decode(data.responseText);
		                            console.log(jsonData);
		                          
		                            Ext.getCmp('NAME_OF_IMPORTER').setValue(jsonData[0]['tbl']['NAME_OF_IMPORTER']);
		                            Ext.getCmp('currency_id').setValue(jsonData[0]['tbl']['currency_id']);
		                            Ext.getCmp('FCY_AMOUNT').setValue(jsonData[0]['tbl']['FCY_AMOUNT']);
		                            Ext.getCmp('OUT_FCY_AMOUNT').setValue(jsonData[0]['tbl']['FCY_AMOUNT']);
		                            Ext.getCmp('FCY_APPROVAL_DATE').setValue("");
		                            Ext.getCmp('FCY_APPROVAL_INTIAL_ORDER_NO').setValue("");
								    Ext.getCmp('FROM_THEIR_FCY_ACCOUNT').setValue("");
		                         },
		                         failed:function(data,opts){
		                          Ext.Msg.alert('Status',data);
		                         }
			    		});
								}
							}
						}
					,
				<?php 
					$options = array('id'=>'NAME_OF_IMPORTER','allowBlank'=>false);
					$this->ExtForm->input('NAME_OF_IMPORTER', $options);
				?>,
							<?php 
					$options = array('allowBlank'=>false);
					$this->ExtForm->input('LC_ISSUE_DATE', $options);
				?>,
				
				<?php 
					$options = array('readOnly'=>'true');
					$options['value']=$lc_no;
					$this->ExtForm->input('LC_REF_NO', $options);
				?>,
				
				<?php 
					$options = array('id'=>'currency_id','allowBlank'=>false);
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $currency_types;
					$this->ExtForm->input('currency_id', $options);
				?>,
				{
				    id:'FCY_AMOUNT',
					xtype:'textfield',
					fieldLabel:'FCY_AMOUNT',
					anchor:'100%',
					name :'data[IbdLc][FCY_AMOUNT]',
					enableKeyEvents:true,
					listeners : {
						 keyup: function(field,e){
							 var value=e.target.value;
							 var other=Ext.getCmp('OPENING_RATE').getValue();
							// var other_fcy=Ext.getCmp('SETT_FCY_AMOUNT').getValue();
							// var other_lcy=Ext.getCmp('SETT_LCY_Amt').getValue();
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
					name : 'data[IbdLc][OPENING_RATE]',
					enableKeyEvents:true,
					listeners : {
						 keyup: function(field,e){
							 var value=e.target.value;
							 var other=Ext.getCmp('FCY_AMOUNT').getValue();
							 //var other_lcy=Ext.getCmp('SETT_FCY_AMOUNT').getValue();
							 var result=value*other;
                             Ext.getCmp('LCY_AMOUNT').setValue(result);
							 Ext.getCmp('OUT_BIRR_VALUE').setValue(result);
						}
					}
			}
				,
				
				<?php 
					$options = array('id'=>'LCY_AMOUNT','readOnly'=>'true');
					$this->ExtForm->input('LCY_AMOUNT', $options);
				?>,
					{
				    id:'Margin Amount',
					xtype:'spinnerfield',
					fieldLabel:'Margin %',
					minValue:'0',
					name : 'data[IbdLc][SETT_Margin_Amt]',
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
					fieldLabel:'MARGIN_AMT',
					anchor:'100%',
					name : 'data[IbdLc][MARGIN_AMT]',
					readOnly:true
					
			    }
				
			
						]
						},{
						columnWidth:.5,
						layout: 'form',
						items: [
							
				<?php 
					$options = array('xtype'=>'combo','allowBlank'=>true);
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $banks;
					$this->ExtForm->input('OPEN_THROUGH', $options);
				?>,<?php 
				$options = array('xtype'=>'combo','allowBlank'=>true);
				if(isset($parent_id))
					$options['hidden'] = $parent_id;
				else	
					$options['items'] = $banks;
				$this->ExtForm->input('REIBURSING_BANK', $options);
			?>,

					
				<?php 
				$now=new DateTime('now');
				$now->modify('+90 day');

				$now = $now->format('Y-m-d');
					$options = array();
					$options['value']=$now;
					$this->ExtForm->input('EXPIRY_DATE', $options);
				?>
				
				
							]
             	  },{
						columnWidth:.5,
						layout: 'form',
						items: [	
							<?php 
					$options = array('id'=>'OUT_FCY_AMOUNT','readOnly'=>'true');
					$this->ExtForm->input('OUT_FCY_AMOUNT', $options);
				?>,
				<?php 
					$options = array('id'=>'OUT_BIRR_VALUE','readOnly'=>'true');
					$this->ExtForm->input('OUT_BIRR_VALUE', $options);
				?>,
				<?php 
					$options = array('id'=>'OUT_Margin_Amt','readOnly'=>'true');
					$this->ExtForm->input('OUT_Margin_Amt', $options);
				?>	
						]
             	  }]
				}
				
					]
		});
		
		var IbdLcAddWindow = new Ext.Window({
			title: '<?php __('LC Registration'); ?>',
			width: 800,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: IbdLcAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					IbdLcAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Ibd Lc.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(IbdLcAddWindow.collapsed)
						IbdLcAddWindow.expand(true);
					else
						IbdLcAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					IbdLcAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdLcAddForm.getForm().reset();
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
			}, {
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
					IbdLcAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdLcAddWindow.close();
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
					IbdLcAddWindow.close();
				}
			}]
		});
