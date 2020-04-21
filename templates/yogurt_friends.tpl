<{include file="db:yogurt_navbar.tpl"}>

<{if $allow_friends !=-1 && $friendrequest==1 && $isOwner==1 && $isFriend==0}>

    <!-- if not owner and not friend -->
    <div id="yogurt-profile-friendrequest" class="confirmMsg">
        <h4><{$lang_youhavexfriendrequests}></h4>
        <img width="30" src="<{$xoops_url}>/uploads/<{$friendrequester_avatar}>">
        <form action="makefriends.php" method="post">
            <{$lang_askingfriend}>
            <ul>
                <li>
                    <label>
                        <input name="level" type="radio" value="5">
                    </label>
                    <{$lang_acceptfriend}>
                </li>
                <li>
                    <label>
                        <input name="level" type="radio" value="0">
                    </label>
                    <{$lang_rejectfriend}>
                </li>
            </ul>
            <input type="hidden" name="friendrequest_id" id="friendrequest_id" value="<{$friendrequest_id}>">
            <input type="submit">
            <{$token}>
        </form>
    </div>
<{/if}>

<div id="yogurt-friends-container" class="outer">
    <h4 class="head"><{$lang_friendstitle}></h4>
    <{if $lang_nofriendsyet==""}>
        <{section name=i loop=$friends}>
            <div class="yogurt-friend <{cycle values="odd,even"}>">
                <p><a href="<{$xoops_url}>/modules/yogurt/index.php?uid=<{$friends[i].uid}>" alt=" <{$friends[i].uname}>" title="<{$friends[i].uname}>"> <{if $friends[i].user_avatar=="avatars/blank.gif" or $friends[i].user_avatar==""}>
                            <img src="assets/images/noavatar.gif">
                        <{else}>
                            <img src="<{$xoops_upload_url}>/<{$friends[i].user_avatar}>"><{/if}><{$friends[i].uname}></a></p>
                <{if $isOwner }>
                    <{if $allow_fanssevaluation == 1 OR $allow_friendshiplevel == 1}>
                        <form action="editfriendship.php" method="post" class="yogurt-friends-deleteform">
                            <input type="hidden" name="friend_uid" id="friend_uid" value="<{$friends[i].uid}>">
                            <input name="submit" id="submit" src="assets/images/evaluate.gif" type="image" title="<{$lang_evaluate}>" alt="<{$lang_evaluate}>">
                        </form>
                    <{/if}>
                    <form action="delfriendship.php" method="post" class="yogurt-friends-evaluateform">
                        <input type="hidden" name="friend_uid" id="friend_uid" value="<{$friends[i].uid}>">
                        <input name="submit" id="submit" src="<{xoModuleIcons16 delete.png}>" type="image" title="<{$lang_delete}>" alt="<{$lang_delete}>">
                    </form>
                <{/if}>
            </div>
        <{/section}>
    <{else}>
        <h4 id="yogurt-friends-nofriends"><{$lang_nofriendsyet}></h4>
    <{/if}>
</div>
<div style="clear:both"></div>
<{if $navegacao!='' }>
    <div id="yogurt-navegacao"><{$navegacao}></div>
<{/if}>
<{include file="db:yogurt_footer.tpl"}>
