<{include file='db:suico_navbar.tpl'}>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div id="content" class="content content-full-width">
                        <!-- start -->

                        <form name='suico-group-edit-form' id='suico-group-edit-form' action='editgroup.php' method='post' enctype="multipart/form-data">
                            <div class="alert alert-primary">
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
                                    <br><img src="<{$xoops_upload_url}>/suico/groups/<{$group_img}>"><br><br>
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


                        <table id="membersofgroup" class="table table-hover table-border">
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

                                        <{if $group_members[i].isOwner }>
                                            <span class="fa fa-user" title="<{$lang_owner}>" style="color:#8B0000;"></span>
                                        <{else}>
                                            <form action="kickfromgroup.php" method="post">
                                                <input type="hidden" value="<{$group_id}>" name="group_id" id="group_id">
                                                <input type="hidden" value="<{$group_members[i].uid}>" name="rel_user_uid" id="rel_user_uid">
                                                <button name="" type="image" class="btn btn-danger btn-sm float-right"><span class="fa fa-remove"></span><{$smarty.const._MD_SUICO_KICKOUT}></button>
                                            </form>
                                        <{/if}>


                                    </td>
                                </tr>
                            <{/section}>

                            </tbody>
                        </table>


                        <{include file="db:suico_footer.tpl"}>
                        <!-- end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
