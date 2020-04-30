<div class="container-fluid">
    <div class="row row-cols-4">
        <{section name=i loop=$block}>
            <div class="col text-center p-2">
                <a href="<{$xoops_url}>/modules/suico/album.php?uid=<{$block[i].uid_voted}>" alt="<{$block[i].caption}>" title="<{$block[i].caption}>">
                    <div class="square">
                    <img src="<{$xoops_upload_url}>/suico/images/<{$block[i].img_filename}>" width="120" height="120">
                    </div>
                    <br> <small> <i class='fa fa-user-circle'></i> <{$block[i].uname}></small>
                </a>
            </div>
        <{/section}>
    </div>
</div>

