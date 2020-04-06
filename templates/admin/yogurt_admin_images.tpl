<{if $imagesRows > 0}>
    <div class="outer">
        <form name="select" action="images.php?op=" method="POST"
              onsubmit="if(window.document.select.op.value =='') {return false;} else if (window.document.select.op.value =='delete') {return deleteSubmitValid('imagesId[]');} else if (isOneChecked('imagesId[]')) {return true;} else {alert('<{$smarty.const.AM_IMAGES_SELECTED_ERROR}>'); return false;}">
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


            <table class="$images" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"/></th>
                    <th class="left"><{$selectorcod_img}></th>
                    <th class="left"><{$selectortitle}></th>
                    <th class="left"><{$selectordata_creation}></th>
                    <th class="left"><{$selectordata_update}></th>
                    <th class="left"><{$selectoruid_owner}></th>
                    <th class="left"><{$selectorurl}></th>
                    <th class="center"><{$selectorprivate}></th>

                    <th class="center width5"><{$smarty.const.AM_YOGURT_FORM_ACTION}></th>
                </tr>
                <{foreach item=imagesArray from=$imagesArrays}>
                    <tr class="<{cycle values="odd,even"}>">

                        <td align="center" style="vertical-align:middle;"><input type="checkbox" name="images_id[]" title="images_id[]" id="images_id[]" value="<{$imagesArray.images_id}>"/></td>
                        <td class='left'><{$imagesArray.cod_img}></td>
                        <td class='left'><{$imagesArray.title}></td>
                        <td class='left'><{$imagesArray.data_creation}></td>
                        <td class='left'><{$imagesArray.data_update}></td>
                        <td class='left'><{$imagesArray.uid_owner}></td>
                        <td class='left'><{$imagesArray.url}></td>
                        <td class='center'><{$imagesArray.private}></td>


                        <td class="center width5"><{$imagesArray.edit_delete}></td>
                    </tr>
                <{/foreach}>
            </table>
            <br>
            <br>
            <{else}>
            <table width="100%" cellspacing="1" class="outer">
                <tr>

                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"/></th>
                    <th class="left"><{$selectorcod_img}></th>
                    <th class="left"><{$selectortitle}></th>
                    <th class="left"><{$selectordata_creation}></th>
                    <th class="left"><{$selectordata_update}></th>
                    <th class="left"><{$selectoruid_owner}></th>
                    <th class="left"><{$selectorurl}></th>
                    <th class="center"><{$selectorprivate}></th>

                    <th class="center width5"><{$smarty.const.AM_YOGURT_FORM_ACTION}></th>
                </tr>
                <tr>
                    <td class="errorMsg" colspan="11">There are no $images</td>
                </tr>
            </table>
    </div>
    <br>
    <br>
<{/if}>
