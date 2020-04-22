<{include file="db:yogurt_navbar.tpl"}>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
   <div class="row">
      <div class="col-md-12">
         <div id="content" class="content content-full-width">
<!-- start -->

<h4><{$smarty.const._MD_YOGURT_MEMBERSLISTSECTION}></h4>
<{if $displaywelcomemessage == 1}><{$welcomemessage}><br><{/if}>

<{if $displaytotalmember == 1}>
    <b><{$smarty.const._MD_YOGURT_TOTALUSERS}>:</b>
    <{$totalmember}>
<{/if}>

<{if $displaylatestmember == 1}>
    &nbsp;&nbsp;
    <b><{$smarty.const._MD_YOGURT_LATESTMEMBER}>:</b>
    <{$latestmember}>
    <br>
    <br>
<{/if}>

<{if $memberslisttemplate == 'datatables'}>
    <div class="table-responsive">
        <table id="memberslist" class="table table-striped table-hover">
            <thead>
            <tr>
                <th bgcolor="#38a8e8"><{$smarty.const._MD_YOGURT_MEMBERSLIST}></th>
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
									<button name="addfriend" type="submit" class="btn btn-info btn-sm float-right"> <i class="fa fa-user-plus"></i> <{$lang_addfriend}></button>			 	   
									<{$token}>
                                </form>
                            <{/if}>
                            <{if $users[i].isFriend ==1 && $users[i].uid != $uid_owner}>
									<button type="button" class="btn btn-info btn-sm"> <i class="fa fa-user-circle"></i> <{$lang_myfriend}></button>
                            <{/if}>
                            <{if $users[i].uid != $uid_owner}>
                                <{if $users[i].selffriendrequest==1 && $self_uid!=0}>
                                    <button type="button" class="btn btn-info btn-sm"> <i class="fa fa-check-circle"></i> <{$lang_friendrequestsent}></button>
                                <{/if}>
                                <{if $users[i].otherfriendrequest==1 && $other_uid!=0}>
                                    <button type="button" class="btn btn-info btn-sm"> <i class="fa fa-clock-o"></i> <{$lang_friendshippending}></button>
                                <{/if}>
                            <{/if}>
                            </p>
                        <{/if}>

                        <h5><a href="<{$xoops_url}>/modules/yogurt/index.php?uid=<{$users[i].id}>"><{$users[i].name}></a></h5>
                        <{if $displayavatar == 1}>
                            <a href="<{$xoops_url}>/modules/yogurt/index.php?uid=<{$users[i].id}>"><img src='<{$xoops_url}>/uploads/<{$users[i].avatar}>' class='rounded-circle float-left' title='<{$users[i].name}>' alt='<{$users[i].name}>' style='padding:10px' width='100' height='100'></a>
                        <{/if}>
                        <{if $displayrealname == 1 && $users[i].realname!=''}>
                            <span class="text-muted"><b><{$smarty.const._MD_YOGURT_REALNAME}> :</b> <a href="<{$xoops_url}>/modules/yogurt/index.php?uid=<{$users[i].id}>"><{$users[i].realname}></a></span>
                        <{/if}>
                        <{if $displayfrom == 1 && $users[i].location!=''}>
                            <br>
                            <span class='text-muted'><small><b><{$smarty.const._MD_YOGURT_LOCATION}> :</b> <{$users[i].location}></small></span>
                        <{/if}>
                        <{if $displayoccupation == 1 && $users[i].occupation!=''}>
                            <span class='text-muted'><small> | <b><{$smarty.const._MD_YOGURT_OCCUPATION}> :</b> <{$users[i].occupation}>  </small></span>
                        <{/if}>
                        <{if $displayinterest == 1 && $users[i].interest!=''}>
                            <br>
                            <span class='text-muted'><small> <b><{$smarty.const._MD_YOGURT_INTEREST}> :</b> <{$users[i].interest}></small></span>
                        <{/if}>
                        <{if $displayextrainfo == 1 && $users[i].extrainfo}>
                            <br>
                            <span class='text-muted'><small> <b><{$smarty.const._MD_YOGURT_EXTRAINFO}> :</b><br> <{$users[i].extrainfo}> </small></span>
                        <{/if}>
                        <{if $displaysignature == 1 && $users[i].signature}>
                            <br>
                            <span class='text-muted'><small> <b><{$smarty.const._MD_YOGURT_SIGNATURE}> : </b><br> <{$users[i].signature}> </small></span>
                        <{/if}>
                        <br>
                        <{if $displayregdate == 1}>
                            <br>
                            <span class='text-muted'><small><b><{$smarty.const._MD_YOGURT_MEMBERSINCE}> :</b> <{$users[i].registerdate}></small></span>
                        <{/if}>
                        <{if $displayposts == 1}>
                            <span class='text-muted'><small> | <b><{$smarty.const._MD_YOGURT_POSTS}> :</b> <{$users[i].posts}>  </small></span>
                        <{/if}>
                        <{if $displaylastlogin == 1}>
                            <span class='text-muted'><small> | <b><{$smarty.const._MD_YOGURT_LASTLOGIN}> :</b> <{$users[i].lastlogin}></small></span>
                        <{/if}>
                        <{if $displayrank == 1}>
                            <br>
                            <span class='text-muted'><small> <b><{$smarty.const._MD_YOGURT_RANK}> :</b> <{$users[i].ranktitle}> <{$users[i].rankimage}> </small></span>
                        <{/if}>
                        <{if $displaygroups == 1}>
                            <span class='text-muted'><small> <b><{$smarty.const._MD_YOGURT_GROUP}> :</b> <{$users[i].groups}></small></span>
                        <{/if}>
                        <br><br>
                        <{if $displayonlinestatus == 1}>
                            <{if $users[i].onlinestatus == 1}>
                                <button type="button" class="btn btn-danger btn-sm"> <i class="fa fa-user-circle-o"></i> <{$smarty.const._MD_YOGURT_ONLINE}></button>
                            <{else}>
                                <button type="button" class="btn btn-dark btn-sm"> <i class="fa fa-user-circle-o"></i> <{$smarty.const._MD_YOGURT_OFFLINE}></button>
                            <{/if}>
                        <{/if}>

                        <{if $xoops_isuser AND $displayemail == 1}>
                            <a href="mailto:<{$users[i].emailaddresss}>" target="_blank" class="btn btn-primary btn-sm" role="button"><i class="fa fa-envelope" aria-hidden="true"></i> <{$smarty.const._MD_YOGURT_EMAIL}></a>
                        <{/if}>
                        <{if $xoops_isuser AND $displaypm == 1}>
                            <a href="javascript:openWithSelfMain('<{$xoops_url}>/pmlite.php?send2=1&amp;to_userid=<{$users[i].id}>', 'pmlite', 450, 380);" class="btn btn-primary btn-sm" role="button"><i class="fa fa-envelope-o"></i> <{$smarty.const._MD_YOGURT_PRIVATEMESSAGE}></a>
                            </button>
                        <{/if}>
                        <{if $displayurl == 1 AND $users[i].website!=''}>
                            <a href="<{$users[i].url}>" target="_blank" class="btn btn-primary btn-sm" role="button"><i class="fa fa-link" aria-hidden="true"></i> <{$smarty.const._MD_YOGURT_URL}></a>
                        <{/if}>
                        <{if $is_admin == true}>
                            <p class="float-right"><br><{$users[i].adminlink}></p>
                        <{/if}>
                    </td>
                </tr>
            <{/section}>
            </tbody>
        </table>
    </div>
    <{$pagenav}>
    <br>
    <br>
    <script>
        jQuery(document).ready(function () {
            jQuery('#memberslist').DataTable({
                "ordering": false,
                "lengthChange": false,
                "displayLength": <{$membersperpage}>,
                "language": {
                    "decimal": "<{$smarty.const._MD_YOGURT_DTDECIMAL}>",
                    "emptyTable": "<{$smarty.const._MD_YOGURT_DTEMPTYTABLE}>",
                    "info": "<{$smarty.const._MD_YOGURT_DTINFOSHOWING}> _START_ <{$smarty.const._MD_YOGURT_DTINFOTO}> _END_ <{$smarty.const._MD_YOGURT_DTINFOOF}> _TOTAL_ <{$smarty.const._MD_YOGURT_DTINFOENTRIES}>",
                    "infoEmpty": "<{$smarty.const._MD_YOGURT_DTINFOEMPTY}>",
                    "infoFiltered": "(<{$smarty.const._MD_YOGURT_DTINFOFILTEREDFROM}> _MAX_ <{$smarty.const._MD_YOGURT_DTINFOFILTEREDTOTALENTRIES}>)",
                    "infoPostFix": "<{$smarty.const._MD_YOGURT_DTINFOPOSTFIX}>",
                    "thousands": "<{$smarty.const._MD_YOGURT_DTTHOUSANDS}>",
                    "lengthMenu": "<{$smarty.const._MD_YOGURT_DTLENGTHMENUSHOW}> _MENU_ <{$smarty.const._MD_YOGURT_DTLENGTHMENUENTRIES}>",
                    "loadingRecords": "<{$smarty.const._MD_YOGURT_DTLOADINGRECORDS}>",
                    "processing": "<{$smarty.const._MD_YOGURT_DTPROCESSING}>",
                    "search": "<{$smarty.const._MD_YOGURT_DTSEARCH}>",
                    "zeroRecords": "<{$smarty.const._MD_YOGURT_DTZERORECORDS}>",
                    "paginate": {
                        "first": "<{$smarty.const._MD_YOGURT_DTFIRST}>",
                        "last": "<{$smarty.const._MD_YOGURT_DTLAST}>",
                        "next": "<{$smarty.const._MD_YOGURT_DTNEXT}>",
                        "previous": "<{$smarty.const._MD_YOGURT_DTPREVIOUS}>"
                    },
                    "aria": {
                        "sortAscending": "<{$smarty.const._MD_YOGURT_DTSORTASCENDING}>",
                        "sortDescending": "<{$smarty.const._MD_YOGURT_DTSORTDESCENSING}>"
                    }
                }
            });
        });
    </script>
<{elseif $memberslisttemplate == 'normal'}>
    <{include file='db:yogurt_memberslist_normal.tpl'}>
<{/if}>

<{include file="db:yogurt_footer.tpl"}>

<!-- end -->
</div>
      </div>
   </div>
</div>
    	</div>
</div>
