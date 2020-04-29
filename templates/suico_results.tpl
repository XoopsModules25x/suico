<{include file="db:suico_navbar.tpl"}>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div id="content" class="content content-full-width">
                        <!-- start -->

                        <h4><{$smarty.const._MD_SUICO_RESULTS}></h4>

                        <div>(<{$total_users}>)</div>
                        <{if $users}>
                            <table class="table table-hover table-borderless">
                                <tr>
                                    <{foreach item=caption from=$captions}>
                                        <th><{$caption}></th>
                                    <{/foreach}>
                                </tr>
                                <{foreach item=user from=$users}>
                                    <tr class="<{cycle values='odd, even'}>">
                                        <{foreach item=fieldvalue from=$user.output}>
                                            <td><{$fieldvalue}></td>
                                        <{/foreach}>
                                    </tr>
                                <{/foreach}>
                            </table>
                            <{$nav}>
                        <{else}>
                            <div class="errorMsg">
                                <{$smarty.const._PROFILE_MA_NOUSERSFOUND}>
                            </div>
                        <{/if}>

                        <!-- end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



