<{if $groupsRows > 0}>
    <div class="outer">
        <form name="select" action="groups.php?op=" method="POST"
              onsubmit="if(window.document.select.op.value =='') {return false;} else if (window.document.select.op.value =='delete') {return deleteSubmitValid('groupsId[]');} else if (isOneChecked('groupsId[]')) {return true;} else {alert('<{$smarty.const.AM_GROUPS_SELECTED_ERROR}>'); return false;}">
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


            <table class="$groups" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"></th>
                    <th class="left"><{$selectorgroup_id}></th>
                    <th class="left"><{$selectorowner_uid}></th>
                    <th class="left"><{$selectorgroup_title}></th>
                    <th class="left"><{$selectorgroup_desc}></th>
                    <th class="center"><{$selectorgroup_img}></th>
                    <th class="left"><{$selectordate_created}></th>
                    <th class="left"><{$selectordate_updated}></th>

                    <th class="center width5"><{$smarty.const.AM_SUICO_FORM_ACTION}></th>
                </tr>
                <{foreach item=groupsArray from=$groupsArrays}>
                    <tr class="<{cycle values="odd,even"}>">

                        <td align="center" style="vertical-align:middle;"><input type="checkbox" name="groups_id[]" title="groups_id[]" id="groups_id[]" value="<{$groupsArray.groups_id}>"></td>
                        <td class='left'><{$groupsArray.group_id}></td>
                        <td class='left'><{$groupsArray.owner_uid}></td>
                        <td class='left'><{$groupsArray.group_title}></td>
                        <td class='left'><{$groupsArray.group_desc}></td>
                        <td class='center'><{$groupsArray.group_img}></td>
                        <td class='left'><{$groupsArray.date_created}></td>
                        <td class='left'><{$groupsArray.date_updated}></td>


                        <td class="center width5"><{$groupsArray.edit_delete}></td>
                    </tr>
                <{/foreach}>
            </table>
            <br>
            <br>
            <{else}>
            <table width="100%" cellspacing="1" class="outer">
                <tr>

                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"></th>
                    <th class="left"><{$selectorgroup_id}></th>
                    <th class="left"><{$selectorowner_uid}></th>
                    <th class="left"><{$selectorgroup_title}></th>
                    <th class="left"><{$selectorgroup_desc}></th>
                    <th class="center"><{$selectorgroup_img}></th>
                    <th class="left"><{$selectordate_created}></th>
                    <th class="left"><{$selectordate_updated}></th>

                    <th class="center width5"><{$smarty.const.AM_SUICO_FORM_ACTION}></th>
                </tr>
                <tr>
                    <td class="errorMsg" colspan="11">There are no $groups</td>
                </tr>
            </table>
    </div>
    <br>
    <br>
<{/if}>
