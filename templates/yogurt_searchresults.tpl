<{include file="db:yogurt_navbar.tpl"}>


<{if $total_found != 0}>
    <table class="outer" cellspacing="1" cellpadding="4">
        <tr>
            <th align="center"><{$lang_avatar}></th>
            <th align="center"><{$lang_username}></th>
            <{if $user_realname}>
				<th align="center"><{$lang_realname}></th>
			<{/if}>
			<{if $xoops_isuser && $allow_friends !=-1}>
				<th align="center"><{$lang_friendshipstatus}></th>
			<{/if}>
		</tr>
        <{section name=i loop=$users}>
            <tr valign="middle">
                <td class="even"><{$users[i].avatar}></td>
                <td class="odd"><a href="index.php?uid=<{$users[i].id}>"><{$users[i].name}></a><br><{if $is_admin === true}><{$users[i].adminlink}><{/if}></td>
                <{if $user_realname}>
				  <td class="even"><{$users[i].realname}></td>
                <{/if}>
				<{if $xoops_isuser && $allow_friends !=-1}>		
					<td class="odd">	
						<{if $users[i].isfriend!=1 && $users[i].uid != $uid_owner && $users[i].selffriendrequest!=1 && $users[i].otherfriendrequest!=1}>
							<a href="index.php?uid=<{$users[i].id}>" target="_blank" role="button" class="btn btn-info"><{$lang_addfriend}></a>
						<{/if}>			
						<{if $users[i].isfriend ==1 && $users[i].uid != $uid_owner}>
							<button type="button"><{$lang_myfriend}></button>	
						<{/if}>
						<{if $users[i].uid != $uid_owner}>
							<{if $users[i].selffriendrequest==1 && $self_uid!=0}>
								<button type="button"><{$lang_friendrequestsent}></button>	
							<{/if}>
	
							<{if $users[i].otherfriendrequest==1 && $other_uid!=0}>
								<button type="button"><{$lang_friendshippending}></button>	
							<{/if}>
						<{/if}>
					</td>	
				<{/if}>			
			</tr>
        <{/section}>
    </table>
    <div style="text-align:center">
        <{$pagenav}>
        <{$lang_numfound}>
    </div>
<{else}>
    <{$lang_nonefound}>
<{/if}>

<{include file="db:yogurt_footer.tpl"}>
