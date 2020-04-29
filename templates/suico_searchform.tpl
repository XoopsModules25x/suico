<{include file="db:suico_navbar.tpl"}>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div id="content" class="content content-full-width">
                        <!-- start -->

                        <{$searchform.javascript}>
                        <h4><{$smarty.const._MD_SUICO_SEARCH}></h4>
                        <{if $displaytotalmember == 1}>
                            <b><{$smarty.const._MD_SUICO_TOTALUSERS}>:</b>
                            <{$totalmember}>
                        <{/if}>

                        <br><br>
                        <form name="<{$searchform.name}>" action="<{$searchform.action}>" method="<{$searchform.method}>" <{$searchform.extra}>>
                            <div>
                                <!-- start of form elements loop -->
                                <{foreach item=element from=$searchform.elements}>
                                    <{if $element.hidden !== true}>
                                        <div class="search-element">
                                            <div class="search-element-label"><label><{$element.caption}></label></div>
                                            <div class="search-element-body"><{$element.body}></div>
                                        </div>
                                    <{else}>
                                        <{$element.body}>
                                    <{/if}>
                                <{/foreach}>
                                <!-- end of form elements loop -->
                            </div>
                        </form>

                        <{include file="db:suico_footer.tpl"}>

                        <!-- end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
