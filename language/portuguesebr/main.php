<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * @copyright    XOOPS Project https://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author       Marcello Brandão aka  Suico
 * @author       XOOPS Development Team
 * @since
 */
/**
 * Translation for Portuguese users
 *
 * @Module     : yogurt
 * @Dependences: FrameWork 1.22
 * @Version    : 3.2
 * @Release    Date:
 * @Author     : Marcelo Brandão
 * @Language   : Portuguesebr
 * @Translators: GibaPhp /
 * @Revision   :
 * @Support    : http://br.impresscms.org - Team Brazilian.
 * @Licence    : GNU
 */

//Present in many files (videos pictures etc...)
define('_MD_YOGURT_DELETE', 'Apagar');
define('_MD_YOGURT_EDITDESC', 'Alterar descrição');
define('_MD_YOGURT_TOKENEXPIRED', 'Sua senha expirou<br> Tente novamente');
define('_MD_YOGURT_DESC_EDITED', 'A descrição da foto foi alterada com sucesso');
define('_MD_YOGURT_CAPTION', 'Subtítulo');
define('_MD_YOGURT_YOUCANUPLOAD', 'Você pode submeter apenas arquivos jpg com até %s KBytes');
define('_MD_YOGURT_UPLOADPICTURE', 'Upload Foto');
define(
    '_MD_YOGURT_NOCACHACA',
    'Desculpe sem cachaça para você<br>
Infelizmente, este módulo agiu de forma inesperada. Esperemos que ele volte ao seu estado normal quando você tentar novamente. '
); // Funny geral mensagem de erro
define('_MD_YOGURT_PAGETITLE', '%s - Álbum do %s');
define('_MD_YOGURT_SUBMIT', 'Enviar');
define('_MD_YOGURT_VIDEOS', 'Videos');
define('_MD_YOGURT_NOTEBOOK', 'Notes');
define('_MD_YOGURT_PHOTOS', 'Fotos'); //GibaPhp
define('_MD_YOGURT_FRIENDS', 'Amigos'); //GibaPhp
define('_MD_YOGURT_GROUPS', 'Tribos'); //GibaPhp
define('_MD_YOGURT_NOGROUPSYET', 'Nenhuma Tribo ainda'); //GibaPhp
define('_MD_YOGURT_MYGROUPS', 'Minhas Tribos'); //GibaPhp
define('_MD_YOGURT_ALLGROUPS', 'Todas as Tribos'); //GibaPhp
define('_MD_YOGURT_PROFILE', 'Perfil'); //GibaPhp
define('_MD_YOGURT_HOME', 'Principal'); //GibaPhp
define('_MD_YOGURT_CONFIGSTITLE', 'Minhas Preferências'); //GibaPhp

##################################################### PICTURES #######################################################
//submit.php (for pictures submission
define('_MD_YOGURT_UPLOADED', 'Upload Realizado com sucesso');

//delpicture.php
define('_MD_YOGURT_ASKCONFIRMDELETION', 'Quer mesmo apagar está foto?');
define('_MD_YOGURT_CONFIRMDELETION', 'Sim, apague!');

//album.php
define('_MD_YOGURT_YOUHAVE', 'Você tem %s foto(s) em seu álbum.');
define('_MD_YOGURT_YOUCANHAVE', 'Você pode ter até %s foto(s).');
define('_MD_YOGURT_DELETED', 'Foto apagada com sucesso');
define('_MD_YOGURT_SUBMIT_PIC_TITLE', 'Enviar uma foto para seu Álbum');
define('_MD_YOGURT_SELECT_PHOTO', 'Selecione a foto');
define('_MD_YOGURT_NOTHINGYET', 'Ainda não há nenhuma foto neste álbum');
define('_MD_YOGURT_AVATARCHANGE', 'Deixar esta foto como meu avatar');
define('_MD_YOGURT_PRIVATIZE', 'Apenas você verá esta foto no seu álbum');
define('_MD_YOGURT_UNPRIVATIZE', 'Todos poderão ver está foto em seu álbum');
define('_MD_YOGURT_MYPHOTOS', 'Minhas Fotos'); //GibaPhp

