		<?php
			$this->ExtForm->create('IbdImportPermit');
			$this->ExtForm->defineFieldFunctions();
		?>

		var IbdImportPermitAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 190,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ibdImportPermits', 'action' => 'add')); ?>',
			

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
					$this->ExtForm->input('NAME_OF_IMPORTER', $options);
				?>,
							<?php 
					$options = array('allowBlank'=>false);
					$this->ExtForm->input('PERMIT_ISSUE_DATE', $options);

				?>,
				
				<?php 
					$options = array();
					$options['value']=$permit;
					$options['readOnly']=true;
					$this->ExtForm->input('IMPORT_PERMIT_NO', $options);
				?>,
				<?php 
					$options = array('allowBlank'=>false);
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $currencies;
					$this->ExtForm->input('currency_id', $options);
				?>
				,
			{
				    id:'FCY_AMOUNT',
					xtype:'textfield',
					fieldLabel:'FCY_AMOUNT',
					anchor:'100%',
					name :'data[IbdImportPermit][FCY_AMOUNT]',
					enableKeyEvents:true,
					listeners : {
						 keyup: function(field,e){
							 var value=e.target.value;
							 var other=Ext.getCmp('PREVAILING_RATE').getValue();
							 var result=value*other;
                             Ext.getCmp('LCY_AMOUNT').setValue(result);

						}
					}
			},
			{
				    id:'PREVAILING_RATE',
					xtype:'textfield',
					fieldLabel:'PREVAILING_RATE',
					anchor:'100%',
					name : 'data[IbdImportPermit][PREVAILING_RATE]',
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
				{  store: new Ext.data.ArrayStore({ 
					id: 0, fields: [ 'id', 'name' ], 
					data: [ <?php $st = false;  foreach ($payment_terms as $k => $v) {
                    if ($st)
                        echo ',';
                    echo '[\'' . $k . '\', \'' . $v . '\']';
                    $st = true;
                    } ?> ]}), 
				    xtype: 'combo', 
				    name: 'payment_term_id', 
				    hiddenName: 'data[IbdImportPermit][payment_term_id]', 
				    fieldLabel: 'Payment Term', 
				    typeAhead: true, 
				    emptyText: 'Select One', 
				    editable: true, 
				    forceSelection: true, 
				    triggerAction: 'all', 
				    lazyRender: true, 
				    mode: 'local', 
				    valueField: 'id', 
				    displayField: 'name', 
				    allowBlank: false, 
				    anchor: '100%',
				    listeners : {
						 select: function(field,r,i){
						 	if(r.data.name=="LC"){
						 		<?php
					 			$now=new DateTime('now');
					         	$now->modify('+4 month');
					            $now = $now->format('Y-m-d'); ?>
					            Ext.getCmp('EXPIRE_DTAE').setValue('<?php echo $now;  ?>');
					           
						 	}else{
						 	<?php
						 	unset($now);
					 			$now=new DateTime('now');
					         	$now->modify('+1 month');
					            $now = $now->format('Y-m-d'); ?>
					            Ext.getCmp('EXPIRE_DTAE').setValue('<?php echo $now;  ?>');
						 	}
						 	
							// Ext.Msg.alert('Test',r.data.name);
						}
					}
				},
				<?php 
					$options = array('allowBlank'=>false,'fieldLabel'=>'REFERENCE NO');
					$this->ExtForm->input('REF_NO', $options);
				?>
				,
				<?php 
					$options = array('allowBlank'=>false);
					$this->ExtForm->input('ITEM_DESCRIPTION_OF_GOODS', $options);
				?>
						]
						},{
						columnWidth:.5,
						layout: 'form',
						items: [
				<?php 
					$options = array('allowBlank'=>false);
					$this->ExtForm->input('SUPPLIERS_NAME', $options);
				?>,
				<?php 
					$options = array('allowBlank'=>false);
					$this->ExtForm->input('MINUTE_NO', $options);
				?>,
				<?php 
					$options = array('allowBlank'=>false);
					$this->ExtForm->input('FCY_APPROVAL_DATE', $options);
				?>,
				<?php 
					$options = array('id'=>'EXPIRE_DTAE','fieldLabel'=>'EXPIRE DATE');
					//$now=new DateTime('now');
					//$now->modify('+4 month');
					//$now = $now->format('Y-m-d');
					//$options['value']=$now;
					$this->ExtForm->input('EXPIRE_DTAE', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('FCY_APPROVAL_INTIAL_ORDER_NO', $options);
				?>,
				<?php 
					$options = array('xtype'=>'combo','allowBlank'=>false);
					$list=array('RETENTION ACCOUNT'=>'RETENTION ACCOUNT','DIASPORA'=>'DIASPORA','NR FCY ACCOUNT'=>'NR FCY ACCOUNT','SUPPLIERS_CREDIT'=>'SUPPLIERS CREDIT','SPECIAL PERMIT'=>'SPECIAL PERMIT','BIRR ACCOUNT'=>'BIRR ACCOUNT');
					$options['items'] = $list;
					$this->ExtForm->input('FROM_THEIR_FCY_ACCOUNT', $options);
				?>,
				<?php 
					$options = array('xtype'=>'combo','allowBlank'=>false);
					$list=array('YES'=>'YES','NO'=>'NO');
					$options['items'] = $list;
					$this->ExtForm->input('THE_PRICE_AS_PER_NBE_SELLECTED', $options);
				?>,
				<?php 
					$options = array('xtype'=>'combo','allowBlank'=>false);
					$list=array('YES'=>'YES','NO'=>'NO');
					$options['items'] = $list;
					$this->ExtForm->input('NBE_UNDERTAKING', $options);
				?>,
				<?php 
					$options = array('id'=>'ACCOUNT','allowBlank'=>false);
					$this->ExtForm->input('NBE_ACCOUNT', $options);
				?>,
				<?php 
					$options = array('allowBlank'=>false);
					$options["id"]="REMARK";
					$this->ExtForm->input('REMARK', $options);
				?>

					]
             	  }]
				}
            ]
		});
		
		var IbdImportPermitAddWindow = new Ext.Window({
			title: '<?php __('Add Ibd Import Permit'); ?>',
			width: 1000,
			minWidth: 500,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: IbdImportPermitAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					IbdImportPermitAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Ibd Import Permit.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(IbdImportPermitAddWindow.collapsed)
						IbdImportPermitAddWindow.expand(true);
					else
						IbdImportPermitAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					IbdImportPermitAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdImportPermitAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentIbdImportPermitData();
<?php } else { ?>
							RefreshIbdImportPermitData();
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
					IbdImportPermitAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdImportPermitAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentIbdImportPermitData();
<?php } else { ?>
							RefreshIbdImportPermitData();
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
					IbdImportPermitAddWindow.close();
				}
			}]
		});



    
