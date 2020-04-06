<{if $friendshipRows > 0}>
    <div class="outer">
        <form name="select" action="friendship.php?op=" method="POST"
              onsubmit="if(window.document.select.op.value =='') {return false;} else if (window.document.select.op.value =='delete') {return deleteSubmitValid('friendshipId[]');} else if (isOneChecked('friendshipId[]')) {return true;} else {alert('<{$smarty.const.AM_FRIENDSHIP_SELECTED_ERROR}>'); return false;}">
            <input type="hidden" name="confirm" value="1"/>
            <div class="floatleft">
                <select name="op">
                    <option value=""><{$smarty.const.AM_YOGURT_SELECT}></option>
                    <option value="delete"><{$smarty.const.AM_YOGURT_SELECTED_DELETE}></option>
                </select>
                <input id="submitUp" class="formButton" type="submit" name="submitselect" value="<{$smarty.const._SUBMIT}>" title="<{$smarty.const._SUBMIT}>"/>
            </div>
            <div class="floatcenter0">
                <div id="pagenav"><{$pagenav}></div>
            </div>


            <table class="$friendship" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"/></th>
                    <th class="left"><{$selectorfriendship_id}></th>
                    <th class="left"><{$selectorfriend1_uid}></th>
                    <th class="left"><{$selectorfriend2_uid}></th>
                    <th class="center"><{$selectorlevel}></th>
                    <th class="center"><{$selectorhot}></th>
                    <th class="center"><{$selectortrust}></th>
                    <th class="center"><{$selectorcool}></th>
                    <th class="center"><{$selectorfan}></th>

                    <th class="center width5"><{$smarty.const.AM_YOGURT_FORM_ACTION}></th>
                </tr>
                <{foreach item=friendshipArray from=$friendshipArrays}>
                    <tr class="<{cycle values="odd,even"}>">

                        <td align="center" style="vertical-align:middle;"><input type="checkbox" name="friendship_id[]" title="friendship_id[]" id="friendship_id[]" value="<{$friendshipArray.friendship_id}>"/></td>
                        <td class='left'><{$friendshipArray.friendship_id}></td>
                        <td class='left'><{$friendshipArray.friend1_uid}></td>
                        <td class='left'><{$friendshipArray.friend2_uid}></td>
                        <td class='center'><{$friendshipArray.level}></td>
                        <td class='center'><{$friendshipArray.hot}></td>
                        <td class='center'><{$friendshipArray.trust}></td>
                        <td class='center'><{$friendshipArray.cool}></td>
                        <td class='center'><{$friendshipArray.fan}></td>


                        <td class="center width5"><{$friendshipArray.edit_delete}></td>
                    </tr>
                <{/foreach}>
            </table>
            <br>
            <br>
            <{else}>
            <table width="100%" cellspacing="1" class="outer">
                <tr>

                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"/></th>
                    <th class="left"><{$selectorfriendship_id}></th>
                    <th class="left"><{$selectorfriend1_uid}></th>
                    <th class="left"><{$selectorfriend2_uid}></th>
                    <th class="center"><{$selectorlevel}></th>
                    <th class="center"><{$selectorhot}></th>
                    <th class="center"><{$selectortrust}></th>
                    <th class="center"><{$selectorcool}></th>
                    <th class="center"><{$selectorfan}></th>

                    <th class="center width5"><{$smarty.const.AM_YOGURT_FORM_ACTION}></th>
                </tr>
                <tr>
                    <td class="errorMsg" colspan="11">There are no $friendship</td>
                </tr>
            </table>
    </div>
    <br>
    <br>
<{/if}>
