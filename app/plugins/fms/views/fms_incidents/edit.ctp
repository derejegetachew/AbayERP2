		<?php
			$this->ExtForm->create('FmsIncident');
			$this->ExtForm->defineFieldFunctions();
		?>
		var FmsIncidentEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'fmsIncidents', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $fms_incident['FmsIncident']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $fms_vehicles;
					$options['value'] = $fms_incident['FmsIncident']['fms_vehicle_id'];
					$this->ExtForm->input('fms_vehicle_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $fms_incident['FmsIncident']['occurrence_date'];
					$this->ExtForm->input('occurrence_date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $fms_incident['FmsIncident']['occurrence_time'];
					$this->ExtForm->input('occurrence_time', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $fms_incident['FmsIncident']['occurrence_place'];
					$this->ExtForm->input('occurrence_place', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $fms_incident['FmsIncident']['details'];
					$this->ExtForm->input('details', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $fms_incident['FmsIncident']['action_taken'];
					$this->ExtForm->input('action_taken', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $fms_incident['FmsIncident']['created_by'];
					$this->ExtForm->input('created_by', $options);
				?>			]
		});
		
		var FmsIncidentEditWindow = new Ext.Window({
			title: '<?php __('Edit Fms Incident'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: FmsIncidentEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					FmsIncidentEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Fms Incident.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(FmsIncidentEditWindow.collapsed)
						FmsIncidentEditWindow.expand(true);
					else
						FmsIncidentEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					FmsIncidentEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FmsIncidentEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentFmsIncidentData();
<?php } else { ?>
							RefreshFmsIncidentData();
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
					FmsIncidentEditWindow.close();
				}
			}]
		});
