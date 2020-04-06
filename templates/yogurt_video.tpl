<{include file="db:yogurt_navbar.tpl"}>
<{if $isOwner }>
<div id="yogurt-video-form" class="outer">
    <h4 id="yogurt-video-form-title" class="head">
        <{$lang_addvideos}> 
    </h4>
    <form name="form_videos" id="form_videos" action="video_submited.php" method="post" onsubmit="return xoopsFormValidate_form_videos();" enctype="multipart/form-data">
        <{$token}>
        <p class="even">
            <{$lang_videohelp}> <{$xoops_sitename}>.<br><{$lang_selectmainvideo}>
        </p>
        <p class="odd">
            <label for="codigo">
                <{$lang_youtubecodeLabel}>
                :
            </label>
            <input type='text' name='codigo' id='codigo' size='50' maxlength='250' value=''>
        </p>
        <p class="even">
            <label for="codigo">
                <{$lang_captionLabel}>
                :
            </label>
            <textarea name='caption' id='caption' rows='5' cols='50'></textarea>
        </p>
        <p class="foot">
            <input type='submit' class='formButton' name='submit_button' id='submit_button' value='<{$lang_submitValue}>'>
        </p>
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
            return true;
        }

        //-->
    </script>
    <!-- End Form Vaidation JavaScript //-->
</div>
<{/if}>

<div id="yogurt-videos-container" class="outer">
    <h4 id="yogurt-videos-title" class="head">
        <a href="<{$xoops_url}>/userinfo.php?uid=<{$owner_uid}>">
            <{$lang_videos}>
        </a>
    </h4>
    <{if $nb_videos<=0}>
        <h4>
            <{$lang_novideoyet}> 
        </h4>
    <{/if}>



    <{section name=i loop=$videos}>
        <div class="yogurt-video-container <{cycle values="odd,even"}>">
            <div class="yogurt-video">
                <object width="<{$width}>" height="<{$height}>">
                    <param name="movie" value="http://www.youtube.com/v/<{$videos[i].url}>"></param>
                    <param name="wmode" value="transparent"></param>
                    <embed src="http://www.youtube.com/v/<{$videos[i].url}>" type="application/x-shockwave-flash" wmode="transparent" width="<{$width}>" height="<{$height}>"></embed>
                </object>
            </div>
            <div class="yogurt-video-details">
                <p class="yogurt-video-desc">
                    <{$videos[i].desc}>
                </p> <{if $isOwner==1 }>
                <form action="delvideo.php" method="post" id="deleteform" class="yogurt-video-forms">
                    <input type="hidden" value="<{$videos[i].id}>" name="cod_video">
                    <{$token}>
                    <input name="submit" type="image" alt="<{$lang_delete}>" title="<{$lang_delete}>" src="<{xoModuleIcons16 delete.png}>">
                </form>
                <form action="editdescvideo.php" method="post" id="editform" class="yogurt-video-forms">
                    <input type="hidden" alt="<{$lang_edit}>" title="<{$lang_edit}>" value="<{$videos[i].id}>" name="video_id">
                    <{$token}>
                    <input name="submit" type="image" alt="<{$lang_editdesc}>" title="<{$lang_editdesc}>" src="<{xoModuleIcons16 edit.png}>">
                </form>
                <form action="mainvideo.php" method="post" id="mainform" class="yogurt-video-forms">
                    <input type="hidden" value="<{$videos[i].id}>" name="video_id">
                    <{$token}>
                    <input name="submit" type="image" alt="<{$lang_makemain}>" title="<{$lang_makemain}>" src="assets/images/mainvideo.gif">
                </form>
                <{/if}>
            </div>
        </div>
    <{/section}>
</div>
<div style="clear:both;width:100%"></div>
<div id="yogurt-navegacao">
    <{$pageNav}>
</div>
<div style="clear:both;width:100%"></div>
<{include file="db:yogurt_footer.tpl"}>
