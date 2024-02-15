<?php
			$this->ExtForm->create('CompetenceResult');
			$this->ExtForm->defineFieldFunctions();
			//$exists = 0;
			$id = -1;
			$result_status = 0;
			$comment = "";
			if(count($competence_result['CompetenceResult']) > 0){
				//$exists = 1;
				$id = $competence_result['CompetenceResult']['id'];
				$comment = $competence_result['CompetenceResult']['comment'];
				$result_status = $competence_result['CompetenceResult']['result_status'];
			}
			
		?>
	var ChangeStatusForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'hoPerformancePlans', 'action' => 'agree_behavioural')); ?>',
			defaultType: 'textfield',

			items: [
				 <?php 
				
						$this->ExtForm->input('id', array('hidden' => $id));

					?>, 
				 
				<?php 
					
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Result status');
					$options['items'] = array(1 => "pending agreement", 2 => "agreed", 3 => "agreed with reservation");
                   
					 $options['value'] = $result_status;

					
					$this->ExtForm->input('result_status', $options);
				?>,
                <?php 
					
					$options = array();
					$options['value'] = $comment;
					$this->ExtForm->input('comment', $options);
				?>,
				]
		});
		
		var ChangeStatusWindow = new Ext.Window({
			title: '<?php __('agree/disagree'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ChangeStatusForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ChangeStatusForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ho Performance Plan.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ChangeStatusWindow.collapsed)
                        ChangeStatusWindow.expand(true);
					else
                        ChangeStatusWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ChangeStatusForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ChangeStatusWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentHoPerformancePlanData();
<?php } else { ?>
							RefreshHoPerformancePlanData();
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
					ChangeStatusWindow.close();
				}
			}]
		});
