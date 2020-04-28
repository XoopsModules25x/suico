<{$xoForm.javascript}>
<form id="<{$xoForm.name}>" name="<{$xoForm.name}>" action="<{$xoForm.action}>" method="<{$xoForm.method}>" <{$xoForm.extra}> >
    <div class="alert alert-primary">
	<table class="table table-hover table-borderless">
        <{foreach item=element from=$xoForm.elements}>
            <{if !$element.hidden}>
                <tr>
                    <td class="head">
                        <div class='xoops-form-element-caption<{if $element.required}>-required<{/if}>'>
                            <span class='caption-text'><b><{$element.caption}></b></span>
                            <span class='caption-marker'>*</span>
                        </div>
                        <{if $element.description != ""}>
                            <div class='xoops-form-element-help'><{$element.description}></div>
                        <{/if}>
                    </td>
                    <td class="<{cycle values='odd, even'}>">
                        <{$element.body}>
                    </td>
                </tr>
            <{/if}>
        <{/foreach}>
    </table>
	</div>
    <{foreach item=element from=$xoForm.elements}>
        <{if $element.hidden}>
            <{$element.body}>
        <{/if}>
    <{/foreach}>
</form>
