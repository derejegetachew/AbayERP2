		<?php
			$this->ExtForm->create('BpPlanDetail');
			$this->ExtForm->defineFieldFunctions();
		?>
		var BpPlanDetailEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'bpPlanDetails', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $bp_plan_detail['BpPlanDetail']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $bp_items;
					$options['value'] = $bp_plan_detail['BpPlanDetail']['bp_item_id'];
					$this->ExtForm->input('bp_item_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $bp_plans;
					$options['value'] = $bp_plan_detail['BpPlanDetail']['bp_plan_id'];
					$this->ExtForm->input('bp_plan_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $bp_plan_detail['BpPlanDetail']['amount'];
					$this->ExtForm->input('amount', $options);
				?>			]
		});
		
		var BpPlanDetailEditWindow = new Ext.Window({
			title: '<?php __('Edit Bp Plan Detail'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: BpPlanDetailEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					BpPlanDetailEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Bp Plan Detail.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(BpPlanDetailEditWindow.collapsed)
						BpPlanDetailEditWindow.expand(true);
					else
						BpPlanDetailEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					BpPlanDetailEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BpPlanDetailEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentBpPlanDetailData();
<?php } else { ?>
							RefreshBpPlanDetailData();
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
					BpPlanDetailEditWindow.close();
				}
			}]
		});
