<{include file="db:yogurt_navbar.tpl"}>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div id="content" class="content content-full-width">
                        <!-- start -->
                        <h5><{$smarty.const._MD_YOGURT_CHANGEMAIL}> <i class="fa fa-envelope"></i></h5><br>

                        <{includeq file="db:yogurt_form.tpl" xoForm=$emailform}>


                        <!-- end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
