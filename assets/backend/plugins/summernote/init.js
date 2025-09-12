function set_summernote_init(){
	try{
		var toolbar=[
			['undoredo',['style','undo','redo']],
			['style', ['bold', 'italic', 'underline', 'clear']],
			['insert', ['table','link','hr','image','video']],
			['fontsize', ['fontname','fontsize','color']],		   					   
			['para', ['ul', 'ol', 'paragraph']],
			['height', ['height']] ,
			['codeview', ['codeview','fullscreen2']],
		];
		$( '.html_editor').each(function(){ 
			var height	= $(this).data('height') || 300; 
			var minheight=$(this).css('min-height');
			try{ if(!minheight){ minheight=null; } }catch(e){minheight=null;}
			$(this).summernote({
				height:height,
				minHeight: minheight,
				toolbar:toolbar,
			});
		});
		
	}catch(e){
		//alert(e.message);
	}	
}
$(function(){
	set_summernote_init();
});