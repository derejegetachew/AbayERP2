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

		var text=new Ext.ux.form.SpinnerField({
					fieldLabel: 'No of Split',
					id:'toDate',
					name: 'data[BpActual][to_date]',
					anchor: '100%',
					minValue:2,
					maxValue:100,
					value:2
		});


		var BpActualAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'bpActuals', 'action' => 'split')); ?>',
			defaultType: 'textfield',

			items: [
			      {
					xtype: 'spinnerfield',
					fieldLabel: 'No of Split',
					id:'noofsplit',
					name: 'data[BpActual][to_date]',
					anchor: '100%',
					minValue:2,
					maxValue:100
				  }
				  ]
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
			items: [text],
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
				text: '<?php __('Split'); ?>',
				handler: function(btn){
                
				Ext.Ajax.request({
				url: '<?php echo $this->Html->url(array('controller' => 'bpActuals', 'action' => 'split')); ?>?id='+'<?php echo $id ?>'+'&split='+text.getValue()+'&amount='+'<?php echo $amount ?>'+'&plan_id=<?php echo $plan_id ?>',
				success: function(response, opts) {
					var bpActual_data = response.responseText;

					eval(bpActual_data);

					splitWindow.show();
					
				},
				failure: function(response, opts) {
					Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the bpActual to be deleted. Error code'); ?>: ' + response.status);
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
