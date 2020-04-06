<{include file="db:yogurt_navbar.tpl"}>

<form class='outer' name='yogurt-group-edit-form' id='yogurt-group-edit-form' action='editgroup.php' method='post' enctype="multipart/form-data">

    <h2 class=head><{$lang_editgroup}></h2>

    <p class=odd>
        <label for='' class='xoops-form-element-caption'>
            <span class='caption-text'>
                <{$lang_groupimage}>
            </span>
            <span class='caption-marker'>
            *
            </span>
        </label>
        <img src="<{$xoops_upload_url}>/yogurt/groups/<{$group_img}>">
    </p>
    <p class=even>
        <label for='' class='xoops-form-element-caption'>
                <span class='caption-text'>
                    <{$lang_keepimage}>
                </span>
            <span class='caption-marker'>
                *
                </span>
        </label>
        <input type='checkbox' value='1' id='flag_oldimg' name='flag_oldimg' onclick="disableElement(img)" checked>
    </p>

    <div>
        <p class="odd">
            <label for='' class='xoops-form-element-caption'>
                <span class='caption-text'>
                    <{$lang_youcanupload}>
                </span>
                <span class='caption-marker'>
                    *
                </span>
            </label>
        </p>
        <p class="even">
            <label for='img' class='xoops-form-element-caption'>
                <span class='caption-text'>
                    <{$lang_groupimage}>
                </span>
                <span class='caption-marker'>
                    *
                </span>
            </label>
            <input type='hidden' name='MAX_FILE_SIZE' value='<{$maxfilesize}>'>
            <input type='file' name='img' id='img' disabled="true">
            <input type='hidden' name='xoops_upload_file[]' id='xoops_upload_file[]' value='img'>
        </p>
    </div>
    <p class="odd">
        <label for='title' class='xoops-form-element-caption'>
                <span class='caption-text'>
                    <{$lang_titlegroup}>
            </span>
            <span class='caption-marker'>
                    *
                </span>
        </label>
        <input type='text' name='title' id='title' size='35' maxlength='55' value='<{$group_title}>'>
    </p>
    <p class="even">
        <label for='desc' class='xoops-form-element-caption'>
                <span class='caption-text'>
                    <{$lang_descgroup}>
                </span>
            <span class='caption-marker'>
                    *
                </span>
        </label>
        <textarea name='desc' id='desc' rows='5' cols='50'><{$group_desc}></textarea>
    </p>
    <p class=odd>
        <input type='submit' class='formButton' name='submit_button' id='submit_button' value='<{$lang_savegroup}>'>
    </p>

    <{$token}>
    <input type='hidden' name='group_id' id='group_id' value='<{$group_id}>'>
    <input type='hidden' name='marker' id='marker' value='1'>
</form>

<div id="yogurt-group-edit-members" class="outer odd">
    <h2 class="head"><{$lang_membersofgroup}></h2>
    <{section name=i loop=$group_members}>
        <div class="yogurt-group-edit-member <{cycle values="odd,even"}>">
            <h2 class="head">
                <{$group_members[i].uname}>
            </h2>
            <p>
                <img src="<{$xoops_upload_url}>/<{$group_members[i].avatar}>">
            <p>
                <{$group_members[i].uname}>
            </p>

            <{if $group_members[i].isOwner }>
                <img src="assets/images/owner.gif" alt="<{$lang_owner}>" title="<{$lang_owner}>">
            <{else}>
                <form action="kickfromgroup.php" method="post">
                    <input type="hidden" value="<{$group_id}>" name="group_id" id="group_id">
                    <input type="hidden" value="<{$group_members[i].uid}>" name="rel_user_uid" id="rel_user_uid">
                    <input type="image" src="assets/images/abandongroup.gif">
                </form>
            <{/if}>

            </p>
        </div>
    <{/section}>
</div>


<{include file="db:yogurt_footer.tpl"}>
