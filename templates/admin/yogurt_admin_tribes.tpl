<{if $tribesRows > 0}>
    <div class="outer">
        <form name="select" action="tribes.php?op=" method="POST"
              onsubmit="if(window.document.select.op.value =='') {return false;} else if (window.document.select.op.value =='delete') {return deleteSubmitValid('tribesId[]');} else if (isOneChecked('tribesId[]')) {return true;} else {alert('<{$smarty.const.AM_TRIBES_SELECTED_ERROR}>'); return false;}">
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


            <table class="$tribes" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"/></th>
                    <th class="left"><{$selectortribe_id}></th>
                    <th class="left"><{$selectorowner_uid}></th>
                    <th class="left"><{$selectortribe_title}></th>
                    <th class="left"><{$selectortribe_desc}></th>
                    <th class="left"><{$selectortribe_img}></th>

                    <th class="center width5"><{$smarty.const.AM_YOGURT_FORM_ACTION}></th>
                </tr>
                <{foreach item=tribesArray from=$tribesArrays}>
                    <tr class="<{cycle values="odd,even"}>">

                        <td align="center" style="vertical-align:middle;"><input type="checkbox" name="tribes_id[]" title="tribes_id[]" id="tribes_id[]" value="<{$tribesArray.tribes_id}>"/></td>
                        <td class='left'><{$tribesArray.tribe_id}></td>
                        <td class='left'><{$tribesArray.owner_uid}></td>
                        <td class='left'><{$tribesArray.tribe_title}></td>
                        <td class='left'><{$tribesArray.tribe_desc}></td>
                        <td class='left'><{$tribesArray.tribe_img}></td>


                        <td class="center width5"><{$tribesArray.edit_delete}></td>
                    </tr>
                <{/foreach}>
            </table>
            <br>
            <br>
            <{else}>
            <table width="100%" cellspacing="1" class="outer">
                <tr>

                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"/></th>
                    <th class="left"><{$selectortribe_id}></th>
                    <th class="left"><{$selectorowner_uid}></th>
                    <th class="left"><{$selectortribe_title}></th>
                    <th class="left"><{$selectortribe_desc}></th>
                    <th class="left"><{$selectortribe_img}></th>

                    <th class="center width5"><{$smarty.const.AM_YOGURT_FORM_ACTION}></th>
                </tr>
                <tr>
                    <td class="errorMsg" colspan="11">There are no $tribes</td>
                </tr>
            </table>
    </div>
    <br>
    <br>
<{/if}>
