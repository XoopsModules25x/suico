<{include file="db:suico_navbar.tpl"}>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div id="content" class="content content-full-width">
                        <!-- start -->

                        <h5><{$smarty.const._MD_SUICO_CHANGEAVATAR}> <span class="fa fa-user-circle-o"></span></h5><br>
                        <div class="alert alert-primary">
                            <{if $old_avatar}>
                                <h5><{$smarty.const._US_OLDDELETED}></h5>
                                <{if $allow_pictures !=0}>
                                    <{$smarty.const._MD_SUICO_CHANGEAVATARHELP}>
                                    <br>
                                    <br>
                                <{/if}>
                                <img src="<{$old_avatar}>" alt="" class="img-fluid">
                            <{/if}>

                            <{if $uploadavatar|default:false}>
                                <{$uploadavatar.javascript}>
                                <form name="<{$uploadavatar.name}>" action="<{$uploadavatar.action}>" method="<{$uploadavatar.method}>" <{$uploadavatar.extra}>>
                                    <table class="table table-borderless">
                                        <tr>
                                            <th colspan="2"><{$uploadavatar.title}>
                                            </th>
                                        </tr>
                                        <!-- start of form elements loop -->
                                        <{foreach item=element from=$uploadavatar.elements}>
                                            <{if $element.hidden !== true}>
                                                <tr>
                                                    <td><strong><{$element.caption}></strong>
                                                        <{if $element.description}>
                                                            <div style="font-weight: normal;"><{$element.description}></div>
                                                        <{/if}>
                                                    </td>
                                                    <td class="<{cycle values='even,odd'}>"><{$element.body}></td>
                                                </tr>
                                            <{else}>
                                                <{$element.body}>
                                            <{/if}>
                                        <{/foreach}>
                                        <!-- end of form elements loop -->
                                    </table>
                                </form>
                                <br>
                            <{/if}>

                        </div>


                        <div class="alert alert-info">

                            <br>
                            <{$chooseavatar.javascript}>
                            <form name="<{$chooseavatar.name}>" action="<{$chooseavatar.action}>" method="<{$chooseavatar.method}>" <{$chooseavatar.extra}>>
                                <table class="table">
                                    <tr>
                                        <th colspan="2"><{$chooseavatar.title}></th>
                                    </tr>
                                    <!-- start of form elements loop -->
                                    <{foreach item=element from=$chooseavatar.elements}>
                                        <{if $element.hidden !== true}>
                                            <tr>
                                                <td><b><{$element.caption}></b>
                                                    <{if $element.description|default:''}>
                                                        <{$element.description}>
                                                    <{/if}>
                                                </td>
                                                <td
                                                "><{$element.body}></td>
                                            </tr>
                                        <{else}>
                                            <{$element.body}>
                                        <{/if}>
                                    <{/foreach}>
                                    <!-- end of form elements loop -->
                                </table>
                            </form>
                        </div>


                        <!-- end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
