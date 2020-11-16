<{include file='db:suico_navbar.tpl'}>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div id="content" class="content content-full-width">
                        <!-- start -->
                        <!-- if not owner and not friend -->
                        <{if $allow_friends !=-1 && $friendrequest|default:0==1 && $isOwner==1 && $isFriend==0}>
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

                        <{if $allow_profile_general}>
                            <h5><{$smarty.const._MD_SUICO_USER_DETAILS}> <span class="fa fa-user-circle"></span></h5>
                            <{foreach item=category from=$categories}>
                                <{if isset($category.fields)}>
                                    <br>
                                    <h6><{$category.cat_title}></h6>
                                    <{foreach item=field from=$category.fields}>
                                        <span class="suico-profileinfo-label"><{$field.title}> : </span>
                                        <span class="suico-profileinfo-value"><{$field.value}></span>
                                        <br>
                                    <{/foreach}>
                                <{/if}>
                            <{/foreach}>
                        <{/if}>

                        <{if ($isOwner==1)}>
                            <{if $visitors}>
                                <br>
                                <h5><{$lang_profilevisitors}> <span class="fa fa-user"></span></h5>
                                <div class="container-fluid">
                                    <div class="row row-cols-5">
                                        <{foreach item=visitor from=$visitors}>
                                            <div class="col text-center p-2">
                                                <a href='index.php?uid=<{$visitor.uid_visitor}>' target='_blank'><img src='<{$xoops_url}>/uploads/<{$visitor.avatar_visitor}>' class='rounded-circle' title='<{$visitor.uname_visitor}>' border='0' alt='<{$visitor.uname_visitor}>' height='48' width='48'></a>
                                                <a href="index.php?uid=<{$visitor.uid_visitor}>" target="_blank"><br><small><{$visitor.uname_visitor}></small></a><br><small><span class="fa fa-calendar-o"></span>&nbsp;<{$visitor.date_visited|date_format}></small>
                                            </div>
                                        <{/foreach}>
                                    </div>
                                </div>
                            <{/if}>
                        <{/if}>

                        <br>
                        <{if $allow_profile_stats}>
                        <{if $modules|default:''!=''}>
                        <h5><{$smarty.const._MD_SUICO_USER_CONTRIBUTIONS}> <span class="fa fa-check-circle"></span></h5>
                        <!-- start module search results loop -->
                        <p>
                            <{foreach item=module from=$modules name="search_results"}>
                            <div class="suico-profile-search-module" id="suico-profile-search-module-<{$smarty.foreach.search_results.iteration}>">
                                <h6>
                                    <a class="suico-profile-search-module-title" id="suico-profile-search-module-title-<{$smarty.foreach.search_results.iteration}>">
                                        <img src="assets/images/toggle.gif">
                                    </a>
                                    <{$module.name}>
                                </h6>

                                <div class="suico-profile-search-module-results" id="suico-profile-search-module-results-<{$smarty.foreach.search_results.iteration}>">
                                    <!-- start results item loop -->
                                    <{foreach item=result from=$module.results}>
                        <p>

                            <b>
                                <a href="<{$xoops_url}>/<{$result.link}>">
                                    <{$result.title}>
                                </a>
                            </b>
                            <br>
                            <small> <span class="fa fa-calendar-o"></span> <{$result.time}></small>
                        </p>

                        <{/foreach}>
                        <!-- end results item loop -->
                        <p>
                            <button class="btn btn-primary btn-sm link-style"><span class='fa fa-arrow-circle-right'></span> <{$module.showall_link}></button>
                        </p>
                    </div>
                </div>
                <{/foreach}>
                </p>
                <!-- end module search results loop -->
                <{/if}>
                <{/if}>

            </div>

            <{if $allow_videos==1}>
                <{if $featuredvideocode!="" }>
                    <div class="container-fluid">
                        <div class="row">
                            <h5><{$lang_featuredvideo}> <span class="fa fa-youtube-play"></span></h5>

                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<{$featuredvideocode}>?rel=0" allowfullscreen></iframe>
                            </div>
                            <div class="alert alert-primary">
                                <b><{$featuredvideotitle}></b><br>
                                <{$featuredvideodesc}>
                            </div>

                        </div>
                    </div>
                <{/if}>
            <{/if}>

            <{if $allow_friends==1}>
                <{if $countFriends!=0}>
                    <br>
                    <h5><{$lang_friends}> <span class="fa fa-address-card-o"></span></h5>
                    <div class="container-fluid">
                        <div class="row row-cols-4 border">
                            <{section name=i loop=$friends}>
                                <div class="col text-center p-2">
                                    <a href="<{$xoops_url}>/modules/suico/index.php?uid=<{$friends[i].uid}>" alt="<{$friends[i].uname}>" title="<{$friends[i].uname}>">
                                        <{if $friends[i].user_avatar=="avatars/blank.gif"}>
                                            <img class="suico-profile-friend-photo" src="<{$xoops_upload_url}>/avatars/blank.gif" title="<{$friends[i].uname}>" width="90" height="90">
                                        <{else}>
                                            <img class="suico-profile-friend-photo" src="<{$xoops_upload_url}>/<{$friends[i].user_avatar}>" title="<{$friends[i].uname}>" width="90" height="90">
                                        <{/if}>
                                        <br><small><{$friends[i].uname}> </small>
                                    </a>
                                </div>
                            <{/section}>
                        </div>
                        <{if $countFriends!=0}>
                            <div class="row p-2">
                                <a href="friends.php?uid=<{$uid_owner}>" class="btn btn-primary btn-sm "> <span class='fa fa-arrow-circle-right'></span> <{$lang_viewallfriends}> <span class="badge badge-pill badge-light"><{$countFriends}></span></a>
                            </div>
                        <{/if}>
                    </div>
                <{/if}>
            <{/if}>

            <{if $allow_groups==1}>
                <br>
                <{if $countGroups!=0}>
                    <br>
                    <h5><{$lang_groups}> <span class="fa fa-group"></span></h5>
                    <div class="container-fluid">
                        <div class="row row-cols-4 border">
                            <{section name=i loop=$groups}>
                                <div class="col text-center p-2">
                                    <a href="group.php?group_id=<{$groups[i].group_id}>">
                                        <img alt="<{$groups[i].title}>" title="<{$groups[i].title}>" class="suico-profile-groups-img" src="<{$xoops_upload_url}>/suico/groups/<{$groups[i].img}>" width="90">
                                        <h6><small><{$groups[i].title}></small></h6></a>
                                    <small><{$groups[i].desc}></small>
                                </div>
                            <{/section}>
                        </div>
                        <{if $countGroups!=0}>
                            <div class="row p-2">
                                <br><a href="groups.php?uid=<{$uid_owner}>" class="btn btn-primary btn-sm "><span class='fa fa-arrow-circle-right'></span> <{$lang_viewallgroups}> <span class="badge badge-pill badge-light"><{$countGroups}></span> </a>
                            </div>
                        <{/if}>
                    </div>
                <{/if}>
            <{/if}>

        </div><!-- end of group2 -->
        <{include file="db:suico_footer.tpl"}>
        <!-- end -->
    </div>
</div>
</div>
</div>
</div>
</div>
