<{section name=i loop=$block.friends}>
<div style="width:80%; text-align: center; page-break-after: always; margin: auto; page-break-before: always;"><a href="<{$xoops_url}>/modules/yogurt/index.php?uid=<{$block.friends[i].uid_voted}>" alt=" Qtty&lt;{$block.friends[i].qtd}&gt;" title=" Qtty<{$block.friends[i].qtd}>"><img src="<{$xoops_upload_url}>/<{$block.friends[i].user_avatar}>"><br>
<{$block.friends[i].uname}> </a></div><br>
<{/section}>

