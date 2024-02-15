		<?php
			$this->ExtForm->create('IbdTt');
			$this->ExtForm->defineFieldFunctions();
		?>
		var IbdTtEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 150,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ibdTts', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $ibd_tt['IbdTt']['id'])); ?>,
				<?php 
					$options = array('id'=>'PERMIT_NO','readOnly'=>false);
					$options['value'] = $ibd_tt['IbdTt']['PERMIT_NO'];
					$this->ExtForm->input('PERMIT_NO', $options);
				?>,
				<?php 
					$options = array('id'=>'NAME_OF_APPLICANT','readOnly'=>false);
					$options['value'] = $ibd_tt['IbdTt']['NAME_OF_APPLICANT'];
					$this->ExtForm->input('NAME_OF_APPLICANT', $options);
				?>,
				<?php 
					$options = array('id'=>'beneficiary_name','readOnly'=>false);
					$options['value'] = $ibd_tt['IbdTt']['beneficiary_name'];
					$this->ExtForm->input('beneficiary_name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $ibd_tt['IbdTt']['DATE_OF_ISSUE'];
					$this->ExtForm->input('DATE_OF_ISSUE', $options);
				?>,
				
				<?php 
					$options = array('id'=>'currency_id','readOnly'=>false);
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $currencies;
					$options['value'] = $ibd_tt['IbdTt']['currency_id'];
					$this->ExtForm->input('currency_id', $options);
				?>,
				<?php 
					$options = array('id'=>'FCY_AMOUNT','readOnly'=>true);
					$options['value'] = $ibd_tt['IbdTt']['FCY_AMOUNT'];
					$this->ExtForm->input('FCY_AMOUNT', $options);
				?>,
				<?php 
					$options = array('id'=>'rate','readOnly'=>true);
					$options['value'] = $ibd_tt['IbdTt']['rate'];
					$this->ExtForm->input('rate', $options);
				?>,

				<?php 
					$options = array('id'=>'LCY_AMOUNT','readOnly'=>true);
					$options['value'] = $ibd_tt['IbdTt']['LCY_AMOUNT'];
					$this->ExtForm->input('LCY_AMOUNT', $options);
				?>,
				<?php 
					$options = array('readOnly'=>'true','allowBlank'=>true);
					$options['value'] = $ibd_tt['IbdTt']['TT_REFERENCE'];
					$this->ExtForm->input('TT_REFERENCE', $options);
				?>
				,
				<?php 
					$options = array('id'=>'REIBURSING_BANK','xtype'=>'combo','valueField'=>'name');
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $REIBURSING;
					$options['value'] = $ibd_tt['IbdTt']['REIBURSING_BANK'];
					$this->ExtForm->input('REIBURSING_BANK', $options);
				?>
				,
				<?php 
					$options = array('id'=>'FCY_APPROVAL_DATE','allowBlank'=>true);
					if($ibd_tt['IbdTt']['FCY_APPROVAL_DATE']=='0000-00-00'){
					$options['value'] = null;
					}else{
					
					$options['value'] = $ibd_tt['IbdTt']['FCY_APPROVAL_DATE'];
					}
					$this->ExtForm->input('FCY_APPROVAL_DATE', $options);
				?>,
				<?php 
					$options = array('id'=>'FCY_APPROVAL_INTIAL_ORDER_NO','allowBlank'=>true);
					$options['value'] = $ibd_tt['IbdTt']['FCY_APPROVAL_INTIAL_ORDER_NO'];
					$this->ExtForm->input('FCY_APPROVAL_INTIAL_ORDER_NO', $options);
				?>,
				<?php 
					$options = array('xtype'=>'combo','id'=>'FROM_THEIR_FCY_ACCOUNT','allowBlank'=>true);
					$list=array('RETENTION A'=>'RETENTION A','RETENTION B'=>'RETENTION B','DIASPORA'=>'DIASPORA','NRNT'=>'NRNT','SUPPLIERS_CREDIT'=>'SUPPLIERS CREDIT','BIRR_ACCOUNT'=>'BIRR ACCOUNT');
					$options['items'] = $list;
					$options['value'] = $ibd_tt['IbdTt']['FROM_THEIR_FCY_ACCOUNT'];
					$this->ExtForm->input('FROM_THEIR_FCY_ACCOUNT', $options);
				?>,
				<?php 
				
					$options = array('xtype'=>'combo','id'=>'FROM_LCY_ACCOUNT','allowBlank'=>true);
					$options['value'] = $ibd_tt['IbdTt']['FROM_LCY_ACCOUNT'];
					$this->ExtForm->input('FROM_LCY_ACCOUNT', $options);
				?>,
				<?php 
					$options = array('allowBlank'=>true);
					$options['value'] = $ibd_tt['IbdTt']['REMARK'];
					$this->ExtForm->input('REMARK', $options);
				?>			]
		});
		
		var IbdTtEditWindow = new Ext.Window({
			title: '<?php __('Edit TT'); ?>',
			width: 500,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: IbdTtEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					IbdTtEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ibd Tt.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(IbdTtEditWindow.collapsed)
						IbdTtEditWindow.expand(true);
					else
						IbdTtEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					IbdTtEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							IbdTtEditWindow.close();
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
					IbdTtEditWindow.close();
				}
			}]
		});
