<div id="yogurt-section-container">
<{ if $isWebmaster==1 }><div id="yogurt-suspension">
<{ if $isSuspended==0 }><form action="suspend.php" method="POST" name="suspend_form" id="suspend_form">
<{$token}><input type="hidden" value="<{$uid_owner}>" id="uid" name="uid" /><label for="time">
<{$lang_timeinseconds}></label><input type="text" name="time" id="time" value="604800" />
<input type="submit" value="<{$lang_suspend}>"/></form><{ else }> <{$lang_suspended}>
<form action="unsuspenduser.php" method="POST"><{$token}><input type="hidden" value="<{$uid_owner}>" id="uid" name="uid" />
<input type="submit" value="<{$lang_unsuspend}>"/></form><{/if}></div><{/if}>

<div class="yogurt-nav-bar" id="yogurt-nav-bar">
<p id="breadcrumbs">
         <a href="<{$xoops_url}>" title="<{$xoops_sitename}> - <{$xoops_slogan}>" >
		 	<{$lang_home}>
		 </a> 
		 > 
		 <a href="index.php" title="<{$module_name}>">
		 	<{$module_name}>
		 </a> 
		 > 
		 <a href="index.php?uid=<{$uid_owner}>" title="<{$owner_uname}>">
		 	<{$owner_uname}>
		 </a> 
		 > 
		 <{$section_name}>
	</p>
	<h2>
		<{if $isOwner}>::<{$lang_mysection}><{else}><{$owner_uname}>::<{$section_name}><{/if}><{ if $isWebmaster==1 }><img id="yogurt-suspensiontools" src="images/suspend.gif" alt="<{$lang_suspensionadmin}>" title="<{$lang_suspensionadmin}>"/><{/if}>
	</h2>

    
    <ul class="tabs-nav">
		<li <{if $section_name==$lang_profile}>class="tabs-selected" <{/if}>><a href="index.php?uid=<{$uid_owner}>"> <span><img class="yogurt-nav-bar-icon" src="images/profile.gif"  /><{$lang_profile}></span></a> </li>
 		<{ if $allow_Notes!=-1 }> <li <{ if $allow_Notes==0 }> class="tabs-disabled" <{/if}> <{if $section_name==$lang_Notebook}>class="tabs-selected" <{/if}>><a href="notebook.php?uid=<{$uid_owner}>"><span><img class="yogurt-nav-bar-icon" src="images/Notebook.gif"  /><{$lang_Notebook}> (<{$nb_Notes}>)</span></a> </li>
        <{/if}>
 		 <{ if $allow_pictures !=-1 }><li <{ if $allow_pictures == 0 }>class="tabs-disabled"<{/if}><{if $section_name==$lang_photos}>class="tabs-selected" <{/if}>><a href="album.php?uid=<{$uid_owner}>"><span><img class="yogurt-nav-bar-icon" src="images/lphoto.gif"  /><{$lang_photos}> ( <{$nb_photos}> )</span></a> </li><{/if}>
 		 <{ if $allow_audios !=-1 }><li <{ if $allow_audios ==0 }>class="tabs-disabled"<{/if}><{if $section_name==$lang_audio}>class="tabs-selected" <{/if}>> <a href="audio.php?uid=<{$uid_owner}>"><span><img class="yogurt-nav-bar-icon" src="images/audio.gif"  /><{$lang_audio}> ( <{$nb_audio}> )</span></a> </li><{/if}>
         <{ if $allow_videos !=-1 }><li <{ if $allow_videos ==0 }>class="tabs-disabled"<{/if}> <{if $section_name==$lang_videos}>class="tabs-selected" <{/if}>><a href="seutubo.php?uid=<{$uid_owner}>"><span><img class="yogurt-nav-bar-icon" src="images/video.gif"  /><{$lang_videos}> ( <{$nb_videos}> )</span></a> </li><{/if}>
 		 <{ if $allow_friends !=-1 }><li <{ if $allow_friends ==0 }>class="tabs-disabled"<{/if}><{if $section_name==$lang_friends}>class="tabs-selected" <{/if}>> <a href="friends.php?uid=<{$uid_owner}>"><span><img class="yogurt-nav-bar-icon" src="images/people.gif"  /><{$lang_friends}> ( <{$nb_friends}> )</span></a> </li><{/if}>
 		 <{ if $allow_tribes !=-1 }><li <{ if $allow_tribes ==0 }>class="tabs-disabled"<{/if}><{if $section_name==$lang_tribes}>class="tabs-selected" <{/if}>> <a href="tribes.php?uid=<{$uid_owner}>"><span><img class="yogurt-nav-bar-icon" src="images/tribes.gif"  /><{$lang_tribes}> ( <{$nb_tribes}> )</span></a> </li><{/if}>
         
<{if $isOwner}>
 		   <li <{if $section_name==$lang_configs}>class="tabs-selected" <{/if}>> <a href="configs.php?uid=<{$uid_owner}>"><span><img class="yogurt-nav-bar-icon" src="images/configs.gif"  /><{$lang_configs}></span></a></li>
<{/if}>
 	</ul>
    <div class="tabs-container">
    
    </div>
</div>
