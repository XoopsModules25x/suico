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
define('_MI_YOGURT_NUMBPICT_TITLE', 'Número de fotos');
define('_MI_YOGURT_NUMBPICT_DESC', 'Número de fotos permitidas na página.');
define('_MI_YOGURT_ADMENU1', 'Home');
define('_MI_YOGURT_ADMENU2', 'Sobre');
define('_MI_YOGURT_SMNAME1', 'Enviar');
define('_MI_YOGURT_THUMW_TITLE', 'Largura do Thumb');
define('_MI_YOGURT_THUMBW_DESC', 'Largura dos Thumbnails em pixels.<br>Significa que sua foto terá no máximo a largura indicada. Todas as proporções serão mantidas.');
define('_MI_YOGURT_THUMBH_TITLE', 'Altura do Thumb');
define('_MI_YOGURT_THUMBH_DESC', 'Largura dos Thumbnails em pixels.<br>Significa que sua foto terá no máximo a altura indicada. Todas as proporções serão mantidas.');
define('_MI_YOGURT_RESIZEDW_TITLE', 'Largura da foto redefinida');
define('_MI_YOGURT_RESIZEDW_DESC', 'Largura da foto redefinida em pixels.<br>Significa que sua foto terá no máximo a largura indicada. Todas as proporções serão mantidas.<br> Se a foto original for maior que tamanho indicado ela será redefinida para não quebrar o laytout do seu template.');
define('_MI_YOGURT_RESIZEDH_TITLE', 'Altura da foto redefinida');
define('_MI_YOGURT_RESIZEDH_DESC', 'Altura da foto redefinida em pixels.<br>Significa que sua foto terá no máximo a altura indicada. Todas as proporções serão mantidas.<br> Se a foto original for maior que tamanho indicado ela será redefinida para não quebrar o laytout do seu template.');
define('_MI_YOGURT_ORIGINALW_TITLE', 'Largura máxima da foto original');
define('_MI_YOGURT_ORIGINALW_DESC', 'Largura máxima medida em pixels.<br>Significa que a foto original do usuário não pode exceder a largura indicada ou não será realizado o upload.');
define('_MI_YOGURT_ORIGINALH_TITLE', 'Altura máxima da foto original');
define('_MI_YOGURT_ORIGINALH_DESC', 'Altura máxima medida em pixels.<br>Significa que a foto original do usuário não pode exceder a altura indicada ou não será realizado o upload.');
define('_MI_YOGURT_PATHUPLOAD_TITLE', 'Local dos Uploads');
define('_MI_YOGURT_PATHUPLOAD_DESC', 'Endereço real para o diretório que receberá as fotos.<br>No linux deverá ser (ex.):  /var/www/uploads<br>No windows deverá ser (ex.): C:/Program Files/www');
define('_MI_YOGURT_LINKPATHUPLOAD_TITLE', 'Link para o diretótio que receberá as fotos');
define('_MI_YOGURT_LINKPATHUPLOAD_DESC', 'Indicar o endereço do diretório que receberá as fotos dos usuário, exemplo: http://www.yoursite.com/uploads');
define('_MI_YOGURT_MAXFILEBYTES_TITLE', 'Tamanho máximo em bytes');
define('_MI_YOGURT_MAXFILEBYTES_DESC', 'Indicar o tamanho máximo que o arquivo da foto pode ter em bytes, exemplo: 512000 que significa 500 KB.');

