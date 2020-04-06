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
//Present in many files (videos pictures etc...)
define('_MD_YOGURT_DELETE', 'L&ouml;schen');
define('_MD_YOGURT_EDITDESC', 'Beschreibung bearbeiten');
define('_MD_YOGURT_TOKENEXPIRED', 'Dein Sicherheitstoken ist abgelaufen<br>Bitte nochmal versuchen');
define('_MD_YOGURT_DESC_EDITED', 'Die Beschreibung wurde erfolgreich ge&auml;ndert');
define('_MD_YOGURT_CAPTION', 'Titel');
define('_MD_YOGURT_YOUCANUPLOAD', 'Du kannst nur JPG-Dateien mit einer maximalen Dateigr&ouml;&szlig;e von %s KBytes hochladen!<br><b>Bilder kannst Du ganz einfach unter <a href=http://www.bilder-editieren.de target=_blank>www.bilder-editieren.de</a> bearbeiten.</b>');
define('_MD_YOGURT_UPLOADPICTURE', 'Bild hochladen');
define(
    '_MD_YOGURT_NOCACHACA',
    'Ein Problem ist aufgetreten ... sieht nicht gut aus<br>
Das Modul hat sich in einer unerwarteten Weise verhalten. Bitte versuche deine letzte Aktion erneut.'
); //Funny general error message
define('_MD_YOGURT_PAGETITLE', "%s - %s's Social Network");
define('_MD_YOGURT_SUBMIT', 'Absenden');
define('_MD_YOGURT_VIDEOS', 'Videos');
define('_MD_YOGURT_NOTEBOOK', 'G&auml;stebuch');
define('_MD_YOGURT_PHOTOS', 'Bilder');
define('_MD_YOGURT_FRIENDS', 'Freunde');
define('_MD_YOGURT_GROUPS', 'Gruppen');
define('_MD_YOGURT_NOGROUPSYET', 'Keine Gruppe vorhanden');
define('_MD_YOGURT_MYGROUPS', 'Meine Gruppe');
define('_MD_YOGURT_ALLGROUPS', 'Alle Gruppen');
define('_MD_YOGURT_PROFILE', 'Profil');
define('_MD_YOGURT_HOME', 'Startseite');
define('_MD_YOGURT_CONFIGSTITLE', 'Einstellungen');

##################################################### PICTURES #######################################################
//submit.php (for pictures submission
define('_MD_YOGURT_UPLOADED', 'Hochladen erfolgreich');

//delpicture.php
define('_MD_YOGURT_ASKCONFIRMDELETION', 'Bist Du sicher, das Du dieses Bild l&ouml;schen willst?');
define('_MD_YOGURT_CONFIRMDELETION', 'Ja, bitte l&ouml;schen!');

//album.php
define('_MD_YOGURT_YOUHAVE', 'Du hast %s Bilder in deinem Album.');
define('_MD_YOGURT_YOUCANHAVE', 'Du kannst bis zu %s Bilder verwenden.');
define('_MD_YOGURT_DELETED', 'Bild erfolgreich gel&ouml;scht');
define('_MD_YOGURT_SUBMIT_PIC_TITLE', 'Bild hochladen');
define('_MD_YOGURT_SELECT_PHOTO', 'Bild w&auml;hlen');
define('_MD_YOGURT_NOTHINGYET', 'In diesem Album befinden sich noch keine Bilder');
define('_MD_YOGURT_AVATARCHANGE', 'Dieses Bild als Avatar verwenden');
define('_MD_YOGURT_PRIVATIZE', 'Nur Du kannst dieses Bild in deinem Album sehen');
define('_MD_YOGURT_UNPRIVATIZE', 'Alle k&ouml;nnen dieses Bild in deinem Album sehen');
define('_MD_YOGURT_MYPHOTOS', 'Meine Bilder');

//avatar.php
define('_MD_YOGURT_AVATAR_EDITED', 'Du hast deinen Avatar ge&auml;ndert!');

//private.php
define('_MD_YOGURT_PRIVATIZED', 'Ab sofort siehst nur Du dieses Bild');
define('_MD_YOGURT_UNPRIVATIZED', 'Ab sofort k&ouml;nnen alle dieses Bild in deinem Album sehen');

