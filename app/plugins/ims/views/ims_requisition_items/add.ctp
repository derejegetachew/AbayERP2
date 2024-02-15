	//<script>	
		<?php
			$this->ExtForm->create('ImsRequisitionItem');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ImsRequisitionItemAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'imsRequisitionItems', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					//else
						//$options['items'] = $ims_requisitions;
					$this->ExtForm->input('ims_requisition_id', $options);
				?>,
				{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						sortInfo: { field: "name", direction: "ASC" },
						storeId: 'my_array_store',
						fields: ['id','name','code'],
						
						data: [
						<?php foreach($results as $result){?>
						['<?php echo $result['id']?>','<?php echo $result['name']?>','<?php echo $result['description']?>'],
						<?php
						}
						?>
						]
						
					}),					
					displayField: 'name',
					typeAhead: false,
					typeAheadDelay: 15000,
					tpl: '<tpl for="."><div ext:qtip="{name} . {position}" class="x-combo-list-item">{name} <br><b>{code}</b></div></tpl>' ,
					hiddenName:'data[ImsRequisitionItem][ims_item_id]',
					id: 'item',
					name: 'item',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select One',
					selectOnFocus:false,
					valueField: 'id',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Item',
					allowBlank: false,
					editable: true,
					lazyRender: true,
					blankText: 'Your input is invalid.',
					disableKeyFilter: true,
					forceSelection:true,
					anyMatch : true,
        
					//override doQuery function
					doQuery : function(q, forceAll){
						
						if(q === undefined || q === null){
							q = '';
						}
						var qe = {
							query: q,
							forceAll: forceAll,
							combo: this,
							cancel:false
						};
						if(this.fireEvent('beforequery', qe)===false || qe.cancel){
							return false;
						}
						q = qe.query;
						forceAll = qe.forceAll;
						if(forceAll === true || (q.length >= this.minChars)){
							if(this.lastQuery !== q){
								this.lastQuery = q;
								if(this.mode == 'local'){
									this.selectedIndex = -1;
									if(forceAll){
										this.store.clearFilter();
									}else{
							this.store.filter(this.displayField, q, this.anyMatch);
									}
									this.onLoad();
								}else{
									this.store.baseParams[this.queryParam] = q;
									this.store.load({
										params: this.getParams(q)
									});
									this.expand();
								}
							}else{
								this.selectedIndex = -1;
								this.onLoad();
							}
						}
					} 
				},
				<?php 
					$options = array('anchor' => '60%');
					$this->ExtForm->input('quantity', $options);
				?>,
				<?php 
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Measurement', 'anchor' => '60%');
					$options['items'] = array('Pcs' => 'Pcs', 'Pkt' => 'Pkt', 'Pad' => 'Pad', 'Kg' => 'Kg', 'Roll' => 'Roll','Ream' => 'Ream','m<sup>2</sup>' => 'm<sup>2</sup>','M' => 'M','Set' => 'Set');
					$this->ExtForm->input('measurement', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('remark', $options);
				?>			]
		});
		
		var ImsRequisitionItemAddWindow = new Ext.Window({
			title: '<?php __('Add Ims Requisition Item'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ImsRequisitionItemAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ImsRequisitionItemAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Ims Requisition Item.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ImsRequisitionItemAddWindow.collapsed)
						ImsRequisitionItemAddWindow.expand(true);
					else
						ImsRequisitionItemAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ImsRequisitionItemAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							Ext.getCmp("item").store.removeAt(Ext.getCmp("item").selectedIndex);
							ImsRequisitionItemAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsRequisitionItemData();
<?php } else { ?>
							RefreshImsRequisitionItemData();
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
					ImsRequisitionItemAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ImsRequisitionItemAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsRequisitionItemData();
<?php } else { ?>
							RefreshImsRequisitionItemData();
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
					ImsRequisitionItemAddWindow.close();
				}
			}]
		});
