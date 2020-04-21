<{include file="db:yogurt_navbar.tpl"}>
<{if $isOwner}>
    <div class="alert alert-info">
        <h5>
            <{$lang_addaudios}>
        </h5>
        <form name="form_audios" id="form_audios" action="submitaudio.php" method="post" onsubmit="return xoopsFormValidate_form_audios();" enctype="multipart/form-data">
            <{$token}>
			<div class="form-group">
			<label for="audio"><{$lang_audiohelp}></label>
			</div>
			
			<div class="form-group">
			<label for="audio"><strong><{$lang_titleLabel}></strong></label>
                <label for='title'></label><input type='text' name='title' id='title' class="form-control" value=''>
			</div>
 
			<div class="form-group">
			<label for="audio"><strong><{$lang_authorLabel}></strong></label>
                <label for='author'></label><input type='text' name='author' id='author' class="form-control" value=''>
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


<div id="yogurt-audio-allaudiocontainer" class="outer">
    <h4 id="yogurt-audio-allaudiotitle" class="head">
        <{$player_from_list}>
    </h4>

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

<div id="yogurt-audio-container" class="outer">
    <h4 id="yogurt-audio-title" class="head">
        <a href="<{$xoops_url}>/userinfo.php?uid=<{$owner_uid}>">
            <{$lang_audios}>
        </a>
    </h4>
    <div id="waveform"></div>
    <{if $nb_audio<=0}>
        <h4>
            <{$lang_noaudioyet}>
        </h4>
    <{/if}>



    <{section name=i loop=$audios}>
    <div class="yogurt-audio-container <{cycle values="odd,even"}>">
        <div class="yogurt-audio">
            <{*            <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="200" height="20" id="dewplayer" align="middle">*}>
            <{*                <param name="wmode" value="transparent">*}>
            <{*                <param name="allowScriptAccess" value="sameDomain">*}>
            <{*                <param name="movie" value="audioplayers/dewplayer.swf?mp3=<{$xoops_url}>/uploads/yogurt/audio/<{$audios[i].url}>&amp;showtime=1">*}>
            <{*                <param name="quality" value="high">*}>
            <{*                <param name="bgcolor" value="FFFFFF">*}>
            <{*                <embed src="audioplayers/dewplayer.swf?mp3=<{$xoops_url}>/uploads/yogurt/audio/<{$audios[i].url}>&amp;showtime=1" width="200" height="20" align="middle" quality="high" bgcolor="FFFFFF" name="dewplayer" wmode="transparent" allowScriptAccess="sameDomain"*}>
            <{*                       type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"></embed>*}>
            <{*            </object>*}>

        </div>
        <div class="audio-play-wrapper">
            <a href="#" id="player<{$audios[i].id}>" class="audio-play-button">
                <i class="fa fa-play"></i>
            </a> <span><strong><{$audios[i].title}></strong></span>
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
                $('#player<{$audios[i].id}>').html('<i class="fa fa-pause"></i>');
            });
            wavesurfer<{$audios[i].id}>.on('pause', function () {
                $('#player<{$audios[i].id}>').html('<i class="fa fa-play"></i>');
            });
            wavesurfer<{$audios[i].id}>.on('finish', function () {
                $('#player<{$audios[i].id}>').html('<i class="fa fa-play"></i>');
            });
            $('#player<{$audios[i].id}>').click(function () {
                wavesurfer<{$audios[i].id}>.playPause();
                return false;
            });
        </script>
        <div class="controls">
            <button class="btn btn-primary" onclick="wavesurfer<{$audios[i].id}>.skipBackward()">
                <i class="fa fa-step-backward"></i>
                Backward
            </button>

            <button class="btn btn-primary" onclick="wavesurfer<{$audios[i].id}>.playPause()">
                <i class="fa fa-play"></i>
                Play
                /
                <i class="fa fa-pause"></i>
                Pause
            </button>

            <button class="btn btn-primary" onclick="wavesurfer<{$audios[i].id}>.skipForward()">
                <i class="fa fa-step-forward"></i>
                Forward
            </button>

            <button class="btn btn-primary" onclick="wavesurfer<{$audios[i].id}>.toggleMute()">
                <i class="fa fa-volume-off"></i>
                Toggle Mute
            </button>
        </div>

        <div class="yogurt-audio-details">
            <p class="yogurt-audio-desc">
                <{$audios[i].title}> <{$audios[i].author}>

                <{if '' !== $audios[i].meta.Title}>

                <div class="yogurt-audio-metainfocontainer">
                    <h4 class="yogurt-audio-metainfo"> <{$lang_meta}></h4>
            <p class="yogurt-audio-meta-title"><span class="yogurt-audio-meta-label"> <{$lang_title}>:</span> <{$audios[i].meta.Title}></p>
            <p class="yogurt-audio-meta-title"><span class="yogurt-audio-meta-label"> <{$lang_album}>:</span> <{$audios[i].meta.Album}></p>
            <p class="yogurt-audio-meta-title"><span class="yogurt-audio-meta-label"> <{$lang_artist}>:</span> <{$audios[i].meta.Artist}></p>
            <p class="yogurt-audio-meta-title"><span class="yogurt-audio-meta-label"> <{$lang_year}>:</span> <{$audios[i].meta.Year}></p>
        </div>
        <{/if}>
    </div>


    </p> <{if $isOwner==1 }>
        <form action="delaudio.php" method="post" id="deleteform" class="yogurt-audio-forms">
            <input type="hidden" value="<{$audios[i].id}>" name="cod_audio">
            <{$token}>
            <input name="submit" type="image" alt="<{$lang_delete}>" title="<{$lang_delete}>" src="<{xoModuleIcons16 delete.png}>">
        </form>
    <{/if}>
</div>
<hr>
    </div>
<{/section}>
</div>
<div style="clear:both;width:100%"></div>
<div id="yogurt-navegacao">
    <{$pageNav}>
</div>
<div style="clear:both;width:100%"></div>
<{include file="db:yogurt_footer.tpl"}>
