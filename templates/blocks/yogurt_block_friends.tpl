<div class="container-fluid">
<div class="row row-cols-4">

<{section name=i loop=$block.friends}>
    <div class="col text-center p-2">
        <a href="<{$xoops_url}>/modules/yogurt/index.php?uid=<{$block.friends[i].uid}>" title="<{$block.friends[i].uname}>">
			<{if $block.friends[i].user_avatar=="avatars/blank.gif"}> 
				<img src="<{$xoops_url}>/uploads/avatars/blank.gif" height="60" width="60"> 
			<{else}> 
				<img src="<{$xoops_upload_url}>/<{$block.friends[i].user_avatar}>" title="<{$block.friends[i].uname}>" height="60" width="60">
			<{/if}>
		<br><small> <{$block.friends[i].uname}> </small>
		</a>
		
         <{if $block.enablepm == 1}>
            <br>
            <a href='javascript:openWithSelfMain("<{$xoops_url}>/pmlite.php?send2=1&to_userid=<{$block.friends[i].uid}>","pmlite",500,450);'><img src="<{$xoops_url}>/images/icons/pm.gif"></a>
        <{/if}>
		
		
    </div>
    <br>
<{/section}>
</div>

<div class="row">
<{if $block.friends}>
    <a href="<{$xoops_url}>/modules/yogurt/friends.php" class="btn btn-primary btn-sm"> <i class='fa fa-arrow-circle-right'></i> <{$block.lang_allfriends}></a>
<{else}>
    <{$block.lang_nofriends}>
<{/if}>

</div>
</div>