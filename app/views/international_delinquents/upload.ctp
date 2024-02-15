		<?php
			$this->ExtForm->create('InternationalDelinquent');
			$this->ExtForm->defineFieldFunctions();
		?>
		var InternationalDelinquentAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'internationalDelinquents', 'action' => 'upload')); ?>',
			defaultType: 'textfield',
			fileUpload: true,

			items: [
			{
                            xtype: 'fileuploadfield',
                            id: 'form-file',
                            emptyText: '',
                            fieldLabel: 'Sanction List File',
                            name: 'data[InternationalDelinquent][file]',
                            buttonText: '',
                            anchor:'50%',
                            buttonCfg: {
                                iconCls: 'upload-icon'
                            }}	,
				<?php
					$options = array();
					$options = array('xtype' => 'combo', 'anchor' => '70%', 'fieldLabel' => 'Sanction Type', 'value' => 'UN');
					$options['items'] = array('UN' => 'UN (XML File)', 'EU' => 'EU (CSV File )','DPRK' => 'DPRK (XML File)','OFAC' => 'OFAC (XML File)','PEP' => 'FIC PEP(CSV File )');
					$this->ExtForm->input('source', $options);
				?>
				]
		});
		
		var InternationalDelinquentAddWindow = new Ext.Window({
			title: '<?php __('Update International Delinquent'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: InternationalDelinquentAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					InternationalDelinquentAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new International Delinquent.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(InternationalDelinquentAddWindow.collapsed)
						InternationalDelinquentAddWindow.expand(true);
					else
						InternationalDelinquentAddWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					InternationalDelinquentAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							InternationalDelinquentAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentInternationalDelinquentData();
<?php } else { ?>
							RefreshInternationalDelinquentData();
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
					InternationalDelinquentAddWindow.close();
				}
			}]
		});
