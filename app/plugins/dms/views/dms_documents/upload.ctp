		<?php
			$this->ExtForm->create('DmsDocument');
			$this->ExtForm->defineFieldFunctions();
		?>
		
	var AwesomeUploaderInstance1 = new AwesomeUploader({
		width:500,
		height:250,
		disableFlash:true,
		maxFileSizeBytes:5003145728,
		flashSwfUploadPath:'<?php echo '/AbayERP/js/extjs/upload/swfupload.swf'; ?>',
		standardUploadUrl:'<?php echo $this->Html->url(array('controller' => 'dmsDocuments', 'action' => 'upload')); ?>',
		xhrUploadUrl:'<?php echo $this->Html->url(array('controller' => 'dmsDocuments', 'action' => 'uploadxhr')); ?>',
		flashUploadUrl:'<?php echo $this->Html->url(array('controller' => 'dmsDocuments', 'action' => 'upload')); ?>',
		extraPostData:{
			parent_id:<?php echo $parent_id; ?>,
			user_id:<?php echo $user_id; ?>
		},
		xhrExtraPostDataPrefix:'parent_id=<?php echo $parent_id; ?>',
		listeners:{
				scope:this,
				fileupload:function(uploader, success, result){
					if(success){
						RefreshDmsDocumentData();
					}
				}
			}
	});
		
		var DmsDocumentUploadWindow = new Ext.Window({
			title: '<?php __('File Uploader'); ?>',
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
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					DmsDocumentUploadWindow.close();
				}
			}]
		});
