		<?php
			$this->ExtForm->create('ImsMaintenanceRequest');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ImsMaintenanceRequestEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'imsMaintenanceRequests', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $ims_maintenance_request['ImsMaintenanceRequest']['id'])); ?>,
				<?php 
					$options = array('fieldLabel' => 'Ref Number','readOnly' => 'true');
					$options['value'] = $ims_maintenance_request['ImsMaintenanceRequest']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array(
						'xtype' => 'textarea',
						'grow' => true,
						'fieldLabel' => 'Description',
						'anchor' => '100%'
					);
					$options['value'] = $ims_maintenance_request['ImsMaintenanceRequest']['description'];
					$this->ExtForm->input('description', $options);
				?>,
				{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						sortInfo: { field: "name", direction: "ASC" },
						storeId: 'my_array_store',
						fields: ['id','name','code'],
						
						data: [
						<?php foreach($items as $result){?>
						['<?php echo $result['ImsItem']['id']?>','<?php echo $result['ImsItem']['name']?>','<?php echo $result['ImsItem']['description']?>'],
						<?php
						}
						?>
						]
						
					}),					
					displayField: 'name',
					typeAhead: false,
					typeAheadDelay: 15000,
					tpl: '<tpl for="."><div ext:qtip="{name} . {position}" class="x-combo-list-item">{name} <br><b>{code}</b></div></tpl>' ,
					hiddenName:'data[ImsMaintenanceRequest][ims_item_id]',
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
					value: '<?php echo $ims_maintenance_request['ImsMaintenanceRequest']['ims_item_id'];?>',
        
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
										//this.store.clearFilter();
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
					$options = array();
					$options['value'] = $ims_maintenance_request['ImsMaintenanceRequest']['tag'];
					$this->ExtForm->input('tag', $options);
				?>,
				<?php 
					$options = array(
						'xtype' => 'textarea',
						'grow' => true,
						'fieldLabel' => 'Branch Recommendation',
						'anchor' => '100%'
					);
					$options['value'] = $ims_maintenance_request['ImsMaintenanceRequest']['branch_recommendation'];
					$this->ExtForm->input('branch_recommendation', $options);
				?>		]
		});
		
		var ImsMaintenanceRequestEditWindow = new Ext.Window({
			title: '<?php __('Edit Maintenance Request'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ImsMaintenanceRequestEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ImsMaintenanceRequestEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ims Maintenance Request.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ImsMaintenanceRequestEditWindow.collapsed)
						ImsMaintenanceRequestEditWindow.expand(true);
					else
						ImsMaintenanceRequestEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ImsMaintenanceRequestEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ImsMaintenanceRequestEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsMaintenanceRequestData();
<?php } else { ?>
							RefreshImsMaintenanceRequestData();
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
					ImsMaintenanceRequestEditWindow.close();
				}
			}]
		});
