<{if $audioRows > 0}>
    <div class="outer">
        <form name="select" action="audio.php?op=" method="POST"
              onsubmit="if(window.document.select.op.value =='') {return false;} else if (window.document.select.op.value =='delete') {return deleteSubmitValid('audioId[]');} else if (isOneChecked('audioId[]')) {return true;} else {alert('<{$smarty.const.AM_AUDIO_SELECTED_ERROR}>'); return false;}">
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


            <table class="$audio" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"/></th>
                    <th class="left"><{$selectoraudio_id}></th>
                    <th class="left"><{$selectortitle}></th>
                    <th class="left"><{$selectorauthor}></th>
                    <th class="left"><{$selectorurl}></th>
                    <th class="left"><{$selectoruid_owner}></th>
                    <th class="left"><{$selectordata_creation}></th>
                    <th class="left"><{$selectordata_update}></th>

                    <th class="center width5"><{$smarty.const.AM_YOGURT_FORM_ACTION}></th>
                </tr>
                <{foreach item=audioArray from=$audioArrays}>
                    <tr class="<{cycle values="odd,even"}>">

                        <td align="center" style="vertical-align:middle;"><input type="checkbox" name="audio_id[]" title="audio_id[]" id="audio_id[]" value="<{$audioArray.audio_id}>"/></td>
                        <td class='left'><{$audioArray.audio_id}></td>
                        <td class='left'><{$audioArray.title}></td>
                        <td class='left'><{$audioArray.author}></td>
                        <td class='left'><{$audioArray.url}></td>
                        <td class='left'><{$audioArray.uid_owner}></td>
                        <td class='left'><{$audioArray.data_creation}></td>
                        <td class='left'><{$audioArray.data_update}></td>


                        <td class="center width5"><{$audioArray.edit_delete}></td>
                    </tr>
                <{/foreach}>
            </table>
            <br>
            <br>
            <{else}>
            <table width="100%" cellspacing="1" class="outer">
                <tr>

                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"/></th>
                    <th class="left"><{$selectoraudio_id}></th>
                    <th class="left"><{$selectortitle}></th>
                    <th class="left"><{$selectorauthor}></th>
                    <th class="left"><{$selectorurl}></th>
                    <th class="left"><{$selectoruid_owner}></th>
                    <th class="left"><{$selectordata_creation}></th>
                    <th class="left"><{$selectordata_update}></th>

                    <th class="center width5"><{$smarty.const.AM_YOGURT_FORM_ACTION}></th>
                </tr>
                <tr>
                    <td class="errorMsg" colspan="11">There are no $audio</td>
                </tr>
            </table>
    </div>
    <br>
    <br>
<{/if}>
