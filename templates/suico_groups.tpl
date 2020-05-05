<{include file='db:suico_navbar.tpl'}>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div id="content" class="content content-full-width">
                        <!-- start -->

                        <{if $isAnonym!=1 && $isOwner}>
                            <div class="alert alert-primary">
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

                            <a name="mygroups"><{$lang_groups}></a>

                        </h5>

                        <{if $countGroups<=0}>
                            <div class="alert alert-primary">
                                <{$lang_nogroupsyet}>
                            </div>
                        <{/if}>


                        <{if $countGroups!=0}>
                            <table id="" class="display no-wrap table table-striped">
                                <thead class="thead-dark">
                                <tr>
                                    <th><{$lang_groupslist}></th>

                                </tr>
                                </thead>
                                <tbody>
                                <{section name=i loop=$mygroups}>
                                    <tr>
                                        <td>
                                            <{if $isAnonym!=1}>
                                                <button name="" type="image" class="btn btn-primary btn-sm float-right"><span class="fa fa-user-circle-o"></span> <{$lang_memberofgroup}></button>
                                            <{/if}>

                                            <a href="group.php?group_id=<{$mygroups[i].group_id}>"><img src="<{$xoops_upload_url}>/suico/groups/<{$mygroups[i].img}>" alt="<{$mygroups[i].title}>" title="<{$mygroups[i].title}>" class="float-left pr-2" width="120"></a>
                                            <h6><a href="group.php?group_id=<{$mygroups[i].group_id}>"><{$mygroups[i].title}></a></h6>
                                            <{$mygroups[i].desc}>
                                            <br>
                                            <{if $isOwner }>
                                                <{if $uid_owner == $mygroups[i].uid }>
                                                    <form action="delete_group.php" method="POST" id="form_deletegroup" class="suico-groups-form-delete">
                                                        <input type="hidden" value="<{$mygroups[i].group_id}>" name="group_id" id="group_id">
                                                        <input type="image" src="<{xoModuleIcons16 delete.png}>">
                                                    </form>
                                                    <form action="editgroup.php" method="POST" id="form_editgroup" class="suico-groups-form-edit">
                                                        <input type="hidden" value="<{$mygroups[i].group_id}>" name="group_id" id="group_id">
                                                        <input type="image" src="<{xoModuleIcons16 edit.png}>">
                                                    </form>
                                                    <button title="<{$lang_owner}>" class="btn btn-secondary btn-sm float-right"><span class="fa fa-user"></span> <{$smarty.const._MD_SUICO_OWNEROFGROUP}></button>
                                                <{/if}>
                                            <{/if}>

                                        </td>
                                    </tr>
                                <{/section}>
                                </tbody>
                            </table>
                        <{/if}>
                        <!--<{$navigationBar_my}>--><br><br>


                        <{if $isOwner==1}>
                            <!-- <div class="alert alert-info">
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
                            </div> -->
                            <h5>
                                <a name="allgroups"><{$lang_availablegroups}> <span class="badge badge-pill badge-primary"><{$groupstotal}></span></a>
                            </h5>
                            <{if $countGroups_all<=0}>
                                <div class="alert alert-primary">
                                    <{$lang_nogroupsyet}>
                                </div>
                            <{/if}>

                            <{if $countGroups_all!=0}>
                                <table id="" class="display no-wrap table table-striped table-hover table-bordered">
                                    <thead class="thead-light">
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
                                                        <form action="becomemembergroup.php" method="POST" id="form_becomemember" class="suico-groups-form-becomemember">
                                                            <input type="hidden" value="<{$groups[j].id}>" name="group_id" id="group_id">
                                                            <button name="" type="image" class="btn btn-dark btn-sm float-right"><span class="fa fa-handshake-o"></span> <{$lang_joingroup}></button>
                                                        </form>
                                                    <{else}>
                                                        <{if $uid_owner == $groups[j].uid OR in_array($groups[j].id, $mygroupsid)}>
                                                            <button name="" type="image" class="btn btn-primary btn-sm float-right"><span class="fa fa-user-circle-o"></span> <{$lang_memberofgroup}></button>
                                                        <{else}>
                                                            <form action="becomemembergroup.php" method="POST" id="form_becomemember" class="suico-groups-form-becomemember">
                                                                <input type="hidden" value="<{$groups[j].id}>" name="group_id" id="group_id">
                                                                <button name="" type="image" class="btn btn-dark btn-sm float-right"><span class="fa fa-handshake-o"></span> <{$lang_joingroup}></button>
                                                            </form>
                                                        <{/if}>
                                                    <{/if}>
                                                <{/if}>

                                                <a href="group.php?group_id=<{$groups[j].id}>"><img src="<{$xoops_upload_url}>/suico/groups/<{$groups[j].img}>" alt="<{$groups[j].title}>" title="<{$groups[j].title}>" class="float-left pr-2" width="120"></a>
                                                <h6>
                                                    <a href="group.php?group_id=<{$groups[j].id}>"><{$groups[j].title}></a>
                                                </h6>
                                                <{if $groups[j].desc!=''}><{$groups[j].desc}><{/if}> <small><span class="text-muted"><{$groups[j].group_total_members}></span></small>
                                                <br>

                                                <{if ($uid_owner == $groups[j].uid)}>
                                                    <form action="delete_group.php" method="POST" id="form_deletegroup" class="suico-groups-form-delete">
                                                        <input type="hidden" value="<{$groups[j].id}>" name="group_id" id="group_id">
                                                        <input type="image" src="<{xoModuleIcons16 delete.png}>">
                                                    </form>
                                                    <form action="editgroup.php" method="POST" id="form_editgroup" class="suico-groups-form-edit">
                                                        <input type="hidden" value="<{$groups[j].id}>" name="group_id" id="group_id">
                                                        <input type="image" src="<{xoModuleIcons16 edit.png}>">
                                                    </form>
                                                    <button title="<{$lang_owner}>" class="btn btn-secondary btn-sm float-right"><span class="fa fa-user"></span> <{$smarty.const._MD_SUICO_OWNEROFGROUP}></button>
                                                <{/if}>


                                            </td>
                                        </tr>
                                    <{/section}>
                                    </tbody>
                                </table>
                                <!--<div>
                                    <{$navigationBar}>
                                </div>-->
                            <{/if}>
                        <{/if}>

                        <script>
                            $(document).ready(function () {
                                $('table.display').DataTable({
                                    //dom: "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>" +
                                    //"<'row'<'col-sm-12'tr>>" +
                                    //"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                                    "responsive": true,
                                    "ordering": false,
                                    "lengthChange": false,
                                    "displayLength": <{$groupsperpage}>,
                                    "language": {
                                        "decimal": "<{$smarty.const._MD_SUICO_DTABLE_DECIMAL}>",
                                        "emptyTable": "<{$smarty.const._MD_SUICO_DTABLE_EMPTYTABLE}>",
                                        "info": "<{$smarty.const._MD_SUICO_DTABLE_INFOSHOWING}> _START_ <{$smarty.const._MD_SUICO_DTABLE_INFOTO}> _END_ <{$smarty.const._MD_SUICO_DTABLE_INFOOF}> _TOTAL_ <{$smarty.const._MD_SUICO_DTABLE_INFOENTRIES}>",
                                        "infoEmpty": "<{$smarty.const._MD_SUICO_DTABLE_INFOEMPTY}>",
                                        "infoFiltered": "(<{$smarty.const._MD_SUICO_DTABLE_INFOFILTEREDFROM}> _MAX_ <{$smarty.const._MD_SUICO_DTABLE_INFOFILTEREDTOTALENTRIES}>)",
                                        "infoPostFix": "<{$smarty.const._MD_SUICO_DTABLE_INFOPOSTFIX}>",
                                        "thousands": "<{$smarty.const._MD_SUICO_DTABLE_THOUSANDS}>",
                                        "lengthMenu": "<{$smarty.const._MD_SUICO_DTABLE_LENGTHMENUSHOW}> _MENU_ <{$smarty.const._MD_SUICO_DTABLE_LENGTHMENUENTRIES}>",
                                        "loadingRecords": "<{$smarty.const._MD_SUICO_DTABLE_LOADINGRECORDS}>",
                                        "processing": "<{$smarty.const._MD_SUICO_DTABLE_PROCESSING}>",
                                        "search": "<{$smarty.const._MD_SUICO_DTABLE_SEARCH}>",
                                        "zeroRecords": "<{$smarty.const._MD_SUICO_DTABLE_ZERORECORDS}>",
                                        "paginate": {
                                            "first": "<{$smarty.const._MD_SUICO_DTABLE_FIRST}>",
                                            "last": "<{$smarty.const._MD_SUICO_DTABLE_LAST}>",
                                            "next": "<{$smarty.const._MD_SUICO_DTABLE_NEXT}>",
                                            "previous": "<{$smarty.const._MD_SUICO_DTABLE_PREVIOUS}>"
                                        },
                                        "aria": {
                                            "sortAscending": "<{$smarty.const._MD_SUICO_DTABLE_SORT_ASCENDING}>",
                                            "sortDescending": "<{$smarty.const._MD_SUICO_DTABLE_SORT_DESCENSING}>"
                                        }
                                    }
                                });
                            });
                        </script>

                        <{include file="db:suico_footer.tpl"}>

                        <!-- end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

