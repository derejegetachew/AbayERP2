		<?php
			$this->ExtForm->create('IbdIbc');
			$this->ExtForm->defineFieldFunctions();
		?>
		var remaining=0;
		var canPost=true;
		var IbdIbcAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 180,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ibdIbcs', 'action' => 'update_po')); ?>',
			defaultType: 'textfield',

			items: [
			  {  
				    store: new Ext.data.ArrayStore({ 
				    	id: 0, fields: [ 'id', 'name' ], 
					data: [ <?php $st = false;  foreach ($purchase as $k => $v) {
                    if ($st)
                        echo ',';
                    echo '[\'' . $k . '\', \'' . $v . '\']';
                    $st = true;
                    } ?> ]}), 
				    xtype: 'combo', 
				    id: 'PURCHASE_ORDER_NO', 
				    name: 'data[IbdIbc][PURCHASE_ORDER_NO]', 
				    fieldLabel: 'PURCHASE ORDER NO', 
				    typeAhead: true, 
				    emptyText: 'Select One', 
				    editable: true, 
				    forceSelection: true, 
				    triggerAction: 'all', 
				    lazyRender: true, 
				    value:'<?php echo $ibcs[0]['IbdIbc']['PURCHASE_ORDER_NO']; ?>',
				    mode: 'local', 
				    valueField: 'id', 
				    displayField: 'name', 
				    allowBlank: false, 
				    anchor: '100%',
				    listeners : {
						 select: function(field,r,i){
						var permit=r.data.name;
						permit=permit.replace(/\//g,"(");
						

					Ext.Ajax.request({
                         url:'<?php echo $this->Html->url(array('controller' => 'ibdPurchaseOrders', 'action' => 'get_po_importer')); ?>/'+permit,
                         success:function(data,opts){
                            var jsonData = Ext.util.JSON.decode(data.responseText);
							console.log(jsonData);
                           
                            Ext.getCmp('NAME_OF_IMPORTER').setValue(jsonData[0]['ibd_purchase_orders']['NAME_OF_IMPORTER']);
                            Ext.getCmp('currency').setValue(jsonData[0]['ibd_purchase_orders']['currency_id']);
                            Ext.getCmp('percent').setValue(jsonData[0]['ibd_purchase_orders']['percent']);
                            Ext.getCmp('rate').setValue(jsonData[0]['ibd_purchase_orders']['RATE']);
                            remaining=jsonData[0]['ibd_purchase_orders']['REM_FCY_AMOUNT'];
                            console.log(remaining);
                         },
                         failed:function(data,opts){
                          Ext.Msg.alert('Status',data);
                         }
			    		});

						}
					}
				},
                  
				 <?php 
				
					$options = array('id'=>'NAME_OF_IMPORTER','value'=>$ibcs[0]['IbdIbc']['NAME_OF_IMPORTER']);
					$this->ExtForm->input('NAME_OF_IMPORTER', $options);
				?>
			 ,
				 <?php 
					$options = array('id'=>'currency','value'=>$ibcs[0]['IbdIbc']['currency_id']);
					$this->ExtForm->input('currency', $options);
				?>
				,
				<?php 
				$options = array('value'=>$ibcs[0]['IbdIbc']['ISSUE_DATE']);
				$this->ExtForm->input('ISSUE_DATE', $options);
		     	?>,
				<?php 
				$options = array('id'=>'PERMIT_NO','allowBlank'=>true,'value'=>$ibcs[0]['IbdIbc']['PERMIT_NO']);
				$this->ExtForm->input('PERMIT_NO', $options);
		     	?>,
				<?php 
				$options = array('id'=>'DRAWER_BANK','fieldLabel'=>'DRAWER BANK','allowBlank'=>true,'value'=>$ibcs[0]['IbdIbc']['REMITTING_BANK']);
				$this->ExtForm->input('REMITTING_BANK',$options);
		     	?>,
				<?php 
				$options = array('xtype'=>'combo','allowBlank'=>true,'value'=>$ibcs[0]['IbdIbc']['REIBURSING_BANK']);
				if(isset($parent_id))
					$options['hidden'] = $parent_id;
				else
					$options['items'] = $banks;
				$this->ExtForm->input('REIBURSING_BANK', $options);
		     	?>,
				<?php 
					$options = array('value'=>$ibc_no,'readOnly'=>'true');
					$this->ExtForm->input('IBC_REFERENCE', $options);
				?>,
				{
				xtype: 'textfield', 
				fieldLabel: 'SETT FCY', 
				id:'SETT_FCY',
				name: 'data[IbdIbc][SETT_FCY]', 
				anchor: '100%' ,
				value: '<?php echo $ibcs[0]['IbdIbc']['SETT_FCY']  ?>',
				enableKeyEvents:true,
				listeners:{
					keyup:function(object,e){

					 	var value=e.target.value;
					 	
					 	var p=Ext.getCmp('percent').getValue();
					 	var r=Ext.getCmp('rate').getValue();

					 	var lcy=((value*r)*p)/100;
					 	  // lcy=	Math.ceil(lcy).toFixed(4);
					 	Ext.getCmp('lcy').setValue(lcy);
						console.log(parseFloat(e.target.value)>parseFloat(remaining));
						if(parseFloat(e.target.value)>parseFloat(remaining)){

							canPost=false;
							
						}else{canPost=true;}
                       
					}
				}
			    },
			    
				{
				    id:'percent',
					xtype:'spinnerfield',
					fieldLabel:'Collected %',
					anchor:'100%',
					minValue:'0',
					maxValue:'100',
					name : 'data[IbdIbc][percent]',
					value: '<?php echo $ibcs[0]['IbdIbc']['percent']  ?>',
					enableKeyEvents:true,
					listeners : {
						 keyup: function(field,e){
							var value=e.target.value;
					 	
					 	var s=Ext.getCmp('SETT_FCY').getValue();
					 	var r=Ext.getCmp('rate').getValue();

					 	var lcy=((s*r)*value)/100;
					    // lcy=	Math.ceil(lcy).toFixed(4);
					 	Ext.getCmp('lcy').setValue(lcy);
						}
					}
				}
				, 
				<?php 
					$options = array('id'=>'lcy','readOnly'=>true,'value'=>$ibcs[0]['IbdIbc']['SETT_Amount']);
					$this->ExtForm->input('SETT_Amount', $options);
				?>,
			    
				<?php 
					$options = array('allowBlank'=>true,'value'=>$ibcs[0]['IbdIbc']['FCY_APPROVAL_INITIAL_NO']);
					$this->ExtForm->input('FCY_APPROVAL_INITIAL_NO', $options);
				?>
				]
		});
		
		var IbdIbcAddWindow = new Ext.Window({
			title: '<?php __('Add Ibd Ibc'); ?>',
			width: 500,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: IbdIbcAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					IbdIbcAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Ibd Ibc.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(IbdIbcAddWindow.collapsed)
						IbdIbcAddWindow.expand(true);
					else
						IbdIbcAddWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Update PO'); ?>',
				handler: function(btn){
           if(canPost){
					IbdIbcAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdIbcAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentIbdIbcData();
<?php } else { ?>
							RefreshIbdIbcData();
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
					}else{
						Ext.Msg.alert('Info','Insufficient Amount. Please Check the IBC FCY Amount')
					}
				}
			},{
				text: '<?php __('Cancel'); ?>',
				handler: function(btn){
					IbdIbcAddWindow.close();
				}
			}]
		});
