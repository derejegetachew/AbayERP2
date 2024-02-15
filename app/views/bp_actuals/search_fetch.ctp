		<?php
			$this->ExtForm->create('BpActual');
			$this->ExtForm->defineFieldFunctions();
		?>
		function BpActualBpItemIdValidator(value){
			if(value!=null || value!= '')
			return true;
		else
			return false;
		}
		var BpActualAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'bpActuals', 'action' => 'search')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					//$options = array();
					//$this->ExtForm->input('account', $options);
					
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $bp_items;
					$this->ExtForm->input('bp_item_id', $options);
					
					
				?>,	{					
				    xtype: 'datefield',
					fieldLabel: 'From Date',
					id:'fromDate',
					name: 'data[BpActual][from_date]',
					anchor: '100%',
					format: 'j/n/Y'
				},{				
        			xtype: 'datefield',
					fieldLabel: 'To Date',
					id:'toDate',
					name: 'data[BpActual][to_date]',
					anchor: '100%',
					format: 'j/n/Y'
				}	]
		});
		
		var BpActualAddWindow = new Ext.Window({
			title: '<?php __('Add Bp Actual'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: BpActualAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					BpActualAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Bp Actual.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(BpActualAddWindow.collapsed)
						BpActualAddWindow.expand(true);
					else
						BpActualAddWindow.collapse(true);
				}
			}],
			buttons: [{
				text: '<?php __('Fetch'); ?>',
				handler: function(btn){
					BpActualAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BpActualAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentBpActualData();
<?php } else { ?>
							
							RefreshParentBpActualData();
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
					BpActualAddWindow.close();
				}
			}]
		});
