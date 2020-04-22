<{include file='db:yogurt_navbar.tpl'}>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
   <div class="row">
      <div class="col-md-12">
         <div id="content" class="content content-full-width">
<!-- start -->

    <h5>
        <{$smarty.const._MD_YOGURT_GROUPSEARCHRESULT}>
    </h5>

    <{if $nb_groups_all<=0}>
       <div class="alert alert-info">
        <{$smarty.const._MD_YOGURT_NOMATCHGROUP}>
        </div>
    <{/if}>

	<table class="table table-striped">
    <thead>
        <tr>
            <th><{$lang_groupslist}></th>
         
        </tr>
    </thead>
    <tbody>
    <{section name=j loop=$groups}>
	<tr>
            <td>

                 <a href="group.php?group_id=<{$groups[j].id}>"><img src="<{$xoops_upload_url}>/yogurt/groups/<{$groups[j].img}>" alt="<{$groups[j].title}>" title="<{$groups[j].title}>"></a>
           
                <h6><a href="group.php?group_id=<{$groups[j].id}>"><{$groups[j].title}></a></h6>
                <{$groups[j].desc}>
            <br>
			 <{if $isOwner }>
                 <{if $uid_owner == $groups[j].uid }>
					<form action="delete_group.php" method="POST" id="form_deletegroup" class="yogurt-groups-form-delete">
                        <input type="hidden" value="<{$groups[j].id}>" name="group_id" id="group_id">
                        <input type="image" src="<{xoModuleIcons16 delete.png}>">
                    </form>
                    <form action="editgroup.php" method="POST" id="form_editgroup" class="yogurt-groups-form-edit">
                        <input type="hidden" value="<{$groups[j].id}>" name="group_id" id="group_id">
                        <input type="image" src="<{xoModuleIcons16 edit.png}>">
                    </form>
                <{/if}>
           <{/if}>

		 </td></tr>
    <{/section}>
 </tbody>
</table>
	

<div>
    <{$navigationBar}>
</div>


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


<{include file="db:yogurt_footer.tpl"}>

<!-- end -->
</div>
      </div>
   </div>
</div>
    	</div>
</div>

