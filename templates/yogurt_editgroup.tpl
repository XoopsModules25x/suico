<{include file="db:yogurt_navbar.tpl"}>

<form class='outer' name='yogurt-group-edit-form' id='yogurt-group-edit-form' action='editgroup.php' method='post' enctype="multipart/form-data">
<div class="alert alert-info">
    <h5><{$lang_editgroup}></h5>

		<div class="form-group">
			<label for="title"><strong><{$lang_titlegroup}></strong></label>
			<input type='text' name='title' id='title' class='form-control' value='<{$group_title}>' required>
		</div>

		<div class="form-group">
			<label for="desc"><strong><{$lang_descgroup}></strong></label>
			<input type='text' name='desc' id='desc' class="form-control" value='<{$group_desc}>' required>
		</div>
   
		<div class="form-check">
			<label for="group"><strong><{$lang_groupimage}></strong></label>
			<br><img src="<{$xoops_upload_url}>/yogurt/groups/<{$group_img}>"><br><br>
			<label class='form-check-label' for="group"><input type='checkbox' class="form-check-input" value='1' id='flag_oldimg' name='flag_oldimg' onclick="disableElement(img)" checked><{$lang_keepimage}></label>
		</div>
   
		<div class="form-group">
			<label for="group"><strong><{$lang_groupimage}></strong><br> <{$lang_youcanupload}></label>
			<input type='hidden' name='MAX_FILE_SIZE' value='<{$maxfilesize}>'>
            <input type='file' name='img' id='img' disabled="true" class='form-control-file'>
            <input type='hidden' name='xoops_upload_file[]' id='xoops_upload_file[]' value='img'>			
		</div>

			<input type='submit' class='btn btn-primary' name='submit_button' id='submit_button' value='<{$lang_savegroup}>'>
			<{$token}>
			<input type='hidden' name='group_id' id='group_id' value='<{$group_id}>'>
			<input type='hidden' name='marker' id='marker' value='1'>
</div>
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
                    <button name="" type="image" class="btn btn-danger btn-sm"><{$smarty.const._MD_YOGURT_KICKOUT}></button>
                </form>
            <{/if}>

            </p>
        </div>
    <{/section}>
</div>


<{include file="db:yogurt_footer.tpl"}>