########################################################## FRIENDS ###################################################
//friends.php
define('_MD_YOGURT_FRIENDSTITLE', 'Freunde von %s');
define('_MD_YOGURT_NOFRIENDSYET', 'Keine Freunde'); //also present in index.php
define('_MD_YOGURT_MYFRIENDS', 'Meine Freunde');
define('_MD_YOGURT_FRIENDSHIPCONFIGS', 'Setze die Art dieser Freundschaft und bewerte deinen Freund.');

//class/yogurtfriendship.php
define('_MD_YOGURT_EDITFRIENDSHIP', 'Deine Freundschaft mit diesem Mitglied:');
define('_MD_YOGURT_FRIENDNAME', 'Benutzername');
define('_MD_YOGURT_LEVEL', 'Freundschaftsebene:');
define('_MD_YOGURT_UNKNOWNACCEPTED', 'Nicht akzeptiert');
define('_MD_YOGURT_AQUAITANCE', 'Bekanntenkreis'); //also present in index.php
define('_MD_YOGURT_FRIEND', 'Freund'); //also present in index.php
define('_MD_YOGURT_BESTFRIEND', 'Bester Freund'); //also present in index.php
define('_MD_YOGURT_FAN', 'Fan'); //also present in index.php
define('_MD_YOGURT_FRIENDLY', 'Friendly'); //also present in index.php
define('_MD_YOGURT_FRIENDLYNO', 'Nein');
define('_MD_YOGURT_FRIENDLYYES', 'Ja');
define('_MD_YOGURT_FRIENDLYALOT', 'Sehr!');
define('_MD_YOGURT_FUNNY', 'Zuverl&auml;ssig');
define('_MD_YOGURT_FUNNYNO', 'Nein');
define('_MD_YOGURT_FUNNYYES', 'Ja');
define('_MD_YOGURT_FUNNYALOT', 'Sehr!');
define('_MD_YOGURT_COOL', 'Cool');
define('_MD_YOGURT_COOLNO', 'Nein');
define('_MD_YOGURT_COOLYES', 'Ja');
define('_MD_YOGURT_COOLALOT', 'Sehr!');
define('_MD_YOGURT_PHOTO', 'Bild meines Freundes');
define('_MD_YOGURT_UPDATEFRIEND', 'Freundschaft aktualisieren');

//editfriendship.php
define('_MD_YOGURT_FRIENDSHIPUPDATED', 'Freundschaft aktualisiert');

//submitfriendpetition.php
define('_MD_YOGURT_PETITIONED', 'Eine Anfrage wurde an diesen Benutzer gesendet. Wenn er zustimmt wird er in deiner Freundesliste erscheinen.');
define('_MD_YOGURT_ALREADY_PETITIONED', 'Du hast bereits eine Anfrage auf Freundschaft an dieses Mitglied gesendet (oder umgekehrt). <br>Warte bitte auf Zustimmtung oder Ablehnung.');

//makefriends.php
define('_MD_YOGURT_FRIENDMADE', 'Als Freund hinzugef&uuml;gt!');

//delfriendship.php
define('_MD_YOGURT_FRIENDSHIPTERMINATED', 'Du hast deine Freundschaft mit diesem Benutzer beendet!');

############################################ VIDEOS ############################################################
//mainvideo.php
define('_MD_YOGURT_SETMAINVIDEO', 'Dieses Video erscheint ab sofort auf deiner Profilseite');

//video.php
define('_MD_YOGURT_YOUTUBECODE', 'YouTube-Link oder URL');
define('_MD_YOGURT_ADDVIDEO', 'Video hinzuf&uuml;gen');
define('_MD_YOGURT_ADDFAVORITEVIDEOS', 'Bevorzugtes Video hinzuf&uuml;gen');
define(
    '_MD_YOGURT_ADDVIDEOSHELP',
    'Wenn Du ein eigenes Video mit anderen teilen willst, dann lade dieses Video
bei <a href=http://www.youtube.com target=_blank>YouTube</a> hoch und f&uuml;ge die URL ein bei '
); //The name of the site will show after this
define('_MD_YOGURT_MYVIDEOS', 'Meine Videos');
define('_MD_YOGURT_MAKEMAIN', 'Dieses Video als Hauptvideo festlegen');
define('_MD_YOGURT_NOVIDEOSYET', 'Keine Videos vorhanden!');

