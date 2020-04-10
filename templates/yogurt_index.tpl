<{include file="db:yogurt_navbar.tpl"}>

<{if $petition==1 && $isOwner==1 && $isfriend==0}>

    <!-- if not owner and not friend -->
    <div id="yogurt-profile-petition" class="confirmMsg">
        <h4><{$lang_youhavexpetitions}></h4>
        <img width="30" src="<{$xoops_url}>/uploads/<{$petitioner_avatar}>">
        <form action="makefriends.php" method="post">
            <{$lang_askingfriend}>
            <ul>
                <li>
                    <input name="level" type="radio" value="0">
                    <{$lang_rejected}>
                </li>
                <li>
                    <input name="level" type="radio" value="1">
                    <{$lang_accepted}>
                </li>

                <li>
                    <input name="level" type="radio" value="3">
                    <{$lang_acquaintance}>
                </li>

                <li>
                    <input name="level" type="radio" value="5">
                    <{$lang_friend}>
                </li>
            </ul>
            <input type="hidden" name="petition_id" id="petition_id" value="<{$petition_id}>">
            <input type="submit">
            <{$token}>
        </form>
    </div>
<{else}>

    <{if (($isfriend!=1) && ($isOwner==0) && ($isanonym!=1))}>
        <div id="yogurt-profile-petition">
            <form action=submit_friendpetition.php method="post">
               <input type="hidden" name="petitioned_uid" id="petitioned_uid" value="<{$uid_owner}>">
               <button name="" type="image"><{$lang_addasafriend}></button>			 
				<{$token}>
            </form>
        </div>
        <!-- end if -->
    <{/if}>
<{/if}>
<{if $allow_friends }>
<{if $friendsevaluation == 1}>
    <div class="yogurt-nav-bar" id="yogurt-nav-bar">
        <p id="yogurt-profile-fans"><a href="fans.php?uid=<{$uid_owner}>" alt="<{$lang_fans}>" title="<{$lang_fans}>"> <{$lang_fans}> </a><img src="assets/images/fans.gif"> (<{$nb_fans}>)
            | <{$lang_funny}> </p>
        <p id="funnybw"><span id="funnycolor">&nbsp;<img width="<{$funny}>" height="0" src="assets/images/transparent.gif"></span>&nbsp;<img width="<{$funny_rest}>" height="0" src="assets/images/transparent.gif"></p>

        | <{$lang_cool}> <p id="coolbw"><span id="coolcolor">&nbsp;<img width="<{$cool}>" height="0" src="assets/images/transparent.gif"></span>&nbsp;<img width="<{$cool_rest}>" height="0" src="assets/images/transparent.gif"></p>

        | <{$lang_friendly}> <p id="friendlybw"><span id="friendlycolor">&nbsp;<img width="<{$friendly}>" height="0" src="assets/images/transparent.gif"></span>&nbsp;<img width="<{$friendly_rest}>" height="0" src="assets/images/transparent.gif"></p>
    </div>
<{/if}>
<{/if}>

