<{if $configsRows > 0}>
    <div class="outer">
        <form name="select" action="configs.php?op=" method="POST"
              onsubmit="if(window.document.select.op.value =='') {return false;} else if (window.document.select.op.value =='delete') {return deleteSubmitValid('configsId[]');} else if (isOneChecked('configsId[]')) {return true;} else {alert('<{$smarty.const.AM_CONFIGS_SELECTED_ERROR}>'); return false;}">
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


            <table class="$configs" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"></th>
                    <th class="left"><{$selectorconfig_id}></th>
                    <th class="left"><{$selectorconfig_uid}></th>
                    <th class="center"><{$selectorpictures}></th>
                    <th class="center"><{$selectoraudio}></th>
                    <th class="center"><{$selectorvideos}></th>
                    <th class="center"><{$selectorgroups}></th>
                    <th class="center"><{$selectornotes}></th>
                    <th class="center"><{$selectorfriends}></th>
                    <th class="center"><{$selectorprofile_contact}></th>
                    <th class="center"><{$selectorprofile_general}></th>
                    <th class="center"><{$selectorprofile_stats}></th>
                    <th class="center"><{$selectorsuspension}></th>
                    <th class="left"><{$selectorbackup_password}></th>
                    <th class="left"><{$selectorbackup_email}></th>
                    <th class="left"><{$selectorend_suspension}></th>

                    <th class="center width5"><{$smarty.const.AM_SUICO_FORM_ACTION}></th>
                </tr>
                <{foreach item=configsArray from=$configsArrays}>
                    <tr class="<{cycle values="odd,even"}>">

                        <td align="center" style="vertical-align:middle;"><input type="checkbox" name="configs_id[]" title="configs_id[]" id="configs_id[]" value="<{$configsArray.configs_id}>"></td>
                        <td class='left'><{$configsArray.config_id}></td>
                        <td class='left'><{$configsArray.config_uid}></td>
                        <td class='center'><{$configsArray.pictures}></td>
                        <td class='center'><{$configsArray.audio}></td>
                        <td class='center'><{$configsArray.videos}></td>
                        <td class='center'><{$configsArray.groups}></td>
                        <td class='center'><{$configsArray.notes}></td>
                        <td class='center'><{$configsArray.friends}></td>
                        <td class='center'><{$configsArray.profile_contact}></td>
                        <td class='center'><{$configsArray.profile_general}></td>
                        <td class='center'><{$configsArray.profile_stats}></td>
                        <td class='center'><{$configsArray.suspension}></td>
                        <td class='left'><{$configsArray.backup_password}></td>
                        <td class='left'><{$configsArray.backup_email}></td>
                        <td class='left'><{$configsArray.end_suspension}></td>


                        <td class="center width5"><{$configsArray.edit_delete}></td>
                    </tr>
                <{/foreach}>
            </table>
            <br>
            <br>
            <{else}>
            <table width="100%" cellspacing="1" class="outer">
                <tr>

                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"></th>
                    <th class="left"><{$selectorconfig_id}></th>
                    <th class="left"><{$selectorconfig_uid}></th>
                    <th class="center"><{$selectorpictures}></th>
                    <th class="center"><{$selectoraudio}></th>
                    <th class="center"><{$selectorvideos}></th>
                    <th class="center"><{$selectorgroups}></th>
                    <th class="center"><{$selectornotes}></th>
                    <th class="center"><{$selectorfriends}></th>
                    <th class="center"><{$selectorprofile_contact}></th>
                    <th class="center"><{$selectorprofile_general}></th>
                    <th class="center"><{$selectorprofile_stats}></th>
                    <th class="center"><{$selectorsuspension}></th>
                    <th class="left"><{$selectorbackup_password}></th>
                    <th class="left"><{$selectorbackup_email}></th>
                    <th class="left"><{$selectorend_suspension}></th>

                    <th class="center width5"><{$smarty.const.AM_SUICO_FORM_ACTION}></th>
                </tr>
                <tr>
                    <td class="errorMsg" colspan="11">There are no $configs</td>
                </tr>
            </table>
    </div>
    <br>
    <br>
<{/if}>
