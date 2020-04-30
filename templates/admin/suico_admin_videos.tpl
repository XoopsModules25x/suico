<{if $videoRows > 0}>
    <div class="outer">
        <form name="select" action="videos.php?op=" method="POST"
              onsubmit="if(window.document.select.op.value =='') {return false;} else if (window.document.select.op.value =='delete') {return deleteSubmitValid('videosId[]');} else if (isOneChecked('videosId[]')) {return true;} else {alert('<{$smarty.const.AM_VIDEOS_SELECTED_ERROR}>'); return false;}">
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


            <table class="$videos" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"></th>
                    <th class="left"><{$selectorvideo_id}></th>
                    <th class="left"><{$selectoruid_owner}></th>
                    <th class="left"><{$selectorvideo_title}></th>
                    <th class="left"><{$selectorvideo_desc}></th>
                    <th class="left"><{$selectoryoutube_code}></th>
                    <th class="center"><{$selectorfeatured_video}></th>
                    <th class="left"><{$selectordate_created}></th>
                    <th class="left"><{$selectordate_updated}></th>

                    <th class="center width5"><{$smarty.const.AM_SUICO_FORM_ACTION}></th>
                </tr>
                <{foreach item=videoArray from=$videosArray}>
                    <tr class="<{cycle values="odd,even"}>">

                        <td align="center" style="vertical-align:middle;"><input type="checkbox" name="videos_id[]" title="videos_id[]" id="videos_id[]" value="<{$videosArray.videos_id}>"></td>
                        <td class='left'><{$videoArray.video_id}></td>
                        <td class='left'><{$videoArray.uid_owner}></td>
                        <td class='left'><{$videoArray.video_title}></td>
                        <td class='left'><{$videoArray.video_desc}></td>
                        <td class='left'><{$videoArray.youtube_code}></td>
                        <td class='center'><{$videoArray.featured_video}></td>
                        <td class='left'><{$videoArray.date_created}></td>
                        <td class='left'><{$videsArray.date_updated}></td>


                        <td class="center width5"><{$videoArray.edit_delete}></td>
                    </tr>
                <{/foreach}>
            </table>
            <br>
            <br>
            <{else}>
            <table width="100%" cellspacing="1" class="outer">
                <tr>

                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"></th>
                    <th class="left"><{$selectorvideo_id}></th>
                    <th class="left"><{$selectoruid_owner}></th>
                    <th class="left"><{$selectorvideo_title}></th>
                    <th class="left"><{$selectorvideo_desc}></th>
                    <th class="left"><{$selectoryoutube_code}></th>
                    <th class="center"><{$selectorfeatured_video}></th>
                    <th class="left"><{$selectordate_created}></th>
                    <th class="left"><{$selectordate_updated}></th>

                    <th class="center width5"><{$smarty.const.AM_SUICO_FORM_ACTION}></th>
                </tr>
                <tr>
                    <td class="errorMsg" colspan="11">There are no videos</td>
                </tr>
            </table>
    </div>
    <br>
    <br>
<{/if}>
