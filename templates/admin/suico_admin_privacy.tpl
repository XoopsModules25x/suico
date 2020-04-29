<{if $privacyRows > 0}>
    <div class="outer">
        <form name="select" action="privacy.php?op=" method="POST"
              onsubmit="if(window.document.select.op.value =='') {return false;} else if (window.document.select.op.value =='delete') {return deleteSubmitValid('privacyId[]');} else if (isOneChecked('privacyId[]')) {return true;} else {alert('<{$smarty.const.AM_PRIVACY_SELECTED_ERROR}>'); return false;}">
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


            <table class="$privacy" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"></th>
                    <th class="left"><{$selectorid}></th>
                    <th class="left"><{$selectorlevel}></th>
                    <th class="left"><{$selectorname}></th>
                    <th class="left"><{$selectordescription}></th>

                    <th class="center width5"><{$smarty.const.AM_SUICO_FORM_ACTION}></th>
                </tr>
                <{foreach item=privacyArray from=$privacyArrays}>
                    <tr class="<{cycle values="odd,even"}>">

                        <td align="center" style="vertical-align:middle;"><input type="checkbox" name="privacy_id[]" title="privacy_id[]" id="privacy_id[]" value="<{$privacyArray.privacy_id}>"></td>
                        <td class='left'><{$privacyArray.id}></td>
                        <td class='left'><{$privacyArray.level}></td>
                        <td class='left'><{$privacyArray.name}></td>
                        <td class='left'><{$privacyArray.description}></td>


                        <td class="center width5"><{$privacyArray.edit_delete}></td>
                    </tr>
                <{/foreach}>
            </table>
            <br>
            <br>
            <{else}>
            <table width="100%" cellspacing="1" class="outer">
                <tr>

                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"></th>
                    <th class="left"><{$selectorid}></th>
                    <th class="left"><{$selectorlevel}></th>
                    <th class="left"><{$selectorname}></th>
                    <th class="left"><{$selectordescription}></th>

                    <th class="center width5"><{$smarty.const.AM_SUICO_FORM_ACTION}></th>
                </tr>
                <tr>
                    <td class="errorMsg" colspan="11">There are no $privacy</td>
                </tr>
            </table>
    </div>
    <br>
    <br>
<{/if}>
