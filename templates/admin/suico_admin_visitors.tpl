<{if $visitorsRows > 0}>
    <div class="outer">
        <form name="select" action="visitors.php?op=" method="POST"
              onsubmit="if(window.document.select.op.value =='') {return false;} else if (window.document.select.op.value =='delete') {return deleteSubmitValid('visitorsId[]');} else if (isOneChecked('visitorsId[]')) {return true;} else {alert('<{$smarty.const.AM_VISITORS_SELECTED_ERROR}>'); return false;}">
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


            <table class="$visitors" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"></th>
                    <th class="left"><{$selectorvisit_id}></th>
                    <th class="left"><{$selectoruid_owner}></th>
                    <th class="left"><{$selectoruid_visitor}></th>
                    <th class="left"><{$selectoruname_visitor}></th>
                    <th class="left"><{$selectordate_visited}></th>

                    <th class="center width5"><{$smarty.const.AM_SUICO_FORM_ACTION}></th>
                </tr>
                <{foreach item=visitorsArray from=$visitorsArrays}>
                    <tr class="<{cycle values="odd,even"}>">

                        <td align="center" style="vertical-align:middle;"><input type="checkbox" name="visitors_id[]" title="visitors_id[]" id="visitors_id[]" value="<{$visitorsArray.visitors_id}>"></td>
                        <td class='left'><{$visitorsArray.visit_id}></td>
                        <td class='left'><{$visitorsArray.uid_owner}></td>
                        <td class='left'><{$visitorsArray.uid_visitor}></td>
                        <td class='left'><{$visitorsArray.uname_visitor}></td>
                        <td class='left'><{$visitorsArray.date_visited}></td>


                        <td class="center width5"><{$visitorsArray.edit_delete}></td>
                    </tr>
                <{/foreach}>
            </table>
            <br>
            <br>
            <{else}>
            <table width="100%" cellspacing="1" class="outer">
                <tr>

                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"></th>
                    <th class="left"><{$selectorvisit_id}></th>
                    <th class="left"><{$selectoruid_owner}></th>
                    <th class="left"><{$selectoruid_visitor}></th>
                    <th class="left"><{$selectoruname_visitor}></th>
                    <th class="left"><{$selectordate_visited}></th>

                    <th class="center width5"><{$smarty.const.AM_SUICO_FORM_ACTION}></th>
                </tr>
                <tr>
                    <td class="errorMsg" colspan="11">There are no $visitors</td>
                </tr>
            </table>
    </div>
    <br>
    <br>
<{/if}>
