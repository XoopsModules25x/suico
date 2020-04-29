<{if $xoops_notification.show}>
    <br>
    <br>
    <form name="notification_select" action="<{$xoops_notification.target_page}>" method="post">
        <h5 style="text-align:center;"><{$lang_activenotifications}></h5>
        <input type="hidden" name="not_redirect" value="<{$xoops_notification.redirect_script}>">
        <input type="hidden" name="XOOPS_TOKEN_REQUEST" value="<{php}>echo $GLOBALS['xoopsSecurity']->createToken();<{/php}>">
        <table class="table table-hover table-border">
            <tr>
                <th colspan="3"><{$lang_notificationoptions}></th>
            </tr>
            <tr>
                <td><{$lang_category}></td>
                <td><input name="allbox" id="allbox" type="checkbox" value="<{$lang_checkall}>"></td>
                <td><{$lang_events}></td>
            </tr>
            <{foreach name=outer item=category from=$xoops_notification.categories}>
                <{foreach name=inner item=event from=$category.events}>
                    <tr>
                        <{if $smarty.foreach.inner.first}>
                            <td rowspan="<{$smarty.foreach.inner.total}>"><{$category.title}></td>
                        <{/if}>
                        <td>
                            <{counter assign=index}>
                            <input type="hidden" name="not_list[<{$index}>][params]" value="<{$category.name}>,<{$category.itemid}>,<{$event.name}>">
                            <input type="checkbox" class="suico-notification-checkbox" id="not_list[]" name="not_list[<{$index}>][status]" value="1" <{if $event.subscribed}>checked<{/if}>>
                        </td>
                        <td><{$event.caption}></td>
                    </tr>
                <{/foreach}>
            <{/foreach}>
            <tr>
                <td class="foot" colspan="3" align="center"><input class='btn btn-info btn-sm' type="submit" name="not_submit" value="<{$lang_updatenow}>"></td>
            </tr>
        </table>
        <div align="center">
            <{$lang_notificationmethodis}>:&nbsp;<{$user_method}>&nbsp;&nbsp;[<a href="<{$editprofile_url}>"><{$lang_change}></a>]
        </div>
    </form>
<{/if}>
