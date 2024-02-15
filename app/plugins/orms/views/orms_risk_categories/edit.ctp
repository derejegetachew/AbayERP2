		<?php
			$this->ExtForm->create('OrmsRiskCategory');
			$this->ExtForm->defineFieldFunctions();
		?>
		var OrmsRiskCategoryEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'ormsRiskCategories', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $risk_category['OrmsRiskCategory']['id'])); ?>,
				<?php 
                $options = array();
                $options['value'] = $risk_category['OrmsRiskCategory']['name'];
                $this->ExtForm->input('name', $options);
            ?>,
            <?php 
                $options = array();
                $options['hidden'] = $risk_category['OrmsRiskCategory']['parent_id'];
                //$options['value'] = $item_category['ImsItemCategory']['parent_id'];
                $this->ExtForm->input('parent_id', $options);
            ?>				]
		});
		
		var OrmsRiskCategoryEditWindow = new Ext.Window({
			title: '<?php __('Edit Risk Category'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: OrmsRiskCategoryEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					OrmsRiskCategoryEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Orms Risk Category.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(OrmsRiskCategoryEditWindow.collapsed)
						OrmsRiskCategoryEditWindow.expand(true);
					else
						OrmsRiskCategoryEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					OrmsRiskCategoryEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							OrmsRiskCategoryEditWindow.close();
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
					OrmsRiskCategoryEditWindow.close();
				}
			}]
		});
