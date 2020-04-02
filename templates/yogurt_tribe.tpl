<{include file="db:yogurt_navbar.tpl"}>

<div id="yogurt-tribe-container" class='outer'>

    <h2 class="head"><{$tribe_title}></h2>

    <p id="yogurt-tribe-img" class=odd>
        <img src="<{$xoops_upload_url}>/<{$tribe_img}>">
    </p>

    <p id="yogurt-tribe-desc" class="even">
        <{$tribe_desc}>
        <{if $isanonym!=1 }>
    <{if $memberOfTribe ==1}>
    <form action="abandontribe.php" method="POST" id="form_abandontribe">
        <input type="hidden" value="<{$tribe_id}>" name="reltribe_id" id="reltribe_id">
        <input type="image" src="assets/images/abandontribe.gif" title="<{$lang_abandontribe}>" alt="<{$lang_abandontribe}>">
    </form><{ else}>
    <form action="becomemembertribe.php" method="POST" id="form_becomemember" class="yogurt-tribes-form-becomemember">
        <input type="hidden" value="<{$tribe_id}>" name="tribe_id" id="tribe_id">
        <input type="image" src="assets/images/makememember.gif" alt="<{$lang_jointribe}>" title="<{$lang_jointribe}>">
    </form><{/if}>
    <{/if}>
    </p>

    <{if $allow_friends }>
        <div id="yogurt-tribe-edit-members" class="outer odd">
            <h2 class="head"><{$lang_membersoftribe}></h2>
            <{section name=i loop=$tribe_members}>
                <div class="yogurt-tribe-edit-member <{cycle values="odd,even"}>">
                    <h2 class="head">
                        <a href="<{$xoops_url}>/modules/yogurt/index.php?uid=<{$tribe_members[i].uid}>" alt="<{$tribe_members[i].uname}>" title="<{$tribe_members[i].uname}>"><{$tribe_members[i].uname}></a>
                        <{if $tribe_owneruid==$tribe_members[i].uid}><img src="assets/images/owner.gif" alt="<{$lang_owner}>" title="<{$lang_owner}>"><{/if}>
                    </h2>
                    <p>
                        <a href="<{$xoops_url}>/modules/yogurt/index.php?uid=<{$tribe_members[i].uid}>" alt="<{$tribe_members[i].uname}>" title="<{$tribe_members[i].uname}>">
                            <{if $tribe_members[i].avatar=="blank.gif"}><img src="assets/images/noavatar.gif"><{else}> <img src="<{$xoops_upload_url}>/<{$tribe_members[i].avatar}>"><{/if}></a>

                        <{if $tribe_owneruid==$useruid}>
                    <form action="kickfromtribe.php" method="post">
                        <input type="hidden" value="<{$tribe_id}>" name="tribe_id" id="tribe_id">
                        <input type="hidden" value="<{$tribe_members[i].uid}>" name="rel_user_uid" id="rel_user_uid">
                        <input type="image" src="assets/images/abandontribe.gif">
                    </form>
                    <{/if}>
                    </p>
                </div>
            <{/section}>
        </div>
    <{/if}>


    <div style="clear:both;">
        <{$commentsnav}>
        <{$lang_notice}>
    </div>
    <div style="clear:both;">
        <{if $comment_mode == "flat"}>
            <{include file="db:system_comments_flat.tpl"}>
        <{elseif $comment_mode == "thread"}>
            <{include file="db:system_comments_thread.tpl"}>
        <{elseif $comment_mode == "nest"}>
            <{include file="db:system_comments_nest.tpl"}>
        <{/if}>
    </div>
    <{include file="db:yogurt_footer.tpl"}>
