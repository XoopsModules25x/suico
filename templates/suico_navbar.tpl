<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">

            <{if $displaybreadcrumb!=-1}>
                <div class="breadcrumb">
                    <a href="index.php" title="<{$module_name}>">
                        <{$module_name}>
                    </a>
                    &nbsp;&raquo;&nbsp;
                    <a href="index.php?uid=<{$uid_owner}>" title="<{$owner_uname}>">
                        <{$owner_uname}>
                    </a>
                    &nbsp;&raquo;&nbsp;
                    <{$section_name|default:''}>
                </div>
            <{/if}>

            <div class="row">
                <div class="col-md-12">
                    <div id="content" class="content content-full-width">
                        <!-- begin profile -->
                        <div class="profile">
                            <div class="profile-header">
                                <!-- BEGIN profile-header-cover -->
                                <div class="profile-header-cover"></div>
                                <!-- END profile-header-cover -->
                                <!-- BEGIN profile-header-content -->
                                <div class="profile-header-content">

                                    <div class="row float-right">
                                        <{if (($allow_friends !=-1) && ($isFriend!=1) && ($isOwner==0) && ($isAnonym!=1) && ($selffriendrequest!=1) && ($otherfriendrequest!=1))}>
                                            <form action=submitFriendrequest.php method="post">
                                                <input type="hidden" name="friendrequestfrom_uid" id="friendrequestfrom_uid" value="<{$uid_owner}>">
                                                <button name="" type="image" class="btn btn-info btn-sm"><span class="fa fa-user-plus"></span> <{$lang_addfriend}></button>
                                                <{$token}>
                                            </form>
                                        <{/if}>
                                        <{if $allow_friends}>
                                            <{if $isFriend == 1 && $isAnonym!=1}>
                                                <button type="button" class="btn btn-info btn-sm"><span class="fa fa-user-circle"></span> <{$lang_myfriend}></button>
                                            <{/if}>

                                            <{if $selffriendrequest==1 && $self_uid!=0 && $isAnonym!=1}>
                                                <button type="button" class="btn btn-info btn-sm"><span class="fa fa-check-circle"></span> <{$lang_friendrequestsent}></button>
                                                <form action=cancelFriendrequest.php method="post">
                                                    <input type="hidden" name="friendrequestto_uid" id="friendrequestto_uid" value="<{$uid_owner}>">
                                                    <button name="" type="image" class="btn btn-danger btn-sm"><span class="fa fa-remove"></span> <{$lang_cancelfriendrequest}></button>
                                                    <{$token}>
                                                </form>
                                            <{/if}>
                                            <{if $otherfriendrequest==1 && $other_uid!=0 && $isAnonym!=1}>
                                                <button type="button" class="btn btn-info btn-sm"><span class="fa fa-clock-o"></span> <{$lang_friendrequestpending}></button>
                                                <form action=cancelFriendrequest.php method="post">
                                                    <input type="hidden" name="friendrequestto_uid" id="friendrequestto_uid" value="<{$uid_owner}>">
                                                    <button name="" type="image" class="btn btn-danger btn-sm"><span class="fa fa-remove"></span> <{$lang_cancelfriendrequest}></button>
                                                    <{$token}>
                                                </form>
                                            <{/if}>


                                        <{/if}>
                                    </div>

                                    <!-- BEGIN profile-header-img -->
                                    <div class="profile-header-img">

                                        <{if $avatar_url!="" && $avatar_url!="blank.gif" }>
                                            <img src="<{$xoops_url}>/uploads/<{$avatar_url}>" class="rounded-circle float-left" height="140" width="140" alt="<{$owner_uname}>" title="<{$owner_uname}>">
                                        <{else}>
                                            <img src="<{$xoops_url}>/uploads/avatars/blank.gif" class="rounded-circle float-left" height="140" width="140" alt="<{$owner_uname}>" title="<{$owner_uname}>">
                                        <{/if}>

                                    </div>
                                    <!-- END profile-header-img -->
                                    <!-- BEGIN profile-header-info -->
                                    <div class="profile-header-info" style="padding-left:15px;">
                                        <h4 class="m-t-10 m-b-5"><{$owner_uname}></h4> <{if $allow_profile_general==1}><{if $user_realname!=''}><h4 class="m-t-10 m-b-5 font-weight-light"><{$user_uname}></h4><{/if}><{/if}>

                                        <{if $allow_profile_general}>
                                            <{if $user_occupation || $user_location }>
                                                <p class="m-b-10"><{if $user_occupation}><span class="fa fa-briefcase"></span>&nbsp;<{$user_occupation}><{/if}> <{if $user_occupation}><span class="fa fa-map-marker"></span>&nbsp;<{$user_location}><{/if}></p>
                                            <{/if}>
                                        <{/if}>

                                        <{if $allow_profile_contact}>
                                            <{if $user_email || $user_websiteurl }>
                                                <p class="m-b-10">
                                                    <{if $user_viewemail!='0'}><span class="fa fa-envelope"></span>&nbsp;<{mailto address=$user_email encode="javascript"}><{/if}>
                                                    <{if $user_websiteurl}><span class="fa fa-globe"></span>&nbsp;<{$user_websiteurl}><{else}><br><{/if}>
                                                </p>
                                            <{/if}>
                                        <{/if}>

                                        <{if $allow_profile_contact}>
                                            <{if $allow_friends}>
                                                <{if $isAnonym!=1 && $isOwner!=1 }>
                                                    <button type="button" class="btn btn-success btn-sm">
                                                        <a href="javascript:openWithSelfMain('<{$xoops_url}>/pmlite.php?send2=1&amp;to_userid=<{$uid_owner}>', 'pmlite', 450, 380);"><span class="fa fa-envelope-o"></span> <{$smarty.const._MD_SUICO_PRIVATEMESSAGE}></a></button>
                                                <{/if}>
                                            <{/if}>
                                        <{/if}>

                                        <{if $isAnonym!=1 && $isOwner==1}>
                                            <{xoInboxCount assign=pmcount}>
                                            <{if $pmcount}><a href="<{$xoops_url}>/viewpmsg.php" class="btn btn-success btn-sm" > <span class="fa fa-envelope-o"></span> <{$smarty.const._MD_SUICO_PRIVATEMESSAGE}> <span class="badge badge-light"><{$pmcount}></span></a> <{/if}>
                                            <a href="<{$xoops_url}>/modules/suico/edituser.php" class="btn btn-success btn-sm"> <span class="fa fa-edit"></span> <{$smarty.const._MD_SUICO_EDITPROFILE}></a>
                                            <a href="<{$xoops_url}>/modules/suico/configs.php?uid=<{$uid_owner}>" class="btn btn-success btn-sm"> <span class="fa fa-gear"></span> <{$lang_configs}></a>
                                            <a href="<{$xoops_url}>/user.php?op=logout" class="btn btn-success btn-sm"> <span class="fa fa-sign-out"></span> <{$smarty.const._MD_SUICO_LOGOUT}></a>
                                        <{/if}>

                                        <{if $user_onlinestatus == 1}>
                                            <button type="button" class="btn btn-danger btn-sm"><span class="fa fa-user-circle-o"></span> <{$smarty.const._MD_SUICO_ONLINE}></button>
                                        <{else}>
                                            <button type="button" class="btn btn-dark btn-sm"><span class="fa fa-user-circle-o"></span> <{$smarty.const._MD_SUICO_OFFLINE}></button>
                                        <{/if}>

                                        <{if $allow_usersuspension==1}><{if $isWebmaster==1 }> <{if $isOwner!=1}>
                                            <a href="#" name='show_suspension' id='show_suspension' type="button" title="<{$lang_suspensionadmin}>" class="btn btn-sm btn-primary"><span class="fa fa-close"></span> <{$smarty.const._MD_SUICO_SUSPENDUSER}></a>
                                        <{/if}><{/if}><{/if}>

                                        <{if $allow_usersuspension==1}>
                                            <{if $isWebmaster==1 }>
                                                <br>
                                                <div id="suspension" name="suspension" class="alert alert-danger">
                                                    <{if $isSuspended==0 }>
                                                        <form action="suspend.php" method="POST" name="suspend_form" id="suspend_form">
                                                        <div class="form-group">
                                                            <label for="time"><strong><{$lang_timeinseconds}></strong></label>
                                                            <input type="text" name="time" id="time" value="604800" class="form-control">
                                                        </div>
                                                        <{$token}><input type="hidden" value="<{$uid_owner}>" id="uid" name="uid">
                                                        <input type="submit" value="<{$lang_suspend}>" class="btn btn-danger btn-sm">
                                                        </form><{else}> <{$lang_suspended}>
                                                        <form action="unsuspenduser.php" method="POST"><{$token}>
                                                            `<input type="hidden" value="<{$uid_owner}>" id="uid" name="uid">
                                                            <input type="submit" value="<{$lang_unsuspend}>" class="btn btn-success btn-sm">
                                                        </form>
                                                    <{/if}>
                                                </div>
                                            <{/if}>
                                        <{/if}>


                                        <{if $allow_friends !=-1}>
                                            <{if $allow_fanssevaluation == 1}>

                                                <!--    <p id="suico-profile-fans"><a href="fans.php?uid=<{$uid_owner}>" alt="<{$lang_fans}>" title="<{$lang_fans}>"> <{$lang_fans}> </a><span class="fa fa-star" style="color:yellow;"></span> (<{$countFans}>)
                </p>  <{$lang_funny}>
            <p id="funnybw"><span id="funnycolor">&nbsp;<img width="<{$funny}>" height="0" src="assets/images/transparent.gif"></span>&nbsp;<img width="<{$funny_rest}>" height="0" src="assets/images/transparent.gif"></p>

             <{$lang_cool}> <p id="coolbw"><span id="coolcolor">&nbsp;<img width="<{$cool}>" height="0" src="assets/images/transparent.gif"></span>&nbsp;<img width="<{$cool_rest}>" height="0" src="assets/images/transparent.gif"></p>

             <{$lang_friendly}> <p id="friendlybw"><span id="friendlycolor">&nbsp;<img width="<{$friendly}>" height="0" src="assets/images/transparent.gif"></span>&nbsp;<img width="<{$friendly_rest}>" height="0" src="assets/images/transparent.gif"></p>
        -->
                                            <{/if}>
                                        <{/if}>


                                    </div>
                                    <!-- END profile-header-info -->
                                </div>
                                <!-- END profile-header-content -->
                            </div>
                        </div>

                        <!-- BEGIN profile-header-tab -->
                        <ul class="profile-header-tab nav nav-tabs">
                            <li class="nav-item"><a href="index.php?uid=<{$uid_owner}>" class="nav-link <{if $section_name|default:''==$lang_profile}>active show<{/if}>"><small><span class="fa fa-user-circle"></span> <{$lang_profile}></small></a></li>
                            <{if $allow_notes!=0}>
                                <li class="nav-item"><a href="notebook.php?uid=<{$uid_owner}>" class="nav-link <{if $section_name|default:''==$lang_notebook}>active show<{/if}>"><small><span class="fa fa-comment"></span> <{$lang_notebook}> <span
                                                    class="badge badge-pill badge-primary"><{$countNotes}></span></small></a>
                                </li>
                            <{/if}>
                            <{if $allow_pictures !=0}>
                                <li class="nav-item"><a href="album.php?uid=<{$uid_owner}>" class="nav-link <{if $section_name|default:''==$lang_photos}>active show<{/if}>"><small><span class="fa fa-picture-o"></span> <{$lang_photos}> <span class="badge badge-pill badge-primary"><{$countPhotos}></span></small></a>
                                </li><{/if}>
                            <{if $allow_audios !=0}>
                                <li class="nav-item"> <a href="audios.php?uid=<{$uid_owner}>" class="nav-link <{if $section_name|default:''==$lang_audio}>active show<{/if}>"><span><small><span class="fa fa-file-audio-o"></span> <{$lang_audio}> <span
                                                    class="badge badge-pill badge-primary"><{$countAudio}></span></small></a>
                                </li><{/if}>
                            <{if $allow_videos !=0}>
                                <li class="nav-item"><a href="videos.php?uid=<{$uid_owner}>" class="nav-link <{if $section_name|default:''==$lang_videos}>active show<{/if}>"><small><span class="fa fa-youtube-play"></span> <{$lang_videos}> <span
                                                class="badge badge-pill badge-primary"><{$countVideos}></span></small></a>
                                </li><{/if}>
                            <{if $allow_friends !=0}>
                                <li class="nav-item"> <a href="friends.php?uid=<{$uid_owner}>" class="nav-link <{if $section_name|default:''==$lang_friends}>active show<{/if}>"><small><span class="fa fa-user-circle-o"></span> <{$lang_friends}> <span
                                                class="badge badge-pill badge-primary"><{$countFriends}></span></small></a>
                                </li><{/if}>
                            <{if $allow_groups !=0}>
                                <li class="nav-item"> <a href="groups.php?uid=<{$uid_owner}>" class="nav-link <{if $section_name|default:''==$lang_groups}>active show<{/if}>"><small><span class="fa fa-group"></span> <{$lang_groups}> <span class="badge badge-pill badge-primary"><{$countGroups}></span></small></a>
                                </li><{/if}>

                        </ul>
                        <br>

                        <!-- END profile-header-tab -->
                        <!-- end profile -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
