<{if $friendpetitionRows > 0}>
    <div class="outer">
        <form name="select" action="friendpetition.php?op=" method="POST"
              onsubmit="if(window.document.select.op.value =='') {return false;} else if (window.document.select.op.value =='delete') {return deleteSubmitValid('friendpetitionId[]');} else if (isOneChecked('friendpetitionId[]')) {return true;} else {alert('<{$smarty.const.AM_FRIENDPETITION_SELECTED_ERROR}>'); return false;}">
            <input type="hidden" name="confirm" value="1"/>
            <div class="floatleft">
                <label>
                    <select name="op">
                        <option value=""><{$smarty.const.AM_YOGURT_SELECT}></option>
                        <option value="delete"><{$smarty.const.AM_YOGURT_SELECTED_DELETE}></option>
                    </select>
                </label>
                <input id="submitUp" class="formButton" type="submit" name="submitselect" value="<{$smarty.const._SUBMIT}>" title="<{$smarty.const._SUBMIT}>"/>
            </div>
            <div class="floatcenter0">
                <div id="pagenav"><{$pagenav}></div>
            </div>


            <table class="$friendpetition" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"/></th>
                    <th class="left"><{$selectorfriendpet_id}></th>
                    <th class="left"><{$selectorpetitioner_uid}></th>
                    <th class="left"><{$selectorpetitionto_uid}></th>

                    <th class="center width5"><{$smarty.const.AM_YOGURT_FORM_ACTION}></th>
                </tr>
                <{foreach item=friendpetitionArray from=$friendpetitionArrays}>
                    <tr class="<{cycle values="odd,even"}>">

                        <td align="center" style="vertical-align:middle;"><input type="checkbox" name="friendpetition_id[]" title="friendpetition_id[]" id="friendpetition_id[]" value="<{$friendpetitionArray.friendpetition_id}>"/></td>
                        <td class='left'><{$friendpetitionArray.friendpet_id}></td>
                        <td class='left'><{$friendpetitionArray.petitioner_uid}></td>
                        <td class='left'><{$friendpetitionArray.petitionto_uid}></td>


                        <td class="center width5"><{$friendpetitionArray.edit_delete}></td>
                    </tr>
                <{/foreach}>
            </table>
            <br>
            <br>
            <{else}>
            <table width="100%" cellspacing="1" class="outer">
                <tr>

                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"/></th>
                    <th class="left"><{$selectorfriendpet_id}></th>
                    <th class="left"><{$selectorpetitioner_uid}></th>
                    <th class="left"><{$selectorpetitionto_uid}></th>

                    <th class="center width5"><{$smarty.const.AM_YOGURT_FORM_ACTION}></th>
                </tr>
                <tr>
                    <td class="errorMsg" colspan="11">There are no $friendpetition</td>
                </tr>
            </table>
    </div>
    <br>
    <br>
<{/if}>
