<div class="row">
    <{section name=i loop=$block.picture}>
        <div class="col-sm-6 h-100 mb-3">
            <div class="card">
                <a href="<{$xoops_url}>/modules/suico/album.php?uid=<{$block.picture[i].uid_owner}>" alt="<{$block.picture[i].caption}>" title="<{$block.picture[i].caption}>">
                    <img class="card-img-top thumb square" src="<{$xoops_upload_url}>/suico/images/<{$block.picture[i].img_filename}>" height="120" width="120">
                </a>
                <{if $block.showtitle == 1 || $block.showcaption == 1 || $block.showowner == 1 || $block.showdate == 1}>
                    <div class="card-body">
                        <{if $block.showtitle == 1}>
                            <h6 class="card-title"><{$block.picture[i].title}></h6>
                        <{/if}>
                        <{if $block.showcaption == 1}>
                            <p class="card-text"><small><{$block.picture[i].caption}></small></p>
                        <{/if}>

                        <p class="text-muted">
                            <{if $block.showowner == 1}>
                                <small> <span class='fa fa-user-circle'></span> <a href="<{$xoops_url}>/modules/suico/album.php?uid=<{$block.picture[i].uid_owner}>"><{$block.picture[i].uname}></a></small>
                            <{/if}>
                            <{if $block.showdate == 1}>
                                <span class="fa fa-calendar"></span>
                                <{if $block.picture[i].date_created == $block.picture[i].date_updated}>
                                    <small><{$block.picture[i].date_created|date_format}></small>
                                <{else}>
                                    <small><{$block.picture[i].date_updated|date_format}></small>
                                <{/if}>
                            <{/if}>
                        </p>
                    </div>
                <{/if}>
            </div>
        </div>
    <{/section}>
</div>