define('_MI_YOGURT_PICTURE_NOTIFYTIT', 'Álbum');
define('_MI_YOGURT_PICTURE_NOTIFYDSC', 'Notificações relacionadas ao álbum do usuário');
define('_MI_YOGURT_PICTURE_NEWPIC_NOTIFY', 'Nova Foto');
define('_MI_YOGURT_PICTURE_NEWPIC_NOTIFYCAP', 'Avise-me quando este usuário postar uma nova foto');
define('_MI_YOGURT_PICTURE_NEWPOST_NOTIFYDSC', 'Avise-me quando este usuário enviar uma nova foto');
define('_MI_YOGURT_PICTURE_NEWPIC_NOTIFYSBJ', '{X_OWNER_NAME} postou uma nova foto no álbum dele');
define('_MI_YOGURT_HOTTEST', 'O Álbum mais quente');
define('_MI_YOGURT_HOTTEST_DESC', 'Este bloco exibirá uma lista dos álbuns mais quentes');
define('_MI_YOGURT_HOTFRIENDS', 'Amigos quentes');
define('_MI_YOGURT_HOTFRIENDS_DESC', 'Este bloco exibirá os amigos com álbuns mais quentes');
define('_MI_YOGURT_PICTURE_TEMPLATEINDEXDESC', 'Esta template exibe as fotos do usuário');
define('_MI_YOGURT_PICTURE_TEMPLATEFRIENDSDESC', 'Esta template exibe os amigos do usuário');
define('_MI_YOGURT_MYFRIENDS', 'Meus Amigos');
define('_MI_YOGURT_FRIENDSPERPAGE_TITLE', 'Amigos por página');
define('_MI_YOGURT_FRIENDSPERPAGE_DESC', 'Ajuste o número de amigos exibidos por a página<br>Em minha página de amigos');
define('_MI_YOGURT_PICTURESPERPAGE_TITLE', 'Fotos por página antes de mostrar a paginação');

define('_MI_YOGURT_LAST', 'Bloco de últimas fotos');
define('_MI_YOGURT_LAST_DESC', 'Últimas fotos postadas, independente do álbum');
define('_MI_YOGURT_DELETEPHYSICAL_TITLE', 'Apagar arquivos da pasta upload também');
define(
    '_MI_YOGURT_DELETEPHYSICAL_DESC',
    'Dizer sim aqui, permitirá que as fotos enviadas sejam apagadas da pasta bem como do banco de dados<br> Tenha cuidado com esta opção, pois se você excluir o arquivo da pasta e não só do banco de dados as pessoas que criaram links diretos para a foto em outra parte do site perderão o conteúdo,<br> ao mesmo tempo, se você excluí-las, as fotos podem ocupar muito espaço no servidor<br>Configures este item de acordo com as suas necessidades.'
);

define('_MI_YOGURT_MYVIDEOS', 'Meus Videos'); //GibaPhp
define('_MI_YOGURT_PICTURE_TEMPLATEALBUMDESC', 'Template para a galeria'); //GibaPhp
define('_MI_YOGURT_MYPICTURES', 'Minhas Fotos'); //GibaPhp
define('_MI_YOGURT_MODULEDESC', 'Este módulo permitirá que cada membro tenha um álbum de retrato com um número X de arquivos.');
define('_MI_YOGURT_TUBEW_TITLE', 'Largura dos Vídeos do YouTube'); //GibaPhp
define('_MI_YOGURT_TUBEW_DESC', 'A largura em pixels do reprodutor de vídeo do YouTube'); //GibaPhp
define('_MI_YOGURT_TUBEH_TITLE', 'Altura dos vídeos do YouTube'); //GibaPhp
define('_MI_YOGURT_TUBEH_DESC', 'A altura em pixels do reprodutos de vídeo do YouTube'); //GibaPhp
define('_MI_YOGURT_PICTURE_TEMPLATENOTEBOOKDESC', 'Template para o Notebook'); //GibaPhp
define('_MI_YOGURT_PICTURE_TEMPLATESEUTUBODESC', 'Template para a seção de videos'); //GibaPhp
define('_MI_YOGURT_PICTURE_TEMPLATEGROUPSDESC', 'Template para as Tribos'); //GibaPhp
define('_MI_YOGURT_MYNOTES', 'Meus Notes'); //GibaPhp
define('_MI_YOGURT_MYGROUPS', 'Minhas Tribos'); //GibaPhp
define('_MI_YOGURT_TEMPLATENAVBARDESC', 'Template Para a parte superior do navbar utilizado em todas as páginas'); //GibaPhp

define('_MI_YOGURT_VIDEOSPERPAGE_TITLE', 'Videos por Página'); //GibaPhp
define('_MI_YOGURT_VIDEO_NOTIFYTIT', 'Vídeos');
define('_MI_YOGURT_VIDEO_NOTIFYDSC', 'Notificações Sobre Vídeos'); //GibaPhp
define('_MI_YOGURT_VIDEO_NEWVIDEO_NOTIFY', 'Novo vídeo'); //GibaPhp
define('_MI_YOGURT_VIDEO_NEWVIDEO_NOTIFYCAP', 'Avise-me quando um novo vídeo for enviado por este usuário'); //GibaPhp
define('_MI_YOGURT_VIDEO_NEWVIDEO_NOTIFYDSC', 'Aviso - Descrição de Novo vídeo'); //GibaPhp - dúvida aqui...
define('_MI_YOGURT_VIDEO_NEWVIDEO_NOTIFYSBJ', '{X_OWNER_NAME} Apresentou um novo vídeo no seu perfil'); //GibaPhp

