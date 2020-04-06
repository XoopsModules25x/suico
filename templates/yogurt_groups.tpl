<{include file="db:yogurt_navbar.tpl"}>
<form class='outer' name='form_group_search' id='form_group_search' action='search_group.php' method='get'>

    <h4 class="head"><{$lang_searchgroup}></h4>


    <p class=even>
        <label for='group_keyword' class='xoops-form-element-caption-required'>
            <span class='yogurt-groups-search-keyword'><{$lang_groupkeyword}></span><span class='caption-marker'>*</span></label>
        <input type='text' name='group_keyword' id='group_keyword' size='35' maxlength='55' value=''>
        <input type='hidden' name='uid' id='uid' value='<{$uid_owner}>'>
    </p>

    <p class=odd>
        <input type='submit' class='formButton' name='submit_button' id='submit_button' value='<{$lang_searchgroup}>'>
    </p>

    <{$token}>
</form>
<{if $isanonym!=1}>

<form class='outer' name='form_group' id='form_group' action='submit_group.php' method='post' onsubmit='return xoopsFormValidate_form_group();' enctype="multipart/form-data">

    <h4 class="head"><{$lang_creategroup}></h4>

    <p class="odd">
        <label for='' class='xoops-form-element-caption'><span class='caption-text'><{$lang_youcanupload}></span><span class='caption-marker'>*</span></label>
    </p>

    <p class=even>
        <label for='group_img' class='xoops-form-element-caption-required'>
            <span class='caption-text'><{$lang_groupimage}></span><span class='caption-marker'>*</span></label>
        <input type='hidden' name='MAX_FILE_SIZE' value='<{$maxfilesize}>'>
        <input type='file' name='group_img' id='group_img'>
        <input type='hidden' name='xoops_upload_file[]' id='xoops_upload_file[]' value='group_img'>
    </p>

    <p class=odd>
        <label for='group_title' class='xoops-form-element-caption'>
            <span class='caption-text'><{$lang_title}></span><span class='caption-marker'>*</span></label>
        <input type='text' name='group_title' id='group_title' size='35' maxlength='55' value='' required>
    </p>

    <p class=even>
        <label for='group_desc' class='xoops-form-element-caption'>
            <span class='caption-text'><{$lang_description}></span>
            <span class='caption-marker'>*</span></label>
        <input type='text' name='group_desc' id='group_desc' size='35' maxlength='55' value='' required>
    </p>

    <p class=odd>
        <input type='submit' class='formButton' name='submit_button' id='submit_button' value='<{$lang_savegroup}>'>
    </p>

    <{$token}><input type='hidden' name='marker' id='marker' value='1'>
</form>

<!-- Start Form Validation JavaScript //-->
<script type='text/javascript'>
    <!--//
    function xoopsFormValidate_form_group() {
        myform = window.document.form_group;
        if (myform.group_img.value == "") {
            window.alert("Please enter Group Image");
            myform.group_img.focus();
            return false;
        }
        return true;
    }

    //--></script>
<!-- End Form Vaidation JavaScript //-->

<{/if}>

<div id="yogurt-mygroups-container" class="outer">
    <h4 class="head">
        <{$lang_mygroupstitle}>
    </h4>

    <{if $nb_groups<=0}>
    <h4 id="yogurt-groups-nogroups">
        <{$lang_nogroupsyet}>
    </h4>
    <{/if}>
    <{section name=i loop=$mygroups}>
        <div class="yogurt-group-my <{cycle values="odd,even"}>">
            <p>

                <a href="group.php?group_id=<{$mygroups[i].group_id}>"><img src="<{$xoops_upload_url}>/yogurt/groups/<{$mygroups[i].img}>" alt="<{$mygroups[i].title}>" title="<{$mygroups[i].title}>"></a>
            <p>
                <a href="group.php?group_id=<{$mygroups[i].group_id}>"><{$mygroups[i].title}></a><br><{$mygroups[i].desc}>
            </p>

            <{if $isOwner }>
                <form action="abandongroup.php" method="POST" id="form_abandongroup">
                    <input type="hidden" value="<{$mygroups[i].id}>" name="relgroup_id" id="relgroup_id">
                    <button name="" type="image"><{$lang_abandongroup}></button>		
				</form>
                <{if $xoops_userid == $mygroups[i].uid }>
                    <form>
                        <img src="assets/images/owner.gif" alt="<{$lang_owner}>" title="<{$lang_owner}>">
                    </form>
                <{/if}>
            <{/if}>

            </p>
        </div>
    <{/section}>
</div>

<div id="yogurt-navegacao">
    <{$barra_navegacao_my}>
</div>

<div id="yogurt-groups-container" class="outer">
    <h4 class="head">
        <{$lang_groupstitle}>
    </h4>

    <{if $nb_groups_all<=0}>
    <h4 id="yogurt-groups-nogroups">
        <{$lang_nogroupsyet}>
    </h4>
    <{/if}>

    <{section name=j loop=$groups}>
        <div class="yogurt-group-all <{cycle values="odd,even"}>">
            <a href="group.php?group_id=<{$groups[j].id}>"><img src="<{$xoops_upload_url}>/yogurt/groups/<{$groups[j].img}>" alt="<{$groups[j].title}>" title="<{$groups[j].title}>"></a>
            <h4>
                <a href="group.php?group_id=<{$groups[j].id}>"><{$groups[j].title}></a>
            </h4>
            <p>

            <p>
                <{$groups[j].desc}>
            </p>

            </p>
            <{if $isOwner }>
                <form action="becomemembergroup.php" method="POST" id="form_becomemember" class="yogurt-groups-form-becomemember">
                    <input type="hidden" value="<{$groups[j].id}>" name="group_id" id="group_id">
                    <button name="" type="image"><{$lang_joingroup}></button>
                </form>
                <{if $xoops_userid == $groups[j].uid }>
                    <form action="delete_group.php" method="POST" id="form_deletegroup" class="yogurt-groups-form-delete">
                        <input type="hidden" value="<{$groups[j].id}>" name="group_id" id="group_id">
                        <input type="image" src="<{xoModuleIcons16 delete.png}>">
                    </form>
                    <form action="editgroup.php" method="POST" id="form_editgroup" class="yogurt-groups-form-edit">
                        <input type="hidden" value="<{$groups[j].id}>" name="group_id" id="group_id">
                        <input type="image" src="<{xoModuleIcons16 edit.png}>">
                    </form>
                    <form>
                        <img src="assets/images/owner.gif" alt="<{$lang_owner}>" title="<{$lang_owner}>">
                    </form>
                <{/if}>

            <{/if}>
        </div>
    <{/section}>

</div>

<div id="yogurt-navegacao">
    <{$barra_navegacao}>
</div>


<{include file="db:yogurt_footer.tpl"}>