<div class="yogurt-profile-group1">
    <{if $allow_pictures || $allow_videos }>
        <div id="yogurt-profile-visual" class="outer">
            <h4 class="yogurt-profile-title head">
                <{$owner_uname}>
            </h4>
            <{if $allow_pictures }>
                <div id="yogurt-profile-avatar">
                    <{if $avatar_url!="" && $avatar_url!="avatars/blank.gif" }>
                        <img src="<{$xoops_url}>/uploads/<{$avatar_url}>">
                    <{else}>
                        <img src="assets/images/noavatar.gif">
                        <{if $isOwner}>
                            <p>
                                <{$lang_selectavatar}>
                            </p>
                        <{else}>
                            <p>
                                <{$lang_noavatar}>
                            </p>
                        <{/if}>
                    <{/if}>
                </div>
            <{/if}>
        </div>
    <{/if}>



    <{if ($isOwner==1) }>
	     <{if $visitors}>
        <div id="yogurt-album-visitors" class="outer">
            <h4 class="head"><{$lang_profilevisitors}></h4>
            <p>
                <{foreach from=$visitors key=k item=v}>
                    <a href=index.php?uid=<{$k}>> <{$v}> </a>
                    &nbsp;
                <{/foreach}>
            </p>
        </div>
    <{/if}>
    <{/if}>



    <{if $allow_profile_general==1}>
        <div id="yogurt-profile-details" class="outer">
            <h4 class="yogurt-profile-title head"><{$lang_detailsinfo}> <{if $isOwner==1 }><a href="edituser.php" title="<{$lang_editprofile}>"><img src="<{xoModuleIcons16 edit.png}>"></a><{/if}></h4>
            <p class="odd"><img src="assets/images/username.gif"><span class="yogurt-profileinfo-label"><{$lang_uname}>:</span><span class="yogurt-profileinfo-value"><{$user_uname}></span></p>
            <{if $user_realname}>
            <p class="even"><img src="assets/images/username.gif"><span class="yogurt-profileinfo-label"><{$lang_realname}>:</span><span class="yogurt-profileinfo-value"><{$user_realname}></span></p>
            <{/if}>
			<{if $user_location}>
            <p class="odd"><img src="assets/images/house.gif"> <span class="yogurt-profileinfo-label"><{$lang_location}>:</span><span class="yogurt-profileinfo-value"><{$user_location}></span><a href="http://maps.google.com/?q=<{$user_location}>" target="_blank"><img
                            src="assets/images/mapsgoogle.gif"></a></p>
            <{/if}>
			<{if $user_occupation}>
            <p class="even"><img src="assets/images/occ.gif"> <span class="yogurt-profileinfo-label"><{$lang_occupation}>:</span><span class="yogurt-profileinfo-value"><{$user_occupation}></span></p>
            <{/if}>
			<{if $user_interest}>
            <p class="odd"><img src="assets/images/interests.gif"> <span class="yogurt-profileinfo-label"><{$lang_interest}>:</span><span class="yogurt-profileinfo-value"><{$user_interest}></span></p>
            <{/if}>
			<{if $user_extrainfo}>
            <p class="even"><img src="assets/images/bio.gif"> <span class="yogurt-profileinfo-label"><{$lang_extrainfo}>:</span></p>
            <p class="yogurt-profileinfo-valuebigtext odd"><{$user_extrainfo}></p>
            <{/if}>
        </div>
    <{/if}>
    <{if $allow_profile_contact==1}>
        <div id="yogurt-profile-details" class="outer">
            <{if $user_email}>
			 <{if $user_viewemail!='0'}>
			<h4 class="yogurt-profile-title head"><{$lang_contactinfo}> <{if $isOwner==1 }><a href="edituser.php" title="<{$lang_editprofile}>"><img src="<{xoModuleIcons16 edit.png}>"></a><{/if}></h4>
             <{/if}>
			<{/if}>
			
			<{if $user_website}>
            <p class="even"><img src="assets/images/url.gif"> <span class="yogurt-profileinfo-label"><{$lang_website}>:</span><span class="yogurt-profileinfo-value"><{$user_websiteurl}></span></p>
            <{/if}>
			<{if $user_email}>
			 <{if $user_viewemail!='0'}>
            <p class="odd"><img src="assets/images/email.gif"> <span class="yogurt-profileinfo-label"><{$lang_email}>:</span><span class="yogurt-profileinfo-value"><{ mailto address=$user_email encode="javascript"}></span></p>
             <{/if}>
			<{/if}>
            <{if $isanonym!=1 && $isOwner!=1 }>
                <p class="even"><img src="assets/images/email.gif"> <span class="yogurt-profileinfo-label"><{$lang_privmsg}>:</span><span class="yogurt-profileinfo-value"><a href="javascript:openWithSelfMain('<{$xoops_url}>/pmlite.php?send2=1&amp;to_userid=<{$uid_owner}>', 'pmlite', 450, 380);"><img
                                    src="<{$xoops_url}>/images/icons/pm.gif" alt=""></a></span></p>
            <{/if}>
			<{if $user_icq}>
            <p class="odd"><img src="assets/images/icq.gif"> <span class="yogurt-profileinfo-label"><{$lang_icq}>:</span><span class="yogurt-profileinfo-value"><{$user_icq}></span> <!-- <{if $user_icq!=""}><img src="http://status.icq.com/online.gif?icq=<{$user_icq}>&img=21"> <{/if}> --></p>
            <{/if}>
			<{if $user_aim}>
            <p class="even"><img src="assets/images/aim.gif"> <span class="yogurt-profileinfo-label"><{$lang_aim}>:</span><span class="yogurt-profileinfo-value"><{$user_aim}></span></p>
            <{/if}>
			<{if $user_yim}>
            <p class="odd"><img src="assets/images/ym.gif"> <span class="yogurt-profileinfo-label"><{$lang_yim}>:</span><span class="yogurt-profileinfo-value"><{$user_yim}></span></p>
            <{/if}>
			<{if $user_msnm}>
            <p class="even"><img src="assets/images/amsn.gif"> <span class="yogurt-profileinfo-label"><{$lang_msnm}>:</span><span class="yogurt-profileinfo-value"><{$user_msnm}></span></p>
            <{/if}>
        </div>
    <{/if}>



    <{if $allow_profile_stats}>
        <div id="yogurt-profile-statistics" class="outer">
            <h4 class="yogurt-profiletitle head"><{$lang_statistics}></h4>
            <p class="odd"><img src="assets/images/birthday.gif"> <span class="yogurt-profileinfo-label"><{$lang_membersince}>:</span><span class="yogurt-profileinfo-value"><{$user_joindate}></span></p>
            <p class="even"><img src="assets/images/rank.gif"> <span class="yogurt-profileinfo-label"><{$lang_rank}>:</span><span class="yogurt-profileinfo-value"><{$user_rankimage}>  <{$user_ranktitle}></span></p>
            <p class="odd"><img src="assets/images/comments.gif"> <span class="yogurt-profileinfo-label"><{$lang_posts}>:</span><span class="yogurt-profileinfo-value"><{$user_posts}></span></p>
            <p class="even"><img src="assets/images/clock.gif"> <span class="yogurt-profileinfo-label"><{$lang_lastlogin}>:</span><span class="yogurt-profileinfo-value"><{$user_lastlogin}></span></p>
            <{if $user_signature}>
            <p class="odd"><img src="assets/images/signature.gif"> <span class="yogurt-profileinfo-label"><{$lang_signature}>:</span></p>
            <p class="yogurt-profileinfo-valuebigtext even"><{$user_signature}></p>
            <{/if}>
        </div>
    <{/if}>

    <{if $modules!=''}>
    <div id="yogurt-profile-search-results" class="outer">
        <h4 class="yogurt-profiletitle head"><{$lang_usercontributions}></h4>
        <!-- start module search results loop -->
        <{foreach item=module from=$modules name="search_results"}>
            <div class="yogurt-profile-search-module" id="yogurt-profile-search-module-<{$smarty.foreach.search_results.iteration}>">
                <h4 class="yogurt-profiletitle head">
                    <a class="yogurt-profile-search-module-title" id="yogurt-profile-search-module-title-<{$smarty.foreach.search_results.iteration}>">
                        <img src="assets/images/toggle.gif">
                    </a>
                    <{$module.name}>
                </h4>

                <div class="yogurt-profile-search-module-results" id="yogurt-profile-search-module-results-<{$smarty.foreach.search_results.iteration}>">
                    <!-- start results item loop -->
                    <{foreach item=result from=$module.results}>
                        <p class="<{ cycle values=" odd,even
                        "}>">
                        <img src="<{$xoops_url}>/<{$result.image}>" alt="<{$module.name}>">
                        <b>
                            <a href="<{$xoops_url}>/<{$result.link}>">
                                <{$result.title}>
                            </a>
                        </b>
                        <br>
                        <small>(<{$result.time}>)</small>
                        </p>

                    <{/foreach}>
                    <!-- end results item loop -->
                    <p>
                        <{$module.showall_link}>
                    </p>
                </div>
            </div>
        <{/foreach}>
        <!-- end module search results loop -->
    </div>
    <{/if}>
