<div class="container-fluid">
    <div class="row row-cols-4">

        <{section name=i loop=$block.friends}>
            <div class="col text-center p-2">
                <a href="<{$xoops_url}>/modules/suico/index.php?uid=<{$block.friends[i].uid}>" title="<{$block.friends[i].uname}>">
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
            <a href="<{$xoops_url}>/modules/suico/friends.php" class="btn btn-primary btn-sm"> <span class='fa fa-arrow-circle-right'></span> <{$block.lang_allfriends}></a>
        <{else}>
            <div class="alert alert-primary text-center"><{$block.lang_nofriends}><br><br>
                <a href="<{$xoops_url}>/modules/suico/memberslist.php" class="btn btn-primary btn-sm" role="button"><span class="fa fa-address-card-o"></span> <{$smarty.const._MB_SUICO_FINDFRIENDS}></a>
            </div>
        <{/if}>

    </div>
</div>
