		<?php
			$this->ExtForm->create('FrwfmApplication');
			$this->ExtForm->defineFieldFunctions();
		?>
		var FrwfmApplicationEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'frwfmApplications', 'action' => 'approve')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $frwfm_application['FrwfmApplication']['id'])); ?>,
				<?php 
					$options = array();
					if($frwfm_application['FrwfmApplication']['status']=='Presented for Approval' && $creator=='false')
					$options['disabled']='true';
					$options['value'] = $frwfm_application['FrwfmApplication']['minute'];
					$options['fieldLabel']='Minute';
					$this->ExtForm->input('minute', $options);
				?>,<?php 
					$options = array();
					if($frwfm_application['FrwfmApplication']['status']=='Presented for Approval' && $creator=='false')
					$options['disabled']='true';
					$options['value'] = $frwfm_application['FrwfmApplication']['approved_date'];
					if($options['value']=='2200-01-01')
					$options['value']='';
					$options['fieldLabel']='Approval Date';
					$this->ExtForm->input('approved_date', $options);
				?>,<?php 
					$options = array();
					if($frwfm_application['FrwfmApplication']['status']=='Presented for Approval' && $creator=='false')
					$options['disabled']='true';
					if($frwfm_application['FrwfmApplication']['status']=='Accepted')
					$options['value'] = $frwfm_application['FrwfmApplication']['amount'];
					else
					$options['value'] = $frwfm_application['FrwfmApplication']['approved_amount'];
					$this->ExtForm->input('approved_amount', $options);
				?>,
				<?php 
					$options = array();
					$options['disabled']='true';
					$options['value'] = $frwfm_application['FrwfmApplication']['currency'];
					$this->ExtForm->input('currency', $options);
				?>,
				<?php 
					$options = array();
					$options = array(
						'xtype' => 'textarea',
						'grow' => false,
						'fieldLabel' => 'SMS Amharic',
						'anchor' => '100%',
						'height' => 100
						);
					if($frwfm_application['FrwfmApplication']['status']=='Presented for Approval' && $creator=='false')
					$options['disabled']='true';
					if($frwfm_application['FrwfmApplication']['sms_english']=='')
					$options['value'] = "Dear Customer :-   Your Foreign currency request is approved. The Approved FCY is Valid until June 16, 2018. if not it will be canceled automatically. - Abay Bank";
					else
					$options['value'] = $frwfm_application['FrwfmApplication']['sms_english'];
					$this->ExtForm->input('sms_english', $options);
				?>,
				<?php 
					$options = array();
						$options = array(
						'xtype' => 'textarea',
						'grow' => false,
						'fieldLabel' => 'SMS Amharic',
						'anchor' => '100%',
						'height' => 100
						);
					if($frwfm_application['FrwfmApplication']['status']=='Presented for Approval' && $creator=='false')
					$options['disabled']='true';
					if($frwfm_application['FrwfmApplication']['sms_amharic']=='')
					$options['value'] = "ውድ ደንበኛችን :-  የጠየቁት የውጭ ምንዛሬ የተፈቀደ መሆኑን እያሳወቅን የውጭ ምንዛሬውን መስራት የሚቻለው እስከ ሰኔ 9, 2010  ሲሆን አስከዚህ ቀን ድረስ ካልሰሩ የሚሰረዝ መሆኑን እናሳውቃለን:: - አባይ ባንክ";
					else
					$options['value'] = $frwfm_application['FrwfmApplication']['sms_amharic'];
					$this->ExtForm->input('sms_amharic', $options);
				?>	]
		});
		
		var FrwfmApplicationApproveWindow = new Ext.Window({
			title: '<?php __('Approve Application'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: FrwfmApplicationEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					FrwfmApplicationEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Frwfm Application.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(FrwfmApplicationEditWindow.collapsed)
						FrwfmApplicationEditWindow.expand(true);
					else
						FrwfmApplicationEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Approve'); ?>',
				handler: function(btn){
					FrwfmApplicationEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FrwfmApplicationApproveWindow.close();
							RefreshFrwfmApplicationData();
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
					FrwfmApplicationApproveWindow.close();
				}
			}]
		});
