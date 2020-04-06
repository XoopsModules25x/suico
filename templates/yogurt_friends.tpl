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
                <form action="editfriendship.php" method="post" class="yogurt-friends-deleteform">
                    <input type="hidden" name="friend_uid" id="friend_uid" value="<{$friends[i].uid}>">
                    <input name="submit" id="submit" src="assets/images/evaluate.gif" type="image" title="<{$lang_evaluate}>" alt="<{$lang_evaluate}>">
                </form>
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