//delvideo.php
define('_MD_YOGURT_ASKCONFIRMVIDEODELETION', 'Willst Du dieses Video wirklich l&ouml;schen?');
define('_MD_YOGURT_CONFIRMVIDEODELETION', 'Ja!');
define('_MD_YOGURT_VIDEODELETED', 'Video wurde gel&ouml;scht');

//video_submited.php
define('_MD_YOGURT_VIDEOSAVED', 'Video wurde gespeichert');

############################## GROUPS ########################################################
//class/Groups.php
define('_MD_YOGURT_SUBMIT_GROUP', 'Neue Gruppe anlegen');
define('_MD_YOGURT_UPLOADGROUP', 'Gruppe speichern'); //also present in many ther groups related
define('_MD_YOGURT_GROUP_IMAGE', 'Gruppenbild (125 Pixel breit und 80 Pixel hoch f&uuml;r optimale Darstellung)'); //also present in many ther groups related
define('_MD_YOGURT_GROUP_TITLE', 'Titel'); //also present in many ther groups related
define('_MD_YOGURT_GROUP_DESC', 'Beschreibung'); //also present in many ther groups related
define('_MD_YOGURTCREATEYOURGROUP', 'Eigene Gruppe erstellen!'); //also present in many ther groups related

//abandongroup.php
define('_MD_YOGURT_ASKCONFIRMABANDONGROUP', 'Willst du diese Gruppe wirklich verlassen?');
define('_MD_YOGURT_CONFIRMABANDON', 'Ja, aus dieser Gruppe austreten!');
define('_MD_YOGURT_GROUPABANDONED', 'Du bist nun nicht mehr Mitglied dieser Gruppe.');

//becomemembergroup.php
define('_MD_YOGURT_YOUAREMEMBERNOW', 'Du bist jetzt Mitglied dieser Gruppe');
define('_MD_YOGURT_YOUAREMEMBERALREADY', 'Du bist bereits Mitglied dieser Gruppe');

//delete_group.php
define('_MD_YOGURT_ASKCONFIRMGROUPDELETION', 'Willst Du diese Gruppe wirklich dauerhaft l&ouml;schen?');
define('_MD_YOGURT_CONFIRMGROUPDELETION', 'Ja, diese Gruppe l&ouml;schen!');
define('_MD_YOGURT_GROUPDELETED', 'Gruppe gel&ouml;scht!');

//edit_group.php
define('_MD_YOGURT_MAINTAINOLDIMAGE', 'Dieses Bild behalten'); //also present in other groups related
define('_MD_YOGURT_GROUPEDITED', 'Gruppe bearbeitet');
define('_MD_YOGURT_EDIT_GROUP', 'Deine Gruppe bearbeiten'); //also present in other groups related
define('_MD_YOGURT_GROUPOWNER', 'Du bist Besitzer dieser Gruppe!'); //also present in other groups related
define('_MD_YOGURT_MEMBERSDOFGROUP', 'Mitglieder dieser Gruppe'); //also present in other groups related

//submit_group.php
define('_MD_YOGURT_GROUP_CREATED', 'Deine Gruppe wurde erstellt');

//kickfromgroup.php
define('_MD_YOGURT_CONFIRMKICK', 'Ja, schmei&szlig; ihn raus!');
define('_MD_YOGURT_ASKCONFIRMKICKFROMGROUP', 'Willst Du diese Person wirklich aus dieser Gruppe ausschlie&szlig;en?');
define('_MD_YOGURT_GROUPKICKED', 'Du hast diesen Benutzer aus dieser Gruppe rausgeschmissen, aber wer wei&szlig;, ob er es nicht wieder neu versucht und zur&uuml;ckkehrt!');

//Groups.php
define('_MD_YOGURT_GROUP_ABANDON', 'Diese Gruppe verlassen');
define('_MD_YOGURT_GROUP_JOIN', 'Dieser Gruppe beitreten und jedermann zeigen, wer Du bist!');
define('_MD_YOGURT_GROUP_SEARCH', 'Gruppe suchen');
define('_MD_YOGURT_GROUP_SEARCHKEYWORD', 'Schl&uuml;sselwort');

