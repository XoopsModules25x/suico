<div class="container-fluid">
    <table class="table table-borderless table-responsive">
        <tr>
            <td>
                <p>
                <h4><{$smarty.const._MD_SUICO_SOCIALNETWORK}></h4>
                <p><{$smarty.const._MD_SUICO_USER_WELCOME}><br>
                    <{$smarty.const._MD_SUICO_JOINUS}></p>
            </td>
            <td>

                <div class="container-fluid">
                    <form style="margin: 0px;" action="<{$xoops_url}>/user.php" method="post">
                        <p><b><{$smarty.const._MD_SUICO_USER_LOGIN}></b>
                            <input type="hidden" name="xoops_redirect" value="/modules/suico/memberslist.php">
                            <input type="hidden" name="op" value="login">
                        </p>
                        <label for="profile-uname"><{$smarty.const._MD_SUICO_USER_NAME}></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><span class="fa fa-user" aria-hidden="true"></span></span>
                            </div>
                            <input class="form-control" type="text" name="uname" id="profile-uname" value="" placeholder="<{$smarty.const._MD_SUICO_YOURUSERNAME}>">
                        </div>

                        <label for="profile-pass"><{$smarty.const._MD_SUICO_PASSWORD}></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><span class="fa fa-lock" aria-hidden="true"></span></span>
                            </div>
                            <input class="form-control" type="password" name="pass" id="profile-pass" placeholder="<{$smarty.const._MD_SUICO_YOURPASSWORD}>">
                        </div>

                        <br><input name="submit" type="submit" class="btn btn-primary" accesskey="l" tabindex="7" value="<{$smarty.const._MD_SUICO_LOGIN}>">
                    </form>

                    <{$smarty.const._MD_SUICO_NOTAMEMBER}> <a href="<{$xoops_url}>/modules/suico/user.php?op=register" target="_self"><{$smarty.const._MD_SUICO_SIGNUP}></a><br>
                    <a href="<{$xoops_url}>/user.php#lost" target="_self"><{$smarty.const._MD_SUICO_LOSTPASSWORD}></a>
                </div>
            </td>
        </tr>
    </table>
</div>
