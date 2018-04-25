		$(document).ready(function(e){
			$("#sb_title,#sb_content").removeAttr("data-target","#myModal");
			$("#sb_title").click(function(){ //gan bien chon khi click
				chon = "title";
			});
			$("#sb_content").click(function(){
				chon = "content";
			});
			jQuery(function($){
				$("#btnsubmit").click(function(){
					var url = $("#url").val();
					if(url==''){
						alert('Bạn chưa nhập url');
					}
					jQuery.ajax({
						url: ajaxurl,
						type: 'post',
						data: {
							action : 'check_url',
							get_url :  $("#url").val()
						},
						success:function(kq){
							//$("#content").html(kq);
							if(kq == 'false'){
							
								alert('sai');
							}else{
								jQuery(".modal-body").html(kq);
								jQuery("#sb_title,#sb_content").attr("data-target","#myModal");
								var iframe = $('.modal-body'); 
		                        iframe.contents()
	                            .on('mouseover', function(event) {
	                                $(event.target).css("background-color","lightblue"); //khi mouseover thi background se thay doi
	                            })
	                            .on('mouseout', function(event) {
	                                $(event.target).css("background-color","inherit");
	                            })
	                            .on('click', function(event) {
	                            	$(event.target).css("background-color","inherit"); //giu lai background mac dinh khi click
	                            	event.preventDefault();	//chan cac the a tren url
	                            	if (chon == "title") {	
	                            		input_data = event.target.textContent;
	                            		$('#id_title').val(input_data); //nhan du lieu do vao the title
	                            	}
	                            	else if(chon == "content"){
		                            	input_data = event.target.outerHTML;
		                                $('#id_content').val(input_data); //nhan du lieu do vao the content
	                            	}
	                            	$('#myModal').modal('hide');
	                            });
							}
						},
						error:function(errorThrown){
							alert('kiểm tra lại url');
						}
					});
					return false;
				});
			});
/*------------------------------------version free----------------------------------------------- */
			// jQuery(function($){
			// 	$("ok").click(function(){
			// 		if( $("#id_title").val() == '' || $("#id_content").val() == '')
			// 		{
			// 			alert("Kiểm tra lại nội dung");
			// 		}else{
			// 			jQuery.ajax({
			// 				url:ajaxurl,
			// 				type: "post",
			// 				data:{
			// 					action: "save_free",
			// 					post_title: $("#id_title").val(),
			// 					post_content: $("#id_content").val(),
			// 					post_status: $("#status").val(),
			// 					post_category: $("#category").val()
			// 				},
			// 				success:function(kq){
			// 					console.log('a');
			// 				},
			// 				error:function(error){
			// 					alert("lưu thất bại");
			// 				}
			// 			});
			// 		}
			// 	});
			// });
/* -------------------------------------------lưu ảnh vào post------------------------------------------------- */
			jQuery(function($){
				$("#ok").click(function(){
					if($("#id_title").val()== '' || $("#id_content").val() == '')
					{
						alert('kiểm tra lại nội dung');
					}else {
						if($("#option").val() == 'wpmedia')
						{
							jQuery.ajax({
								url: ajaxurl,
								type: 'post',
								data:{
								  action: 'save_post',
								  post_title: $("#id_title").val(),
								  post_content : $("#id_content").val(),
								  post_status : $("#status").val(),
								  post_category : $("#category").val()
								},
								success:function(result){
									//$('#content').html(result);
									//console.log('a');
									alert("lưu thành công");
								},
								error:function(error){
									alert('save error');
								}
							});
						}else{
							jQuery.ajax({
								url: ajaxurl,
								type: 'post',
								data:{
									action: 'aws',
									post_title: $("#id_title").val(),
									post_content : $("#id_content").val(),
									post_status : $("#status").val(),
									post_category : $("#category").val()
								},
								success:function(kq){
									alert("upload thành công");
								},
								error:function(error){
									alert("upload lỗi");
								}
							});
						}
					}
				});
			});
/*------------------------------------------PRO or Free---------------------------------------------------- */
			jQuery(function($){
				$("#pro").click(function(){
					if( $("#key_id").val() == '' )
					{
						alert('Bạn chưa nhập key');
					}else{
						jQuery.ajax({
							url: ajaxurl,
							type: 'post',
							data:{
								action : 'up_license',
								key : $('#key_id').val()
							},
							success:function(kq){
				    			if (kq == 'ok') {
								window.location.reload();
								}else if (kq == 'no'){
								alert("Sorry can not active!!!");
								}
							},
							error:function(error){
								alert('lỗi');
							}
						});
					}
				});
			});
		}); 