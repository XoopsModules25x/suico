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
                <{$section_name}>
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
    <{if (($allow_friends !=-1) && ($isFriend!=1) && ($isOwner==0) && ($isAnonym!=1) && $friendrequestfrom_uid != $uid_owner) && $friendrequestto_uid != $xoops_userid}>
       
            <form action=submitFriendrequest.php method="post">
				<input type="hidden" name="friendrequestfrom_uid" id="friendrequestfrom_uid" value="<{$uid_owner}>">
				<button name="" type="image" class="btn btn-info btn-sm"> <i class="fa fa-user-plus"></i> <{$lang_addfriend}></button>			 	   
				<{$token}>
            </form>
    <{/if}>
					 <{if $allow_friends}>
							<{if $isFriend == 1 && $isAnonym!=1}>
								<button type="button" class="btn btn-info btn-sm"> <i class="fa fa-user-circle"></i> <{$lang_myfriend}></button>	
							<{/if}>
							<{if $friendrequestfrom_uid == $uid_owner && $isAnonym!=1}>
								<button type="button" class="btn btn-info btn-sm"> <i class="fa fa-check-circle"></i> <{$lang_friendrequestsent}></button>	
							<{/if}>
							<{if $friendrequestto_uid == $xoops_userid && $isAnonym!=1}>
								<button type="button" class="btn btn-info btn-sm"> <i class="fa fa-clock-o"></i> <{$lang_friendrequestpending}></button>	
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
                        
						<{if $allow_profile_general==1}>
						<{if $user_occupation || $user_location }>
						<p class="m-b-10"><{if $user_occupation}><i class="fa fa-briefcase"></i> <{$user_occupation}><{/if}> <{if $user_occupation}> <i class="fa fa-map-marker"></i>  <{$user_location}><{/if}></p>
						<{/if}>
						<{/if}>
						
						<{if $allow_profile_contact==1}>
						<{if $user_email || $user_websiteurl }>
						<p class="m-b-10">
						<{if $user_viewemail!='0'}><i class="fa fa-envelope"></i> <{mailto address=$user_email encode="javascript"}><{/if}>
						<{if $user_websiteurl}><i class="fa fa-globe"></i> <{$user_websiteurl}><{else}><br><{/if}>
						</p>
						<{/if}>
						<{/if}>
						
						
						<{if $allow_profile_contact==1}>
						<{if $allow_friends}>
						<{if $isAnonym!=1 && $isOwner!=1 }> 
						<button type="button" class="btn btn-success btn-sm">
						<a href="javascript:openWithSelfMain('<{$xoops_url}>/pmlite.php?send2=1&amp;to_userid=<{$uid_owner}>', 'pmlite', 450, 380);"><i class="fa fa-envelope-o"></i> <{$smarty.const._MD_YOGURT_PRIVATEMESSAGE}></a></button>
						<{/if}>
						<{/if}>
						<{/if}>
						
						<{if $isOwner==1}> 
						<{xoInboxCount assign=pmcount}>
						<{if $pmcount}><a href="<{$xoops_url}>/viewpmsg.php" class="btn btn-info btn-sm" > <i class="fa fa-envelope-o"></i> <{$smarty.const._MD_YOGURT_PRIVATEMESSAGE}> <span class="badge badge-light"><{$pmcount}></span></a> <{/if}>
						<a href="<{$xoops_url}>/modules/yogurt/edituser.php" class="btn btn-success btn-sm" /> <i class="fa fa-edit"></i> <{$smarty.const._MD_YOGURT_EDITPROFILE}></a>
						<a href="<{$xoops_url}>/modules/yogurt/configs.php?uid=<{$uid_owner}>" class="btn btn-success btn-sm" /> <i class="fa fa-gear"></i> <{$lang_configs}></a>
						<{/if}>
						
						 <{if $user_onlinestatus == 1}>
							<button type="button" class="btn btn-danger btn-sm"> <i class="fa fa-user-circle-o"></i> <{$smarty.const._MD_YOGURT_ONLINE}></button>
						<{else}>
							<button type="button" class="btn btn-dark btn-sm">  <i class="fa fa-user-circle-o"></i> <{$smarty.const._MD_YOGURT_OFFLINE}></button>
						<{/if}>

 <{if $allow_usersuspension==1}><{if $isWebmaster==1 }>	
<!--<button id="yogurt-suspensiontools" type="submit" title="<{$lang_suspensionadmin}>" class="btn btn-sm btn-primary"><i class="fa fa-close"></i> <{$smarty.const._MD_YOGURT_SUSPENDUSER}></button> -->
<img id="yogurt-suspensiontools" src="assets/images/suspend.png" alt="<{$lang_suspensionadmin}>" title="<{$lang_suspensionadmin}>">	

		<{/if}><{/if}>

    <{if $allow_usersuspension==1}>
        <{if $isWebmaster==1 }><br>
		 <div id="yogurt-suspension" class="alert alert-danger">
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
        
        <!--    <p id="yogurt-profile-fans"><a href="fans.php?uid=<{$uid_owner}>" alt="<{$lang_fans}>" title="<{$lang_fans}>"> <{$lang_fans}> </a><i class="fa fa-star" style="color:yellow;"></i> (<{$nb_fans}>)
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
            <li class="nav-item"><a href="index.php?uid=<{$uid_owner}>" class="nav-link <{if $section_name==$lang_profile}>active show<{/if}>"><small><i class="fa fa-user-circle"></i> <{$lang_profile}></small></a></li>
            <{if $allow_notes!=0}>
                <li class="nav-item"><a href="notebook.php?uid=<{$uid_owner}>" class="nav-link <{if $section_name==$lang_notebook}>active show<{/if}>"><small><i class="fa fa-comment"></i> <{$lang_notebook}> (<{$nb_notes}>)</small></a>
                </li>
            <{/if}>
            <{if $allow_pictures !=0}>
            <li class="nav-item"><a href="album.php?uid=<{$uid_owner}>" class="nav-link <{if $section_name==$lang_photos}>active show<{/if}>"><small><i class="fa fa-picture-o"></i> <{$lang_photos}> (<{$nb_photos}>)</small></a>
                </li><{/if}>
            <{if $allow_audios !=0}>
            <li class="nav-item"> <a href="audio.php?uid=<{$uid_owner}>" class="nav-link <{if $section_name==$lang_audio}>active show<{/if}>"><span><small><i class="fa fa-file-audio-o"></i> <{$lang_audio}> (<{$nb_audio}>)</small></a>
                </li><{/if}>
            <{if $allow_videos !=0}>
            <li class="nav-item"><a href="video.php?uid=<{$uid_owner}>" class="nav-link <{if $section_name==$lang_videos}>active show<{/if}>"><small><i class="fa fa-youtube-play"></i> <{$lang_videos}> (<{$nb_videos}>)</small></a>
                </li><{/if}>
            <{if $allow_friends !=0}>
            <li class="nav-item"> <a href="friends.php?uid=<{$uid_owner}>" class="nav-link <{if $section_name==$lang_friends}>active show<{/if}>"><small><i class="fa fa-user-circle-o"></i> <{$lang_friends}> (<{$nb_friends}>)</small></a>
                </li><{/if}>
            <{if $allow_groups !=0}>
            <li class="nav-item"> <a href="groups.php?uid=<{$uid_owner}>" class="nav-link <{if $section_name==$lang_groups}>active show<{/if}>"><small><i class="fa fa-group"></i> <{$lang_groups}> (<{$nb_groups}>)</small></a>
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
