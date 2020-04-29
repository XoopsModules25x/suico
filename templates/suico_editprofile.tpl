<{include file="db:suico_navbar.tpl"}>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div id="content" class="content content-full-width">
                        <!-- start -->
                        <h5><{$smarty.const._MD_SUICO_EDITPROFILE}> <i class="fa fa-user-circle"></i></h5><br>


                        <{if $stop}>
                            <div class='errorMsg txtleft'><{$stop}></div>
                            <br class='clear'/>
                        <{/if}>

                        <{includeq file="db:suico_form.tpl" xoForm=$userinfo}>

                        <!-- end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