define('_MI_YOGURT_NOTE_NOTIFYTIT', 'Notes');
define('_MI_YOGURT_NOTE_NOTIFYDSC', 'Notificações de Notebook'); //GibaPhp
define('_MI_YOGURT_NOTE_NEWNOTE_NOTIFY', 'Novo Note'); //GibaPhp
define('_MI_YOGURT_NOTE_NEWNOTE_NOTIFYCAP', 'Avise-me quando um novo Note for enviado para este Notebook'); //GibaPhp
define('_MI_YOGURT_NOTE_NEWNOTE_NOTIFYDSC', 'Aviso - Descrição do Novo Note'); //GibaPhp - dúvida aqui...
define('_MI_YOGURT_NOTE_NEWNOTE_NOTIFYSBJ', '{X_OWNER_NAME} Apresentou um novo Note dentro do seu Notebook'); //GibaPhp

define('_MI_YOGURT_MAINTUBEW_TITLE', 'Largura do vídeo Principal'); //GibaPhp
define('_MI_YOGURT_MAINTUBEW_DESC', 'Largura do vídeo que será mostrado na primeira página do módulo'); //GibaPhp
define('_MI_YOGURT_MAINTUBEH_TITLE', 'Altura do vídeo Principal'); //GibaPhp
define('_MI_YOGURT_MAINTUBEH_DESC', 'Altura do vídeo que será mostrado na primeira página do módulo'); //GibaPhp

//24/09/2007
define('_MI_YOGURT_MYCONFIGS', 'Minhas Preferências'); //GibaPhp
define('_MI_YOGURT_PICTURE_TEMPLATECONFIGSDESC', 'Template com definições para o usuário'); //GibaPhp
define('_MI_YOGURT_PICTURE_TEMPLATEFOOTERDESC', 'Template para o rodapé do módulo'); //GibaPhp
define('_MI_YOGURT_PICTURE_TEMPLATEEDITGROUP', 'Template para os atributos da página das Tribos'); //GibaPhp
define('_MI_YOGURT_LICENSE', 'Yogurt foi feito por Marcello Brandão é está sob uma Licença ( confirmar o correto desta licença) Não Atribuida de Obras Derivadas 2,5 Brasil.'); //GibaPhp - Dúvida aqui... Também não entendi nem a tradução que eu fiz, rss :-)

//19/10/2007
define('_MI_YOGURT_GROUPSPERPAGE_TITLE', 'Tribos por Página'); //GibaPhp
define('_MI_YOGURT_GROUPSPERPAGE_DESC', 'Tribos por página antes de mostrar a paginação'); //GibaPhp
define('_MI_YOGURT_PICTURE_TEMPLATESEARCHRESULTDESC', 'Este Template mostra os resultados de uma pesquisa de comunidades'); //GibaPhp
define('_MI_YOGURT_PICTURE_TEMPLATEGROUPDESC', 'Este Template mostra uma Tribo e os seus membros'); //GibaPhp

//22/10/2007
define('_MI_YOGURT_MYPROFILE', 'Meu Perfil'); //GibaPhp
define('_MI_YOGURT_SEARCH', 'Procurar Membros'); //GibaPhp
define('_MI_YOGURT_PICTURE_TEMPLATESEARCHRESULTSDESC', 'Template para o resultado da Procura de Membros'); //GibaPhp
define('_MI_YOGURT_PICTURE_TEMPLATESEARCHFORMDESC', 'Template para o formulário de procura'); //GibaPhp

