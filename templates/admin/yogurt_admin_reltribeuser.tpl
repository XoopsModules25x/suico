<{if $reltribeuserRows > 0}>
    <div class="outer">
        <form name="select" action="reltribeuser.php?op=" method="POST"
              onsubmit="if(window.document.select.op.value =='') {return false;} else if (window.document.select.op.value =='delete') {return deleteSubmitValid('reltribeuserId[]');} else if (isOneChecked('reltribeuserId[]')) {return true;} else {alert('<{$smarty.const.AM_RELTRIBEUSER_SELECTED_ERROR}>'); return false;}">
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


            <table class="$reltribeuser" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"/></th>
                    <th class="left"><{$selectorrel_id}></th>
                    <th class="left"><{$selectorrel_tribe_id}></th>
                    <th class="left"><{$selectorrel_user_uid}></th>

                    <th class="center width5"><{$smarty.const.AM_YOGURT_FORM_ACTION}></th>
                </tr>
                <{foreach item=reltribeuserArray from=$reltribeuserArrays}>
                    <tr class="<{cycle values="odd,even"}>">

                        <td align="center" style="vertical-align:middle;"><input type="checkbox" name="reltribeuser_id[]" title="reltribeuser_id[]" id="reltribeuser_id[]" value="<{$reltribeuserArray.reltribeuser_id}>"/></td>
                        <td class='left'><{$reltribeuserArray.rel_id}></td>
                        <td class='left'><{$reltribeuserArray.rel_tribe_id}></td>
                        <td class='left'><{$reltribeuserArray.rel_user_uid}></td>


                        <td class="center width5"><{$reltribeuserArray.edit_delete}></td>
                    </tr>
                <{/foreach}>
            </table>
            <br>
            <br>
            <{else}>
            <table width="100%" cellspacing="1" class="outer">
                <tr>

                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"/></th>
                    <th class="left"><{$selectorrel_id}></th>
                    <th class="left"><{$selectorrel_tribe_id}></th>
                    <th class="left"><{$selectorrel_user_uid}></th>

                    <th class="center width5"><{$smarty.const.AM_YOGURT_FORM_ACTION}></th>
                </tr>
                <tr>
                    <td class="errorMsg" colspan="11">There are no $reltribeuser</td>
                </tr>
            </table>
    </div>
    <br>
    <br>
<{/if}>
