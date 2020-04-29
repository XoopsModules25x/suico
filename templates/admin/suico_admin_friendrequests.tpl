<{if $friendrequestRows > 0}>
    <div class="outer">
        <form name="select" action="friendrequests.php?op=" method="POST"
              onsubmit="if(window.document.select.op.value =='') {return false;} else if (window.document.select.op.value =='delete') {return deleteSubmitValid('friendrequestsId[]');} else if (isOneChecked('friendrequestsId[]')) {return true;} else {alert('<{$smarty.const.AM_FRIENDREQUESTS_SELECTED_ERROR}>'); return false;}">
            <input type="hidden" name="confirm" value="1">
            <div class="floatleft">
                <label>
                    <select name="op">
                        <option value=""><{$smarty.const.AM_SUICO_SELECT}></option>
                        <option value="delete"><{$smarty.const.AM_SUICO_SELECTED_DELETE}></option>
                    </select>
                </label>
                <input id="submitUp" class="formButton" type="submit" name="submitselect" value="<{$smarty.const._SUBMIT}>" title="<{$smarty.const._SUBMIT}>">
            </div>
            <div class="floatcenter0">
                <div id="pagenav"><{$pagenav}></div>
            </div>

            <table class="$friendrequests" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"></th>
                    <th class="left"><{$selectorfriendreq_id}></th>
                    <th class="left"><{$selectorfriendrequester_uid}></th>
                    <th class="left"><{$selectorfriendrequestto_uid}></th>
                    <th class="left"><{$selectordate_created}></th>

                    <th class="center width5"><{$smarty.const.AM_SUICO_FORM_ACTION}></th>
                </tr>
                <{foreach item=friendrequestArray from=$friendrequestsArray}>
                    <tr class="<{cycle values="odd,even"}>">

                        <td align="center" style="vertical-align:middle;"><input type="checkbox" name="friendrequests_id[]" title="friendrequests_id[]" id="friendrequests_id[]" value="<{$friendrequestArray.friendrequests_id}>"></td>
                        <td class='left'><{$friendrequestArray.friendreq_id}></td>
                        <td class='left'><{$friendrequestArray.friendrequester_uid}></td>
                        <td class='left'><{$friendrequestArray.friendrequestto_uid}></td>
                        <td class='left'><{$friendrequestArray.date_created}></td>
                        <td class="center width5"><{$friendrequestArray.edit_delete}></td>
                    </tr>
                <{/foreach}>
            </table>
            <br>
            <br>
            <{else}>
            <table width="100%" cellspacing="1" class="outer">
                <tr>
                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"></th>
                    <th class="left"><{$selectorfriendreq_id}></th>
                    <th class="left"><{$selectorfriendrequester_uid}></th>
                    <th class="left"><{$selectorfriendrequestto_uid}></th>
                    <th class="left"><{$selectordate_created}></th>

                    <th class="center width5"><{$smarty.const.AM_SUICO_FORM_ACTION}></th>
                </tr>
                <tr>
                    <td class="errorMsg" colspan="11">There are no friendrequests</td>
                </tr>
            </table>
    </div>
    <br>
    <br>
<{/if}>