//avatar.php
define('_MD_YOGURT_AVATAR_EDITED', 'Você mudou seu avatar!');

//private.php
define('_MD_YOGURT_PRIVATIZED', 'Agora somente você poderá ver esta foto em seu álbum');
define('_MD_YOGURT_UNPRIVATIZED', 'Agora todos poderão ver esta foto em seu álbum');

########################################################## FRIENDS ###################################################
//friends.php
define('_MD_YOGURT_FRIENDSTITLE', 'Amigos do %s');
define('_MD_YOGURT_NOFRIENDSYET', 'Nenhum Amigo ainda'); //also present in index.php - GibaPhp
define('_MD_YOGURT_MYFRIENDS', 'Meus Amigos'); //GibaPhp
define('_MD_YOGURT_FRIENDSHIPCONFIGS', 'Defina as configurações desta amizade. Avalie seu amigo.'); //GibaPhp

//class/yogurtfriendship.php
define('_MD_YOGURT_EDITFRIENDSHIP', 'Sua amizade com este membro:'); //GibaPhp
define('_MD_YOGURT_FRIENDNAME', 'Usuário'); //GibaPhp
define('_MD_YOGURT_LEVEL', 'Grau de amizade:'); //GibaPhp
define('_MD_YOGURT_UNKNOWNACCEPTED', 'Não conheço mas aceito'); //GibaPhp
define('_MD_YOGURT_AQUAITANCE', 'Conhecidos'); //also present in index.php - GibaPhp
define('_MD_YOGURT_FRIEND', 'Amigo'); //also present in index.php - GibaPhp
define('_MD_YOGURT_BESTFRIEND', 'Melhor Amigo'); //also present in index.php - GibaPhp
define('_MD_YOGURT_FAN', 'Fan'); //also present in index.php - GibaPhp
define('_MD_YOGURT_FRIENDLY', 'Friendly'); //also present in index.php - GibaPhp
define('_MD_YOGURT_FRIENDLYNO', 'Nope'); //GibaPhp - ??? Dúvida no conteúdo...
define('_MD_YOGURT_FRIENDLYYES', 'Sim'); //GibaPhp
define('_MD_YOGURT_FRIENDLYALOT', 'Muito!'); //GibaPhp
define('_MD_YOGURT_FUNNY', 'Confiável'); //GibaPhp
define('_MD_YOGURT_FUNNYNO', 'Nope'); //GibaPhp ??? Dúvida no conteúdo...
define('_MD_YOGURT_FUNNYYES', 'Sim'); //GibaPhp
define('_MD_YOGURT_FUNNYALOT', 'Muito'); //GibaPhp
define('_MD_YOGURT_COOL', 'Legal'); //GibaPhp
define('_MD_YOGURT_COOLNO', 'Nope'); //GibaPhp ??? Dúvida no conteúdo...
define('_MD_YOGURT_COOLYES', 'Sim'); //GibaPhp
define('_MD_YOGURT_COOLALOT', 'Muito'); //GibaPhp
define('_MD_YOGURT_PHOTO', 'Foto(s) de Amigos'); //GibaPhp
define('_MD_YOGURT_UPDATEFRIEND', 'Atualizar Amigo(s)'); //GibaPhp

//editfriendship.php
define('_MD_YOGURT_FRIENDSHIPUPDATED', 'Atualizou Amizade(s)'); //GibaPhp

//submitfriendpetition.php
define('_MD_YOGURT_PETITIONED', 'Um pedido de amizade foi enviado para este usuário. Espere até que ele aceite para aparecer em sua lista de amigos.'); //GibaPhp
define('_MD_YOGURT_ALREADY_PETITIONED', 'Você já enviou um pedido de amizade para este usuário ou vice-versa. <br> Espere até que ele aceite ou rejeite, ou consultando a página de perfil de amigos deste usuário em questão como um visitante.'); //GibaPhp

