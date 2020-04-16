<{include file="db:yogurt_navbar.tpl"}>


<{if $total_found != 0}>

 <{$lang_numfound}>
	<table class="table table-hover table-striped " cellspacing="1" cellpadding="4">
            <tr>
            <{if $displayavatar == 1}>  
				<th align="center"><{$lang_avatar}></th>
			<{/if}>    
			<th align="center"><{$lang_username}></th>
            <{if $displayrealname == 1}>
				<th align="center"><{$lang_realname}></th>
			<{/if}>
			<{if $xoops_isuser && $allow_friends !=-1}>
				<th align="center"><{$lang_friendshipstatus}></th>
			<{/if}>
			<{if $is_admin === true}>
				<th align="center"><{$smarty.const._MD_YOGURT_ADMIN}></th>
			<{/if}>	

		</tr>
        <{section name=i loop=$users}>
            <tr valign="middle">
              	<{if $displayavatar == 1}>  
					<td class="even"><a href="<{$xoops_url}>/userinfo.php?uid=<{$users[i].id}>"><img src='<{$xoops_url}>/uploads/<{$users[i].avatar}>' title='<{$users[i].name}>' alt='<{$users[i].name}>' style='padding:10px' width='100' height='100'></a></td>
				<{/if}>
				<td class="odd"><a href="index.php?uid=<{$users[i].id}>"><{$users[i].name}></a></td>
                <{if $displayrealname == 1}>
					<td class="even"><{$users[i].realname}></td>
                <{/if}>
				<{if $xoops_isuser && $allow_friends !=-1}>		
					<td class="odd">	
						<{if $users[i].isFriend!=1 && $users[i].uid != $uid_owner && $users[i].selffriendrequest!=1 && $users[i].otherfriendrequest!=1}>
							<a href="index.php?uid=<{$users[i].id}>" target="_blank" role="button" class="btn btn-info"><{$lang_addfriend}></a>
						<{/if}>			
						<{if $users[i].isFriend ==1 && $users[i].uid != $uid_owner}>
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
				<{if $is_admin === true}>
				<td>
					<p class="float-right"><br><{$users[i].adminlink}></p>
				<td>
				<{/if}>				
			</tr>
        <{/section}>
    </table>
    <div style="text-align:center">
        <{$pagenav}>
       
    </div>
<{else}>
    <{$lang_nonefound}>
<{/if}>

<{include file="db:yogurt_footer.tpl"}>