######################################### NOTES #####################################################
//notebook.php
define('_MD_YOGURT_ENTERTEXTNOTE', 'Text eingeben');
define('_MD_YOGURT_SENDNOTE', 'Eintrag schreiben');
define('_MD_YOGURT_ANSWERNOTE', 'Antworten'); //also present in configs.php
define('_MD_YOGURT_MYNOTEBOOK', 'Mein G&auml;stebuch');
define('_MD_YOGURT_CANCEL', 'Abbrechen'); //also present in configs.php
define('_MD_YOGURT_NOTETIPS', 'G&auml;stebuch-Tipps');
define('_MD_YOGURT_BOLD', 'Fett');
define('_MD_YOGURT_ITALIC', 'Kursiv');
define('_MD_YOGURT_UNDERLINE', 'Unterstrichen');
define('_MD_YOGURT_NONOTESYET', 'Keine G&auml;stebucheintr&auml;ge vorhanden, hier kannst Du noch erster sein!');

//submitNote.php
define('_MD_YOGURT_NOTE_SENT', 'Danke f&uuml;r die Teilnahme, G&auml;stebucheintrag wurde gesendet');

//delete_Note.php
define('_MD_YOGURT_ASKCONFIRMNOTEDELETION', 'Willst du diesen Eintrag wirklich l&ouml;schen?');
define('_MD_YOGURT_CONFIRMNOTEDELETION', 'Ja, diesen Eintrag l&ouml;schen.');
define('_MD_YOGURT_NOTEDELETED', 'G&auml;stebucheintrag wurde gel&ouml;scht');

############################ CONFIGS ##############################################
//configs.php
define('_MD_YOGURT_CONFIGSEVERYONE', 'Jeder');
define('_MD_YOGURT_CONFIGSONLYEUSERS', 'Nur registrierte Mitglieder');
define('_MD_YOGURT_CONFIGSONLYEFRIENDS', 'Meine Freunde.');
define('_MD_YOGURT_CONFIGSONLYME', 'Nur ich');
define('_MD_YOGURT_CONFIGSPICTURES', 'Deine Bilder sehen');
define('_MD_YOGURT_CONFIGSVIDEOS', 'Deine Videos sehen');
define('_MD_YOGURT_CONFIGSGROUPS', 'Deine Gruppen sehen');
define('_MD_YOGURT_CONFIGSNOTES', 'Deine G&auml;stebucheintr&auml;ge sehen');
define('_MD_YOGURT_CONFIGSNOTESSEND', 'Darf dir ins G&auml;stebuch schreiben');
define('_MD_YOGURT_CONFIGSFRIENDS', 'Deine Freunde sehen');
define('_MD_YOGURT_CONFIGSPROFILECONTACT', 'Deine Kontaktinfo sehen');
define('_MD_YOGURT_CONFIGSPROFILEGENERAL', 'Deine Details sehen');
define('_MD_YOGURT_CONFIGSPROFILESTATS', 'Deine Aktivit&auml;ten sehen');
define('_MD_YOGURT_WHOCAN', 'Wer kann:');

//submit_configs.php
define('_MD_YOGURT_CONFIGSSAVE', 'Einstellungen gespeichert!');

//class/yogurt_controller.php
define('_MD_YOGURT_NOPRIVILEGE', 'Du ben&ouml;tigst mehr Rechte, um dieses Profil zu sehen.<br>Schlie&szlig;e Freundschaft mit diesem Mitglied.');

###################################### OTHERS ##############################

