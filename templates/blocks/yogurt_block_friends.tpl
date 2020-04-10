<{section name=i loop=$block.friends}>
    <div style="width:80%; text-align: center; page-break-after: always; margin: auto; page-break-before: always;">
        <a href="<{$xoops_url}>/modules/yogurt/index.php?uid=<{$block.friends[i].uid}>" title="<{$block.friends[i].uname}>"><{if $block.friends[i].user_avatar=="avatars/blank.gif"}> <img src="<{$xoops_url}>/modules/yogurt/assets/images/noavatar.gif"> <{else}> <img
            src="<{$xoops_upload_url}>/<{$block.friends[i].user_avatar}>"><{/if}><br><{$block.friends[i].uname}> </a>
        <{if $block.enablepm == 1}>
        <br><a href='javascript:openWithSelfMain("<{$xoops_url}>/pmlite.php?send2=1&to_userid=<{$block.friends[i].uid}>","pmlite",500,450);'><img src="<{$xoops_url}>/images/icons/pm.gif"></a>
        <{/if}>   
	</div>
    <br>
<{/section}>
<{if $block.friends}>
<a href="<{$xoops_url}>/modules/yogurt/friends.php"><{$block.lang_allfriends}></a>
 <{else}>
 <{$block.lang_nofriends}>
 <{/if}>
