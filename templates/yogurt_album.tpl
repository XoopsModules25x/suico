<{include file="db:yogurt_navbar.tpl"}>

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
<div id="yogurt-album-container" class="outer">
    <h4 class="head">
        <{if $isOwner}>
            <{$lang_mysection}>
        <{else}>
            <{$owner_uname}> <{$section_name}>
        <{/if}>
    </h4>
    <{if $lang_nopicyet=="" }>
    <{section name=i loop=$pics_array}>
    <{if (($pics_array[i].private == 0))}>
    <div class="yogurt-album-picture <{ cycle values=" odd,even
    "}>">
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
    <{if ($pics_array[i].private == 1) }>
        <p><span class="yogurt-album-private"> Private </span></p>
        <p class="yogurt-album-picture-img"><a href="<{$xoops_url}>/uploads/yogurt/images/resized_<{$pics_array[i].url}>" rel="lightbox[album]" title="<{$pics_array[i].desc}>">
                <img class="thumb" src="<{$xoops_url}>/uploads/yogurt/images/thumb_<{$pics_array[i].url}>" rel="lightbox" title="<{$pics_array[i].desc}>">
            </a></p>
        <p id="yogurt-album-picture-desc"><{$pics_array[i].desc}></p>
    <{/if}>

    <p class="yogurt-album-picture-img"><a href="<{$xoops_url}>/uploads/yogurt/images/resized_<{$pics_array[i].url}>" rel="lightbox[album]" title="<{$pics_array[i].desc}>">
            <img class="thumb" src="<{$xoops_url}>/uploads/yogurt/images/thumb_<{$pics_array[i].url}>" rel="lightbox" title="<{$pics_array[i].desc}>">
        </a></p>
    <p id="yogurt-album-picture-desc"><{$pics_array[i].desc}></p>

</div>
    <{else}>
<div class="yogurt-album-picture <{ cycle values=" odd,even
    "}>">
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
    <{if ($pics_array[i].private == 1) }>
        <p><span class="yogurt-album-private"> Private </span></p>
        <p class="yogurt-album-picture-img"><a href="<{$xoops_url}>/uploads/yogurt/images/resized_<{$pics_array[i].url}>" rel="lightbox[album]" title="<{$pics_array[i].desc}>">
                <img class="thumb" src="<{$xoops_url}>/uploads/yogurt/images/thumb_<{$pics_array[i].url}>" rel="lightbox" title="<{$pics_array[i].desc}>">
            </a></p>
        <p id="yogurt-album-picture-desc"><{$pics_array[i].desc}></p>
    <{/if}>


    </div>
    <{/if}>
    <{/section}>
<{else}>
    <h4 id="yogurt-album-nopic"><{$lang_nopicyet}></h4>
<{/if}>
</div>
<{if $navegacao!='' }>
    <div id="yogurt-navegacao"><{$navegacao}></div>
<{/if}>
<div style="clear:both;width:100%"></div>
<{include file="db:yogurt_footer.tpl"}>