//index.php
define('_MD_YOGURT_VISITORS', 'Deine Besucher');
define('_MD_YOGURT_USERDETAILS', 'Benutzerdetails');
define('_MD_YOGURT_USERCONTRIBUTIONS', 'Aktivit&auml;ten');
define('_MD_YOGURT_FANS', 'Fans');
define('_MD_YOGURT_UNKNOWNREJECTING', 'Diese Person ist mir unbekannt, nicht zu meinen Freunden hinzuf&uuml;gen');
define('_MD_YOGURT_UNKNOWNACCEPTING', 'Diese Person ist mir unbekannt, trotzdem zu meinen Freunden hinzuf&uuml;gen');
define('_MD_YOGURT_ASKINGFRIEND', 'Ist %s dein Freund?');
define('_MD_YOGURT_ASKBEFRIEND', 'Willst Du mit diesem Mitglied Freundschaft schlie&szlig;en?');
define('_MD_YOGURT_EDITPROFILE', 'Dein Profil bearbeiten');
define('_MD_YOGURT_SELECTAVATAR', 'Lade Bilder in dein Album hoch und w&auml;hle eines als deinen eigenen Avatar aus.');
define('_MD_YOGURT_SELECTMAINVIDEO', 'F&uuml;ge ein Video zu deinen Videos hinzu und w&auml;hle es als Hauptvideo');
define('_MD_YOGURT_NOAVATARYET', 'Noch kein Avatar');
define('_MD_YOGURT_NOMAINVIDEOYET', 'Noch kein Hauptvideo');
define('_MD_YOGURT_MYPROFILE', 'Mein Profil');
define('_MD_YOGURT_YOUHAVEXPETITIONS', '%u Benutzer will Freundschaft mit dir schlie&szlig;en!');
define('_MD_YOGURT_CONTACTINFO', 'Kontaktdaten');
define('_MD_YOGURT_SUSPENDUSER', 'Benutzer sperren');
define('_MD_YOGURT_SUSPENDTIME', 'Ausschlu&szlig;zeit (in Sekunden)');
define('_MD_YOGURT_UNSUSPEND', 'Benutzersperre aufheben');
define('_MD_YOGURT_SUSPENSIONADMIN', 'Sperre Admin-Tools');

//suspend.php
define('_MD_YOGURT_SUSPENDED', 'Benutzer gesperrt bis %s');
define('_MD_YOGURT_USERSUSPENDED', 'Benutzer gesperrt!'); //also present in index.php

//unsuspend.php
define('_MD_YOGURT_USERUNSUSPENDED', 'Benutzersperre aufgehoben');

//searchmembers.php
define('_MD_YOGURT_SEARCH', 'Finde Mitglieder');
define('_MD_YOGURT_AVATAR', 'Avatar');
define('_MD_YOGURT_REALNAME', 'Wirklicher Name');
define('_MD_YOGURT_REGDATE', 'Beitrittsdatum');
define('_MD_YOGURT_EMAIL', 'E-Mail');
define('_MD_YOGURT_PM', 'PM');
define('_MD_YOGURT_URL', 'URL');
define('_MD_YOGURT_ADMIN', 'ADMIN');
define('_MD_YOGURT_PREVIOUS', 'Zur&uuml;ck');
define('_MD_YOGURT_NEXT', 'Weiter');
define('_MD_YOGURT_USERSFOUND', '%s Mitglied(er) gefunden');
define('_MD_YOGURT_TOTALUSERS', 'Insgesamt: %s Mitglieder');
define('_MD_YOGURT_NOFOUND', 'Keine Mitglieder gefunden');
define('_MD_YOGURT_UNAME', 'Benutzername');
define('_MD_YOGURT_ICQ', 'ICQ');
define('_MD_YOGURT_AIM', 'AIM');
define('_MD_YOGURT_YIM', 'YIM');
define('_MD_YOGURT_MSNM', 'MSNM');
define('_MD_YOGURT_LOCATION', 'Ort enth&auml;lt');
define('_MD_YOGURT_OCCUPATION', 'T&auml;tigkeit enth&auml;lt');
define('_MD_YOGURT_INTEREST', 'Interessen enth&auml;lt');
define('_MD_YOGURT_URLC', 'URL enth&auml;lt');
define('_MD_YOGURT_LASTLOGMORE', "Letzter Login vor mehr als <span style='color:#ff0000;'>X</span> Tagen");
define('_MD_YOGURT_LASTLOGLESS', "Letzter Login vor weniger als <span style='color:#ff0000;'>X</span> Tagen");
define('_MD_YOGURT_REGMORE', "Beitritt vor mehr als <span style='color:#ff0000;'>X</span> Tagen");
define('_MD_YOGURT_REGLESS', "Beitritt vor weniger als <span style='color:#ff0000;'>X</span> Tagen");
define('_MD_YOGURT_POSTSMORE', "Anzahl Beitr&auml;ge h&ouml;her als <span style='color:#ff0000;'>X</span>");
define('_MD_YOGURT_POSTSLESS', "Anzahl Beitr&auml;ge weniger als <span style='color:#ff0000;'>X</span>");
define('_MD_YOGURT_SORT', 'Sortiere nach');
define('_MD_YOGURT_ORDER', 'Reihenfolge');
define('_MD_YOGURT_LASTLOGIN', 'Letzter Login');
define('_MD_YOGURT_POSTS', 'Anzahl Beitr&auml;ge');
define('_MD_YOGURT_ASC', 'Aufsteigend');
define('_MD_YOGURT_DESC', 'Absteigend');
define('_MD_YOGURT_LIMIT', 'Anzahl Mitglieder je Seite');
define('_MD_YOGURT_RESULTS', 'Suchergebnis');

