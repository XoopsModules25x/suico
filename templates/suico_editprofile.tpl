<{include file="db:suico_navbar.tpl"}>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div id="content" class="content content-full-width">
                        <!-- start -->
                        <h5><{$smarty.const._MD_SUICO_EDITPROFILE}> <span class="fa fa-user-circle"></span></h5><br>


                        <{if $stop|default:false}>
                            <div class='errorMsg txtleft'><{$stop}></div>
                            <br class='clear'>
                        <{/if}>

                        <{includeq file="db:suico_form.tpl" xoForm=$userinfo}>

                        <!-- end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
