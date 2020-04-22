<{include file='db:yogurt_navbar.tpl'}>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
   <div class="row">
      <div class="col-md-12">
         <div id="content" class="content content-full-width">
<!-- start -->
<{if $allow_friends !=-1 && $friendrequest==1 && $isOwner==1 && $isFriend==0}>

    <!-- if not owner and not friend -->
<div class="alert alert-info">
<h5><{$lang_youhavexfriendrequests}></h5>
<img class="rounded-circle float-left p-1" height="60" width="60" src="<{$xoops_url}>/uploads/<{$friendrequester_avatar}>">
<form action="makefriends.php" method="post">
<{$lang_askingfriend}>

<div class="form-check">
		<label class="form-check-label"><input name="level" type="radio" value="5"> <{$lang_acceptfriend}></label>
</div>
<div class="form-check">
	<label class="form-check-label"><input name="level" type="radio" value="0"> <{$lang_rejectfriend}></label>
 </div> 
<div class='form-group'>
<input type="hidden" name="friendrequest_id" id="friendrequest_id" value="<{$friendrequest_id}>">
<input type="submit" class='btn btn-primary btn-sm' value='Submit'>
</div>
<{$token}>
</form>
</div>
<{/if}>

    <{if $allow_profile_general==1}>
        <div>
            <h5><{$lang_detailsinfo}> <i class="fa fa-user-circle"></i></h5>
            <span class="yogurt-profileinfo-label"><{$lang_uname}>:</span><span class="yogurt-profileinfo-value"><{$user_uname}></span><br>
            <{if $user_realname}>
                <p><span class="yogurt-profileinfo-label"><{$lang_realname}>:</span><span class="yogurt-profileinfo-value"><{$user_realname}></span><br>
            <{/if}>
            <{if $user_location}>
                <span class="yogurt-profileinfo-label"><{$lang_location}>:</span><span class="yogurt-profileinfo-value"><{$user_location}></span><br>
            <{/if}>
            <{if $user_occupation}>
                <span class="yogurt-profileinfo-label"><{$lang_occupation}>:</span><span class="yogurt-profileinfo-value"><{$user_occupation}></span><br>
            <{/if}>
            <{if $user_interest}>
                <span class="yogurt-profileinfo-label"><{$lang_interest}>:</span><span class="yogurt-profileinfo-value"><{$user_interest}></span><br>
            <{/if}>
            <{if $user_extrainfo}>
                <span class="yogurt-profileinfo-label"><{$lang_extrainfo}>:</span><br>
                <{$user_extrainfo}><br>
            <{/if}>
			<{if $user_signature}>
                <span class="yogurt-profileinfo-label"><{$lang_signature}>:</span><br>
                <{$user_signature}><br>
            <{/if}>
    
        </div>
    <{/if}>
    
    <{if $allow_profile_stats}>
            <h5><{$lang_statistics}> <i class="fa fa-bar-chart"></i></h5>
           <span class="yogurt-profileinfo-label"><{$lang_membersince}>:</span><span class="yogurt-profileinfo-value"><{$user_joindate}></span><br>
           <span class="yogurt-profileinfo-label"><{$lang_rank}>:</span><span class="yogurt-profileinfo-value"><{$user_rankimage}>  <{$user_ranktitle}></span><br>
           <span class="yogurt-profileinfo-label"><{$lang_posts}>:</span><span class="yogurt-profileinfo-value"><{$user_posts}></span><br>
           <span class="yogurt-profileinfo-label"><{$lang_lastlogin}>:</span><span class="yogurt-profileinfo-value"><{$user_lastlogin}></span><br>
           	<{if ($isOwner==1)}><{if $visitors}>
				 <span class="yogurt-profileinfo-label"> <{$lang_profilevisitors}>: </span>
		    <{foreach from=$visitors key=k item=v}>
                <a href=index.php?uid=<{$k}>> <{$v}> </a> &nbsp;
            <{/foreach}>
                <br>
			<{/if}><{/if}>	
    <{/if}>

