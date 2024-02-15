		<?php
			$this->ExtForm->create('IbdTt');
			$this->ExtForm->defineFieldFunctions();
		?>
		var IbdTtAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 200,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ibdTts', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
			{
				xtype:'combo',
				id:'permitType',
				name:'data[IbdTt][permitType]',
			    typeAhead: true,
			    triggerAction: 'all',
			    lazyRender:true,
			    mode: 'local',
			    emptyText:'Select One',
			    anchor: '100%',
			    fieldLabel:'TYPES_OF_ADVANCE_PAYMENT',
			    store: new Ext.data.ArrayStore({
			        id: 0,
			        fields: [
			            'myId',
			            'displayText'
			        ],
			        data: [[1,'VISIBLE'],[2,'INVISBLE']]
			    }),
			    valueField: 'displayText',
			    displayField: 'displayText',
			    listeners:{
			    	'select': function(combo,r,i){
			    		
			    		Ext.Ajax.request({
                         url:'<?php echo $this->Html->url(array('controller' => 'IbdTts', 'action' => 'get_permit')); ?>/'+r.data.displayText,
                         success:function(data,opts){
                             var jsonData = Ext.util.JSON.decode(data.responseText);
                             // var obj =JSON.parse(data.responseText);
                              //console.log(jsonData);
                              var convertData = [];
						for (var i = 0; i < jsonData.length; i++) {
							
						convertData.push([jsonData[i].tbl.name]);
						}
						 console.log(convertData);
                              var store = new Ext.data.ArrayStore({
										 fields: ['name'],
										 data : convertData
										});
                             
                              Ext.getCmp('PERMIT_NO').bindStore(store);
                             
                            //Ext.Msg.alert('Status',data);

                            Ext.getCmp('NAME_OF_APPLICANT').setValue("");
                            Ext.getCmp('currency_id').setValue("");
                            Ext.getCmp('FCY_AMOUNT').setValue("");
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

			},
			
				
				{

				xtype:'combo',
				id:'PERMIT_NO',
			    typeAhead: true,
			    triggerAction: 'all',
			    lazyRender:true,
			    mode: 'local',
			    name : 'data[IbdTt][PERMIT_NO]',
			    emptyText:'Select One',
			    anchor: '100%',
			    fieldLabel:'PERMIT_NO',
			     valueField: 'name',
			    displayField: 'name',
			    listeners:{
			    	'select':function(combo,r,i){
			    		 
                     var type=Ext.getCmp('permitType').getValue();
                     
                     
                     var permit=r.data.name;
                     permit=permit.replace(/\//g,"(");
                       Ext.Ajax.request({
                         url:'<?php echo $this->Html->url(array('controller' => 'IbdTts', 'action' => 'get_permit_detail')); ?>/'+permit+"/"+type,
                         success:function(data,opts){
                            var jsonData = Ext.util.JSON.decode(data.responseText);
							
                             
                            Ext.getCmp('NAME_OF_APPLICANT').setValue("");
                            Ext.getCmp('currency_id').setValue("");
                            Ext.getCmp('FCY_AMOUNT').setValue("");
                            Ext.getCmp('FCY_APPROVAL_DATE').setValue("");
                            Ext.getCmp('FCY_APPROVAL_INTIAL_ORDER_NO').setValue("");
						    Ext.getCmp('FROM_THEIR_FCY_ACCOUNT').setValue("");

						    Ext.getCmp('rate').setValue("");
						    Ext.getCmp('LCY_AMOUNT').setValue("");

                           
                            if(type=="VISIBLE"){

                            Ext.getCmp('NAME_OF_APPLICANT').setValue(jsonData[0]['tbl']['NAME_OF_IMPORTER']);
                            Ext.getCmp('currency_id').setValue(jsonData[0]['tbl']['currency_id']);
                            Ext.getCmp('FCY_AMOUNT').setValue(jsonData[0]['tbl']['FCY_AMOUNT']);
                            Ext.getCmp('FCY_APPROVAL_DATE').setValue(jsonData[0]['tbl']['FCY_APPROVAL_DATE']);
                            Ext.getCmp('FCY_APPROVAL_INTIAL_ORDER_NO').setValue(jsonData[0]['tbl']['FCY_APPROVAL_INTIAL_ORDER_NO']);
						    Ext.getCmp('FROM_THEIR_FCY_ACCOUNT').setValue(jsonData[0]['tbl']['FROM_THEIR_FCY_ACCOUNT']);

						    Ext.getCmp('rate').setValue(jsonData[0]['tbl']['PREVAILING_RATE']);
						       Ext.getCmp('LCY_AMOUNT').setValue(jsonData[0]['tbl']['LCY_AMOUNT']);

						    }else if(type=="INVISBLE"){

						       Ext.getCmp('NAME_OF_APPLICANT').setValue(jsonData[0]['tbl']['NAME_OF_APPLICANT']);
						       Ext.getCmp('FROM_LCY_ACCOUNT').setValue(jsonData[0]['tbl']['FROM_THEIR_LCY_ACCOUNT']);
						       Ext.getCmp('FCY_AMOUNT').setValue(jsonData[0]['tbl']['FCY_AMOUNT']);
						       Ext.getCmp('rate').setValue(jsonData[0]['tbl']['rate']);
						       Ext.getCmp('LCY_AMOUNT').setValue(jsonData[0]['tbl']['LCY_AMOUNT']);
						       Ext.getCmp('currency_id').setValue(jsonData[0]['tbl']['currency_id']);

						    }
                              
                             
                            
                         },
                         failed:function(data,opts){
                          Ext.Msg.alert('Status',data);
                         }
			    		});

			    	}
			    }
				},
				<?php 
					$options = array('id'=>'NAME_OF_APPLICANT','readOnly'=>true);
					$this->ExtForm->input('NAME_OF_APPLICANT', $options);
				?>,
				<?php 
					$options = array('id'=>'beneficiary_name','readOnly'=>false);
					$this->ExtForm->input('beneficiary_name', $options);
				?>
				,
				<?php 
					$options = array();
					$this->ExtForm->input('DATE_OF_ISSUE', $options);
				?>,
				
				<?php 
					$options = array('id'=>'currency_id','readOnly'=>true);
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $currencies;
					$this->ExtForm->input('currency_id', $options);
				?>,
				<?php 
					$options = array('id'=>'FCY_AMOUNT','readOnly'=>true);
					$this->ExtForm->input('FCY_AMOUNT', $options);
				?>,
				<?php 
					$options = array('id'=>'rate','readOnly'=>true);
					$this->ExtForm->input('rate', $options);
				?>,

				<?php 
					$options = array('id'=>'LCY_AMOUNT','readOnly'=>true);
					$this->ExtForm->input('LCY_AMOUNT', $options);
				?>,
				<?php 
					$options = array('value'=>$tt_no,'readOnly'=>'true','allowBlank'=>false);
					$this->ExtForm->input('TT_REFERENCE', $options);
				?>
				,
				<?php 
					$options = array('id'=>'REIBURSING_BANK','xtype'=>'combo','valueField'=>'name');
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $REIBURSING;
					$this->ExtForm->input('REIBURSING_BANK', $options);
				?>
				,
				<?php 
					$options = array('id'=>'FCY_APPROVAL_DATE','allowBlank'=>false);
					$this->ExtForm->input('FCY_APPROVAL_DATE', $options);
				?>,
				<?php 
					$options = array('id'=>'FCY_APPROVAL_INTIAL_ORDER_NO','allowBlank'=>false);
					$this->ExtForm->input('FCY_APPROVAL_INTIAL_ORDER_NO', $options);
				?>,
				<?php 
				
					$options = array('xtype'=>'combo','id'=>'FROM_THEIR_FCY_ACCOUNT','allowBlank'=>false);
					$list=array('RETENTION A'=>'RETENTION A','RETENTION B'=>'RETENTION B','DIASPORA'=>'DIASPORA','NRNT'=>'NRNT','NRFC'=>'NRFC','SUPPLIERS_CREDIT'=>'SUPPLIERS CREDIT','BIRR_ACCOUNT'=>'BIRR ACCOUNT');
					$options['items'] = $list;
					$this->ExtForm->input('FROM_THEIR_FCY_ACCOUNT', $options);
				?>,
				<?php 
				
					$options = array('xtype'=>'combo','id'=>'FROM_LCY_ACCOUNT','allowBlank'=>false);
					$list=array('BIRR_ACCOUNT'=>'BIRR ACCOUNT');
					$options['items'] = $list;
					$this->ExtForm->input('FROM_LCY_ACCOUNT', $options);
				?>,
				<?php 
					$options = array('allowBlank'=>false);
					$this->ExtForm->input('REMARK', $options);
				?>			]
		});
		
		var IbdTtAddWindow = new Ext.Window({
			title: '<?php __('Add TT'); ?>',
			width: 500,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: IbdTtAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					IbdTtAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Ibd Tt.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(IbdTtAddWindow.collapsed)
						IbdTtAddWindow.expand(true);
					else
						IbdTtAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					IbdTtAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdTtAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentIbdTtData();
<?php } else { ?>
							RefreshIbdTtData();
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
					IbdTtAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdTtAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentIbdTtData();
<?php } else { ?>
							RefreshIbdTtData();
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
					IbdTtAddWindow.close();
				}
			}]
		});
