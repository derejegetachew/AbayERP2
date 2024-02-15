		<?php
			$this->ExtForm->create('SpCat');
			$this->ExtForm->defineFieldFunctions();
		?>
		var SpCatEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'spCats', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [

Warning: Invalid argument supplied for foreach() in C:\wamp\www\AbayERP\cake\console\templates\default\views\form.ctp on line 21

Call Stack:
    0.0030     542872   1. {main}() C:\wamp\www\AbayERP\cake\console\cake.php:0
    0.0032     543656   2. ShellDispatcher->ShellDispatcher() C:\wamp\www\AbayERP\cake\console\cake.php:660
    5.3635    2738680   3. ShellDispatcher->dispatch() C:\wamp\www\AbayERP\cake\console\cake.php:139
   15.6032    5378032   4. BakeShell->all() C:\wamp\www\AbayERP\cake\console\cake.php:373
  378.6831    9343712   5. ViewTask->execute() C:\wamp\www\AbayERP\cake\console\libs\bake.php:188
  379.3491   10493224   6. ViewTask->getContent() C:\wamp\www\AbayERP\cake\console\libs\tasks\view.php:137
  379.3493   10493320   7. TemplateTask->generate() C:\wamp\www\AbayERP\cake\console\libs\tasks\view.php:392
  379.3506   10586144   8. include('C:\wamp\www\AbayERP\cake\console\templates\default\views\form.ctp') C:\wamp\www\AbayERP\cake\console\libs\tasks\template.php:146

			]
		});
		
		var SpCatEditWindow = new Ext.Window({
			title: '<?php __('Edit Sp Cat'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: SpCatEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					SpCatEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Sp Cat.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(SpCatEditWindow.collapsed)
						SpCatEditWindow.expand(true);
					else
						SpCatEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					SpCatEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							SpCatEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentSpCatData();
<?php } else { ?>
							RefreshSpCatData();
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
					SpCatEditWindow.close();
				}
			}]
		});
