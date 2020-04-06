 <{include file="db:yogurt_navbar.tpl"}>
<form class='outer' name='form_group_search' id='form_group_search' action='search_group.php' method='get'>
    <h4 class=head><{$lang_searchgroup}></h4>

    <p class=even>
        <label for='group_keyword' class='xoops-form-element-caption-required'>
            <span class='yogurt-groups-search-keyword'><{$lang_groupkeyword}></span><span class='caption-marker'>*</span></label>
        <input type='text' name='group_keyword' id='group_keyword' size='35' maxlength='55' value=''>
    </p>

    <p class=odd>
        <input type='submit' class='formButton' name='submit_button' id='submit_button' value='<{$lang_searchgroup}>'>
    </p>

    <{$token}>
</form>


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
<{*            <img src="<{$xoops_upload_url}>/yogurt/groups/<{$groups[j].img}>" alt="<{$groups[j].title}>" title="<{$groups[j].title}>">*}>
            <a href="group.php?group_id=<{$groups[j].id}>"><img src="<{$xoops_upload_url}>/yogurt/groups/<{$groups[j].img}>" alt="<{$groups[j].title}>" title="<{$groups[j].title}>"></a>
            <h4> <a href="group.php?group_id=<{$groups[j].id}>"><{$groups[j].title}></a></h4>
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
