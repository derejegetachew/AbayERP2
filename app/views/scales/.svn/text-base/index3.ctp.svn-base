//<script>
    var store_scales = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: ['grade-id','grade',
    <?php
    foreach ($steps as $step)
        echo "'" . $step['Step']['name'] . "',"
        ?>
                    ]
                }),
                proxy: new Ext.data.HttpProxy({
                    url: '<?php echo $this->Html->url(array('controller' => 'scales', 'action' => 'list_data3')); ?>'
                
                
                })

            });


            function AddScale() {
                Ext.Ajax.request({
                    url: '<?php echo $this->Html->url(array('controller' => 'scales', 'action' => 'add')); ?>',
                    success: function(response, opts) {
                        var scale_data = response.responseText;
			
                        eval(scale_data);
			
                        ScaleAddWindow.show();
                    },
                    failure: function(response, opts) {
                        Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the scale add form. Error code'); ?>: ' + response.status);
                    }
                });
            }

            function EditScale(id) {
                Ext.Ajax.request({
                    url: '<?php echo $this->Html->url(array('controller' => 'scales', 'action' => 'edit')); ?>/'+id,
                    success: function(response, opts) {
                        var scale_data = response.responseText;
			
                        eval(scale_data);
			
                        ScaleEditWindow.show();
                    },
                    failure: function(response, opts) {
                        Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the scale edit form. Error code'); ?>: ' + response.status);
                    }
                });
            }

            function ViewScale(id) {
                Ext.Ajax.request({
                    url: '<?php echo $this->Html->url(array('controller' => 'scales', 'action' => 'view')); ?>/'+id,
                    success: function(response, opts) {
                        var scale_data = response.responseText;

                        eval(scale_data);

                        ScaleViewWindow.show();
                    },
                    failure: function(response, opts) {
                        Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the scale view form. Error code'); ?>: ' + response.status);
                    }
                });
            }

            function DeleteScale(id) {
                Ext.Ajax.request({
                    url: '<?php echo $this->Html->url(array('controller' => 'scales', 'action' => 'delete')); ?>/'+id,
                    success: function(response, opts) {
                        Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Scale successfully deleted!'); ?>');
                        RefreshScaleData();
                    },
                    failure: function(response, opts) {
                        Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the scale add form. Error code'); ?>: ' + response.status);
                    }
                });
            }

            function SearchScale(){
                Ext.Ajax.request({
                    url: '<?php echo $this->Html->url(array('controller' => 'scales', 'action' => 'search')); ?>',
                    success: function(response, opts){
                        var scale_data = response.responseText;

                        eval(scale_data);

                        scaleSearchWindow.show();
                    },
                    failure: function(response, opts) {
                        Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the scale search form. Error Code'); ?>: ' + response.status);
                    }
                });
            }

            function SearchByScaleName(value){
                var conditions = '\'Scale.name LIKE\' => \'%' + value + '%\'';
                store_scales.reload({
                    params: {
                        start: 0,
                        limit: list_size,
                        conditions: conditions
                    }
                });
            }

            function RefreshScaleData() {
                store_scales.reload();
            }
            
            


            function savestore(){
                var records = store_scales.getModifiedRecords(), fields = store_scales.fields;
                var param = {};        
                for(var i = 0; i < records.length; i++) {
                    for(var j = 0; j < fields.length; j++){
                        param[ i + '_' + fields['items'][j]['name']] = Ext.encode(records[i].get(fields['items'][j]['name']));
                    }
                }
                Ext.Ajax.request({
                    url: '<?php echo $this->Html->url(array('controller' => 'scales', 'action' => 'add3')); ?>',
                    params: param,
                    method: 'POST',
                    success: function(){
                        store_scales.commitChanges();
                    },
                    failure: function(){
                        // do stuff	
                    }
                });
                                
            }

            var editor = new Ext.ux.grid.RowEditor({
                saveText: 'Update'
            });

            if(center_panel.find('id', 'scale-tab') != "") {
                var p = center_panel.findById('scale-tab');
                center_panel.setActiveTab(p);
            } else {
                var p = center_panel.add({
                    title: '<?php __('Salary Scale'); ?>',
                    closable: true,
                    loadMask: true,
                    stripeRows: true,
                    id: 'scale-tab',
                    xtype: 'grid',
                    store: store_scales,
                    plugins: [editor],
                    columns: [
                        {header: "<?php __('Grade'); ?>", dataIndex: 'grade', sortable: true},
    <?php
    foreach ($steps as $step)
        echo '{header: "' . $step['Step']['name'] . '", dataIndex: \'' . $step['Step']['name'] . '\', sortable: true, editor: { xtype: \'numberfield\', allowBlank: false },align:\'right\'},';
    ?>
            
                ],
		
                view: new Ext.grid.GroupingView({
                    forceFit:true,
                    groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Scales" : "Scale"]})'
                })
                ,
	
                sm: new Ext.grid.RowSelectionModel({
                    singleSelect: false
                }),
                tbar: new Ext.Toolbar({
			
                    items: [' ', {
                            xtype: 'tbbutton',
                            text: '<?php __('Save Changes'); ?>',
                            tooltip:'<?php __('<b>Save Changes</b><br />Click here to Save Changes'); ?>',
                            icon: 'img/table_edit.png',
                            cls: 'x-btn-text-icon',
                            handler: function(btn) {
                                savestore();
                            }
                        }
                    ]}),
                bbar: new Ext.PagingToolbar({
                    pageSize: list_size,
                    store: store_scales,
                    displayInfo: true,
                    displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
                    beforePageText: '<?php __('Page'); ?>',
                    afterPageText: '<?php __('of {0}'); ?>',
                    emptyMsg: '<?php __('No data to display'); ?>'
                })
            });
            p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
                p.getTopToolbar().findById('edit-scale').enable();
                p.getTopToolbar().findById('delete-scale').enable();
                p.getTopToolbar().findById('view-scale').enable();
                if(this.getSelections().length > 1){
                    p.getTopToolbar().findById('edit-scale').disable();
                    p.getTopToolbar().findById('view-scale').disable();
                }
            });
            p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
                if(this.getSelections().length > 1){
                    p.getTopToolbar().findById('edit-scale').disable();
                    p.getTopToolbar().findById('view-scale').disable();
                    p.getTopToolbar().findById('delete-scale').enable();
                }
                else if(this.getSelections().length == 1){
                    p.getTopToolbar().findById('edit-scale').enable();
                    p.getTopToolbar().findById('view-scale').enable();
                    p.getTopToolbar().findById('delete-scale').enable();
                }
                else{
                    p.getTopToolbar().findById('edit-scale').disable();
                    p.getTopToolbar().findById('view-scale').disable();
                    p.getTopToolbar().findById('delete-scale').disable();
                }
            });
            center_panel.setActiveTab(p);
	
            store_scales.load({
                params: {
                    start: 0,          
                    limit: list_size
                }
            });
	
        }
