<{section name=i loop=$block}>
    <div style="width:80%; text-align: center; page-break-after: always; margin: auto; page-break-before: always;">
        <a href="<{$xoops_url}>/modules/yogurt/album.php?uid=<{$block[i].uid_voted}>" alt="<{$block[i].caption}>" title="<{$block[i].caption}>"><img src="<{$xoops_upload_url}>/yogurt/images/thumb_<{$block[i].img_filename}>"><br><{$block[i].uname}> </a>

    </div>
<{/section}>


