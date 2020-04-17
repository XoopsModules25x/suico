<{include file="db:yogurt_navbar.tpl"}>

<{$searchform.javascript}>
<h4><{$smarty.const._MD_YOGURT_SEARCH}></h4>
<{if $displaytotalmember == 1}>
    <b><{$smarty.const._MD_YOGURT_TOTALUSERS}>:</b> <{$totalmember}>
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

<{include file="db:yogurt_footer.tpl"}>
