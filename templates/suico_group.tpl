<{include file='db:suico_navbar.tpl'}>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div id="content" class="content content-full-width">
                        <!-- start -->
                        <h5><{$smarty.const._MD_SUICO_GROUP}> : <{$group_title}></h5>

                        <div>
                            <img src="<{$xoops_upload_url}>/suico/groups/<{$group_img}>" alt="<{$group_title}>" title="<{$group_title}>"><br><br>
                        </div>

                        <div class="alert alert-primary">
                            <{if $xoops_userid == $group_owneruid }>
                                <button title="<{$lang_owner}>" class="btn btn-secondary btn-sm float-right"><span class="fa fa-user"></span> <{$smarty.const._MD_SUICO_OWNEROFGROUP}></button>
                            <{/if}>
                            <{if $isAnonym!=1}>
                                <{if $memberOfGroup ==1}>
                                    <form action="abandongroup.php" method="POST" id="form_abandongroup">
                                        <input type="hidden" value="<{$group_rel_id}>" name="relgroup_id" id="relgroup_id">
                                        <input type="hidden" value="<{$group_id}>" name="group_id" id="group_id">
                                        <button name="" type="image" class="btn btn-primary btn-sm float-right"><span class="fa fa-user-circle-o"></span> <{$smarty.const._MD_SUICO_MEMBEROFGROUP}></button>
                                        <button name="" type="image" class="btn btn-danger btn-sm float-right"><span class="fa fa-close"></span> <{$lang_abandongroup}></button>
                                    </form>
                                    <{ else}>
                                    <form action="becomemembergroup.php" method="POST" id="form_becomemember" class="suico-groups-form-becomemember">
                                        <input type="hidden" value="<{$group_id}>" name="group_id" id="group_id">
                                        <button name="" type="image" class="btn btn-info btn-sm float-right"><span class="fa fa-handshake-o"></span> <{$lang_joingroup}></button>
                                    </form>
                                <{/if}>
                            <{/if}>

                            <h6><{$group_title}></h6>
                            <{$group_desc}>
                            <p class="text-muted"><small>
                                    <span class="fa fa-user-circle" title="<{$smarty.const._MD_SUICO_OWNEROFGROUP}>"></span> <a href="<{$xoops_url}>/modules/suico/index.php?uid=<{$group_owneruid}>" target="_blank"><{$group_ownername}></a>
                                    <span class="fa fa-calendar" title="<{$smarty.const._MD_SUICO_GROUPDATECREATED}>"></span>
                                    <{if $group_date_created == $group_date_updated}>
                                        <{$group_date_created|date_format}>
                                    <{else}>
                                        <{$group_date_updated|date_format}>
                                    <{/if}>
                                    <span class="fa fa-user" title="<{$smarty.const._MD_SUICO_GROUPTOTALMEMBERS}>"></span> <{$group_total_members}>
                                    <span class="fa fa-comment" title="<{$smarty.const._MD_SUICO_GROUPTOTALCOMMENTS}>"></span> <{$group_total_comments}>
                                </small></p>
                            <{if $isOwner }>
                                <{if $xoops_userid == $group_owneruid }>
                                    <form action="delete_group.php" method="POST" id="form_deletegroup" class="suico-groups-form-delete">
                                        <input type="hidden" value="<{$group_id}>" name="group_id" id="group_id">
                                        <input type="image" src="<{xoModuleIcons16 delete.png}>">
                                    </form>
                                    <form action="editgroup.php" method="POST" id="form_editgroup" class="suico-groups-form-edit">
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
                                        <a href="<{$xoops_url}>/modules/suico/index.php?uid=<{$group_members[i].uid}>" alt="<{$group_members[i].uname}>" title="<{$group_members[i].uname}>">
                                            <{if $group_members[i].avatar=="avatars/blank.gif"}><img src="<{$xoops_upload_url}>/avatars/blank.gif" class="rounded-circle float-left p-2" height="60" width="60"  alt="<{$group_members[i].uname}>" title="<{$group_members[i].uname}>"><{else}> <img
                                                class="rounded-circle float-left p-2" src="<{$xoops_upload_url}>/<{$group_members[i].avatar}>" height="60" width="60"  alt="<{$group_members[i].uname}>" title="<{$group_members[i].uname}>"><{/if}></a>

                                        <a href="<{$xoops_url}>/modules/suico/index.php?uid=<{$group_members[i].uid}>" alt="<{$group_members[i].uname}>" title="<{$group_members[i].uname}>"><{$group_members[i].uname}></a>
                                        <{if $group_owneruid==$group_members[i].uid}>
                                            <button title="<{$lang_owner}>" class="btn btn-secondary btn-sm float-right"><span class="fa fa-user"></span> <{$smarty.const._MD_SUICO_OWNEROFGROUP}></button>
                                        <{/if}>

                                        <{if $group_owneruid==$useruid && $group_owneruid!=$group_members[i].uid}>
                                            <form action="kickfromgroup.php" method="post">
                                                <input type="hidden" value="<{$group_id}>" name="group_id" id="group_id">
                                                <input type="hidden" value="<{$group_members[i].uid}>" name="rel_user_uid" id="rel_user_uid">
                                                <button name="" type="image" class="btn btn-info btn-sm float-right"><span class="fa fa-remove"></span> <{$lang_removemember}></button>
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

                        <{include file="db:suico_footer.tpl"}>

                        <!-- end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
