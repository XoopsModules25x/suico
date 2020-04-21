<{include file='db:yogurt_navbar.tpl'}>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
   <div class="row">
      <div class="col-md-12">
         <div id="content" class="content content-full-width">
<!-- start -->

<{if $isAnonym!=1 && $isOwner}>
<div class="alert alert-info">
  <h5><{$lang_creategroup}></h5>
    <form name="form_group1" id="form_group1" action="submitGroup.php" method="post" onsubmit="return xoopsFormValidate_form_group();" enctype="multipart/form-data">
   	
	<div class="form-group">
			<label for="group"><strong><{$lang_title}></strong></label>
			<input type='text' name='group_title' id='group_title' class='form-control' value='' required>
		</div>

		<div class="form-group">
			<label for="group"><strong><{$lang_description}></strong></label>
			<input type='text' name='group_desc' id='group_desc' class="form-control" value='' required>
		</div>

		<div class="form-group">
			<label for="group"><strong><{$lang_groupimage}></strong><br><{$lang_youcanupload}></label>
			 <input type='hidden' name='MAX_FILE_SIZE' value='<{$maxfilesize}>'>
			 <input type='file' name='group_img' id='group_img' class='form-control-file'>
		    <input type='hidden' name='xoops_upload_file[]' id='xoops_upload_file[]' value='group_img'>			
		</div>

		<input type='submit' class='btn btn-primary' name='submit_button' id='submit_button' value='<{$lang_savegroup}>'>
        <{$token}><input type='hidden' name='marker' id='marker' value='1'>
	</form>
	</div>
    

<{/if}>


	<h5>
      
            <{$lang_mysection}>
        
    </h5>

    <{if $nb_groups<=0}>
        <div class="alert alert-info">
            <{$lang_nogroupsyet}>
        </div>
    <{/if}>



<table id="table_id" class="table table-striped">
    <thead>
        <tr>
            <th><{$lang_groupslist}></th>
         
        </tr>
    </thead>
    <tbody>
    <{section name=i loop=$mygroups}>
        <tr>
            <td>
             <{if $isAnonym!=1}>
				    <button name="" type="image" class="btn btn-primary btn-sm float-right"> <i class="fa fa-user-circle-o"></i> <{$lang_memberofgroup}></button>
            <{/if}>

                <a href="group.php?group_id=<{$mygroups[i].group_id}>"><img src="<{$xoops_upload_url}>/yogurt/groups/<{$mygroups[i].img}>" alt="<{$mygroups[i].title}>" title="<{$mygroups[i].title}>" class="float-left pr-2" width="120" height="120"></a>
                <h6><a href="group.php?group_id=<{$mygroups[i].group_id}>"><{$mygroups[i].title}></a></h6>
				<{$mygroups[i].desc}>
            <br>
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
                         <i class="fa fa-user float-right" title="<{$lang_owner}>" style="color:#8B0000;"></i>
                <{/if}>
            <{/if}>

		 </td></tr>
    <{/section}>
 </tbody>
</table>

<{$navigationBar_my}>


<div class="alert alert-primary"> 
<form name='form_group_search1' id='form_group_search1' action='search_group.php' method='get'>   
<h5><{$lang_searchgroup}></h5>

		<div class="form-group">
			<label for="group_keyword"><strong> <{$lang_groupkeyword}></strong></label> 
			<input type='text' name='group_keyword' id='group_keyword' class="form-control" value=''>
			<input type='hidden' name='uid' id='uid' value='<{$uid_owner}>'>
			</div>

        <input type='submit' class='btn btn-primary' name='submit_button' id='submit_button' value='<{$lang_searchgroup}>'>

    <{$token}>
</form>
</div>


    <h5>
        <{$lang_availablegroups}>
    </h5>

    <{if $nb_groups_all<=0}>
        <div class="alert alert-info">
            <{$lang_nogroupsyet}>
        </div>
    <{/if}>



<table id="table_id" class="table table-striped">
    <thead>
        <tr>
            <th><{$lang_groupslist}></th>
         
        </tr>
    </thead>
    <tbody>
    <{section name=j loop=$groups}>
        <tr>
            <td>
             <{if $isAnonym!=1}>
                <{if !in_array($groups[j].id, $mygroupsid)}>
                    <form action="becomemembergroup.php" method="POST" id="form_becomemember" class="yogurt-groups-form-becomemember">
                        <input type="hidden" value="<{$groups[j].id}>" name="group_id" id="group_id">
                        <button name="" type="image" class="btn btn-dark btn-sm float-right"> <i class="fa fa-handshake-o"></i> <{$lang_joingroup}></button>
                    </form>
				<{else}>
				    <button name="" type="image" class="btn btn-primary btn-sm float-right"> <i class="fa fa-user-circle-o"></i> <{$lang_memberofgroup}></button>
                <{/if}>
            <{/if}>
			
			<a href="group.php?group_id=<{$groups[j].id}>"><img src="<{$xoops_upload_url}>/yogurt/groups/<{$groups[j].img}>" alt="<{$groups[j].title}>" title="<{$groups[j].title}>" class="float-left pr-2" width="120" height="120"></a>
            <h6>
                <a href="group.php?group_id=<{$groups[j].id}>"><{$groups[j].title}></a>
            </h6>
                <{$groups[j].desc}>
            <br>
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
                        <i class="fa fa-user float-right" title="<{$lang_owner}>" style="color:#8B0000;"></i>
                    </form>
                <{/if}>
            
         
		 </td></tr>
    <{/section}>
 </tbody>
</table>

<div>
    <{$navigationBar}>
</div>


<{include file="db:yogurt_footer.tpl"}>

<!-- end -->
</div>
      </div>
   </div>
</div>
    	</div>
</div>
