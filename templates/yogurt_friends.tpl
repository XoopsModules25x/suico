<{include file='db:yogurt_navbar.tpl'}>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div id="content" class="content content-full-width">
                        <!-- start -->
                        <{if $allow_friends !=-1 && $friendrequest==1 && $isOwner==1 && $isFriend==0}>
                        <!-- if not owner and not friend -->
                        <div class="alert alert-warning">
                            <h5><{$lang_you_have_x_friendrequests}></h5>
                            <img class="rounded-circle float-left p-1" height="60" width="60" src="<{$xoops_url}>/uploads/<{$friendrequester_avatar}>">
                            <form action="makefriends.php" method="post">
                                <{$lang_askingfriend}>

                                <div class="form-check">
                                    <label class="form-check-label"><input name="level" type="radio" value="5"> <{$lang_acceptfriend}></label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label"><input name="level" type="radio" value="0"> <{$lang_rejectfriend}></label>
                                </div>

                                <div class='form-group'>
                                    <input type="hidden" name="friendrequest_id" id="friendrequest_id" value="<{$friendrequest_id}>">
                                    <input type="submit" class='btn btn-primary btn-sm' value='Submit'>
                                </div>
                                <{$token}>
                            </form>
                        </div>
                        <{/if}>
                        <{if (($isOwner==1))}>
                        <{if $lang_nofriendsyet==""}>
                        <a href="memberslist.php" class="btn btn-primary btn-sm float-right" role="button"><i class="fa fa-address-card-o"></i> <{$smarty.const._MD_YOGURT_FINDMOREFRIENDS}></a>
                        <{else}>
                        <a href="memberslist.php" class="btn btn-primary btn-sm float-right" role="button"><i class="fa fa-address-card-o"></i> <{$smarty.const._MD_YOGURT_FINDFRIENDS}></a>
                        <{/if}>
                        <{/if}>

                        <h5 class="m-t-0 m-b-20"><{$lang_friends}></h5>

                        <!-- begin row -->
                        <{if $lang_nofriendsyet==""}>
                        <div class="row row-space-2">
                            <{section name=i loop=$friends}>
                            <!-- begin col-6 -->
                            <div class="col-md-6 m-b-2">
                                <div class="p-10 bg-white">
                                    <div class="media media-xs overflow-visible">
                                        <a class="media-left" href="<{$xoops_url}>/modules/yogurt/index.php?uid=<{$friends[i].uid}>" alt=" <{$friends[i].uname}>" title="<{$friends[i].uname}>">
                                            <{ if $friends[i].user_avatar=="blank.gif" }><img src="<{$xoops_url}>/uploads/avatars/blank.gif" class="media-object"> <{else}> <img src="<{$xoops_upload_url}>/<{$friends[i].user_avatar}>" class="media-object"><{/if}>
                                        </a>
                                        <div class="media-body valign-middle">
                                            <b class="text-inverse"><a class="media-left" href="<{$xoops_url}>/modules/yogurt/index.php?uid=<{$friends[i].uid}>" alt=" <{$friends[i].uname}>" title="<{$friends[i].uname}>">  <{$friends[i].uname}></a></b>
                                        </div>
                                        <div class="media-body valign-middle text-right overflow-visible">
                                            <div class="btn-group dropdown">
                                                <a href="javascript:;" class="btn btn-default"><{$lang_friends}></a>
                                                <{if $isOwner }>
                                                    <a href="javascript:;" data-toggle="dropdown" class="btn btn-default dropdown-toggle" aria-expanded="false"></a>
                                                    <ul class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(101px, 34px, 0px);">
                                                        <{if $allow_fanssevaluation == 1 OR $allow_friendshiplevel == 1}>
                                                            <li class="p-1">
                                                                <form action="editfriendship.php" method="post" class="yogurt-friends-deleteform">
                                                                    <input type="hidden" name="friend_uid" id="friend_uid" value="<{$friends[i].uid}>">
                                                                    <button name="submit" id="submit" type="image" class="btn btn-primary btn-sm" title="<{$lang_evaluate}>"><i class="fa fa-gear"></i> <{$lang_friendshipsettings}></button>
                                                                </form>
                                                            </li>
                                                        <{/if}>
                                                        <li class="p-1">
                                                            <form action="delfriendship.php" method="post">
                                                                <input type="hidden" name="friend_uid" id="friend_uid" value="<{$friends[i].uid}>">
                                                                <button name="submit" id="submit" type="image" class="btn btn-danger btn-sm" title="<{$lang_delete}>"><i class="fa fa-remove"></i> <{$lang_deletefriend}></button>
                                                            </form>

                                                        </li>
                                                    </ul>
                                                <{/if}>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end col-6 -->
                            <{/section}>
                        </div>
                        <!-- end row -->
                        <{else}>
                        <br>
                        <div class="alert alert-primary">
                            <{$lang_nofriendsyet}></div>


                        <{/if}>


                        <{ if $navegacao!='' }>
                        <div><{$navegacao}></div>
                        <{/if}>

                        <{include file="db:yogurt_footer.tpl"}>
                        <!-- end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
