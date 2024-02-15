		<?php
			$this->ExtForm->create('FaAsset');
			$this->ExtForm->defineFieldFunctions();
		?>



function SoldAsset() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'faTransactions', 'action' => 'sold')); ?>/'+<?php echo $fa_asset['FaAsset']['id'] ?>,
		success: function(response, opts) {
			var faAsset_data = response.responseText;
			
			eval(faAsset_data);
			
			FaAssetSoldWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the faAsset edit form. Error code'); ?>: ' + response.status);
		}
	});
}

		var FaAssetEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'faAssets', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $fa_asset['FaAsset']['id'])); ?>,
				<?php 
					$options = array('readOnly'=>true,'disabled'=>true);
					$options['value'] = $fa_asset['FaAsset']['reference'];
					$this->ExtForm->input('reference', $options);
				?>,
				<?php 
					$options = array('readOnly'=>false,'disabled'=>false);
					$options['value'] = $fa_asset['FaAsset']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array('readOnly'=>true,'disabled'=>true);
					$options['value'] = $fa_asset['FaAsset']['original_cost'];
					$this->ExtForm->input('original_cost', $options);
				?>,
				<?php 
					$options = array('readOnly'=>true,'disabled'=>true);
					$options['value'] = $fa_asset['FaAsset']['book_date'];
					$this->ExtForm->input('book_date', $options);
				?>,
				<?php 
					$options = array('readOnly'=>true,'disabled'=>true);
					$options['value'] = $fa_asset['FaAsset']['sold'];
					$this->ExtForm->input('sold', $options);
				?>,
				<?php 
					$options = array('readOnly'=>true,'disabled'=>true);
					$options['value'] = $fa_asset['FaAsset']['sold_date'];
					$this->ExtForm->input('sold_date', $options);
				?>  ,
        {
     	    store: new Ext.data.ArrayStore({ 
   	      id: 0, fields: [ 'id', 'name' ], 
					data: [ <?php $st = false;  foreach ($po as $k => $v) {
                    if ($st)
                        echo ',';
                    echo '[\'' . $k . '\', \'' . $v . '\']';
                    $st = true;
                    } ?> ]}), 
          fieldLabel: 'Branch_Name',
          name:'data[FaAsset][branch_name]',
          id: 'branch_name',
          xtype:'combo',
         	typeAhead: true, 
			    emptyText: 'Select One', 
			    editable: true, 
			    forceSelection: true, 
			    triggerAction: 'all', 
			    lazyRender: true, 
			    mode: 'local', 
			    valueField: 'id', 
			    displayField: 'name', 
			    allowBlank: true, 
          value:'<?php echo $fa_asset['FaAsset']['branch_name'] ?>',
			    anchor: '100%'
			   
            }
        ,
				<?php 
					$options = array();
					$options['value'] = $fa_asset['FaAsset']['tax_rate'];
					$this->ExtForm->input('tax_rate', $options);
				?>,
				<?php 
					$options = array('xtype'=>'combo','fieldLabel'=>'Tax Category');
					$list=array('COMPSOFT'=>'COMPSOFT','FURNIFITTI'=>'FURNIFITTI','MOTORVEH'=>'MOTORVEH','OFFANDEQUI'=>'OFFANDEQUI','PREMISES'=>'PREMISES');
					$options['items'] = $list;
					$options['value'] = $fa_asset['FaAsset']['tax_cat'];
					$this->ExtForm->input('tax_cat', $options);
				?>,
				<?php 
					$options = array('xtype'=>'combo','fieldLabel'=>'IFRS Classification','value'=>'S');
					$list=array('S'=>'S','M'=>'M','L'=>'L','U'=>'U');
					$options['items'] = $list;
					$options['value'] = $fa_asset['FaAsset']['ifrs_class'];
					$this->ExtForm->input('ifrs_class', $options);
				?>,
				<?php 
					$options = array('xtype'=>'combo','fieldLabel'=>'IFRS Category');
					$list=array('COMPSOFT'=>'COMPSOFT','FURNIFITTI'=>'FURNIFITTI','MOTORVEH'=>'MOTORVEH','OFFANDEQUI'=>'OFFANDEQUI','PREMISES'=>'PREMISES','INTANGIBLE'=>'INTANGIBLE');
					$options['items'] = $list;
					$options['value'] = $fa_asset['FaAsset']['ifrs_cat'];
					$this->ExtForm->input('ifrs_cat', $options);
				?>,
				<?php 
					$options = array('fieldLabel'=>'IFRS Useful Age');
					$options['value'] = $fa_asset['FaAsset']['ifrs_useful_age'];
					$this->ExtForm->input('ifrs_useful_age', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $fa_asset['FaAsset']['residual_value_rate'];
					$this->ExtForm->input('residual_value_rate', $options);
				?>			]
		});
		
		var FaAssetEditWindow = new Ext.Window({
			title: '<?php __('Edit Fa Asset'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: FaAssetEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					FaAssetEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Fa Asset.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(FaAssetEditWindow.collapsed)
						FaAssetEditWindow.expand(true);
					else
						FaAssetEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					FaAssetEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							FaAssetEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentFaAssetData();
<?php } else { ?>
							RefreshFaAssetData();
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
				text: '<?php __('Sell'); ?>',
				handler: function(btn){
				SoldAsset();
				}
			} ,{
				text: '<?php __('Cancel'); ?>',
				handler: function(btn){
					FaAssetEditWindow.close();
				}
			}
			]
		});
