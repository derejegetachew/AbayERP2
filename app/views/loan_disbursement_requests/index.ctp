
var store_loanDisbursementRequests = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name_of_applicants','purpose_of_loan','branch','approval_committee','date_of_approval','sector','company_size','amount_approved','disbursement_amount_requested','amount_disbursed','undisbursed_amount','fcy_generated','date_dsb_requested','approval_status'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'loanDisbursementRequests', 'action' => 'list_data')); ?>'
	})

});




function AddLoanDisbursementRequest() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'loanDisbursementRequests', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var loanDisbursementRequest_data = response.responseText;
			
			eval(loanDisbursementRequest_data);
			
			LoanDisbursementRequestAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the loanDisbursementRequest add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditLoanDisbursementRequest(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'loanDisbursementRequests', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var loanDisbursementRequest_data = response.responseText;
			
			eval(loanDisbursementRequest_data);
			
			LoanDisbursementRequestEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the loanDisbursementRequest edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ReportLoanDisbursementRequest(){




//window.location.assign("http://10.1.85.85:8080/iportal/iv?__report=%2f%24%24%24Transient%2facfile43822%2erptdocument&__design=C%3a%2fUsers%2fAdministrator%2fWorkspace%2fLoanDisbursementRequest%2fReport%20Designs%2fLoanDisbRequest%2erptdesign&connectionHandle=46315&__vp=workgroup&__masterpage=true&__locale=en_US&__svg=true&__rtl=false&__timezone=EAT&__asattachment=false")	;
//window.href("http://10.1.85.85:8080/iportal/iv?__report=%2f%24%24%24Transient%2facfile43822%2erptdocument&__design=C%3a%2fUsers%2fAdministrator%2fWorkspace%2fLoanDisbursementRequest%2fReport%20Designs%2fLoanDisbRequest%2erptdesign&connectionHandle=46315&__vp=workgroup&__masterpage=true&__locale=en_US&__svg=true&__rtl=false&__timezone=EAT&__asattachment=false");
// location.href = "http://10.1.85.85:8080/iportal/frameset?__report=C%3A%5CUsers%5CAdministrator%5CWorkspace%5CLoanDisbursementReq%5CReport+Designs%5Cloan_disbursement_report.rptdesign&__format=html&__svg=true&__locale=en_US&__timezone=EAT&__masterpage=true&__rtl=false&__cubememsize=1000&__resourceFolder=C%3A%5CUsers%5CAdministrator%5CWorkspace%5CLoanDisbursementReq&1003764429&PurposeOfLoanParameter=EXPORT";
<?php if ($is_branch){  ?>
//	location.href = "http://10.1.85.85:8080/iportal/iv?__report=%2f%24%24%24Transient%2facfile76062%2erptdocument&__design=C%3a%2fUsers%2fAdministrator%2fWorkspace%2fLoanDisbursementRequest%2fReport%20Designs%2fLoanDisbRequest%2erptdesign&connectionHandle=80363&__vp=workgroup&__masterpage=true&__locale=en_US&__svg=true&__rtl=false&__timezone=EAT&__asattachment=false&branch="+"<?php echo $branch_id ; ?>";
location.href = "http://10.1.85.85:8080/iportal/frameset?__report=C%3A%5CUsers%5CAdministrator%5CWorkspace%5CLoanDisbursementRequest%5CReport+Designs%5CLoanDisbRequest.rptdesign&__format=html&__svg=true&__locale=en_US&__timezone=EAT&__masterpage=true&__rtl=false&__cubememsize=1000&__resourceFolder=C%3A%5CUsers%5CAdministrator%5CWorkspace%5CLoanDisbursementRequest&-418519457&branch="+"<?php echo $branch_id ; ?>";
<?php } else { ?>
//	location.href = "http://10.1.85.85:8080/iportal/frameset?__report=C%3A%5CUsers%5CAdministrator%5CWorkspace%5CLoanDisbursementRequest%5CReport+Designs%5CLoanDisbRequest.rptdesign&__format=html&__svg=true&__locale=en_US&__timezone=EAT&__masterpage=true&__rtl=false&__cubememsize=1000&__resourceFolder=C%3A%5CUsers%5CAdministrator%5CWorkspace%5CLoanDisbursementRequest&-418519457&branch=377";

 location.href = "http://10.1.85.85:8080/iportal/frameset?__report=C%3A%5CUsers%5CAdministrator%5CWorkspace%5CLoanDisbursementReq%5CReport+Designs%5CloanDisbursementReport.rptdesign&__format=html&__svg=true&__locale=en_US&__timezone=EAT&__masterpage=true&__rtl=false&__cubememsize=1000&__resourceFolder=C%3A%5CUsers%5CAdministrator%5CWorkspace%5CLoanDisbursementReq&1458719884&branch=0";
<?php } ?>




}

function ViewLoanDisbursementRequest(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'loanDisbursementRequests', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var loanDisbursementRequest_data = response.responseText;

            eval(loanDisbursementRequest_data);

            LoanDisbursementRequestViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the loanDisbursementRequest view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteLoanDisbursementRequest(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'loanDisbursementRequests', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('LoanDisbursementRequest successfully deleted!'); ?>');
			RefreshLoanDisbursementRequestData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the loanDisbursementRequest add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchLoanDisbursementRequest(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'loanDisbursementRequests', 'action' => 'search')); ?>',
		success: function(response, opts){
			var loanDisbursementRequest_data = response.responseText;

			eval(loanDisbursementRequest_data);

			loanDisbursementRequestSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the loanDisbursementRequest search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByLoanDisbursementRequestName(value){
	var conditions = '\'LoanDisbursementRequest.name LIKE\' => \'%' + value + '%\'';
	store_loanDisbursementRequests.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshLoanDisbursementRequestData() {
	store_loanDisbursementRequests.reload();
}


if(center_panel.find('id', 'loanDisbursementRequest-tab') != "") {
	var p = center_panel.findById('loanDisbursementRequest-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Loan Disbursement Requests'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'loanDisbursementRequest-tab',
		xtype: 'grid',
		store: store_loanDisbursementRequests,
		columns: [
			{header: "<?php __('Name Of Applicants'); ?>", dataIndex: 'name_of_applicants', sortable: true},
			{header: "<?php __('Purpose Of Loan'); ?>", dataIndex: 'purpose_of_loan', sortable: true},
			{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true},
			{header: "<?php __('Approval Committee'); ?>", dataIndex: 'approval_committee', sortable: true},
			{header: "<?php __('Date Of Approval'); ?>", dataIndex: 'date_of_approval', sortable: true},
			{header: "<?php __('Sector'); ?>", dataIndex: 'sector', sortable: true},
			{header: "<?php __('Company Size'); ?>", dataIndex: 'company_size', sortable: true},
			{header: "<?php __('Amount Approved'); ?>", dataIndex: 'amount_approved', sortable: true},
			{header: "<?php __('Disbursement Amount Requested'); ?>", dataIndex: 'disbursement_amount_requested', sortable: true},
			{header: "<?php __('Amount Disbursed'); ?>", dataIndex: 'amount_disbursed', sortable: true},
			{header: "<?php __('Undisbursed Amount'); ?>", dataIndex: 'undisbursed_amount', sortable: true},
			{header: "<?php __('Fcy Generated'); ?>", dataIndex: 'fcy_generated', sortable: true},
			{header: "<?php __('Date Dsb Requested'); ?>", dataIndex: 'date_dsb_requested', sortable: true},
			{header: "<?php __('Approval Status'); ?>", dataIndex: 'approval_status', sortable: true},
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "LoanDisbursementRequests" : "LoanDisbursementRequest"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewLoanDisbursementRequest(Ext.getCmp('loanDisbursementRequest-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add LoanDisbursementRequests</b><br />Click here to create a new LoanDisbursementRequest'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddLoanDisbursementRequest();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-loanDisbursementRequest',
					tooltip:'<?php __('<b>Edit LoanDisbursementRequests</b><br />Click here to modify the selected LoanDisbursementRequest'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditLoanDisbursementRequest(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Report'); ?>',
					id: 'report-loanDisbursementRequest',
					tooltip:'<?php __('<b>Report LoanDisbursementRequests</b><br />Click here to report LoanDisbursementRequest'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: false,
					handler: function(btn) {
					
						
							ReportLoanDisbursementRequest();
						
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-loanDisbursementRequest',
					tooltip:'<?php __('<b>Delete LoanDisbursementRequests(s)</b><br />Click here to remove the selected LoanDisbursementRequest(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove LoanDisbursementRequest'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteLoanDisbursementRequest(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove LoanDisbursementRequest'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected LoanDisbursementRequests'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteLoanDisbursementRequest(sel_ids);
										}
									}
								});
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbsplit',
					text: '<?php __('View LoanDisbursementRequest'); ?>',
					id: 'view-loanDisbursementRequest',
					tooltip:'<?php __('<b>View LoanDisbursementRequest</b><br />Click here to see details of the selected LoanDisbursementRequest'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewLoanDisbursementRequest(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '->', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchLoanDisbursementRequest();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_loanDisbursementRequests,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-loanDisbursementRequest').enable();
		p.getTopToolbar().findById('delete-loanDisbursementRequest').enable();
		p.getTopToolbar().findById('view-loanDisbursementRequest').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-loanDisbursementRequest').disable();
			p.getTopToolbar().findById('view-loanDisbursementRequest').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-loanDisbursementRequest').disable();
			p.getTopToolbar().findById('view-loanDisbursementRequest').disable();
			p.getTopToolbar().findById('delete-loanDisbursementRequest').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-loanDisbursementRequest').enable();
			p.getTopToolbar().findById('view-loanDisbursementRequest').enable();
			p.getTopToolbar().findById('delete-loanDisbursementRequest').enable();
		}
		else{
			p.getTopToolbar().findById('edit-loanDisbursementRequest').disable();
			p.getTopToolbar().findById('view-loanDisbursementRequest').disable();
			p.getTopToolbar().findById('delete-loanDisbursementRequest').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_loanDisbursementRequests.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
