
var store_misLetterDetails = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','mis_letter','mis_letter_id','mis_letter_file','type','account_of','account_number','amount','branch','status','created_by','replied_by','completed_by','letter_prepared_by','remark','file','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'misLetterDetails', 'action' => 'list_data_1')); ?>'
	})
,	sortInfo:{field: 'mis_letter', direction: "ASC"},
	groupField: 'type'
});


function ReplyMisLetterDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'misLetterDetails', 'action' => 'reply')); ?>/'+id,
		success: function(response, opts) {
			var misLetterDetail_data = response.responseText;
			
			eval(misLetterDetail_data);
			
			MisLetterDetailReplyWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the misLetterDetail add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchMisLetterDetail(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'misLetterDetails', 'action' => 'search')); ?>',
		success: function(response, opts){
			var misLetterDetail_data = response.responseText;

			eval(misLetterDetail_data);

			misLetterDetailSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the misLetterDetail search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByMisLetterDetailName(value){
	var conditions = '\'MisLetterDetail.name LIKE\' => \'%' + value + '%\'';
	store_misLetterDetails.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshMisLetterDetailData() {
	store_misLetterDetails.reload();
}

function DownloadMisLetter(id) {
         url = '<?php echo $this->Html->url(array('controller' => 'mis_letters', 'action' => 'download')); ?>/' + id;	
		 window.open(url);
}

if(center_panel.find('id', 'misLetterDetail-tab') != "") {
	var p = center_panel.findById('misLetterDetail-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Mis Letter Details'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'misLetterDetail-tab',
		xtype: 'grid',
		store: store_misLetterDetails,
		columns: [
			{header: "<?php __('MisLetter'); ?>", dataIndex: 'mis_letter', sortable: true},
			{header: "<?php __('mis_letter_id'); ?>", dataIndex: 'mis_letter_id', sortable: true, hidden: true},
			{header: "<?php __('mis_letter_file'); ?>", dataIndex: 'mis_letter_file', sortable: true, hidden: true},
			{header: "<?php __('Type'); ?>", dataIndex: 'type', sortable: true},
			{header: "<?php __('Account Of'); ?>", dataIndex: 'account_of', sortable: true},
			{header: "<?php __('Account Number'); ?>", dataIndex: 'account_number', sortable: true},
			{header: "<?php __('Amount'); ?>", dataIndex: 'amount', sortable: true},
			{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true, hidden: true},
			{header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true},
			{header: "<?php __('Created By'); ?>", dataIndex: 'created_by', sortable: true},
			{header: "<?php __('Replied By'); ?>", dataIndex: 'replied_by', sortable: true, hidden: true},
			{header: "<?php __('Completed By'); ?>", dataIndex: 'completed_by', sortable: true, hidden: true},
			{header: "<?php __('Letter Prepared By'); ?>", dataIndex: 'letter_prepared_by', sortable: true, hidden: true},
			{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true},
			{header: "<?php __('File'); ?>", dataIndex: 'file', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "MisLetterDetails" : "MisLetterDetail"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewMisLetterDetail(Ext.getCmp('misLetterDetail-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [
				{
					xtype: 'tbbutton',
					text: '<?php __('Download Letter'); ?>',
					id: 'misLetterDetail_download',
					tooltip:'<?php __('<b>Download Mis Letter</b><br />Click here to download Mis Letter'); ?>',
					icon: 'img/download.gif',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							DownloadMisLetter(sel.data.mis_letter_id);
						};
					}
				}, ' ', '-', ' ', 
				{
					xtype: 'tbbutton',
					text: '<?php __('Reply'); ?>',
					id: 'misLetterDetail_reply',
					tooltip:'<?php __('<b>Reply Mis Letter</b><br />Click here to reply Mis Letter'); ?>',
					icon: 'img/reply-arrow.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ReplyMisLetterDetail(sel.data.id);
						};
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'misLetterDetail_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByMisLetterDetailName(Ext.getCmp('misLetterDetail_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'misLetterDetail_go_button',
					handler: function(){
						SearchByMisLetterDetailName(Ext.getCmp('misLetterDetail_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchMisLetterDetail();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_misLetterDetails,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		if(this.getSelections()[0].data.status == 'Sent to Branch'){
			p.getTopToolbar().findById('misLetterDetail_reply').enable();
		}
		if(this.getSelections()[0].data.mis_letter_file != 'No file'){
			p.getTopToolbar().findById('misLetterDetail_download').enable();
		}
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('misLetterDetail_reply').disable();
			p.getTopToolbar().findById('misLetterDetail_download').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('misLetterDetail_reply').disable();
			p.getTopToolbar().findById('misLetterDetail_download').disable();
		}
		else if(this.getSelections().length == 1){
			if(this.getSelections()[0].data.status == 'Sent to Branch'){
				p.getTopToolbar().findById('misLetterDetail_reply').enable();
			}
			if(this.getSelections()[0].data.mis_letter_file != 'No file'){
				p.getTopToolbar().findById('misLetterDetail_download').enable();
			}
		}
		else{
			p.getTopToolbar().findById('misLetterDetail_reply').disable();
			p.getTopToolbar().findById('misLetterDetail_download').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_misLetterDetails.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
