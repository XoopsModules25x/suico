<{if $audioRows > 0}>
    <div class="outer">
        <form name="select" action="audios.php?op=" method="POST"
              onsubmit="if(window.document.select.op.value =='') {return false;} else if (window.document.select.op.value =='delete') {return deleteSubmitValid('audiosId[]');} else if (isOneChecked('audiosId[]')) {return true;} else {alert('<{$smarty.const.AM_AUDIOS_SELECTED_ERROR}>'); return false;}">
            <input type="hidden" name="confirm" value="1">
            <div class="floatleft">
                <select name="op">
                    <option value=""><{$smarty.const.AM_SUICO_SELECT}></option>
                    <option value="delete"><{$smarty.const.AM_SUICO_SELECTED_DELETE}></option>
                </select>
                <input id="submitUp" class="formButton" type="submit" name="submitselect" value="<{$smarty.const._SUBMIT}>" title="<{$smarty.const._SUBMIT}>">
            </div>
            <div class="floatcenter0">
                <div id="pagenav"><{$pagenav}></div>
            </div>


            <table class="$audios" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"></th>
                    <th class="left"><{$selectoraudio_id}></th>
                    <th class="left"><{$selectoruid_owner}></th>
                    <th class="left"><{$selectorauthor}></th>
                    <th class="left"><{$selectortitle}></th>
                    <th class="left"><{$selectordescription}></th>
                    <th class="left"><{$selectorfilename}></th>
                    <th class="left"><{$selectordate_created}></th>
                    <th class="left"><{$selectordate_updated}></th>

                    <th class="center width5"><{$smarty.const.AM_SUICO_FORM_ACTION}></th>
                </tr>
                <{foreach item=audiosArray from=$audiosArrays}>
                    <tr class="<{cycle values="odd,even"}>">

                        <td align="center" style="vertical-align:middle;"><input type="checkbox" name="audios_id[]" title="audios_id[]" id="audios_id[]" value="<{$audiosArray.audios_id}>"></td>
                        <td class='left'><{$audiosArray.audio_id}></td>
                        <td class='left'><{$audiosArray.uid_owner}></td>
                        <td class='left'><{$audiosArray.author}></td>
                        <td class='left'><{$audiosArray.title}></td>
                        <td class='left'><{$audiosArray.description}></td>
                        <td class='left'><{$audiosArray.filename}></td>
                        <td class='left'><{$audiosArray.date_created}></td>
                        <td class='left'><{$audiosArray.date_updated}></td>


                        <td class="center width5"><{$audiosArray.edit_delete}></td>
                    </tr>
                <{/foreach}>
            </table>
            <br>
            <br>
            <{else}>
            <table width="100%" cellspacing="1" class="outer">
                <tr>

                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"></th>
                    <th class="left"><{$selectoraudio_id}></th>
                    <th class="left"><{$selectoruid_owner}></th>
                    <th class="left"><{$selectorauthor}></th>
                    <th class="left"><{$selectortitle}></th>
                    <th class="left"><{$selectordescription}></th>
                    <th class="left"><{$selectorfilename}></th>
                    <th class="left"><{$selectordate_created}></th>
                    <th class="left"><{$selectordate_updated}></th>

                    <th class="center width5"><{$smarty.const.AM_SUICO_FORM_ACTION}></th>
                </tr>
                <tr>
                    <td class="errorMsg" colspan="11">There are no audios</td>
                </tr>
            </table>
    </div>
    <br>
    <br>
<{/if}>
