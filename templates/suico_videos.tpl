<{include file='db:suico_navbar.tpl'}>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div id="content" class="content content-full-width">
                        <!-- start -->


                        <{if $isOwner }>
                            <div class="alert alert-primary">
                                <h5>
                                    <{$lang_addvideos}>
                                </h5>
                                <form name="form_videos" id="form_videos" action="submitVideo.php" method="post" onsubmit="return xoopsFormValidate_form_videos();" enctype="multipart/form-data">
                                    <{$token}>

                                    <div class="form-group">
                                        <label for="video"><{$lang_videohelp}> <{$xoops_sitename}>. <{$lang_selectfeaturedvideo}></label>
                                    </div>

                                    <div class="form-group">
                                        <label for="video_title"><strong><{$smarty.const._MD_SUICO_VIDEOTITLE}> </strong></label>
                                        <input type='text' class='form-control' name='title' id='title' size='35' maxlength='55' value='' required>
                                    </div>

                                    <div class="form-group">
                                        <label for="video_desc"><strong> <{$lang_captionLabel}></strong></label>
                                        <textarea class="form-control" name='caption' id='caption' rows='5' cols='50'></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="video"><strong> <{$lang_youtubecodeLabel}></strong></label>
										<input type='text' name='videourl' id='videourl' class='form-control' value=''>
                                    `	<label for="video"><small><{$smarty.const._MD_SUICO_YOUTUBE_CODEHELP}></small></label>
									</div>

                                    <input type='submit' class='btn btn-primary' name='submit_button' id='submit_button' value='<{$lang_submitValue}>'>
                                </form>
                                <!-- Start Form Validation JavaScript //-->
                                <script type='text/javascript'>
                                    <!--//
                                    function xoopsFormValidate_form_videos() {
                                        myform = window.document.form_videos;
                                        if (myform.videourl.value == "") {
                                            window.alert("Please enter YouTube code");
                                            myform.videourl.focus();
                                            return false;
                                        }

                                    //-->
                                </script>
                                <!-- End Form Vaidation JavaScript //-->
                            </div>
                        <{/if}>

                        <h5>
                            <a href="<{$xoops_url}>/userinfo.php?uid=<{$owner_uid|default:''}>">
                                <{$lang_videos}>
                            </a>
                        </h5>

                        <{if $countVideos<=0}>
                            <div class="alert alert-primary"><{$lang_novideoyet}></div>
                        <{/if}>

                        <br>

                        <{section name=i loop=$videos}>
                            <h6><a name="<{$videos[i].id}>"><{$videos[i].title}></a></h6>
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<{$videos[i].url}>?rel=0" allowfullscreen></iframe>
                            </div>
                            <div class="alert alert-primary">
								<{if $videos[i].featured_video==1}>
                                    <button class="btn btn-danger btn-sm float-right" title="<{$smarty.const._MD_SUICO_FEATUREDVIDEOPROFILE}>"><span class='fa fa-youtube-play' title='<{$smarty.const._MD_SUICO_FEATUREDVIDEOPROFILE}>'></span>&nbsp;<{$smarty.const._MD_SUICO_VIDEO_FEATURED}></button>
                                <{/if}>
                                <h6><{$videos[i].title}></h6>
								<{$videos[i].desc}>
								<p class="text-muted"><span class="fa fa-calendar"></span>
                                                        <{if $videos[i].date_created == $videos[i].date_updated}>
                                                            <small><{$videos[i].date_created|date_format}></small>
                                                        <{else}>
                                                            <small><{$videos[i].date_updated|date_format}></small>
                                                        <{/if}>
                                </p>

                                <{if $isOwner==1 }>
                                    <form action="delvideo.php" method="post" id="deleteform" class="suico-video-forms">
                                        <input type="hidden" value="<{$videos[i].id}>" name="cod_video">
                                        <{$token}>
                                        <input name="submit" type="image" alt="<{$lang_delete}>" title="<{$lang_delete}>" src="<{xoModuleIcons16 delete.png}>" class="float-left">
                                    </form>
                                    <form action="editvideo.php" method="post" id="editform" class="suico-video-forms">
                                        <input type="hidden" alt="<{$lang_edit|default:''}>" title="<{$lang_edit|default:''}>" value="<{$videos[i].id}>" name="video_id">
                                        <{$token}>
                                        <input name="submit" type="image" alt="<{$lang_editvideo}>" title="<{$lang_editvideo}>" src="<{xoModuleIcons16 edit.png}>" class="float-left">
                                    </form>
                                    <form action="featuredvideo.php" method="post" id="mainform" class="suico-video-forms">
                                        <input type="hidden" value="<{$videos[i].id}>" name="video_id">
                                        <{$token}>
                                        <input name="submit" type="image" alt="<{$lang_featurethisvideo}>" title="<{$lang_featurethisvideo}>" src="assets/images/featuredvideo.gif" class="float-left">
                                    </form>
                                <{/if}>
                                <br>
                            </div>
                        <{/section}>

                        <{$pageNav}>


                        <{include file="db:suico_footer.tpl"}>

                        <!-- end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