</div><!-- end of div of group1 -->

<div class="yogurt-profile-group2">
    <{if $allow_videos==1 }>
        <div id="yogurt-profile-friends" class="outer">
            <h4 id="titulo-friends" class="head"><{$lang_featuredvideo}></h4>
            <div id="yogurt-profile-group">
                <{if $mainvideocode!="" }>
                    <object width="200" height="150">
                        <param name="movie" value="http://www.youtube.com/v/<{$mainvideocode}>">
                        <param name="wmode" value="transparent">
                        <embed src="http://www.youtube.com/v/<{$mainvideocode}>" type="application/x-shockwave-flash" wmode="transparent" width="200" height="150">
                    </object>
                    <p id="yogurt-profile-mainvideo-desc">
                        <{$mainvideodesc}>
                    </p>
                    <p id="yogurt-profile-friend-viewall" class="foot">
                        <a href="video.php?uid=<{$uid_owner}>"><{$lang_viewallvideos}></a>
                    </p>
                <{else}>
                        <p>
                            <{$lang_nomainvideo}>
                        </p>
                <{/if}>
            </div>
        </div>
    <{/if}>
    <{if $allow_friends==1 }>
        <div id="yogurt-profile-friends" class="outer">
            <h4 id="titulo-friends" class="head"><{$lang_friendstitle}> (<{$nb_friends}>)</h4>
            <{if $nb_friends==0}><p id="nofriends"><{$lang_nofriendsyet}></p><{/if}>
            <{section name=i loop=$friends}>
                <div class="yogurt-profile-friend <{cycle values="odd,even"}>">
                    <a href="<{$xoops_url}>/modules/yogurt/index.php?uid=<{$friends[i].uid}>" alt="<{$friends[i].uname}>" title="<{$friends[i].uname}>"><{if $friends[i].user_avatar=="avatars/blank.gif"}>
                            <img class="yogurt-profile-friend-photo" src="assets/images/noavatar.gif">
                        <{else}>
                            <img class = "yogurt-profile-friend-photo" src="<{$xoops_upload_url}>/<{$friends[i].user_avatar}>"><{/if}><{$friends[i].uname}> </a>
                </div>
            <{/section}>
            <p id="yogurt-profile-friend-viewall" class="foot">
                <a href="friends.php?uid=<{$uid_owner}>"><{$lang_viewallfriends}></a>
            </p>
        </div>
    <{/if}>
    <{if $allow_groups==1}>
        <div id="yogurt-profile-groups" class="outer">
            <h4 class="yogurt-profiletitle head"><{$lang_groups}> (<{$nb_groups}>)</h4>
            <{if $nb_groups==0}><p id="nogroups"><{$lang_nogroupsyet}></p><{/if}>
            <{section name=i loop=$groups}>
                <div class="yogurt-profile-group <{cycle values="odd,even"}>">
                    <a href="group.php?group_id=<{$groups[i].group_id}>"><img alt="<{$groups[i].title}>" title="<{$groups[i].title}>" class="yogurt-profile-groups-img" src="<{$xoops_upload_url}>/yogurt/groups/<{$groups[i].img}>"></a> <h4> <{$groups[i].title}> </h4>
                    <p><{$groups[i].desc}></p>
                </div>
            <{/section}>
            <p id="yogurt-profile-friend-viewall" class="foot">
                <a href="groups.php?uid=<{$uid_owner}>"><{$lang_viewallgroups}></a>
            </p>
        </div>
    <{/if}>
</div><!-- end of group2 -->
<{include file="db:yogurt_footer.tpl"}>
