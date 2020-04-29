<{if $friendshipRows > 0}>
    <div class="outer">
        <form name="select" action="friendships.php?op=" method="POST"
              onsubmit="if(window.document.select.op.value =='') {return false;} else if (window.document.select.op.value =='delete') {return deleteSubmitValid('friendshipsId[]');} else if (isOneChecked('friendshipsId[]')) {return true;} else {alert('<{$smarty.const.AM_FRIENDSHIPS_SELECTED_ERROR}>'); return false;}">
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


            <table class="$friendships" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"></th>
                    <th class="left"><{$selectorfriendship_id}></th>
                    <th class="left"><{$selectorfriend1_uid}></th>
                    <th class="left"><{$selectorfriend2_uid}></th>
                    <th class="center"><{$selectorlevel}></th>
                    <th class="center"><{$selectorhot}></th>
                    <th class="center"><{$selectortrust}></th>
                    <th class="center"><{$selectorcool}></th>
                    <th class="center"><{$selectorfan}></th>
                    <th class="left"><{$selectordate_created}></th>
                    <th class="left"><{$selectordate_updated}></th>

                    <th class="center width5"><{$smarty.const.AM_SUICO_FORM_ACTION}></th>
                </tr>
                <{foreach item=friendshipArray from=$friendshipsArray}>
                    <tr class="<{cycle values="odd,even"}>">

                        <td align="center" style="vertical-align:middle;"><input type="checkbox" name="friendships_id[]" title="friendships_id[]" id="friendships_id[]" value="<{$friendshipArray.friendships_id}>"></td>
                        <td class='left'><{$friendshipArray.friendship_id}></td>
                        <td class='left'><{$friendshipArray.friend1_uid}></td>
                        <td class='left'><{$friendshipArray.friend2_uid}></td>
                        <td class='center'><{$friendshipArray.level}></td>
                        <td class='center'><{$friendshipArray.hot}></td>
                        <td class='center'><{$friendshipArray.trust}></td>
                        <td class='center'><{$friendshipArray.cool}></td>
                        <td class='center'><{$friendshipArray.fan}></td>
                        <td class='left'><{$friendshipArray.date_created}></td>
                        <td class='left'><{$friendshipArray.date_updated}></td>


                        <td class="center width5"><{$friendshipArray.edit_delete}></td>
                    </tr>
                <{/foreach}>
            </table>
            <br>
            <br>
            <{else}>
            <table width="100%" cellspacing="1" class="outer">
                <tr>

                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"></th>
                    <th class="left"><{$selectorfriendship_id}></th>
                    <th class="left"><{$selectorfriend1_uid}></th>
                    <th class="left"><{$selectorfriend2_uid}></th>
                    <th class="center"><{$selectorlevel}></th>
                    <th class="center"><{$selectorhot}></th>
                    <th class="center"><{$selectortrust}></th>
                    <th class="center"><{$selectorcool}></th>
                    <th class="center"><{$selectorfan}></th>
                    <th class="left"><{$selectordate_created}></th>
                    <th class="left"><{$selectordate_updated}></th>

                    <th class="center width5"><{$smarty.const.AM_SUICO_FORM_ACTION}></th>
                </tr>
                <tr>
                    <td class="errorMsg" colspan="11">There are no friendships</td>
                </tr>
            </table>
    </div>
    <br>
    <br>
<{/if}>
