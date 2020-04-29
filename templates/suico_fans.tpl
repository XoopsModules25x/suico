<{include file='db:suico_navbar.tpl'}>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div id="content" class="content content-full-width">
                        <!-- start -->

                        <div id="suico-friends-container">
                            <h5><{$lang_fanstitle}></h5>
                            <{if $lang_nofansyet==""}>

                                <{section name=i loop=$friends}>
                                    <div class="suico-friend <{cycle values="odd,even"}>">
                                        <p><a href="<{$xoops_url}>/modules/suico/index.php?uid=<{$friends[i].uid}>" alt=" <{$friends[i].uname}>" title="<{$friends[i].uname}>"> <{if $friends[i].user_avatar=="avatars/blank.gif" }>
                                                    <img src="assets/images/noavatar.gif">
                                                <{else}>
                                                    <imgsrc
                                                    ="<{$xoops_upload_url}>/<{$friends[i].user_avatar}>"><{/if}><{$friends[i].uname}></a></p>
                                        <{if $isOwner }>
                                            <form action="editfriendship.php" method="post" class="suico-friends-deleteform">
                                                <input type="hidden" name="friend_uid" id="friend_uid" value="<{$friends[i].uid}>">
                                                <input name="submit" id="submit" src="assets/images/evaluate.gif" type="image" title="<{$lang_evaluate}>" alt="<{$lang_evaluate}>">
                                            </form>
                                            <form action="delfriendship.php" method="post" class="suico-friends-evaluateform">
                                                <input type="hidden" name="friend_uid" id="friend_uid" value="<{$friends[i].uid}>">
                                                <input name="submit" id="submit" src="<{xoModuleIcons16 delete.png}>" type="image" title="<{$lang_delete}>" alt="<{$lang_delete}>">
                                            </form>
                                        <{/if}>


                                    </div>
                                <{/section}>
                            <{else}>
                                <div class="alert alert-primary"><{$lang_nofansyet}></div>
                            <{/if}>
                        </div>
                        <{if $navegacao!='' }>
                            <div><{$navegacao}></div>
                        <{/if}>

                        <{include file="db:suico_footer.tpl"}>
                        <!-- end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