//26/10/2007
define('_MI_YOGURT_ENABLEPICT_TITLE', 'Ativar imagens na seção'); //GibaPhp
define('_MI_YOGURT_ENABLEPICT_DESC', 'Ativando a seção de fotos para os usuários, permitirá que exista uma galeria de imagens para cada usuário'); //GibaPhp
define('_MI_YOGURT_ENABLEFRIENDS_TITLE', 'Ativar a seção de amigos'); //GibaPhp
define('_MI_YOGURT_ENABLEFRIENDS_DESC', 'Ativando a seção de amigos para os usuários, permitirá o agendamento de amigos'); //GibaPhp
define('_MI_YOGURT_ENABLEVIDEOS_TITLE', 'Ativando a seção de vídeos'); //GibaPhp
define('_MI_YOGURT_ENABLEVIDEOS_DESC', 'Ativando a seção de vídeos para os usuários, permitirá que exista uma galera de vídeos para cada usuário'); //GibaPhp
define('_MI_YOGURT_ENABLENOTES_TITLE', 'Ativar a seção de Notes'); //GibaPhp
define('_MI_YOGURT_ENABLENOTES_DESC', 'Ativando a seção de Notes, permitirá que os membros possam deixar mensagens públicas no Note de outros usuários. Esse recurso é como você conhece no Facebook'); //GibaPhp
define('_MI_YOGURT_ENABLEGROUPS_TITLE', 'Ativar a seção de Tribos'); //GibaPhp
define('_MI_YOGURT_ENABLEGROUPS_DESC', 'Ativando a seão de Tribos para os usuários, permitirá a criação de tribos. Desta forma alguns grupos de usuários irão se reunir em locais semelhantes de interesse'); //GibaPhp
define('_MI_YOGURT_NOTESPERPAGE_TITLE', 'Número de Notes por página'); //GibaPhp
define('_MI_YOGURT_NOTESPERPAGE_DESC', 'Número de Notes em uma página antes de mostrar a navegação e paginação '); //GibaPhp

//25/11/2007
define('_MI_YOGURT_FRIENDS', 'Meus Amigos'); //GibaPhp
define('_MI_YOGURT_FRIENDS_DESC', 'Este bloco mostra os amigos do usuário'); //GibaPhp

//26/01/2008
define('_MI_YOGURT_IMGORDER_TITLE', 'Ordem das Fotos'); //GibaPhp
define('_MI_YOGURT_IMGORDER_DESC', 'Mostrar as imagens mais recentes primeiro?'); //GibaPhp

//08/04/2008
define('_MI_YOGURT_PICTURE_TEMPLATENOTIFICATIONS', 'Template para as notificações');

//11/04/2008
define('_MI_YOGURT_FRIENDSHIP_NOTIFYTIT', 'Amizades'); //GibaPhp
define('_MI_YOGURT_FRIENDSHIP_NOTIFYDSC', 'Solicitações de amizade'); //GibaPhp
define('_MI_YOGURT_FRIEND_NEWPETITION_NOTIFY', 'Solicitação'); //GibaPhp
define('_MI_YOGURT_FRIEND_NEWPETITION_NOTIFYCAP', 'Avise-me quando alguém pedir para ser seu amigo'); //GibaPhp
define('_MI_YOGURT_FRIEND_NEWPETITION_NOTIFYDSC', 'Avise-me quando alguém pedir a minha amizade'); //GibaPhp
define('_MI_YOGURT_FRIEND_NEWPETITION_NOTIFYSBJ', 'Alguém apenas pediu para ser seu amigo'); //GibaPhp

//13/04/2008
define('_MI_YOGURT_PICTURE_TEMPLATEFANS', 'Modelo/Template para as páginas de fãs'); //GibaPhp

//17/07/2008 - 3.2
define('_MI_YOGURT_ENABLEAUDIO_TITLE', 'Ativar seção de áudio'); //GibaPhp
define('_MI_YOGURT_ENABLEAUDIO_DESC', 'A ativação desta seção para os utilizadores, irá permitir a reprodução de áudio'); //GibaPhp
define('_MI_YOGURT_PICTURE_TEMPLATEAUDIODESC', 'Página de Modelo/Templates de áudio'); //GibaPhp
define('_MI_YOGURT_NUMBAUDIO_TITLE', 'O número máximo de áudio para um usuário'); //GibaPhp
define('_MI_YOGURT_AUDIOSPERPAGE_TITLE', 'Número de arquivos mp3 por página'); //GibaPhp

//19/04/2008 - 3.3
define('_MI_YOGURT_MYAUDIOS', 'Meus audios'); //GibaPhp
