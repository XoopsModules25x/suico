<{include file='db:yogurt_navbar.tpl'}>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
   <div class="row">
      <div class="col-md-12">
         <div id="content" class="content content-full-width">
<!-- start -->
    <h5><{$smarty.const._MD_YOGURT_GROUP}> : <{$group_title}></h5>

    <div>
        <img src="<{$xoops_upload_url}>/yogurt/groups/<{$group_img}>" alt="<{$group_title}>" title="<{$group_title}>"><br><br>
    </div>

  <div class="alert alert-info">
    <{if $xoops_userid == $group_owneruid }>
		<button title="<{$lang_owner}>" class="btn btn-secondary btn-sm float-right"> <i class="fa fa-user"></i> <{$smarty.const._MD_YOGURT_OWNEROFGROUP}></button>
	<{/if}> 
		<{if $isAnonym!=1}>
		<{if $memberOfGroup ==1}>          	
    <form action="abandongroup.php" method="POST" id="form_abandongroup">
        <input type="hidden" value="<{$group_rel_id}>" name="relgroup_id" id="relgroup_id">
		<input type="hidden" value="<{$group_id}>" name="group_id" id="group_id">
		<button name="" type="image" class="btn btn-primary btn-sm float-right"> <i class="fa fa-user-circle-o"></i> <{$smarty.const._MD_YOGURT_MEMBEROFGROUP}></button> 
        <button name="" type="image" class="btn btn-danger btn-sm float-right"> <i class="fa fa-close"></i> <{$lang_abandongroup}></button> 
	</form>
    <{ else}>
    <form action="becomemembergroup.php" method="POST" id="form_becomemember" class="yogurt-groups-form-becomemember">
        <input type="hidden" value="<{$group_id}>" name="group_id" id="group_id">
        <button name="" type="image" class="btn btn-info btn-sm float-right"> <i class="fa fa-handshake-o"></i> <{$lang_joingroup}></button>
	</form>
    <{/if}>
<{/if}>

		<b><{$smarty.const._MD_YOGURT_GROUPDESCRIPTION}></b><br>
		<h6><{$group_title}></h6>
		<{$group_desc}>
		<br><b><{$lang_ownerofgroup}></b><br>
		<a href><a href="<{$xoops_url}>/modules/yogurt/index.php?uid=<{$group_owneruid}>" target="_blank"><{$group_ownername}></a><br><br>
		
		<{if $isOwner }>
        <{if $xoops_userid == $group_owneruid }>
                         
					 <form action="delete_group.php" method="POST" id="form_deletegroup" class="yogurt-groups-form-delete">
                        <input type="hidden" value="<{$group_id}>" name="group_id" id="group_id">
                        <input type="image" src="<{xoModuleIcons16 delete.png}>">
                    </form>
                    <form action="editgroup.php" method="POST" id="form_editgroup" class="yogurt-groups-form-edit">
                        <input type="hidden" value="<{$group_id}>" name="group_id" id="group_id">
                        <input type="image" src="<{xoModuleIcons16 edit.png}>">
                    </form>
					      <{/if}>
              
                <{/if}>
		
		
    </div>
<br>

<table class="table table-striped table-hover table-border">
    <thead>
        <tr>
            <th><h6><{$lang_membersofgroup}></h6></th>
        </tr>
    </thead>
    <tbody>
       
		<{section name=i loop=$group_members}>    
			<tr>        
		   <td>
		   <a href="<{$xoops_url}>/modules/yogurt/index.php?uid=<{$group_members[i].uid}>" alt="<{$group_members[i].uname}>" title="<{$group_members[i].uname}>">
      <{if $group_members[i].avatar=="avatars/blank.gif"}><img src="<{$xoops_upload_url}>/avatars/blank.gif" class="rounded-circle float-left p-2" height="60" width="60"  alt="<{$group_members[i].uname}>" title="<{$group_members[i].uname}>"><{else}> <img class="rounded-circle float-left p-2" src="<{$xoops_upload_url}>/<{$group_members[i].avatar}>" height="60" width="60"  alt="<{$group_members[i].uname}>" title="<{$group_members[i].uname}>"><{/if}></a>
		   
		   <a href="<{$xoops_url}>/modules/yogurt/index.php?uid=<{$group_members[i].uid}>" alt="<{$group_members[i].uname}>" title="<{$group_members[i].uname}>"><{$group_members[i].uname}></a>
               <{if $group_owneruid==$group_members[i].uid}>
			   <button title="<{$lang_owner}>" class="btn btn-secondary btn-sm float-right"> <i class="fa fa-user"></i> <{$smarty.const._MD_YOGURT_OWNEROFGROUP}></button>
				<{/if}>
			   
			    <{if $group_owneruid==$useruid && $group_owneruid!=$group_members[i].uid}>
                    <form action="kickfromgroup.php" method="post">
                        <input type="hidden" value="<{$group_id}>" name="group_id" id="group_id">
                        <input type="hidden" value="<{$group_members[i].uid}>" name="rel_user_uid" id="rel_user_uid">
                         <button name="" type="image" class="btn btn-info btn-sm float-right"> <i class="fa fa-remove"></i> <{$lang_removemember}></button>
                    </form>
                    <{/if}>
           </td>
		   </tr>
         <{/section}>
		
    </tbody>
</table>

        <{$commentsnav}>
        <{$lang_notice}>

        <{if $comment_mode == "flat"}>
            <{include file="db:system_comments_flat.tpl"}>
        <{elseif $comment_mode == "thread"}>
            <{include file="db:system_comments_thread.tpl"}>
        <{elseif $comment_mode == "nest"}>
            <{include file="db:system_comments_nest.tpl"}>
        <{/if}>

    <{include file="db:yogurt_footer.tpl"}>
	
	<!-- end -->
</div>
      </div>
   </div>
</div>
    	</div>
</div>
