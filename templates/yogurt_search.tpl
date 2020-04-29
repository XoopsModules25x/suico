<{include file="db:yogurt_navbar.tpl"}>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div id="content" class="content content-full-width">
                        <!-- start -->
                        <h4><{$smarty.const._MD_YOGURT_SEARCH}></h4>

                        <div>(<{$total_users}>)</div>
                        <{includeq file="db:yogurt_form.tpl" xoForm=$searchform}>

                        <!-- end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