//26/10/2007
define('_MD_YOGURT_VIDEOSNOTENABLED', 'Die Video-Funktion ist im Moment deaktiviert');
define('_MD_YOGURT_FRIENDSNOTENABLED', 'Die Freunde-Funktion ist im Moment deaktiviert');
define('_MD_YOGURT_GROUPSNOTENABLED', 'Die Gruppen-Funktion ist im Moment deaktiviert');
define('_MD_YOGURT_PICTURESNOTENABLED', 'Die Bilder-Funktion ist im Moment deaktiviert');
define('_MD_YOGURT_NOTESNOTENABLED', 'Die G&auml;stebuch-Funktion ist im Moment deaktiviert');

//26/01/2008
define('_MD_YOGURT_ALLFRIENDS', 'Zeige alle Freunde');
define('_MD_YOGURT_ALLGROUPS', 'Zeige alle Gruppen');

//31/01/2008
define('_MD_YOGURT_FRIENDSHIPNOTACCEPTED', 'Freundschaft abgelehnt');

//07/04/2008
define('_MD_YOGURT_USERDOESNTEXIST', 'Dieses Mitglied existiert nicht oder wurde gel&ouml;scht!');
define('_MD_YOGURT_FANSTITLE', "%s's Fans");
define('_MD_YOGURT_NOFANSYET', 'Keine Fans bis jetzt');

//17/04/2008
define('_MD_YOGURT_AUDIONOTENABLED', 'Die Audio-Funktion ist im Moment deaktiviert');
define('_MD_YOGURT_NOAUDIOYET', 'Noch keine Audio-Dateien vorhanden');
define('_MD_YOGURT_AUDIOS', 'Audio');
define('_MD_YOGURT_CONFIGSAUDIOS', 'Zeige deine Audio-Dateien');
define('_MD_YOGURT_UPLOADEDAUDIO', 'MP3-Datei hochgeladen');

define('_MD_YOGURT_SELECTAUDIO', 'Durchsuche deine MP3s');
define('_MD_YOGURT_AUTHORAUDIO', 'Interpret');
define('_MD_YOGURT_TITLEAUDIO', 'Titel oder Songname');
define('_MD_YOGURT_ADDAUDIO', 'F&uuml;ge eine MP3-Datei hinzu');
define('_MD_YOGURT_SUBMITAUDIO', 'Datei hochgeladen');
define('_MD_YOGURT_ADDAUDIOHELP', 'W&auml;hle eine MP3-Datei von deinem Rechner (max. %s KBytes)<br> Lasse die Felder Titel/Songname und Interpret frei, wenn ID-Tags vorhanden sind');

//19/04/2008
define('_MD_YOGURT_AUDIODELETED', 'Dein MP3 wurde gel&ouml;scht!');
define('_MD_YOGURT_ASKCONFIRMAUDIODELETION', 'Willst Du die Audio-Datei wirklich l&ouml;schen?');
define('_MD_YOGURT_CONFIRMAUDIODELETION', 'Ja, bitte l&ouml;schen!');

define('_MD_YOGURT_META', 'Metainfo/ID-Tags');
define('_MD_YOGURT_META_TITLE', 'Titel');
define('_MD_YOGURT_META_ALBUM', 'Album');
define('_MD_YOGURT_META_ARTIST', 'Interpret');
define('_MD_YOGURT_META_YEAR', 'Jahr');

// v3.3RC2
define('_MD_YOGURT_PLAYER', 'Deine Wiedergabeliste');
