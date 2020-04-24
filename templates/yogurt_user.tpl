<div class="container-fluid">
    <table class="table table-borderless table-responsive">
        <tr>
            <td>
                <p>
                <h4><{$smarty.const._MD_YOGURT_SOCIALNETWORK}></h4>
                <p><{$smarty.const._MD_YOGURT_USERWELCOME}><br>
                    <{$smarty.const._MD_YOGURT_JOINUS}></p>
            </td>
            <td>

                <div class="container-fluid">
                    <form style="margin: 0px;" action="<{$xoops_url}>/user.php" method="post">
                        <p><b><{$smarty.const._MD_YOGURT_USERLOGIN}></b>
                            <input type="hidden" name="xoops_redirect" value="/modules/yogurt/memberslist.php">
                            <input type="hidden" name="op" value="login">
                        </p>
                        <label for="profile-uname"><{$smarty.const._MD_YOGURT_USERNAME}></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                            </div>
                            <input class="form-control" type="text" name="uname" id="profile-uname" value="" placeholder="<{$smarty.const._MD_YOGURT_YOURUSERNAME}>">
                        </div>

                        <label for="profile-pass"><{$smarty.const._MD_YOGURT_PASSWORD}></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-lock" aria-hidden="true"></i></span>
                            </div>
                            <input class="form-control" type="password" name="pass" id="profile-pass" placeholder="<{$smarty.const._MD_YOGURT_YOURPASSWORD}>">
                        </div>

                        <br><input name="submit" type="submit" class="btn btn-primary" accesskey="l" tabindex="7" value="<{$smarty.const._MD_YOGURT_LOGIN}>">
                    </form>

                    <{$smarty.const._MD_YOGURT_NOTAMEMBER}> <a href="<{$xoops_url}>/register.php" target="_self"><{$smarty.const._MD_YOGURT_SIGNUP}></a><br>
                    <a href="<{$xoops_url}>/user.php#lost" target="_self"><{$smarty.const._MD_YOGURT_LOSTPASSWORD}></a>
                </div>
            </td>
        </tr>
    </table>
</div>
