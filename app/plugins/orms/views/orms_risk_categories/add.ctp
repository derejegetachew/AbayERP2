//<script>	
		<?php
			$this->ExtForm->create('OrmsRiskCategory');
			$this->ExtForm->defineFieldFunctions();
		?>
		var OrmsRiskCategoryAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'orms_risk_categories', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
                $options = array();
                $this->ExtForm->input('name', $options);
            ?>,
            <?php 
                $options1 = array('xtype' => 'hidden');
                $options1['hidden'] = $parent_id;
                $this->ExtForm->input('parent_id', $options1);
            ?>	
			]
		});
		
		var OrmsRiskCategoryAddWindow = new Ext.Window({
			title: '<?php __('Add Risk Category'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: OrmsRiskCategoryAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					OrmsRiskCategoryAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Risk Category.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(OrmsRiskCategoryAddWindow.collapsed)
						OrmsRiskCategoryAddWindow.expand(true);
					else
						OrmsRiskCategoryAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					OrmsRiskCategoryAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							OrmsRiskCategoryAddForm.getForm().reset();							
							RefreshOrmsRiskCategoryData();
							p.getRootNode().reload();
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
					OrmsRiskCategoryAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							OrmsRiskCategoryAddWindow.close();							
							RefreshOrmsRiskCategoryData();
							p.getRootNode().reload();
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
					OrmsRiskCategoryAddWindow.close();
				}
			}]
		});