//makefriends.php
define('_MD_YOGURT_FRIENDMADE', 'Adicionado como amigo!'); //GibaPhp

//delfriendship.php
define('_MD_YOGURT_FRIENDSHIPTERMINATED', 'Você terminou a sua amizade com este usuário!'); //GibaPhp

############################################ VIDEOS ############################################################
//mainvideo.php
define('_MD_YOGURT_SETMAINVIDEO', 'This video is selected on your front page from now on'); //GibaPhp

//video.php
define('_MD_YOGURT_YOUTUBECODE', 'Código do YouTube ou URL'); //GibaPhp
define('_MD_YOGURT_ADDVIDEO', 'Incluir video'); //GibaPhp
define('_MD_YOGURT_ADDFAVORITEVIDEOS', 'Adicione seus vídeos favoritos'); //GibaPhp
define(
    '_MD_YOGURT_ADDVIDEOSHELP',
    'Se você quizer fazer upload do seu vídeo para compartilhar, poderá enviar os seus vídeos para
<a href=http://www.youtube.com>YouTube</a> e, em seguida, adicione a URL aqui '
); //The name of the site will show after this - GibaPhp
define('_MD_YOGURT_MYVIDEOS', 'Meus Videos'); //GibaPhp
define('_MD_YOGURT_MAKEMAIN', 'Fazer deste vídeo o Principal no seu Perfil'); //GibaPhp
define('_MD_YOGURT_NOVIDEOSYET', 'Nenhum video ainda!'); //GibaPhp

//delvideo.php
define('_MD_YOGURT_ASKCONFIRMVIDEODELETION', 'Tem certeza de que deseja excluir este vídeo?'); //GibaPhp
define('_MD_YOGURT_CONFIRMVIDEODELETION', 'Sim eu Tenho!'); //GibaPhp
define('_MD_YOGURT_VIDEODELETED', 'Seu video foi apagado'); //GibaPhp

//video_submited.php
define('_MD_YOGURT_VIDEOSAVED', 'Seu video foi gravado'); //GibaPhp

############################## GROUPS ########################################################
//class/Groups.php
define('_MD_YOGURT_SUBMIT_GROUP', 'Criar uma nova Tribo'); //GibaPhp
define('_MD_YOGURT_UPLOADGROUP', 'Salvar Tribo'); //also present in many ther groups related - GibaPhp
define('_MD_YOGURT_GROUP_IMAGE', 'Imagem da Tribo'); //also present in many ther groups related - GibaPhp
define('_MD_YOGURT_GROUP_TITLE', 'Título'); //also present in many ther groups related - GibaPhp
define('_MD_YOGURT_GROUP_DESC', 'Descrição'); //also present in many ther groups related - GibaPhp
define('_MD_YOGURTCREATEYOURGROUP', 'Crie a sua própria Tribo!'); //also present in many ther groups related - GibaPhp

//abandongroup.php
define('_MD_YOGURT_ASKCONFIRMABANDONGROUP', 'Tem certeza de que deseja sair desta Tribo?'); //GibaPhp
define('_MD_YOGURT_CONFIRMABANDON', 'Sim, remova-me desta Tribo!'); //GibaPhp
define('_MD_YOGURT_GROUPABANDONED', 'Você não pertence mais a esta Tribo.'); //GibaPhp

//becomemembergroup.php
define('_MD_YOGURT_YOUAREMEMBERNOW', 'Você agora é um membro desta comunidade'); //GibaPhp
define('_MD_YOGURT_YOUAREMEMBERALREADY', 'Você já é um membro desta Tribo'); //GibaPhp

//delete_group.php
define('_MD_YOGURT_ASKCONFIRMGROUPDELETION', 'Tem certeza que deseja apagar esta Tribo de forma permanente?'); //GibaPhp
define('_MD_YOGURT_CONFIRMGROUPDELETION', 'Sim, apague essa Tribo!'); //GibaPhp
define('_MD_YOGURT_GROUPDELETED', 'Tribo apagada!'); //GibaPhp