<br>
   <{if $allow_profile_stats}>
    <{if $modules!=''}>
        <h5><{$lang_usercontributions}> <i class="fa fa-check-circle"></i></h5>
        <!-- start module search results loop -->
        <p>
            <{foreach item=module from=$modules name="search_results"}>
            <div class="yogurt-profile-search-module" id="yogurt-profile-search-module-<{$smarty.foreach.search_results.iteration}>">
                <h6>
                    <a class="yogurt-profile-search-module-title" id="yogurt-profile-search-module-title-<{$smarty.foreach.search_results.iteration}>">
                        <img src="assets/images/toggle.gif">
                    </a>
                    <{$module.name}>
                </h6>

                <div class="yogurt-profile-search-module-results" id="yogurt-profile-search-module-results-<{$smarty.foreach.search_results.iteration}>">
                    <!-- start results item loop -->
                    <{foreach item=result from=$module.results}>
        <p>
     
        <b>
            <a href="<{$xoops_url}>/<{$result.link}>">
                <{$result.title}>
            </a>
        </b>
        <br>
        <small> <i class="fa fa-calendar-o"></i> <{$result.time}></small>
        </p>

        <{/foreach}>
        <!-- end results item loop -->
        <p>
            <button class="btn btn-primary btn-sm link-style"> <i class='fa fa-arrow-circle-right'></i> <{$module.showall_link}></button>
        </p>
    </div>
</div>
    <{/foreach}>
    </p>
<!-- end module search results loop -->
    <{/if}>
<{/if}>

</div>

    <{if $allow_videos==1 }>
		<{if $mainvideocode!="" }>
		<div class="container-fluid"> 
		<div class="row"> 
           <h5><{$lang_featuredvideo}> <i class="fa fa-youtube-play"></i></h5>
                
                   <div class="embed-responsive embed-responsive-16by9">
							<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<{$mainvideocode}>?rel=0" allowfullscreen></iframe>
					</div>
						<div class="alert alert-info">
							<{$mainvideodesc}>
						</div>
				
          </div>
		  </div>
		<{/if}>
    <{/if}>
	
	<{if $allow_profile_general==1}>
    <{if $allow_friends==1}>
	<{if $nb_friends!=0}>
            <br><h5><{$lang_friends}> <i class="fa fa-address-card-o"></i></h5>
			<div class="container-fluid">
			<div class="row row-cols-4 border">
            <{section name=i loop=$friends}>
               <div class="col text-center p-2">
                    <a href="<{$xoops_url}>/modules/yogurt/index.php?uid=<{$friends[i].uid}>" alt="<{$friends[i].uname}>" title="<{$friends[i].uname}>">
						<{if $friends[i].user_avatar=="avatars/blank.gif"}>
                            <img class="yogurt-profile-friend-photo" src="<{$xoops_upload_url}>/avatars/blank.gif" title="<{$friends[i].uname}>" width="90" height="90">
                        <{else}>
                            <img class="yogurt-profile-friend-photo" src="<{$xoops_upload_url}>/<{$friends[i].user_avatar}>" title="<{$friends[i].uname}>" width="90" height="90">
						<{/if}>
						<br><small><{$friends[i].uname}> </small>
					</a>
                </div>
            <{/section}>
			</div>
            <{if $nb_friends!=0}>
                <div class="row p-2">
                    <a href="friends.php?uid=<{$uid_owner}>" class="btn btn-primary btn-sm "> <i class='fa fa-arrow-circle-right'></i> <{$lang_viewallfriends}> (<{$nb_friends}>) </a>
                </div>
            <{/if}>
		</div>
    <{/if}>
	<{/if}>
	<{/if}>
	
	<{if $allow_profile_general==1}>
    <{if $allow_groups==1}><br>
        <{if $nb_groups!=0}>
		
            <br><h5><{$lang_groups}> <i class="fa fa-group"></i></h5>
			<div class="container-fluid">
			<div class="row row-cols-4 border">
		   <{section name=i loop=$groups}>
                 <div class="col text-center p-2">
                    <a href="group.php?group_id=<{$groups[i].group_id}>">
					<img alt="<{$groups[i].title}>" title="<{$groups[i].title}>" class="yogurt-profile-groups-img" src="<{$xoops_upload_url}>/yogurt/groups/<{$groups[i].img}>" width="90" height="90"> 
					<h6><small><{$groups[i].title}></small></h6></a>
                    <small><{$groups[i].desc}></small>
                </div>
            <{/section}>
				</div>
			<{if $nb_groups!=0}>
                <div class="row p-2">
                    <br><a href="groups.php?uid=<{$uid_owner}>" class="btn btn-primary btn-sm "><i class='fa fa-arrow-circle-right'></i> <{$lang_viewallgroups}> (<{$nb_groups}>) </a>
                </div>
            <{/if}>
        </div>
		    
    <{/if}>
	<{/if}>
	<{/if}>
</div><!-- end of group2 -->
<{include file="db:yogurt_footer.tpl"}>

<!-- end -->
</div>
      </div>
   </div>
</div>
    	</div>
</div>
