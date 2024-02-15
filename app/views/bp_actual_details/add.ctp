		<?php
			$this->ExtForm->create('BpActualDetail');
			$this->ExtForm->defineFieldFunctions();
		?>
		var BpActualDetailAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'bpActualDetails', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					$this->ExtForm->input('GLCode', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('GLDescription', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('TDate', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('VDate', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('RefNo', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('CCY', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('DR', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('CR', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('TranCode', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('TranDesc', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('Amount', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('InstrumentCode', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('CPO', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('Description', $options);
				?>			]
		});
		
		var BpActualDetailAddWindow = new Ext.Window({
			title: '<?php __('Add Bp Actual Detail'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: BpActualDetailAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					BpActualDetailAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Bp Actual Detail.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(BpActualDetailAddWindow.collapsed)
						BpActualDetailAddWindow.expand(true);
					else
						BpActualDetailAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					BpActualDetailAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BpActualDetailAddForm.getForm().reset();
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
			}, {
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
					BpActualDetailAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BpActualDetailAddWindow.close();
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
					BpActualDetailAddWindow.close();
				}
			}]
		});
