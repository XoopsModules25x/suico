<{include file='db:suico_navbar.tpl'}>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div id="content" class="content content-full-width">
                        <!-- start -->
                        <{if $isAnonym!=1 && $isOwner==1}>
                            <form action="submitConfigs.php" method="POST" id="form_configs" name="form_configs">
                                <h5><{$lang_whocan}></h5>
                                <{if $allow_pictures!=-1}>
                                    <div class="alert alert-primary">
                                        <h5><{$lang_configpictures}></h5>

                                        <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="pic" id="pic0" value="1" <{if $pic==1}>checked<{/if}>><label for="pic0"><{$lang_everyone}></label></label></div>
                                        <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="pic" id="pic1" value="2" <{if $pic==2}>checked<{/if}>><label for="pic1"><{$lang_only_users}></label></label></div>
                                        <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="pic" id="pic2" value="3" <{if $pic==3}>checked<{/if}>> <label for="pic2"><{$lang_only_friends}></label></label></div>
                                        <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="pic" id="pic3" value="4" <{if $pic==4}>checked<{/if}>> <label for="pic3"><{$lang_only_me}></label></label></div>

                                    </div>
                                    <br>
                                <{/if}>

                                <{if $allow_videos!=-1}>
                                    <div class="alert alert-primary">
                                        <h5><{$lang_configvideos}></h5>

                                        <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="vid" id="vid0" value="1" <{if $vid==1}>checked<{/if}>> <label for="vid0"><{$lang_everyone}></label></label></div>
                                        <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="vid" id="vid1" value="2" <{if $vid==2}>checked<{/if}>><label for="vid1"><{$lang_only_users}></label></label></div>
                                        <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="vid" id="vid2" value="3" <{if $vid==3}>checked<{/if}>><label for="vid2"><{$lang_only_friends}></label></label></div>
                                        <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="vid" id="vid3" value="4" <{if $vid==4}>checked<{/if}>><label for="vid3"><{$lang_only_me}></label></label></div>

                                    </div>
                                    <br>
                                <{/if}>

                                <{if $allow_groups!=-1}>
                                    <div class="alert alert-primary">
                                        <h5><{$lang_configgroups}></h5>

                                        <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="groups" id="groups0" value="1" <{if $tri==1}>checked<{/if}>><label for="groups0"><{$lang_everyone}></label></label></div>
                                        <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="groups" id="groups1" value="2" <{if $tri==2}>checked<{/if}>> <label for="groups1"><{$lang_only_users}></label></label></div>
                                        <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="groups" id="groups2" value="3" <{if $tri==3}>checked<{/if}>> <label for="groups2"><{$lang_only_friends}></label></label></div>
                                        <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="groups" id="groups3" value="4" <{if $tri==4}>checked<{/if}>> <label for="groups3"><{$lang_only_me}></label></label></div>

                                    </div>
                                    <br>
                                <{/if}>

                                <{if $allow_notes!=-1}>
                                    <div class="alert alert-primary">
                                        <h5><{$lang_confignotes}></h5>

                                        <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="notes" id="notes0" value="1" <{if $scr==1}>checked<{/if}>> <label for="notes0"><{$lang_everyone}></label></label></div>
                                        <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="notes" id="notes1" value="2" <{if $scr==2}>checked<{/if}>> <label for="notes1"><{$lang_only_users}></label></label></div>
                                        <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="notes" id="notes2" value="3" <{if $scr==3}>checked<{/if}>> <label for="notes2"><{$lang_only_friends}></label></label></div>
                                        <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="notes" id="notes3" value="4" <{if $scr==4}>checked<{/if}>> <label for="notes3"><{$lang_only_me}></label></label></div>

                                    </div>
                                    <br>
                                    <{*<div class="alert alert-primary">*}>
                                    <{*<h5><{$lang_configsendNotes}></h5>*}>

                                    <{*<div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="sendNotes" id="sendNotes0" value="0" <{if $sscr==0}>checked<{/if}>>  <label for="sendNotes0"><{$lang_everyone}></label></label></div>*}>
                                    <{*<div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="sendNotes" id="sendNotes1" value="1" <{if $sscr==1}>checked<{/if}>>  <label for="sendNotes1"><{$lang_only_users}></label></label></div>*}>
                                    <{*<div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="sendNotes" id="sendNotes2" value="2" <{if $sscr==2}>checked<{/if}>>  <label for="sendNotes2"><{$lang_only_friends}></label></label></div>*}>
                                    <{*<div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="sendNotes" id="sendNotes3" value="3" <{if $sscr==3}>checked<{/if}>>  <label for="sendNotes3"><{$lang_only_me}></label></label></div>*}>

                                    <{*</div><br>*}>

                                <{/if}>

                                <{if $allow_friends!=-1}>
                                    <div class="alert alert-primary">
                                        <h5><{$lang_configfriends}></h5>

                                        <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="friends" id="friends0" value="1" <{if $fri==1}>checked<{/if}>><label for="friends0"><{$lang_everyone}></label></label></div>
                                        <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="friends" id="friends1" value="2" <{if $fri==2}>checked<{/if}>><label for="friends1"><{$lang_only_users}></label></label></div>
                                        <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="friends" id="friends2" value="3" <{if $fri==3}>checked<{/if}>><label for="friends2"><{$lang_only_friends}></label></label></div>
                                        <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="friends" id="friends3" value="4" <{if $fri==4}>checked<{/if}>><label for="friends3"><{$lang_only_me}></label></label></div>

                                    </div>
                                    <br>
                                <{/if}>

                                <div class="alert alert-primary">
                                    <h5><{$lang_configprofilecontact}></h5>

                                    <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="profileContact" id="contact0" value="1" <{if $pcon==1}>checked<{/if}>> <label for="contact0"><{$lang_everyone}></label></label></div>
                                    <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="profileContact" id="contact1" value="2" <{if $pcon==2}>checked<{/if}>> <label for="contact1"><{$lang_only_users}></label></label></div>
                                    <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="profileContact" id="contact2" value="3" <{if $pcon==3}>checked<{/if}>> <label for="contact2"><{$lang_only_friends}></label></label></div>
                                    <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="profileContact" id="contact3" value="4" <{if $pcon==4}>checked<{/if}>> <label for="contact3"><{$lang_only_me}></label></label></div>
                                </div>
                                <br>
                                <div class="alert alert-primary">
                                    <h5><{$lang_configprofilegeneral}></h5>

                                    <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="gen" id="gen0" value="1" <{if $pgen==1}>checked<{/if}>> <label for="gen0"><{$lang_everyone}></label></label></div>
                                    <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="gen" id="gen1" value="2" <{if $pgen==2}>checked<{/if}>> <label for="gen1"><{$lang_only_users}></label></label></div>
                                    <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="gen" id="gen2" value="3" <{if $pgen==3}>checked<{/if}>> <label for="gen2"><{$lang_only_friends}></label></label></div>
                                    <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="gen" id="gen3" value="4" <{if $pgen==4}>checked<{/if}>> <label for="gen3"><{$lang_only_me}></label></label></div>

                                </div>
                                <br>
                                <div class="alert alert-primary">
                                    <h5><{$lang_configprofilestats}></h5>
                                    <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="stat" id="stat0" value="1" <{if $psta==1}>checked<{/if}>> <label for="stat0"><{$lang_everyone}></label></label></div>
                                    <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="stat" id="stat1" value="2" <{if $psta==2}>checked<{/if}>> <label for="stat1"><{$lang_only_users}></label></label></div>
                                    <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="stat" id="stat2" value="3" <{if $psta==3}>checked<{/if}>> <label for="stat2"><{$lang_only_friends}></label></label></div>
                                    <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="stat" id="stat3" value="4" <{if $psta==4}>checked<{/if}>> <label for="stat3"><{$lang_only_me}></label></label></div>
                                </div>

                                <br>
                                <{if $allow_audios!=-1}>
                                    <div class="alert alert-primary">
                                        <h5><{$lang_configaudio}></h5>
                                        <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="aud" id="aud0" value="1" <{if $aud==1}>checked<{/if}>> <label for="aud0"><{$lang_everyone}></label></label></div>
                                        <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="aud" id="aud1" value="2" <{if $aud==2}>checked<{/if}>> <label for="aud1"><{$lang_only_users}></label></label></div>
                                        <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="aud" id="aud2" value="3" <{if $aud==3}>checked<{/if}>> <label for="aud2"><{$lang_only_friends}></label></label></div>
                                        <div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="aud" id="aud3" value="4" <{if $aud==4}>checked<{/if}>> <label for="aud3"><{$lang_only_me}></label></label></div>

                                    </div>
                                    <br>
                                <{/if}>
                                <input type="submit" name="button" id="button" class='btn btn-primary'>
                                <{$token}>
                            </form>
                        <{/if}>

                        <{include file="db:suico_footer.tpl"}>
                        <!-- end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
