<{include file='db:yogurt_navbar.tpl'}>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
   <div class="row">
      <div class="col-md-12">
         <div id="content" class="content content-full-width">
<!-- start -->


<{if $isOwner }>
<div class="alert alert-info">
    <h5>
        <{$lang_addvideos}> 
    </h5>
    <form name="form_videos" id="form_videos" action="submitVideo.php" method="post" onsubmit="return xoopsFormValidate_form_videos();" enctype="multipart/form-data">
        <{$token}>
		
		<div class="form-group">
			<label for="video"><{$lang_videohelp}> <{$xoops_sitename}>. <{$lang_selectmainvideo}></label>
		</div>
		
		<div class="form-group">
			<label for="video"><strong> <{$lang_youtubecodeLabel}></strong></label>
			<input type='text' name='codigo' id='codigo' class='form-control' value=''>
		</div>
          
        <div class="form-group">
			<label for="video"><strong> <{$lang_captionLabel}></strong></label>
			 <textarea class="form-control" name='caption' id='caption' rows='5' cols='50'></textarea>
		</div>
            
          <input type='submit' class='btn btn-primary' name='submit_button' id='submit_button' value='<{$lang_submitValue}>'>
      </form>
    <!-- Start Form Validation JavaScript //-->
    <script type='text/javascript'>
        <!--//
        function xoopsFormValidate_form_videos() {
            myform = window.document.form_videos;
            if (myform.codigo.value == "") {
                window.alert("Please enter YouTube code");
                myform.codigo.focus();
                return false;
            }
            //-->
        </script>
        <!-- End Form Vaidation JavaScript //-->
    </div>
<{/if}>

    <h5>
        <a href="<{$xoops_url}>/userinfo.php?uid=<{$owner_uid}>">
            <{$lang_videos}>
        </a>
    </h5>
    <{if $nb_videos<=0}>
        <h4>
            <{$lang_novideoyet}>
        </h4>
    <{/if}>

 <{if $nb_videos<=0}>
		<div class="alert alert-info"><{$lang_novideoyet}></div>
    <{/if}>



    <{section name=i loop=$videos}>
         
	<div class="embed-responsive embed-responsive-16by9">
   <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<{$videos[i].url}>?rel=0" allowfullscreen></iframe>
   </div>
                
               <div class="alert alert-info">
                       <{$videos[i].desc}>
					   <{if $isOwner==1 }>
                    <form action="delvideo.php" method="post" id="deleteform" class="yogurt-video-forms">
                        <input type="hidden" value="<{$videos[i].id}>" name="cod_video">
                        <{$token}>
                        <input name="submit" type="image" alt="<{$lang_delete}>" title="<{$lang_delete}>" src="<{xoModuleIcons16 delete.png}>" class="float-left">
                    </form>
                    <form action="editdescvideo.php" method="post" id="editform" class="yogurt-video-forms">
                        <input type="hidden" alt="<{$lang_edit}>" title="<{$lang_edit}>" value="<{$videos[i].id}>" name="video_id">
                        <{$token}>
                        <input name="submit" type="image" alt="<{$lang_editdesc}>" title="<{$lang_editdesc}>" src="<{xoModuleIcons16 edit.png}>" class="float-left">
                    </form>
                    <form action="mainvideo.php" method="post" id="mainform" class="yogurt-video-forms">
                        <input type="hidden" value="<{$videos[i].id}>" name="video_id">
                        <{$token}>
                        <input name="submit" type="image" alt="<{$lang_makemain}>" title="<{$lang_makemain}>" src="assets/images/mainvideo.gif" class="float-left">
                    </form>
                <{/if}>
				<br>
               </div>
	

    <{/section}>

    <{$pageNav}>


<{include file="db:yogurt_footer.tpl"}>

<!-- end -->
</div>
      </div>
   </div>
</div>
    	</div>
</div>