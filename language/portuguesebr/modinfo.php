<?php
// $Id: modinfo.php,v 1.32 2008/04/08 22:35:42 marcellobrandao Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
/**
 * Translation for Portuguese users
 * $Id: modinfo.php,v 3.2 2008/06/23  06:14:00 GibaPhp Exp $
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

define('_MI_YOG_NUMBPICT_TITLE', 'Número de fotos');
define('_MI_YOG_NUMBPICT_DESC', 'Número de fotos permitidas na página.');
define('_MI_YOG_ADMENU1', 'Home');
define('_MI_YOG_ADMENU2', 'Sobre');
define('_MI_YOG_SMNAME1', 'Enviar');
define('_MI_YOG_THUMW_TITLE', 'Largura do Thumb');
define('_MI_YOG_THUMBW_DESC', 'Largura dos Thumbnails em pixels.<br />Significa que sua foto terá no máximo a largura indicada. Todas as proporções serão mantidas.');
define('_MI_YOG_THUMBH_TITLE', 'Altura do Thumb');
define('_MI_YOG_THUMBH_DESC', 'Largura dos Thumbnails em pixels.<br />Significa que sua foto terá no máximo a altura indicada. Todas as proporções serão mantidas.');
define('_MI_YOG_RESIZEDW_TITLE', 'Largura da foto redefinida');
define('_MI_YOG_RESIZEDW_DESC', 'Largura da foto redefinida em pixels.<br />Significa que sua foto terá no máximo a largura indicada. Todas as proporções serão mantidas.<br /> Se a foto original for maior que tamanho indicado ela será redefinida para não quebrar o laytout do seu template.');
define('_MI_YOG_RESIZEDH_TITLE', 'Altura da foto redefinida');
define('_MI_YOG_RESIZEDH_DESC', 'Altura da foto redefinida em pixels.<br />Significa que sua foto terá no máximo a altura indicada. Todas as proporções serão mantidas.<br /> Se a foto original for maior que tamanho indicado ela será redefinida para não quebrar o laytout do seu template.');
define('_MI_YOG_ORIGINALW_TITLE', 'Largura máxima da foto original');
define('_MI_YOG_ORIGINALW_DESC', 'Largura máxima medida em pixels.<br />Significa que a foto original do usuário não pode exceder a largura indicada ou não será realizado o upload.');
define('_MI_YOG_ORIGINALH_TITLE', 'Altura máxima da foto original');
define('_MI_YOG_ORIGINALH_DESC', 'Altura máxima medida em pixels.<br />Significa que a foto original do usuário não pode exceder a altura indicada ou não será realizado o upload.');
define('_MI_YOG_PATHUPLOAD_TITLE', 'Local dos Uploads');
define('_MI_YOG_PATHUPLOAD_DESC', 'Endereço real para o diretório que receberá as fotos.<br />No linux deverá ser (ex.):  /var/www/uploads<br />No windows deverá ser (ex.): C:/Program Files/www');
define('_MI_YOG_LINKPATHUPLOAD_TITLE', 'Link para o diretótio que receberá as fotos');
define('_MI_YOG_LINKPATHUPLOAD_DESC', 'Indicar o endereço do diretório que receberá as fotos dos usuário, exemplo: http://www.yoursite.com/uploads');
define('_MI_YOG_MAXFILEBYTES_TITLE', 'Tamanho máximo em bytes');
define('_MI_YOG_MAXFILEBYTES_DESC', 'Indicar o tamanho máximo que o arquivo da foto pode ter em bytes, exemplo: 512000 que significa 500 KB.');

define('_MI_YOG_PICTURE_NOTIFYTIT', 'Álbum');
define('_MI_YOG_PICTURE_NOTIFYDSC', 'Notificações relacionadas ao álbum do usuário');
define('_MI_YOG_PICTURE_NEWPIC_NOTIFY', 'Nova Foto');
define('_MI_YOG_PICTURE_NEWPIC_NOTIFYCAP', 'Avise-me quando este usuário postar uma nova foto');
define('_MI_YOG_PICTURE_NEWPOST_NOTIFYDSC', 'Avise-me quando este usuário enviar uma nova foto');
define('_MI_YOG_PICTURE_NEWPIC_NOTIFYSBJ', '{X_OWNER_NAME} postou uma nova foto no álbum dele');
define('_MI_YOGURT_HOTTEST', 'O Álbum mais quente');
define('_MI_YOGURT_HOTTEST_DESC', 'Este bloco exibirá uma lista dos álbuns mais quentes');
define('_MI_YOGURT_HOTFRIENDS', 'Amigos quentes');
define('_MI_YOGURT_HOTFRIENDS_DESC', 'Este bloco exibirá os amigos com álbuns mais quentes');
define('_MI_YOG_PICTURE_TEMPLATEINDEXDESC', 'Esta template exibe as fotos do usuário');
define('_MI_YOG_PICTURE_TEMPLATEFRIENDSDESC', 'Esta template exibe os amigos do usuário');
define('_MI_YOGURT_MYFRIENDS', 'Meus Amigos');
define('_MI_YOG_FRIENDSPERPAGE_TITLE', 'Amigos por página');
define('_MI_YOG_FRIENDSPERPAGE_DESC', 'Ajuste o número de amigos exibidos por a página<br />Em minha página de amigos');
define('_MI_YOG_PICTURESPERPAGE_TITLE', 'Fotos por página antes de mostrar a paginação');

define('_MI_YOGURT_LAST', 'Bloco de últimas fotos');
define('_MI_YOGURT_LAST_DESC', 'Últimas fotos postadas, independente do álbum');
define('_MI_YOG_DELETEPHYSICAL_TITLE', 'Apagar arquivos da pasta upload também');
define(
    '_MI_YOG_DELETEPHYSICAL_DESC',
    'Dizer sim aqui, permitirá que as fotos enviadas sejam apagadas da pasta bem como do banco de dados<br /> Tenha cuidado com esta opção, pois se você excluir o arquivo da pasta e não só do banco de dados as pessoas que criaram links diretos para a foto em outra parte do site perderão o conteúdo,<br /> ao mesmo tempo, se você excluí-las, as fotos podem ocupar muito espaço no servidor<br />Configures este item de acordo com as suas necessidades.'
);

define('_MI_YOGURT_MYVIDEOS', 'Meus Videos'); //GibaPhp
define('_MI_YOG_PICTURE_TEMPLATEALBUMDESC', 'Template para a galeria'); //GibaPhp
define('_MI_YOGURT_MYPICTURES', 'Minhas Fotos'); //GibaPhp
define('_MI_YOGURT_MODULEDESC', 'Este módulo permitirá que cada membro tenha um álbum de retrato com um número X de arquivos.');
define('_MI_YOG_TUBEW_TITLE', 'Largura dos Vídeos do YouTube'); //GibaPhp
define('_MI_YOG_TUBEW_DESC', 'A largura em pixels do reprodutor de vídeo do YouTube'); //GibaPhp
define('_MI_YOG_TUBEH_TITLE', 'Altura dos vídeos do YouTube'); //GibaPhp
define('_MI_YOG_TUBEH_DESC', 'A altura em pixels do reprodutos de vídeo do YouTube'); //GibaPhp
define('_MI_YOG_PICTURE_TEMPLATENOTEBOOKDESC', 'Template para o Notebook'); //GibaPhp
define('_MI_YOG_PICTURE_TEMPLATESEUTUBODESC', 'Template para a seção de videos'); //GibaPhp
define('_MI_YOG_PICTURE_TEMPLATETRIBESDESC', 'Template para as Tribos'); //GibaPhp
define('_MI_YOGURT_MYNOTES', 'Meus Notes'); //GibaPhp
define('_MI_YOGURT_MYTRIBES', 'Minhas Tribos'); //GibaPhp
define('_MI_YOG_TEMPLATENAVBARDESC', 'Template Para a parte superior do navbar utilizado em todas as páginas'); //GibaPhp

define('_MI_YOG_VIDEOSPERPAGE_TITLE', 'Videos por Página'); //GibaPhp
define('_MI_YOG_VIDEO_NOTIFYTIT', 'Vídeos');
define('_MI_YOG_VIDEO_NOTIFYDSC', 'Notificações Sobre Vídeos'); //GibaPhp
define('_MI_YOG_VIDEO_NEWVIDEO_NOTIFY', 'Novo vídeo'); //GibaPhp
define('_MI_YOG_VIDEO_NEWVIDEO_NOTIFYCAP', 'Avise-me quando um novo vídeo for enviado por este usuário'); //GibaPhp
define('_MI_YOG_VIDEO_NEWVIDEO_NOTIFYDSC', 'Aviso - Descrição de Novo vídeo'); //GibaPhp - dúvida aqui...
define('_MI_YOG_VIDEO_NEWVIDEO_NOTIFYSBJ', '{X_OWNER_NAME} Apresentou um novo vídeo no seu perfil'); //GibaPhp

define('_MI_YOG_NOTE_NOTIFYTIT', 'Notes');
define('_MI_YOG_NOTE_NOTIFYDSC', 'Notificações de Notebook'); //GibaPhp
define('_MI_YOG_NOTE_NEWNOTE_NOTIFY', 'Novo Note'); //GibaPhp
define('_MI_YOG_NOTE_NEWNOTE_NOTIFYCAP', 'Avise-me quando um novo Note for enviado para este Notebook'); //GibaPhp
define('_MI_YOG_NOTE_NEWNOTE_NOTIFYDSC', 'Aviso - Descrição do Novo Note'); //GibaPhp - dúvida aqui...
define('_MI_YOG_NOTE_NEWNOTE_NOTIFYSBJ', '{X_OWNER_NAME} Apresentou um novo Note dentro do seu Notebook'); //GibaPhp

define('_MI_YOG_MAINTUBEW_TITLE', 'Largura do vídeo Principal'); //GibaPhp
define('_MI_YOG_MAINTUBEW_DESC', 'Largura do vídeo que será mostrado na primeira página do módulo'); //GibaPhp
define('_MI_YOG_MAINTUBEH_TITLE', 'Altura do vídeo Principal'); //GibaPhp
define('_MI_YOG_MAINTUBEH_DESC', 'Altura do vídeo que será mostrado na primeira página do módulo'); //GibaPhp

//24/09/2007
define('_MI_YOGURT_MYCONFIGS', 'Minhas Preferências'); //GibaPhp
define('_MI_YOG_PICTURE_TEMPLATECONFIGSDESC', 'Template com definições para o usuário'); //GibaPhp
define('_MI_YOG_PICTURE_TEMPLATEFOOTERDESC', 'Template para o rodapé do módulo'); //GibaPhp
define('_MI_YOG_PICTURE_TEMPLATEEDITTRIBE', 'Template para os atributos da página das Tribos'); //GibaPhp
define('_MI_YOGURT_LICENSE', 'Yogurt foi feito por Marcello Brandão é está sob uma Licença ( confirmar o correto desta licença) Não Atribuida de Obras Derivadas 2,5 Brasil.'); //GibaPhp - Dúvida aqui... Também não entendi nem a tradução que eu fiz, rss :-)

//19/10/2007
define('_MI_YOG_TRIBESPERPAGE_TITLE', 'Tribos por Página'); //GibaPhp
define('_MI_YOG_TRIBESPERPAGE_DESC', 'Tribos por página antes de mostrar a paginação'); //GibaPhp
define('_MI_YOG_PICTURE_TEMPLATESEARCHRESULTDESC', 'Este Template mostra os resultados de uma pesquisa de comunidades'); //GibaPhp
define('_MI_YOG_PICTURE_TEMPLATETRIBEDESC', 'Este Template mostra uma Tribo e os seus membros'); //GibaPhp

//22/10/2007
define('_MI_YOGURT_MYPROFILE', 'Meu Perfil'); //GibaPhp
define('_MI_YOGURT_SEARCH', 'Procurar Membros'); //GibaPhp
define('_MI_YOG_PICTURE_TEMPLATESEARCHRESULTSDESC', 'Template para o resultado da Procura de Membros'); //GibaPhp
define('_MI_YOG_PICTURE_TEMPLATESEARCHFORMDESC', 'Template para o formulário de procura'); //GibaPhp

//26/10/2007
define('_MI_YOG_ENABLEPICT_TITLE', 'Ativar imagens na seção'); //GibaPhp
define('_MI_YOG_ENABLEPICT_DESC', 'Ativando a seção de fotos para os usuários, permitirá que exista uma galeria de imagens para cada usuário'); //GibaPhp
define('_MI_YOG_ENABLEFRIENDS_TITLE', 'Ativar a seção de amigos'); //GibaPhp
define('_MI_YOG_ENABLEFRIENDS_DESC', 'Ativando a seção de amigos para os usuários, permitirá o agendamento de amigos'); //GibaPhp
define('_MI_YOG_ENABLEVIDEOS_TITLE', 'Ativando a seção de vídeos'); //GibaPhp
define('_MI_YOG_ENABLEVIDEOS_DESC', 'Ativando a seção de vídeos para os usuários, permitirá que exista uma galera de vídeos para cada usuário'); //GibaPhp
define('_MI_YOG_ENABLENOTES_TITLE', 'Ativar a seção de Notes'); //GibaPhp
define('_MI_YOG_ENABLENOTES_DESC', 'Ativando a seção de Notes, permitirá que os membros possam deixar mensagens públicas no Note de outros usuários. Esse recurso é como você conhece no Facebook'); //GibaPhp
define('_MI_YOG_ENABLETRIBES_TITLE', 'Ativar a seção de Tribos'); //GibaPhp
define('_MI_YOG_ENABLETRIBES_DESC', 'Ativando a seão de Tribos para os usuários, permitirá a criação de tribos. Desta forma alguns grupos de usuários irão se reunir em locais semelhantes de interesse'); //GibaPhp
define('_MI_YOG_NOTESPERPAGE_TITLE', 'Número de Notes por página'); //GibaPhp
define('_MI_YOG_NOTESPERPAGE_DESC', 'Número de Notes em uma página antes de mostrar a navegação e paginação '); //GibaPhp

//25/11/2007
define('_MI_YOGURT_FRIENDS', 'Meus Amigos'); //GibaPhp
define('_MI_YOGURT_FRIENDS_DESC', 'Este bloco mostra os amigos do usuário'); //GibaPhp

//26/01/2008
define('_MI_YOG_IMGORDER_TITLE', 'Ordem das Fotos'); //GibaPhp
define('_MI_YOG_IMGORDER_DESC', 'Mostrar as imagens mais recentes primeiro?'); //GibaPhp

//08/04/2008
define('_MI_YOG_PICTURE_TEMPLATENOTIFICATIONS', 'Template para as notificações');

//11/04/2008
define('_MI_YOG_FRIENDSHIP_NOTIFYTIT', 'Amizades'); //GibaPhp
define('_MI_YOG_FRIENDSHIP_NOTIFYDSC', 'Solicitações de amizade'); //GibaPhp
define('_MI_YOG_FRIEND_NEWPETITION_NOTIFY', 'Solicitação'); //GibaPhp
define('_MI_YOG_FRIEND_NEWPETITION_NOTIFYCAP', 'Avise-me quando alguém pedir para ser seu amigo'); //GibaPhp
define('_MI_YOG_FRIEND_NEWPETITION_NOTIFYDSC', 'Avise-me quando alguém pedir a minha amizade'); //GibaPhp
define('_MI_YOG_FRIEND_NEWPETITION_NOTIFYSBJ', 'Alguém apenas pediu para ser seu amigo'); //GibaPhp

//13/04/2008
define('_MI_YOG_PICTURE_TEMPLATEFANS', 'Modelo/Template para as páginas de fãs'); //GibaPhp

//17/07/2008 - 3.2
define('_MI_YOG_ENABLEAUDIO_TITLE', 'Ativar seção de áudio'); //GibaPhp
define('_MI_YOG_ENABLEAUDIO_DESC', 'A ativação desta seção para os utilizadores, irá permitir a reprodução de áudio'); //GibaPhp
define('_MI_YOG_PICTURE_TEMPLATEAUDIODESC', 'Página de Modelo/Templates de áudio'); //GibaPhp
define('_MI_YOG_NUMBAUDIO_TITLE', 'O número máximo de áudio para um usuário'); //GibaPhp
define('_MI_YOG_AUDIOSPERPAGE_TITLE', 'Número de arquivos mp3 por página'); //GibaPhp

//19/04/2008 - 3.3
define('_MI_YOGURT_MYAUDIOS', 'Meus audios'); //GibaPhp
