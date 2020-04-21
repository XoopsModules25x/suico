<{include file="db:yogurt_navbar.tpl"}>

<{if $isAnonym!=1 && $isOwner}>
    <form class='outer' name='form_group' id='form_group' action='submitGroup.php' method='post' onsubmit='return xoopsFormValidate_form_group();' enctype="multipart/form-data">
<div class="alert alert-info">
        <h5><{$lang_creategroup}></h5>

		<div class="form-group">
			<label for="group"><strong><{$lang_title}></strong></label>
            <label for='group_title'></label><input type='text' name='group_title' id='group_title' class='form-control' value='' required>
		</div>

		<div class="form-group">
			<label for="group"><strong><{$lang_description}></strong></label>
            <label for='group_desc'></label><input type='text' name='group_desc' id='group_desc' class="form-control" value='' required>
		</div>

		<div class="form-group">
			<label for="group"><strong><{$lang_groupimage}></strong><br><{$lang_youcanupload}></label>
			 <input type='hidden' name='MAX_FILE_SIZE' value='<{$maxfilesize}>'>
			 <input type='file' name='group_img' id='group_img' class='form-control-file'>
		    <input type='hidden' name='xoops_upload_file[]' id='xoops_upload_file[]' value='group_img'>			
		</div>

		<input type='submit' class='btn btn-primary' name='submit_button' id='submit_button' value='<{$lang_savegroup}>'>
        <{$token}><input type='hidden' name='marker' id='marker' value='1'>
	</div>	
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
        <{if $isOwner}>
            <{$lang_mysection}>
        <{else}>
            <{$owner_uname}> <{$section_name}>
        <{/if}>
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
                <{if $xoops_userid == $mygroups[i].uid }>
                    
					 <form action="delete_group.php" method="POST" id="form_deletegroup" class="yogurt-groups-form-delete">
                        <input type="hidden" value="<{$mygroups[i].group_id}>" name="group_id" id="group_id">
                        <input type="image" src="<{xoModuleIcons16 delete.png}>">
                    </form>
                    <form action="editgroup.php" method="POST" id="form_editgroup" class="yogurt-groups-form-edit">
                        <input type="hidden" value="<{$mygroups[i].group_id}>" name="group_id" id="group_id">
                        <input type="image" src="<{xoModuleIcons16 edit.png}>">
                    </form>
                        <img src="assets/images/owner.gif" alt="<{$lang_owner}>" title="<{$lang_owner}>">
                  
                <{/if}>
            <{/if}>

            </p>
        </div>
    <{/section}>
</div>

<div id="yogurt-navegacao">
    <{$navigationBar_my}>
</div>


<form class='outer' name='form_group_search' id='form_group_search' action='search_group.php' method='get'>
<div class="alert alert-primary">    
<h4 class="head"><{$lang_searchgroup}></h4>

		<div class="form-group">
			<label for="group_keyword"><strong> <{$lang_groupkeyword}></strong></label> 
			<input type='text' name='group_keyword' id='group_keyword' class="form-control" value=''>
			<input type='hidden' name='uid' id='uid' value='<{$uid_owner}>'>
			</div>

        <input type='submit' class='btn btn-primary' name='submit_button' id='submit_button' value='<{$lang_searchgroup}>'>

    <{$token}>
</div>
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
            <a href="group.php?group_id=<{$groups[j].id}>"><img src="<{$xoops_upload_url}>/yogurt/groups/<{$groups[j].img}>" alt="<{$groups[j].title}>" title="<{$groups[j].title}>"></a>
            <h4>
                <a href="group.php?group_id=<{$groups[j].id}>"><{$groups[j].title}></a>
            </h4>
            <p>
            <p>
                <{$groups[j].desc}>
            </p>
            </p>
            <{if ($xoops_userid == $groups[j].uid)}>
         	
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
            
             <{if $isAnonym!=1}>
                <{if !in_array($groups[j].id, $mygroupsid)}>
                    <form action="becomemembergroup.php" method="POST" id="form_becomemember" class="yogurt-groups-form-becomemember">
                        <input type="hidden" value="<{$groups[j].id}>" name="group_id" id="group_id">
                        <button name="" type="image" class="btn btn-dark btn-sm"><{$lang_joingroup}></button>
                    </form>
				<{else}>
				    <button name="" type="image" class="btn btn-success btn-sm"><{$lang_memberofgroup}></button>
                <{/if}>
            <{/if}>
         
		</div>
        <br>
    <{/section}>

</div>

<div id="yogurt-navegacao">
    <{$navigationBar}>
</div>


<{include file="db:yogurt_footer.tpl"}>
