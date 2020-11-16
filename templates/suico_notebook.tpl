<{include file='db:suico_navbar.tpl'}>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div id="content" class="content content-full-width">
                        <!-- start -->

                        <{if $isAnonym!=1 }>
                            <div class="alert alert-primary">
                                <form name="formNoteNew" id="formNoteNew" action="submitNote.php" method="post">
                                    <h5>
                                        <{$lang_submit}>
                                    </h5>

                                    <div class="form-group">
                                        <label for="text"><{$smarty.const._MD_SUICO_SENDNOTESTO}> <{$owner_uname}></label>
                                        <input type='hidden' name='uid' id='uid' value='<{$uid_owner}>'>
                                        <input type='hidden' name='mainform' id='mainform' value='1'>
                                        <{$token}>
                                        <textarea class="form-control" rows="5" cols="50" name='text' id='text'><{$lang_entertext}></textarea>
                                    </div>

                                    <input type='submit' class='formButton btn btn-primary' name='post_Note' id='post_Note' value='<{$lang_submit}>'>
                                    <a href="#" name='show_tips' id='show_tips' value='Notetips'><{$lang_tips}></a>
                                </form>
                                <div id="xtips" name="xtips" style="width:500px;height:50px;" action="">
                                    [b]<{$lang_bold}>[/b] => <b><{$lang_bold}></b> | [i]<{$lang_italic}>[/i] => </i><{$lang_italic}></span> | [u]<{$lang_underline}>[/u] => <u><{$lang_underline}></u>
                                </div>
                            </div>
                        <{/if}>

                        <h5>
                            <{$section_name}>
                        </h5>

                        <{if $lang_noNotesyet|default:''=="" }>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title"><{$smarty.const._MD_SUICO_RECENTNOTES}></h4>
                                        <h6 class="card-subtitle"><{$smarty.const._MD_SUICO_LATESTNOTES}></h6>
                                    </div>
                                    <{section name=i loop=$notes}>
                                    <div class="comment-widgets m-b-20">
                                        <div class="d-flex flex-row comment-row">
                                            <div class="p-2">
                                                <{if $notes[i].user_avatar!="" && $notes[i].user_avatar!="blank.gif" }>
                                                    <img src="<{$xoops_url}>/uploads/<{$notes[i].user_avatar}>" class="rounded-circle" height="60" width="60" alt="" title="<{$notes[i].uname}>">
                                                <{else}>
                                                    <img src="<{$xoops_url}>/uploads/avatars/blank.gif" class="rounded-circle" height="60" width="60" alt="" title="<{$notes[i].uname}>">
                                                <{/if}>
                                            </div>
                                            <{if $uid_owner==$notes[i].uid}>
                                            <div class="comment-text w-100 alert alert-primary">
                                                <{else}>
                                                <div class="comment-text w-100 ">
                                                    <{/if}>
                                                    <h5><a name="<{$notes[i].id}>" href="index.php?uid=<{$notes[i].uid}>"><{$notes[i].uname}></a></h5>
                                                    <div class="comment-footer"><span class="date_created text-muted"> <span class="fa fa-calendar"></span> <{$notes[i].date_created|date_format}></span>


                                                        <p class="m-b-5 m-t-10"> &nbsp;<{$notes[i].text}></p>
                                                        <{if $isOwner==1}>

                                                        <form name="delete_note" method="post" action="delete_note.php" class="suico-Note-form-delete">
                                                            <button type="image" id="note_idimage" name="note_idimage" class="btn btn-primary btn-xs">Delete</button>
                                                            <input value="<{$notes[i].id}>" type="hidden" id="note_id" name="note_id">
                                                        </form>
                                                        <{/if}>


                                                    </div>
                                                </div>
                                            </div>


<{*                                            <div class="suico-Note-details-texts">*}>
<{*                                                <p class="suico-Note-text"><img src="assets/images/notes.gif" alt="<{$section_name}>" title="<{$section_name}>">*}>
<{*                                                    &nbsp;<{$notes[i].text}><br>&nbsp;<small><{$notes[i].date_created}></small>*}>
<{*                                                    <a name="replyform<{$notes[i].id}>" id="replyform<{$notes[i].id}>"></a>*}>
<{*                                                </p>*}>
<{*                                                <{if $isOwner==1}>*}>
<{*                                                    <div class="suico-Note-details-form">*}>
<{*                                                        <form action="submitNote.php" method="post" name="form_reply_<{$notes[i].id}>"*}>
<{*                                                              id="form_reply_<{$notes[i].id}>" class="suico-Note-form">*}>
<{*                                                            <input type="hidden" value="<{$notes[i].uid}>" name="uid" id="uid">*}>
<{*                                                            <textarea name="text" id="text" cols="50"></textarea>*}>
<{*                                                            <{$token}>*}>
<{*                                                            <div>*}>
<{*                                                                <input type="submit" name="submit" value="<{$lang_answerNote}>"><input type="reset" name="reset"*}>
<{*                                                                                                                                       value="<{$lang_cancel}>" class="resetNote">*}>
<{*                                                            </div>*}>
<{*                                                        </form>*}>
<{*                                                    </div>*}>
<{*                                                <{/if}>*}>
<{*                                            </div>*}>

<{*                                            <{if $isOwner==1}>*}>
<{*                                            <div><a class="suico-Notes-replyNote">*}>
<{*                                                    <{$lang_answerNote}>*}>
<{*                                                </a></div>*}>
<{*                                            <{/if}>*}>

                                        </div>
                                        <{/section}>

                                    </div>
                                </div>
                            </div>
                            <{else}>
                            <div class="alert alert-primary"><{$lang_noNotesyet}>  </div>
                            <{/if}>

                            <div>
                                <{$pageNav|default:''}>
                            </div>


                            <{include file='db:suico_footer.tpl'}>


                            <!-- end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
