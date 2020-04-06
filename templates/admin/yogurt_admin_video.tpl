<{if $videoRows > 0}>
    <div class="outer">
        <form name="select" action="video.php?op=" method="POST"
              onsubmit="if(window.document.select.op.value =='') {return false;} else if (window.document.select.op.value =='delete') {return deleteSubmitValid('videoId[]');} else if (isOneChecked('videoId[]')) {return true;} else {alert('<{$smarty.const.AM_VIDEO_SELECTED_ERROR}>'); return false;}">
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


            <table class="$video" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"/></th>
                    <th class="left"><{$selectorvideo_id}></th>
                    <th class="left"><{$selectoruid_owner}></th>
                    <th class="left"><{$selectorvideo_desc}></th>
                    <th class="left"><{$selectoryoutube_code}></th>
                    <th class="center"><{$selectormain_video}></th>

                    <th class="center width5"><{$smarty.const.AM_YOGURT_FORM_ACTION}></th>
                </tr>
                <{foreach item=videoArray from=$videoArrays}>
                    <tr class="<{cycle values="odd,even"}>">

                        <td align="center" style="vertical-align:middle;"><input type="checkbox" name="video_id[]" title="video_id[]" id="video_id[]" value="<{$videoArray.video_id}>"/></td>
                        <td class='left'><{$videoArray.video_id}></td>
                        <td class='left'><{$videoArray.uid_owner}></td>
                        <td class='left'><{$videoArray.video_desc}></td>
                        <td class='left'><{$videoArray.youtube_code}></td>
                        <td class='center'><{$videoArray.main_video}></td>


                        <td class="center width5"><{$videoArray.edit_delete}></td>
                    </tr>
                <{/foreach}>
            </table>
            <br>
            <br>
            <{else}>
            <table width="100%" cellspacing="1" class="outer">
                <tr>

                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"/></th>
                    <th class="left"><{$selectorvideo_id}></th>
                    <th class="left"><{$selectoruid_owner}></th>
                    <th class="left"><{$selectorvideo_desc}></th>
                    <th class="left"><{$selectoryoutube_code}></th>
                    <th class="center"><{$selectormain_video}></th>

                    <th class="center width5"><{$smarty.const.AM_YOGURT_FORM_ACTION}></th>
                </tr>
                <tr>
                    <td class="errorMsg" colspan="11">There are no $video</td>
                </tr>
            </table>
    </div>
    <br>
    <br>
<{/if}>
