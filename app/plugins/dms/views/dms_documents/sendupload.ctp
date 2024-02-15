
	var AwesomeUploaderInstance1 = new AwesomeUploader({
		width:500,
		height:250,
		maxFileSizeBytes:5003145728,
		flashSwfUploadPath:'<?php echo 'http://localhost/AbayERP-Server-test/js/extjs/upload/swfupload.swf'; ?>',
		standardUploadUrl:'<?php echo $this->Html->url(array('controller' => 'dmsDocuments', 'action' => 'sendupload')); ?>',
		xhrUploadUrl:'<?php echo $this->Html->url(array('controller' => 'dmsDocuments', 'action' => 'senduploadxhr')); ?>',
		flashUploadUrl:'<?php echo $this->Html->url(array('controller' => 'dmsDocuments', 'action' => 'sendupload')); ?>',
		extraPostData:{
			message_id:<?php echo $message_id; ?>,
			user_id:<?php echo $user_id; ?>
		},
		xhrExtraPostDataPrefix:'message_id=<?php echo $message_id; ?>',
		listeners:{
				scope:this,
				fileupload:function(uploader, success, result){
					if(success){
						//RefreshDmsDocumentData();
					}
				}
			}
	});
		
		var DmsDocumentUploadWindow = new Ext.Window({
			title: '<?php __('Select Files To Send'); ?>',
			width: 460,
			minWidth: 250,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: AwesomeUploaderInstance1,
			buttons: [{
				text: '<?php __('Finish'); ?>',
				handler: function(btn){
					DmsDocumentUploadWindow.close();
				}
			}]
		});
