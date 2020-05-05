<{include file='db:suico_navbar.tpl'}>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div id="content" class="content content-full-width">
                        <!-- start -->

                        <{if $isOwner}>
                            <div class="alert alert-primary">
                                <h5>
                                    <{$lang_addaudios}>
                                </h5>
                                <form name="form_audios" id="form_audios" action="submitAudio.php" method="post" onsubmit="return xoopsFormValidate_form_audios();" enctype="multipart/form-data">
                                    <{$token}>
                                    <div class="form-group">
                                        <label for="audio"><{$lang_audiohelp}><!--<{$smarty.const._MD_SUICO_METAINFOHELP}>--></label>
                                    </div>

                                    <div class="form-group">
                                        <label for="audio"><strong><{$lang_titleLabel}></strong></label>
                                        <input type='text' name='title' id='title' class="form-control" value='' required>
                                    </div>

                                    <div class="form-group">
                                        <label for="audio"><strong><{$lang_authorLabel}></strong></label>
                                        <input type='text' name='author' id='author' class="form-control" value='' required>
                                    </div>

                                    <div class="form-group">
                                        <label for="audio"><strong><{$lang_selectaudio}></strong></label>
                                        <input type='hidden' name='MAX_FILE_SIZE' value='<{$max_youcanupload}>'>
                                        <input type='file' name='sel_audio' id='sel_audio' class='form-control-file'>
                                        <input type='hidden' name='xoops_upload_file[]' id='xoops_upload_file[]' value='sel_audio'>
                                    </div>

                                    <input type='submit' class='btn btn-primary' name='submit_button' id='submit_button' value='<{$lang_submitValue}>'>
                                </form>

                            </div>
                        <{/if}>

                        <h5>
                            <{$section_name}>
                        </h5>

                        <{if $countAudio > 0}>
                            <div id="suico-audio-allaudiocontainer">

                                <{*    <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="240" height="20" id="dewplayer" align="middle">*}>
                                <{*        <param name="wmode" value="transparent">*}>
                                <{*        <param name="allowScriptAccess" value="sameDomain">*}>
                                <{*        <param name="movie" value="audioplayers/dewplayer-multi.swf?mp3=<{$audio_list}>">*}>
                                <{*        <param name="quality" value="high">*}>
                                <{*        <param name="bgcolor" value="FFFFFF">*}>
                                <{*        <embed src="audioplayers/dewplayer-multi.swf?mp3=<{$audio_list}>" quality="high" bgcolor="FFFFFF" width="240" height="20" name="dewplayer" wmode="transparent" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash"*}>
                                <{*               pluginspage="http://www.macromedia.com/go/getflashplayer"></embed>*}>
                                <{*    </object>*}>

                            </div>
                            <div id="waveform"></div>
                        <{else}>
                            <div class="alert alert-primary">
                                <{$lang_noaudioyet}>
                            </div>
                        <{/if}>



                        <{section name=i loop=$audios}>
                            <div class="suico-audio">
                                <{*            <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="200" height="20" id="dewplayer" align="middle">*}>
                                <{*                <param name="wmode" value="transparent">*}>
                                <{*                <param name="allowScriptAccess" value="sameDomain">*}>
                                <{*                <param name="movie" value="audioplayers/dewplayer.swf?mp3=<{$xoops_url}>/uploads/suico/audio/<{$audios[i].url}>&amp;showtime=1">*}>
                                <{*                <param name="quality" value="high">*}>
                                <{*                <param name="bgcolor" value="FFFFFF">*}>
                                <{*                <embed src="audioplayers/dewplayer.swf?mp3=<{$xoops_url}>/uploads/suico/audio/<{$audios[i].url}>&amp;showtime=1" width="200" height="20" align="middle" quality="high" bgcolor="FFFFFF" name="dewplayer" wmode="transparent" allowScriptAccess="sameDomain"*}>
                                <{*                       type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"></embed>*}>
                                <{*            </object>*}>

                            </div>
                            <div class="audio-play-wrapper">
                                <!-- <a href="#" id="player<{$audios[i].id}>" class="audio-play-button float-left">
                <span class="fa fa-play"></span>
            </a>--> <span><strong><{$audios[i].author}> - <{$audios[i].title}></strong></span>
                            </div>
                            <div id="waveform"></div>
                            <div id="waveform<{$audios[i].id}>" class="waveform-player"></div>
                            <script>
                                let wavesurfer<{$audios[i].id}> = WaveSurfer.create({
                                    container: '#waveform<{$audios[i].id}>',
                                    waveColor: '#aaa',
                                    progressColor: '#333',
                                    cursorColor: '#aaa',
                                    height: 100
                                });
                                wavesurfer<{$audios[i].id}>.load('<{$audio_list[i]}>');
                                $('#waveform<{$audios[i].id}>').click(function () {
                                    wavesurfer<{$audios[i].id}>.play();
                                });
                                wavesurfer<{$audios[i].id}>.on('play', function () {
                                    $('#player<{$audios[i].id}>').html('<span class="fa fa-pause"></span>');
                                });
                                wavesurfer<{$audios[i].id}>.on('pause', function () {
                                    $('#player<{$audios[i].id}>').html('<span class="fa fa-play"></span>');
                                });
                                wavesurfer<{$audios[i].id}>.on('finish', function () {
                                    $('#player<{$audios[i].id}>').html('<span class="fa fa-play"></span>');
                                });
                                $('#player<{$audios[i].id}>').click(function () {
                                    wavesurfer<{$audios[i].id}>.playPause();
                                    return false;
                                });
                            </script>
                            <div class="controls">
                                <button class="btn btn-primary" onclick="wavesurfer<{$audios[i].id}>.skipBackward()">
                                    <span class="fa fa-step-backward"></span>
                                    Backward
                                </button>

                                <button class="btn btn-primary" onclick="wavesurfer<{$audios[i].id}>.playPause()">
                                    <span class="fa fa-play"></span>
                                    Play
                                    /
                                    <span class="fa fa-pause"></span>
                                    Pause
                                </button>

                                <button class="btn btn-primary" onclick="wavesurfer<{$audios[i].id}>.skipForward()">
                                    <span class="fa fa-step-forward"></span>
                                    Forward
                                </button>

                                <button class="btn btn-primary" onclick="wavesurfer<{$audios[i].id}>.toggleMute()">
                                    <span class="fa fa-volume-off"></span>
                                    Toggle Mute
                                </button>
                            </div>
                            <br>
                            <div class="alert alert-primary">
                                <h5><{$smarty.const._MD_SUICO_DESCRIPTION}></h5>
                                <{$audios[i].author}> - <{$audios[i].title}> <br>

                                <p class="text-muted"><span class="fa fa-calendar"></span>
                                    <{if $audios[i].date_created == $audios[i].date_updated}>
                                        <small><{$audios[i].date_created|date_format}></small>
                                    <{else}>
                                        <small><{$audios[i].date_updated|date_format}></small>
                                    <{/if}>
                                </p>

                                <{if '' != $audios[i].meta.Title || '' != $audios[i].meta.Album  || '' != $audios[i].meta.Artist || '' != $audios[i].meta.Year   }><h6> <{$lang_meta}></h6><{/if}>
                                <{if '' != $audios[i].meta.Title}><p class="suico-audio-meta-title"><span class="suico-audio-meta-label"> <{$lang_title}>:</span><{$audios[i].meta.Title}></p><{/if}>
                                <{if '' != $audios[i].meta.Album}><p class="suico-audio-meta-title"><span class="suico-audio-meta-label"> <{$lang_album}>:</span><{$audios[i].meta.Album}></p> <{/if}>
                                <{if '' != $audios[i].meta.Artist}><p class="suico-audio-meta-title"><span class="suico-audio-meta-label"> <{$lang_artist}>:</span><{$audios[i].meta.Artist}></p> <{/if}>
                                <{if '' != $audios[i].meta.Year}><p class="suico-audio-meta-title"><span class="suico-audio-meta-label"> <{$lang_year}>:</span><{$audios[i].meta.Year}></p> <{/if}>
                                <{if $isOwner==1 }>
                                    <form action="delaudio.php" method="post" id="deleteform" class="suico-audio-forms">
                                        <input type="hidden" value="<{$audios[i].id}>" name="cod_audio">
                                        <{$token}>
                                        <input name="submit" type="image" alt="<{$lang_delete}>" title="<{$lang_delete}>" src="<{xoModuleIcons16 delete.png}>">
                                    </form>
                                <{/if}>
                            </div>
                        <{/section}>

                        <div>
                            <{$pageNav}>
                        </div>

                        <{include file="db:suico_footer.tpl"}>

                        <!-- end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
