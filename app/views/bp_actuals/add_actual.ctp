		<?php
			$this->ExtForm->create('BpActual');
			$this->ExtForm->defineFieldFunctions();
		?>
		
		
	function 	BpActualBranchIdValidator(value){
		if(value!=null || value!= '')
			return true;
		else
			return false;
	}
	function 	BpActualBpItemIdValidator(value){
		if(value!=null || value!= '')
			return true;
		else
			return false;
	}
	
		var store=new Ext.data.JsonStore({
			autoDestroy:true,
			url:'<?php echo $this->Html->url(array('controller' => 'bpActuals', 'action' => 'getBranch')); ?>/',
			root:"data",
			fields :['id','name']
		})
		
		var cb=new Ext.form.ComboBox({
			typeAhead:true,
			fieldLabel:'Branch',
			mode:'remote',
			store:store,
			triggerAction: 'all',
			valueField:'id',
			displayField: 'name',
			width:200
		});
		
		var BpActualAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'bpActuals', 'action' => 'add_actual')); ?>/<?php echo $brr."_".$plan ?>',
			defaultType: 'textfield',
			items: [
				<?php 
					$options = array();
					$this->ExtForm->input('amount', $options);
				?>,
				<?php 
						$options = array();
					if(!isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $bp_month;
					$this->ExtForm->input('bp_month_id', $options);
				?>,
				<?php 
				   
					$options = array();
					if(!isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $branches;
					$this->ExtForm->input('branch_id', $options);
				?>,
				<?php 
					$options = array();
					if(!isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $bp_items;
					$this->ExtForm->input('bp_item_id', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('remark', $options);
				?>
				
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
			buttons: [  {
				text: '<?php __('Save'); ?>',
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
							BpActualAddForm.getForm().reset();
							RefreshActualData();
							
<?php if(isset($parent_id)){ ?>
							
<?php } else { ?>
							
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
															
								<?php } else { ?>
														
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
