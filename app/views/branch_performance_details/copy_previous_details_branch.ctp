<?php
			$this->ExtForm->create('BranchPerformanceDetail');
			$this->ExtForm->defineFieldFunctions();
		?>
		var activetab = 1;
		var BrCopyPreviousDetailsForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'branchPerformanceDetails', 'action' => 'copy_previous_details_branch')); ?>',
			defaultType: 'textfield',


			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $parent_id)); ?>
					,
					<?php 
				
				$options = array();
				if(isset($parent_id))
				{	
					$options['hidden'] = $parent_id;
					$this->ExtForm->input('branch_performance_plan_id', $options);
				}
			
				
			?>,

			{
				xtype: 'label',
				text: 'If there are details they will be overwritten. Are you sure you want to copy?',
				margins: '0 0 0 10'

			}
			

				]
	
		});
		
		var BrCopyPreviousDetailsWindow = new Ext.Window({
			title: '<?php __('Copy previous details by branch'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: BrCopyPreviousDetailsForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					BrCopyPreviousDetailsForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ho Performance Detail.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(HoPerformanceDetailEditWindow.collapsed)
						BrCopyPreviousDetailsWindow.expand(true);
					else
						BrCopyPreviousDetailsWindow.collapse(true);
				}
			}],
		

			buttons: [  {
				text: '<?php __('Yes'); ?>',
				handler: function(btn){
					BrCopyPreviousDetailsForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BrCopyPreviousDetailsWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentBranchPerformanceDetailData();
<?php } else { ?>
							RefreshBranchPerformanceDetailData();
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
				text: '<?php __('Yes & Close'); ?>',
				handler: function(btn){
					BrCopyPreviousDetailsForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BrCopyPreviousDetailsWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentBranchPerformanceDetailData();
<?php } else { ?>
							RefreshBranchPerformanceDetailData();
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
				text: '<?php __('Cancel'); ?>',
				handler: function(btn){
					BrCopyPreviousDetailsWindow.close();
				}
			}]
		});