//edit_group.php
define('_MD_YOGURT_MAINTAINOLDIMAGE', 'Manter esta imagem'); //also present in other groups related - GibaPhp
define('_MD_YOGURT_GROUPEDITED', 'Tribo editada'); //GibaPhp
define('_MD_YOGURT_EDIT_GROUP', 'Editar sua Tribo'); //also present in other groups related - GibaPhp
define('_MD_YOGURT_GROUPOWNER', 'Você é o dono deste Tribo!'); //also present in other groups related - GibaPhp
define('_MD_YOGURT_MEMBERSDOFGROUP', 'Os membros desta Tribo'); //also present in other groups related - GibaPhp

//submit_group.php
define('_MD_YOGURT_GROUP_CREATED', 'Sua Tribo foi criada'); //GibaPhp

//kickfromgroup.php
define('_MD_YOGURT_CONFIRMKICK', 'Sim kick-lo para fora!'); //GibaPhp - Tenho dúvida aqui...
define('_MD_YOGURT_ASKCONFIRMKICKFROMGROUP', 'Tem certeza que deseja dar um kick nesta pessoa para fora desta Tribo?'); //GibaPhp
define('_MD_YOGURT_GROUPKICKED', 'Você se afastou deste usuário da Tribo, mas quem sabe quando ele vai poderá tentar um novo regresso!'); //GibaPhp - Tenho dúvidas aqui...

//Groups.php
define('_MD_YOGURT_GROUP_ABANDON', 'Deixar esta Tribo'); //GibaPhp
define('_MD_YOGURT_GROUP_JOIN', 'Participe desta Tribo e mostre a todos quem você é!'); //GibaPhp
define('_MD_YOGURT_GROUP_SEARCH', 'Procurar uma Tribo'); //GibaPhp
define('_MD_YOGURT_GROUP_SEARCHKEYWORD', 'Palavra-chave'); //GibaPhp

######################################### NOTES #####################################################
//notebook.php
define('_MD_YOGURT_ENTERTEXTNOTE', 'Digite o texto ou códigos Especiais'); //GibaPhp
define('_MD_YOGURT_SENDNOTE', 'Enviar Note'); //GibaPhp
define('_MD_YOGURT_ANSWERNOTE', 'Responder'); //also present in configs.php - GibaPhp
define('_MD_YOGURT_MYNOTEBOOK', 'Meu Notebook'); //GibaPhp
define('_MD_YOGURT_CANCEL', 'Cancelar'); //also present in configs.php - GibaPhp
define('_MD_YOGURT_NOTETIPS', 'Dicas de Note'); //GibaPhp
define('_MD_YOGURT_BOLD', 'Negrito'); //GibaPhp
define('_MD_YOGURT_ITALIC', 'itálico'); //GibaPhp
define('_MD_YOGURT_UNDERLINE', 'Sublinhar'); //GibaPhp
define('_MD_YOGURT_NONOTESYET', 'Nenhum Recado foi criado ainda neste Note'); //GibaPhp

//submitNote.php
define('_MD_YOGURT_NOTE_SENT', 'Obrigado pela sua participação, Note enviado'); //GibaPhp

//delete_Note.php
define('_MD_YOGURT_ASKCONFIRMNOTEDELETION', 'Tem certeza que deseja apagar este Note?'); //GibaPhp
define('_MD_YOGURT_CONFIRMNOTEDELETION', 'Sim, pode apagar este Note.'); //GibaPhp
define('_MD_YOGURT_NOTEDELETED', 'O Note foi apagado'); //GibaPhp

