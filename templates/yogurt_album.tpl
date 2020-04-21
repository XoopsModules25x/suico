<{include file="db:yogurt_navbar.tpl"}>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
   <div class="row">
      <div class="col-md-12">
         <div id="content" class="content content-full-width">
<!-- start -->

<{if ($showForm==1) }>
<div class="alert alert-info">
    <h5>
        <{$lang_formtitle}>
    </h5>
	
    <form name="form_picture" id="form_picture" action="submit.php" method="post" enctype="multipart/form-data">
       <{$token}>
		<div class="form-group">
		<label for="album"><{$lang_youcanupload}><br><{$lang_nb_pict}> <{$lang_max_nb_pict}></label>
        </div>
		
		<div class="form-group">
		<label for="selectphoto"><strong><{$lang_selectphoto}> :</strong></label>		
		<input type='hidden' name='MAX_FILE_SIZE' value='<{$maxfilebytes}>'>
		<input type='file' name='sel_photo' id="sel_photo" class='form-control-file'>
		<input type='hidden' name='xoops_upload_file[]' id='xoops_upload_file[]' value='sel_photo'>
        </div> 
		
		<div class="form-group">
		<label><strong><{$lang_caption}> :</strong></label>
		<input type='text' class='form-control' name='caption' id='caption' size='35' maxlength='55' value='' required>
		</div>
  
		<div class="form-group">
		<input type='submit' class='formButton btn btn-primary' name='submit_button'  id='submit_button' value='<{$lang_uploadpicture}>'>
		</div>
     
    </form>
</div>
<{/if}>

    <h5>
            <{$lang_photos}>
    </h5>
    <{if $lang_nopicyet=="" }>
<div class="row">
    <{section name=i loop=$pics_array}>
    <{if (($pics_array[i].private == 0))}>
        <!-- Start Normal Photo -->
		<div class="col-6 h-100 mb-3">
<div class="card" style="width:400px">
		<a href="<{$xoops_url}>/uploads/yogurt/images/resized_<{$pics_array[i].url}>" rel="lightbox[album]" title="<{$pics_array[i].desc}>">
                <img class="card-img-top thumb" src="<{$xoops_url}>/uploads/yogurt/images/<{$pics_array[i].url}>" rel="lightbox" title="<{$pics_array[i].desc}>">
        </a>
			<div class="card-body">
				<h4 class="card-title">&nbsp;</h4>
				<p class="card-text"><{$pics_array[i].desc}></p>
				<{if (($isOwner==1))}>
        <form action="delpicture.php" method="post" id="deleteform" class="yogurt-album-formquick">
            <input type="hidden" value="<{$pics_array[i].cod_img}>" name="cod_img">
            <{$token}>
            <input name="submit" type="image" alt="<{$lang_delete}>" title="<{$lang_delete}>" src="<{xoModuleIcons16 delete.png}>">
        </form>
        <form action="editdescpicture.php" method="post" id="editform" class="yogurt-album-formquick">
            <input type="hidden" value="<{$pics_array[i].cod_img}>" name="cod_img">
            <{$token}>
            <input name="submit" type="image" alt="<{$lang_editdesc}>" title="<{$lang_editdesc}>" src="<{xoModuleIcons16 edit.png}>">
        </form>
        <form action="avatar.php" method="post" id="setavatar" class="yogurt-album-formquick">
            <input type="hidden" value="<{$pics_array[i].cod_img}>" name="cod_img">
            <{$token}>
            <input name="submit" type="image" alt="<{$lang_avatarchange}>" title="<{$lang_avatarchange}>" src="assets/images/avatar.gif">
        </form>
        <form action="private.php" method="post" id="setprivate" class="yogurt-album-formquick">
            <input type="hidden" value="<{$pics_array[i].cod_img}>" name="cod_img">
            <{$token}>
            <{if $pics_array[i].private == 1}>
                <input type="hidden" value="0" name="private">
                <input name="submit" type="image" alt="<{$lang_unsetprivate}>" title="<{$lang_unsetprivate}>" src="assets/images/unlock.gif">
            <{else}>
                <input type="hidden" value="1" name="private">
                <input name="submit" type="image" alt="<{$lang_setprivate}>" title="<{$lang_setprivate}>" src="assets/images/lock.gif">
            <{/if}>
        </form>
    <{/if}>
    </div>
			</div>
	</div>
    
	<!-- End Normal Photo -->
    <{else}>
    <!-- start private photo -->
	<{if ($pics_array[i].private == 1) }>
	<div class="col-6 h-100 mb-3">
	<div class="card" style="width:400px">
		<a href="<{$xoops_url}>/uploads/yogurt/images/resized_<{$pics_array[i].url}>" rel="lightbox[album]" title="<{$pics_array[i].desc}>">
                <img class="card-img-top thumb" src="<{$xoops_url}>/uploads/yogurt/images/<{$pics_array[i].url}>" rel="lightbox" title="<{$pics_array[i].desc}>">
        </a>
			<div class="card-body">
				<h4 class="card-title">&nbsp;</h4>
				<p class="card-text"><{$pics_array[i].desc}></p>
				<p class="text-center"><button class="btn btn-info btn-sm"><i class='fa fa-lock'></i> <{$lang_privatephoto}></button></p>
				<{if (($isOwner==1))}>
        <form action="delpicture.php" method="post" id="deleteform" class="yogurt-album-formquick">
            <input type="hidden" value="<{$pics_array[i].cod_img}>" name="cod_img">
            <{$token}>
            <input name="submit" type="image" alt="<{$lang_delete}>" title="<{$lang_delete}>" src="<{xoModuleIcons16 delete.png}>">
        </form>
        <form action="editdescpicture.php" method="post" id="editform" class="yogurt-album-formquick">
            <input type="hidden" value="<{$pics_array[i].cod_img}>" name="cod_img">
            <{$token}>
            <input name="submit" type="image" alt="<{$lang_editdesc}>" title="<{$lang_editdesc}>" src="<{xoModuleIcons16 edit.png}>">
        </form>
        <form action="avatar.php" method="post" id="setavatar" class="yogurt-album-formquick">
            <input type="hidden" value="<{$pics_array[i].cod_img}>" name="cod_img">
            <{$token}>
            <input name="submit" type="image" alt="<{$lang_avatarchange}>" title="<{$lang_avatarchange}>" src="assets/images/avatar.gif">
        </form>
        <form action="private.php" method="post" id="setprivate" class="yogurt-album-formquick">
            <input type="hidden" value="<{$pics_array[i].cod_img}>" name="cod_img">
            <{$token}>
            <{if $pics_array[i].private == 1}>
                <input type="hidden" value="0" name="private">
                <input name="submit" type="image" alt="<{$lang_unsetprivate}>" title="<{$lang_unsetprivate}>" src="assets/images/unlock.gif">
            <{else}>
                <input type="hidden" value="1" name="private">
                <input name="submit" type="image" alt="<{$lang_setprivate}>" title="<{$lang_setprivate}>" src="assets/images/lock.gif">
            <{/if}>
        </form>
    <{/if}>
    </div>
			</div>
	</div>
        
   <{/if}>


    <{/if}>
	
	<!-- End Private Photo -->
    <{/section}>
</div>
<{else}>
        <div class="alert alert-info"><{$lang_nopicyet}></div>
<{/if}>

<{if $navegacao!='' }>
    <{$navegacao}>
<{/if}>

<{include file="db:yogurt_footer.tpl"}>

<!-- end -->
</div>
      </div>
   </div>
</div>
    	</div>
</div>
