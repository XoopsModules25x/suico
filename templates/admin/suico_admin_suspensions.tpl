<{if $suspensionsRows > 0}>
    <div class="outer">
        <form name="select" action="suspensions.php?op=" method="POST"
              onsubmit="if(window.document.select.op.value =='') {return false;} else if (window.document.select.op.value =='delete') {return deleteSubmitValid('suspensionsId[]');} else if (isOneChecked('suspensionsId[]')) {return true;} else {alert('<{$smarty.const.AM_SUSPENSIONS_SELECTED_ERROR}>'); return false;}">
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


            <table class="$suspensions" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"></th>
                    <th class="left"><{$selectoruid}></th>
                    <th class="left"><{$selectorold_pass}></th>
                    <th class="left"><{$selectorold_email}></th>
                    <th class="left"><{$selectorold_signature}></th>
                    <th class="left"><{$selectorsuspension_time}></th>
                    <th class="left"><{$selectorold_enc_type}></th>
                    <th class="left"><{$selectorold_pass_expired}></th>

                    <th class="center width5"><{$smarty.const.AM_SUICO_FORM_ACTION}></th>
                </tr>
                <{foreach item=suspensionsArray from=$suspensionsArrays}>
                    <tr class="<{cycle values="odd,even"}>">

                        <td align="center" style="vertical-align:middle;"><input type="checkbox" name="suspensions_id[]" title="suspensions_id[]" id="suspensions_id[]" value="<{$suspensionsArray.suspensions_id}>"></td>
                        <td class='left'><{$suspensionsArray.uid}></td>
                        <td class='left'><{$suspensionsArray.old_pass}></td>
                        <td class='left'><{$suspensionsArray.old_email}></td>
                        <td class='left'><{$suspensionsArray.old_signature}></td>
                        <td class='left'><{$suspensionsArray.suspension_time}></td>
                        <td class='left'><{$suspensionsArray.old_enc_type}></td>
                        <td class='left'><{$suspensionsArray.old_pass_expired}></td>


                        <td class="center width5"><{$suspensionsArray.edit_delete}></td>
                    </tr>
                <{/foreach}>
            </table>
            <br>
            <br>
            <{else}>
            <table width="100%" cellspacing="1" class="outer">
                <tr>

                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"></th>
                    <th class="left"><{$selectoruid}></th>
                    <th class="left"><{$selectorold_pass}></th>
                    <th class="left"><{$selectorold_email}></th>
                    <th class="left"><{$selectorold_signature}></th>
                    <th class="left"><{$selectorsuspension_time}></th>
                    <th class="left"><{$selectorold_enc_type}></th>
                    <th class="left"><{$selectorold_pass_expired}></th>

                    <th class="center width5"><{$smarty.const.AM_SUICO_FORM_ACTION}></th>
                </tr>
                <tr>
                    <td class="errorMsg" colspan="11">There are no $suspensions</td>
                </tr>
            </table>
    </div>
    <br>
    <br>
<{/if}>