############################ CONFIGS ##############################################
//configs.php
define('_MD_YOGURT_CONFIGSEVERYONE', 'Todos'); //GibaPhp
define('_MD_YOGURT_CONFIGSONLYEUSERS', 'Somente usuário registrado'); //GibaPhp
define('_MD_YOGURT_CONFIGSONLYEFRIENDS', 'Meus Amigos.'); //GibaPhp
define('_MD_YOGURT_CONFIGSONLYME', 'Somente Eu'); //GibaPhp
define('_MD_YOGURT_CONFIGSPICTURES', 'Ver suas Fotos'); //GibaPhp
define('_MD_YOGURT_CONFIGSVIDEOS', 'Ver seus Videos'); //GibaPhp
define('_MD_YOGURT_CONFIGSGROUPS', 'Ver suas Tribos'); //GibaPhp
define('_MD_YOGURT_CONFIGSNOTES', 'Ver seus Notes'); //GibaPhp
define('_MD_YOGURT_CONFIGSNOTESSEND', 'Envie você Notes'); //GibaPhp - Tenho dúvida aqui...
define('_MD_YOGURT_CONFIGSFRIENDS', 'Ver seus Amigos'); //GibaPhp
define('_MD_YOGURT_CONFIGSPROFILECONTACT', 'Ver seu Email'); //GibaPhp
define('_MD_YOGURT_CONFIGSPROFILEGENERAL', 'Ver suas Informações'); //GibaPhp
define('_MD_YOGURT_CONFIGSPROFILESTATS', 'Ver suas estatísticas'); //GibaPhp
define('_MD_YOGURT_WHOCAN', 'Quem pode:'); //GibaPhp

//submit_configs.php
define('_MD_YOGURT_CONFIGSSAVE', 'Configuração Salva!'); //GibaPhp

//class/yogurt_controller.php
define(
    '_MD_YOGURT_NOPRIVILEGE',
    'O proprietário deste perfil alterou os privilégios para vê-lo, <br> e ficou superior em relação ao que você tem agora. <br>Faça o Login para tornar-se seu amigo. <br>Se eles não confirmaram ainda as permissões, talvez seja este o motivo que só eles possam ver. <br>Após ajustado isto, você será capaz de vê-lo.'
); //GibaPhp - Tenho grande dúvida aqui.

###################################### OTHERS ##############################

//index.php
define('_MD_YOGURT_VISITORS', 'Visitantes');
define('_MD_YOGURT_USERDETAILS', 'Detalhes do Usuário'); //GibaPhp
define('_MD_YOGURT_USERCONTRIBUTIONS', 'Contribuições deste Usuário'); //GibaPhp
define('_MD_YOGURT_FANS', 'Fans'); //GibaPhp
define('_MD_YOGURT_UNKNOWNREJECTING', 'Eu não conheço essa pessoa, por isto não irei adiciona-lo à minha lista de amigos'); //GibaPhp
define('_MD_YOGURT_UNKNOWNACCEPTING', 'Eu não conheço essa pessoa, Porém vou adicioná-la à minha lista de amigos'); //GibaPhp
define('_MD_YOGURT_ASKINGFRIEND', 'É %s seu Amigo?'); //GibaPhp
define('_MD_YOGURT_ASKBEFRIEND', 'Pergunte a este usuário se deseja ser seu amigo?'); //GibaPhp
define('_MD_YOGURT_EDITPROFILE', 'Editar seu Perfil'); //GibaPhp
define('_MD_YOGURT_SELECTAVATAR', 'Upload de fotos para a capa do álbum e poderá selecionar um como sendo o seu avatar.'); //GibaPhp
define('_MD_YOGURT_SELECTMAINVIDEO', 'Adicione um vídeo para o seu álbum, em seguida, selecione-o como sendo o seu Vídeo principal'); //GibaPhp
define('_MD_YOGURT_NOAVATARYET', 'Nenhum avatar ainda'); //GibaPhp
define('_MD_YOGURT_NOMAINVIDEOYET', 'Nenhum Vídeo principal ainda'); //GibaPhp
define('_MD_YOGURT_MYPROFILE', 'Meu Perfil'); //GibaPhp
define('_MD_YOGURT_YOUHAVEXPETITIONS', 'Você tem %u pedidos de amizade(s).'); //GibaPhp
define('_MD_YOGURT_CONTACTINFO', 'Informações de Contato'); //GibaPhp
define('_MD_YOGURT_SUSPENDUSER', 'Suspender usuário'); //GibaPhp
define('_MD_YOGURT_SUSPENDTIME', 'Tempo de suspensão(em segundos)'); //GibaPhp
define('_MD_YOGURT_UNSUSPEND', 'Liberar Usuário'); //GibaPhp
define('_MD_YOGURT_SUSPENSIONADMIN', 'Ferramenta para Administrar Suspensão'); //GibaPhp

