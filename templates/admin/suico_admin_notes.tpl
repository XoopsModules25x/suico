<{if $notesRows > 0}>
    <div class="outer">
        <form name="select" action="notes.php?op=" method="POST"
              onsubmit="if(window.document.select.op.value =='') {return false;} else if (window.document.select.op.value =='delete') {return deleteSubmitValid('notesId[]');} else if (isOneChecked('notesId[]')) {return true;} else {alert('<{$smarty.const.AM_NOTES_SELECTED_ERROR}>'); return false;}">
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


            <table class="$notes" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"></th>
                    <th class="left"><{$selectornote_id}></th>
                    <th class="left"><{$selectornote_text}></th>
                    <th class="left"><{$selectornote_from}></th>
                    <th class="left"><{$selectornote_to}></th>
                    <th class="center"><{$selectorprivate}></th>
                    <th class="left"><{$selectordate_created}></th>
                    <th class="left"><{$selectordate_updated}></th>

                    <th class="center width5"><{$smarty.const.AM_SUICO_FORM_ACTION}></th>
                </tr>
                <{foreach item=notesArray from=$notesArrays}>
                    <tr class="<{cycle values="odd,even"}>">

                        <td align="center" style="vertical-align:middle;"><input type="checkbox" name="notes_id[]" title="notes_id[]" id="notes_id[]" value="<{$notesArray.notes_id}>"></td>
                        <td class='left'><{$notesArray.note_id}></td>
                        <td class='left'><{$notesArray.note_text}></td>
                        <td class='left'><{$notesArray.note_from}></td>
                        <td class='left'><{$notesArray.note_to}></td>
                        <td class='center'><{$notesArray.private}></td>
                        <td class='left'><{$notesArray.date_created}></td>
                        <td class='left'><{$notesArray.date_updated}></td>


                        <td class="center width5"><{$notesArray.edit_delete}></td>
                    </tr>
                <{/foreach}>
            </table>
            <br>
            <br>
            <{else}>
            <table width="100%" cellspacing="1" class="outer">
                <tr>

                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"></th>
                    <th class="left"><{$selectornote_id}></th>
                    <th class="left"><{$selectornote_text}></th>
                    <th class="left"><{$selectornote_from}></th>
                    <th class="left"><{$selectornote_to}></th>
                    <th class="center"><{$selectorprivate}></th>
                    <th class="left"><{$selectordate_created}></th>
                    <th class="left"><{$selectordate_updated}></th>

                    <th class="center width5"><{$smarty.const.AM_SUICO_FORM_ACTION}></th>
                </tr>
                <tr>
                    <td class="errorMsg" colspan="11">There are no $notes</td>
                </tr>
            </table>
    </div>
    <br>
    <br>
<{/if}>
