		<?php
			$this->ExtForm->create('FmsDriver');
			$this->ExtForm->defineFieldFunctions();
		?>
		var FmsDriverAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'fmsDrivers', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				{
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($people as $item){if($st) echo ",
							";?>['<?php echo $item['Person']['id']; ?>' ,'<?php echo $item['Person']['first_name'].' '.$item['Person']['middle_name'].' '.$item['Person']['last_name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					hiddenName:'data[FmsDriver][person_id]',
					id: 'item',
					name: 'item',
					mode : 'local',
					triggerAction: 'all',
					emptyText: 'Select Driver',
					selectOnFocus:false,
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> የአሽከርካሪው ስም',
					allowBlank: false,
					editable: true,
					lazyRender: true,
					blankText: 'Your input is invalid.',
					disableKeyFilter: true,
					forceSelection:true,
					anyMatch : false,
				},
				<?php 
					$options = array('fieldLabel' => 'የአሽ/ብ/ማ ፈቃድ ቁ.');
					$this->ExtForm->input('license_no', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'የተሰጠበት ቀን');
					$this->ExtForm->input('date_given', $options);
				?>,
				<?php 
					$options = array('fieldLabel' => 'የሚያበቃበት  ቀን');
					$this->ExtForm->input('expiration_date', $options);
				?>			]
		});
		
		var FmsDriverAddWindow = new Ext.Window({
			title: '<?php __('Add Driver'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: FmsDriverAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					FmsDriverAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Fms Driver.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(FmsDriverAddWindow.collapsed)
						FmsDriverAddWindow.expand(true);
					else
						FmsDriverAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					FmsDriverAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FmsDriverAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentFmsDriverData();
<?php } else { ?>
							RefreshFmsDriverData();
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
					FmsDriverAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FmsDriverAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentFmsDriverData();
<?php } else { ?>
							RefreshFmsDriverData();
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
					FmsDriverAddWindow.close();
				}
			}]
		});