//suspend.php
define('_MD_YOGURT_SUSPENDED', 'Usuário está suspenso até %s'); //GibaPhp
define('_MD_YOGURT_USERSUSPENDED', 'Usuário suspenso!'); //als0 present in index.php -GibaPhp

//unsuspend.php
define('_MD_YOGURT_USERUNSUSPENDED', 'Usuário Liberado'); //GibaPhp

//searchmembers.php
define('_MD_YOGURT_SEARCH', 'Procurar Usuários'); //GibaPhp
define('_MD_YOGURT_AVATAR', 'Avatar');
define('_MD_YOGURT_REALNAME', 'Nome Real'); //GibaPhp
define('_MD_YOGURT_REGDATE', 'Data de Registro'); //GibaPhp
define('_MD_YOGURT_EMAIL', 'Email');
define('_MD_YOGURT_PM', 'MP'); //GibaPhp
define('_MD_YOGURT_URL', 'URL'); //GibaPhp
define('_MD_YOGURT_ADMIN', 'ADMIN');
define('_MD_YOGURT_PREVIOUS', 'Anterior'); //GibaPhp
define('_MD_YOGURT_NEXT', 'Próxima'); //GibaPhp
define('_MD_YOGURT_USERSFOUND', '%s usuário(s) localizado(s)'); //GibaPhp
define('_MD_YOGURT_TOTALUSERS', 'Total: %s usuários'); //GibaPhp
define('_MD_YOGURT_NOFOUND', 'Nenhum usuário Encontrado'); //GibaPhp
define('_MD_YOGURT_UNAME', 'Nome do Usuário'); //GibaPhp
define('_MD_YOGURT_ICQ', 'ICQ'); //GibaPhp
define('_MD_YOGURT_AIM', 'AIM'); //GibaPhp
define('_MD_YOGURT_YIM', 'YIM'); //GibaPhp
define('_MD_YOGURT_MSNM', 'MSNM'); //GibaPhp
define('_MD_YOGURT_LOCATION', 'Localização contém'); //GibaPhp
define('_MD_YOGURT_OCCUPATION', 'Ocupação contém'); //GibaPhp
define('_MD_YOGURT_INTEREST', 'Interesses contém'); //GibaPhp
define('_MD_YOGURT_URLC', 'URL contém'); //GibaPhp
define('_MD_YOGURT_LASTLOGMORE', "Última visita há mais de <span style='color:#ff0000;'>X</span> dias"); //GibaPhp
define('_MD_YOGURT_LASTLOGLESS', "Última visita há menos de <span style='color:#ff0000;'>X</span> dias"); //GibaPhp
define('_MD_YOGURT_REGMORE', "Usuário há mais de <span style='color:#ff0000;'>X</span> dias"); //GibaPhp
define('_MD_YOGURT_REGLESS', "Usuário há menos de <span style='color:#ff0000;'>X</span> dias"); //GibaPhp
define('_MD_YOGURT_POSTSMORE', "Número de mensagens acima de <span style='color:#ff0000;'>X</span>"); //GibaPhp
define('_MD_YOGURT_POSTSLESS', "Número de mensagens abaixo de <span style='color:#ff0000;'>X</span>"); //GibaPhp
define('_MD_YOGURT_SORT', 'Ordenar por'); //GibaPhp
define('_MD_YOGURT_ORDER', 'Ordem'); //GibaPhp
define('_MD_YOGURT_LASTLOGIN', 'Último Acesso'); //GibaPhp
define('_MD_YOGURT_POSTS', 'Número de Mensagens'); //GibaPhp
define('_MD_YOGURT_ASC', 'Ordem Ascendente'); //GibaPhp
define('_MD_YOGURT_DESC', 'Ordem Descendente'); //GibaPhp
define('_MD_YOGURT_LIMIT', 'Número de usuários por página'); //GibaPhp
define('_MD_YOGURT_RESULTS', 'Resultados da Procura'); //GibaPhp

