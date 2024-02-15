		<?php
			$this->ExtForm->create('BpActualDetail');
			$this->ExtForm->defineFieldFunctions();
		?>
		var BpActualDetailEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'bpActualDetails', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $bp_actual_detail['BpActualDetail']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $bp_actual_detail['BpActualDetail']['GLCode'];
					$this->ExtForm->input('GLCode', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $bp_actual_detail['BpActualDetail']['GLDescription'];
					$this->ExtForm->input('GLDescription', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $bp_actual_detail['BpActualDetail']['TDate'];
					$this->ExtForm->input('TDate', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $bp_actual_detail['BpActualDetail']['VDate'];
					$this->ExtForm->input('VDate', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $bp_actual_detail['BpActualDetail']['RefNo'];
					$this->ExtForm->input('RefNo', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $bp_actual_detail['BpActualDetail']['CCY'];
					$this->ExtForm->input('CCY', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $bp_actual_detail['BpActualDetail']['DR'];
					$this->ExtForm->input('DR', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $bp_actual_detail['BpActualDetail']['CR'];
					$this->ExtForm->input('CR', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $bp_actual_detail['BpActualDetail']['TranCode'];
					$this->ExtForm->input('TranCode', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $bp_actual_detail['BpActualDetail']['TranDesc'];
					$this->ExtForm->input('TranDesc', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $bp_actual_detail['BpActualDetail']['Amount'];
					$this->ExtForm->input('Amount', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $bp_actual_detail['BpActualDetail']['InstrumentCode'];
					$this->ExtForm->input('InstrumentCode', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $bp_actual_detail['BpActualDetail']['CPO'];
					$this->ExtForm->input('CPO', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $bp_actual_detail['BpActualDetail']['Description'];
					$this->ExtForm->input('Description', $options);
				?>			]
		});
		
		var BpActualDetailEditWindow = new Ext.Window({
			title: '<?php __('Edit Bp Actual Detail'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: BpActualDetailEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					BpActualDetailEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Bp Actual Detail.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(BpActualDetailEditWindow.collapsed)
						BpActualDetailEditWindow.expand(true);
					else
						BpActualDetailEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					BpActualDetailEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BpActualDetailEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentBpActualDetailData();
<?php } else { ?>
							RefreshBpActualDetailData();
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
					BpActualDetailEditWindow.close();
				}
			}]
		});
