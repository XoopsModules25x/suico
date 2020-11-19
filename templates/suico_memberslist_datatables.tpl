<{include file="db:suico_navbar.tpl"}>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div id="content" class="content content-full-width">
                        <!-- start -->

                        <h4><{$smarty.const._MD_SUICO_MEMBERSLISTSECTION}></h4>
                        <{if $displaywelcomemessage == 1}><{$welcomemessage}><br><{/if}>

                        <{if $displaytotalmember == 1}>
                            <b><{$smarty.const._MD_SUICO_TOTALUSERS}>:</b>
                            <{$totalmember}>
                        <{/if}>

                        <{if $displaylatestmember == 1}>
                            &nbsp;&nbsp;
                            <b><{$smarty.const._MD_SUICO_LATESTMEMBER}>:</b>
                            <{$latestmember}>
                            <br>
                            <br>
                        <{/if}>

                        <{if $memberslisttemplate == 'datatables'}>
                            <div class="table-responsive">
                                <table id="memberslist" class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th bgcolor="#38a8e8"><{$smarty.const._MD_SUICO_MEMBERSLIST}></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <{section name=i loop=$users}>
                                        <tr>
                                            <td>
                                                <{if $xoops_isuser && $allow_friends !=-1}>
                                                    <p class="float-right">
                                                    <{if $users[i].isFriend!=1 && $users[i].uid != $uid_owner && $users[i].selffriendrequest!=1 && $users[i].otherfriendrequest!=1}>
                                                        <form action=send_friendrequest.php method="post">
                                                            <input type="hidden" name="friendrequestto_uid" id="friendrequestto_uid" value="<{$users[i].id}>">
                                                            <button name="addfriend" type="submit" class="btn btn-info btn-sm float-right"><span class="fa fa-user-plus"></span> <{$lang_addfriend}></button>
                                                            <{$token}>
                                                        </form>
                                                    <{/if}>
                                                    <{if $users[i].isFriend ==1 && $users[i].uid != $uid_owner}>
                                                        <button type="button" class="btn btn-info btn-sm"><span class="fa fa-user-circle"></span> <{$lang_myfriend}></button>
                                                    <{/if}>
                                                    <{if $users[i].uid != $uid_owner}>
                                                        <{if $users[i].selffriendrequest==1 && $self_uid!=0}>
                                                            <button type="button" class="btn btn-info btn-sm"><span class="fa fa-check-circle"></span> <{$lang_friendrequestsent}></button>
                                                            <form action=cancelFriendrequest.php method="post">
                                                                <input type="hidden" name="friendrequestto_uid" id="friendrequestto_uid" value="<{$users[i].id}>">
                                                                <button name="" type="image" class="btn btn-danger btn-sm float-right"><span class="fa fa-remove"></span> <{$lang_cancelfriendrequest}></button>
                                                                <{$token}>
                                                            </form>
                                                        <{/if}>
                                                        <{if $users[i].otherfriendrequest==1 && $other_uid!=0}>
                                                            <button type="button" class="btn btn-info btn-sm"><span class="fa fa-clock-o"></span> <{$lang_friendshippending}></button>
                                                            <form action=cancelFriendrequest.php method="post">
                                                                <input type="hidden" name="friendrequestto_uid" id="friendrequestto_uid" value="<{$users[i].id}>">
                                                                <button name="" type="image" class="btn btn-danger btn-sm float-right"><span class="fa fa-remove"></span> <{$lang_cancelfriendrequest}></button>
                                                                <{$token}>
                                                            </form>
                                                        <{/if}>
                                                    <{/if}>
                                                    </p>
                                                <{/if}>

                                                <h5><a href="<{$xoops_url}>/modules/suico/index.php?uid=<{$users[i].id}>"><{$users[i].name}></a></h5>
                                                <{if $displayavatar == 1}>
                                                    <a href="<{$xoops_url}>/modules/suico/index.php?uid=<{$users[i].id}>"><img src='<{$xoops_url}>/uploads/<{$users[i].avatar}>' class='rounded-circle float-left' title='<{$users[i].name}>' alt='<{$users[i].name}>' style='padding:10px' width='100'
                                                                                                                               height='100'></a>
                                                <{/if}>
                                                <{if $displayrealname == 1 && $users[i].realname!=''}>
                                                    <span class="text-muted"><b><{$smarty.const._MD_SUICO_REALNAME}> :</b> <a href="<{$xoops_url}>/modules/suico/index.php?uid=<{$users[i].id}>"><{$users[i].realname}></a></span>
                                                <{/if}>
                                                <{if $displayfrom == 1 && $users[i].location!=''}>
                                                    <br>
                                                    <span class='text-muted'><small><b><{$smarty.const._MD_SUICO_LOCATION}> :</b> <{$users[i].location}></small></span>
                                                <{/if}>
                                                <{if $displayoccupation == 1 && $users[i].occupation!=''}>
                                                    <span class='text-muted'><small> | <b><{$smarty.const._MD_SUICO_OCCUPATION}> :</b> <{$users[i].occupation}>  </small></span>
                                                <{/if}>
                                                <{if $displayinterest == 1 && $users[i].interest!=''}>
                                                    <br>
                                                    <span class='text-muted'><small> <b><{$smarty.const._MD_SUICO_INTEREST}> :</b> <{$users[i].interest}></small></span>
                                                <{/if}>
                                                <{if $displayextrainfo == 1 && $users[i].extrainfo}>
                                                    <br>
                                                    <span class='text-muted'><small> <b><{$smarty.const._MD_SUICO_EXTRAINFO}> :</b><br> <{$users[i].extrainfo}> </small></span>
                                                <{/if}>
                                                <{if $displaysignature == 1 && $users[i].signature}>
                                                    <br>
                                                    <span class='text-muted'><small> <b><{$smarty.const._MD_SUICO_SIGNATURE}> : </b><br> <{$users[i].signature}> </small></span>
                                                <{/if}>
                                                <br>
                                                <{if $displayregdate == 1}>
                                                    <br>
                                                    <span class='text-muted'><small><b><{$smarty.const._MD_SUICO_MEMBERSINCE}> :</b> <{$users[i].registerdate}></small></span>
                                                <{/if}>
                                                <{if $displayposts == 1}>
                                                    <span class='text-muted'><small> | <b><{$smarty.const._MD_SUICO_POSTS}> :</b> <{$users[i].posts}>  </small></span>
                                                <{/if}>
                                                <{if $displaylastlogin == 1}>
                                                    <span class='text-muted'><small> | <b><{$smarty.const._MD_SUICO_LASTLOGIN}> :</b> <{$users[i].lastlogin}></small></span>
                                                <{/if}>
                                                <{if $displayrank == 1}>
                                                    <br>
                                                    <span class='text-muted'><small> <b><{$smarty.const._MD_SUICO_RANK}> :</b> <{$users[i].ranktitle}> <{$users[i].rankimage}> </small></span>
                                                <{/if}>
                                                <{if $displaygroups == 1}>
                                                    <span class='text-muted'><small> <b><{$smarty.const._MD_SUICO_GROUP}> :</b> <{$users[i].groups}></small></span>
                                                <{/if}>
                                                <br><br>
                                                <{if $displayonlinestatus == 1}>
                                                    <{if $users[i].onlinestatus == 1}>
                                                        <button type="button" class="btn btn-danger btn-sm"><span class="fa fa-user-circle-o"></span> <{$smarty.const._MD_SUICO_ONLINE}></button>
                                                    <{else}>
                                                        <button type="button" class="btn btn-dark btn-sm"><span class="fa fa-user-circle-o"></span> <{$smarty.const._MD_SUICO_OFFLINE}></button>
                                                    <{/if}>
                                                <{/if}>

                                                <{if $xoops_isuser AND $displayemail == 1}>
                                                    <a href="mailto:<{$users[i].emailaddress}>" target="_blank" class="btn btn-primary btn-sm" role="button"><span class="fa fa-envelope" aria-hidden="true"></span> <{$smarty.const._MD_SUICO_EMAIL}></a>
                                                <{/if}>
                                                <{if $xoops_isuser AND $displaypm == 1}>
                                                    <a href="javascript:openWithSelfMain('<{$xoops_url}>/pmlite.php?send2=1&amp;to_userid=<{$users[i].id}>', 'pmlite', 450, 380);" class="btn btn-primary btn-sm" role="button"><span class="fa fa-envelope-o"></span> <{$smarty.const._MD_SUICO_PRIVATEMESSAGE}>
                                                    </a>
                                                    </button>
                                                <{/if}>
                                                <{if $displayurl == 1 AND $users[i].url!=''}>
                                                    <a href="<{$users[i].url}>" target="_blank" class="btn btn-primary btn-sm" role="button"><span class="fa fa-link" aria-hidden="true"></span> <{$smarty.const._MD_SUICO_URL}></a>
                                                <{/if}>
                                                <{if $is_admin === true}>
                                                    <p class="float-right"><br><{$users[i].adminlink}></p>
                                                <{/if}>
                                            </td>
                                        </tr>
                                    <{/section}>
                                    </tbody>
                                </table>
                            </div>
                            <{$pagenav|default:''}>
                            <br>
                            <br>
                            <script>
                                $(document).ready(function () {
                                    $('#memberslist').DataTable({
                                        "ordering": false,
                                        "lengthChange": false,
                                        "displayLength": <{$membersperpage}>,
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
                        <{elseif $memberslisttemplate == 'normal'}>
                            <{include file='db:suico_memberslist_normal.tpl'}>
                        <{/if}>

                        <{include file="db:suico_footer.tpl"}>

                        <!-- end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
