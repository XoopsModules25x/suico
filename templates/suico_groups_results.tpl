<{include file='db:suico_navbar.tpl'}>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div id="content" class="content content-full-width">
                        <!-- start -->

                        <h5>
                            <{$smarty.const._MD_SUICO_GROUPSEARCHRESULT}>
                        </h5>

                        <{if $countGroups_all<=0}>
                            <div class="alert alert-primary">
                                <{$smarty.const._MD_SUICO_NOMATCHGROUP}>
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
                                        <{if $isOwner && $isAnonym!=1}>
                                            <{if $uid_owner == $groups[j].uid }>
                                                <button title="<{$lang_owner}>" class="btn btn-secondary btn-sm float-right"><span class="fa fa-user"></span> <{$smarty.const._MD_SUICO_OWNEROFGROUP}></button>
                                            <{/if}>
                                            <{if $uid_owner == $groups[j].uid OR in_array($groups[j].id, $mygroupsid)}>
                                                <button name="" type="image" class="btn btn-primary btn-sm float-right"><span class="fa fa-user-circle-o"></span> <{$lang_memberofgroup}></button>
                                            <{/if}>
                                            <{if !in_array($groups[j].id, $mygroupsid) && $uid_owner != $groups[j].uid}>
                                                <form action="becomemembergroup.php" method="POST" id="form_becomemember" class="suico-groups-form-becomemember">
                                                    <input type="hidden" value="<{$groups[j].id}>" name="group_id" id="group_id">
                                                    <button name="" type="image" class="btn btn-dark btn-sm float-right"><span class="fa fa-handshake-o"></span> <{$lang_joingroup}></button>
                                                </form>
                                            <{/if}>

                                        <{/if}>

                                        <a href="group.php?group_id=<{$groups[j].id}>"><img src="<{$xoops_upload_url}>/suico/groups/<{$groups[j].img}>" alt="<{$groups[j].title}>" title="<{$groups[j].title}>"></a>

                                        <h6><a href="group.php?group_id=<{$groups[j].id}>"><{$groups[j].title}></a></h6>
                                        <{$groups[j].desc}>
                                        <br>
                                        <{if $isOwner }>
                                            <{if $uid_owner == $groups[j].uid }>
                                                <form action="delete_group.php" method="POST" id="form_deletegroup" class="suico-groups-form-delete">
                                                    <input type="hidden" value="<{$groups[j].id}>" name="group_id" id="group_id">
                                                    <input type="image" src="<{xoModuleIcons16 delete.png}>">
                                                </form>
                                                <form action="editgroup.php" method="POST" id="form_editgroup" class="suico-groups-form-edit">
                                                    <input type="hidden" value="<{$groups[j].id}>" name="group_id" id="group_id">
                                                    <input type="image" src="<{xoModuleIcons16 edit.png}>">
                                                </form>
                                            <{/if}>
                                        <{/if}>

                                    </td>
                                </tr>
                            <{/section}>
                            </tbody>
                        </table>


                        <div>
                            <{$navigationBar}>
                        </div>


                        <div class="alert alert-info">
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


                        <{include file="db:suico_footer.tpl"}>

                        <!-- end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