//26/10/2007
define('_MD_YOGURT_VIDEOSNOTENABLED', 'O administrador do site desabilitou este recurso'); //GibaPhp
define('_MD_YOGURT_FRIENDSNOTENABLED', 'O administrador do site desabilitou este recurso'); //GibaPhp
define('_MD_YOGURT_GROUPSNOTENABLED', 'O administrador do site desabilitou este recurso'); //GibaPhp
define('_MD_YOGURT_PICTURESNOTENABLED', 'O administrador do site desabilitou este recurso'); //GibaPhp
define('_MD_YOGURT_NOTESNOTENABLED', 'O administrador do site desabilitou este recurso'); //GibaPhp

//26/01/2008
define('_MD_YOGURT_ALLFRIENDS', 'Ver todos os amigos'); //GibaPhp
define('_MD_YOGURT_ALLGROUPS', 'Ver todas as tribos'); //GibaPhp

//31/01/2008
define('_MD_YOGURT_FRIENDSHIPNOTACCEPTED', 'Amizade Rejeitada'); //GibaPhp

//07/04/2008 - 3.1
define('_MD_YOGURT_USERDOESNTEXIST', 'Este usuário não existe ou foi excluído'); //GibaPhp
define('_MD_YOGURT_FANSTITLE', "%s's Fans"); //GibaPhp
define('_MD_YOGURT_NOFANSYET', 'Nenhum fã ainda'); //GibaPhp

//17/04/2008 - 3.2
define('_MD_YOGURT_AUDIONOTENABLED', 'O administrador do site tem recurso de áudio com deficiência');
define('_MD_YOGURT_NOAUDIOYET', 'Este usuário não carregou nenhum arquivo de áudio ainda');
define('_MD_YOGURT_AUDIOS', 'Audio');
define('_MD_YOGURT_CONFIGSAUDIOS', 'Veja seu arquivos de áudio');
define('_MD_YOGURT_UPLOADEDAUDIO', 'Arquivo de áudio carregado');

define('_MD_YOGURT_SELECTAUDIO', 'Navegar para o seu arquivo MP3');
define('_MD_YOGURT_AUTHORAUDIO', 'Autor/Cantor');
define('_MD_YOGURT_TITLEAUDIO', 'Título do arquivo ou canção');
define('_MD_YOGURT_ADDAUDIO', 'Adicionar um arquivo MP3');
define('_MD_YOGURT_SUBMITAUDIO', 'Carregar arquivo');
define('_MD_YOGURT_ADDAUDIOHELP', 'Escolha um arquivo mp3 no seu computador, tamanho máximo %s ,<br> Deixe os campos de título e autor em branco se o seu arquivo já tem metainfo');

//19/04/2008 - 3.3
define('_MD_YOGURT_AUDIODELETED', 'Seu arquivo MP3 foi excluído!');
define('_MD_YOGURT_ASKCONFIRMAUDIODELETION', 'Você realmente deseja excluir o seu arquivo de áudio?');
define('_MD_YOGURT_CONFIRMAUDIODELETION', 'Sim, por favor exclua isto!');

define('_MD_YOGURT_META', 'Meta Info');
define('_MD_YOGURT_META_TITLE', 'Título');
define('_MD_YOGURT_META_ALBUM', 'Album');
define('_MD_YOGURT_META_ARTIST', 'Artista');
define('_MD_YOGURT_META_YEAR', 'Ano');
