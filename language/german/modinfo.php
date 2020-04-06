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
define('_MI_YOGURT_NUMBPICT_TITLE', 'Anzahl Bilder');
define('_MI_YOGURT_NUMBPICT_DESC', 'Anzahl Bilder, die ein User in seinem Album haben darf');
define('_MI_YOGURT_ADMENU1', 'Startseite');
define('_MI_YOGURT_ADMENU2', '&Uuml;ber');
define('_MI_YOGURT_SMNAME1', 'Absenden');
define('_MI_YOGURT_THUMW_TITLE', 'Miniaturansicht Breite');
define('_MI_YOGURT_THUMBW_DESC', 'Miniaturansicht Breite in Pixel.<br>Die Miniaturansichten werden auf diese Breite reduziert,<br>Proportionen bleiben erhalten');
define('_MI_YOGURT_THUMBH_TITLE', 'Miniaturansicht H&ouml;he');
define('_MI_YOGURT_THUMBH_DESC', 'Miniaturansicht H&ouml;he in Pixel.<br>Die Miniaturansichten werden auf diese H&ouml;he reduziert,<br>Proportionen bleiben erhalten');
define('_MI_YOGURT_RESIZEDW_TITLE', 'Angepasste Bilder Breite');
define('_MI_YOGURT_RESIZEDW_DESC', 'Maximale Breite der Bilder in Pixel.<br>Proportionen bleiben erhalten.<br>Ist das Original Bild breiter, wird es reduziert.<br>Dadurch wird Ihre Layout nicht zerst&ouml;rt.');
define('_MI_YOGURT_RESIZEDH_TITLE', 'Angepasste Bilder H&ouml;he');
define('_MI_YOGURT_RESIZEDH_DESC', 'Maximale H&ouml;he Ihrer Bilder in Pixel.<br>Proportionen bleiben erhalten.<br>Ist das Original Bild h&ouml;her, wird es reduziert.<br>Dadurch wird Ihre Layout nicht zerst&ouml;rt.');
define('_MI_YOGURT_ORIGINALW_TITLE', 'Maximale Breite der Originalbilder');
define('_MI_YOGURT_ORIGINALW_DESC', 'Maximale Breite des Originalbildes in Pixel.<br>Bei &Uuml;berschreiten ist ein Hochladen nicht m&ouml;glich.');
define('_MI_YOGURT_ORIGINALH_TITLE', 'Maximale H&ouml;he der Originalbilder');
define('_MI_YOGURT_ORIGINALH_DESC', 'Maximale H&ouml;he des Originalbildes in Pixel.<br>Bei &Uuml;berschreiten ist ein Hochladen nicht m&ouml;glich.');
define('_MI_YOGURT_PATHUPLOAD_TITLE', 'Upload-Pfad');
define('_MI_YOGURT_PATHUPLOAD_DESC', 'Pfad zum Upload-Verzeichnis<br>in Linux zB.: /var/www/uploads<br>in Windows zB.: C:/Programme/www');
define('_MI_YOGURT_LINKPATHUPLOAD_TITLE', 'Link zu Ihrem Upload-Verzeichnis');
define('_MI_YOGURT_LINKPATHUPLOAD_DESC', 'Adresse zum Root-Pfad des Upload-Verzeichnis<br>zB.: http://www.yoursite.com/uploads');
define('_MI_YOGURT_MAXFILEBYTES_TITLE', 'Maximale Dateigr&ouml;&szlig;e in bytes');
define('_MI_YOGURT_MAXFILEBYTES_DESC', 'Maximale Dateigr&ouml;&szlig;e von Bildern<br>Angabe in bytes, zB.: 512000 for 500 KB<br>Wert kann nicht gr&ouml;&szlig;er sein als in der PHP.INI des Servers.<br>Der Server akzeptiert maximal ' . ini_get('post_max_size'));

define('_MI_YOGURT_PICTURE_NOTIFYTIT', 'Album');
define('_MI_YOGURT_PICTURE_NOTIFYDSC', 'Benachrichtigungen bezogen auf das User-Album');
define('_MI_YOGURT_PICTURE_NEWPIC_NOTIFY', 'Neues Bild');
define('_MI_YOGURT_PICTURE_NEWPIC_NOTIFYCAP', 'Benachrichtigung bei neuem Bild dieses Users');
define('_MI_YOGURT_PICTURE_NEWPOST_NOTIFYDSC', 'Benachrichtigung, wenn dieser User ein neues Bild einsendet');
define('_MI_YOGURT_PICTURE_NEWPIC_NOTIFYSBJ', '{X_OWNER_NAME} hat ein neues Bild in sein Album eingef&uuml;gt');
//define("_MI_YOGURT_HOTTEST","Begehrteste Alben");
//define("_MI_YOGURT_HOTTEST_DESC","Dieser Block zeigt die begehrtesten Alben");
//define("_MI_YOGURT_HOTFRIENDS","Begehrteste Freunde");
//define("_MI_YOGURT_HOTFRIENDS_DESC","Dieser Block zeit Benutzern begehrteste Freunde, die hinzugef&uuml;gt wurden");
define('_MI_YOGURT_PICTURE_TEMPLATEINDEXDESC', 'Diese Vorlage zeigt das Profil des Users');
define('_MI_YOGURT_PICTURE_TEMPLATEFRIENDSDESC', 'Diese Vorlage zeigt die Freunde des Users');
define('_MI_YOGURT_MYFRIENDS', 'Meine Freunde');
define('_MI_YOGURT_FRIENDSPERPAGE_TITLE', 'Freunde je Seite');
define('_MI_YOGURT_FRIENDSPERPAGE_DESC', "Anzahl der Freunde, die je Seite angezeigt werden<br>in der 'Meine Freunde' Seite");
define('_MI_YOGURT_PICTURESPERPAGE_TITLE', 'Bilder je Seite vor Seitenumbruch');

define('_MI_YOGURT_LAST', 'Letzte Bilder-Block');
define('_MI_YOGURT_LAST_DESC', 'Letze, eingesendete Bilder unabh&auml;ngig vom Album');
define('_MI_YOGURT_DELETEPHYSICAL_TITLE', 'Dateien auch aus dem Upload-Verzeichnis l&ouml;schen');
define(
    '_MI_YOGURT_DELETEPHYSICAL_DESC',
    "Best&auml;tigen Sie hier mit 'Ja' erlaubt dem Skript, Dateien sowohl vom Upload-Verzeichnis als auch aus der Datenbank zu l&ouml;schen.<br>Vorsicht mit dieser Funktion. Entfernen Sie die Datei auch aus dem Verzeichnis und nicht nur aus der Datenbank, k&ouml;nnen User, die direkt auf dieses Bild von einem anderen Teil dieser Seite verlinken, Ihren Inhalt verlieren;<br>andererseits ben&ouml;tigen Sie m&ouml;glicherweise sehr viel Platz auf dem Server.<br>Konfigurieren Sie diese Funktion mit Bedacht f&uuml;r Ihre Bed&uuml;rfnisse."
);

define('_MI_YOGURT_MYVIDEOS', 'Meine Videos');
define('_MI_YOGURT_PICTURE_TEMPLATEALBUMDESC', 'Vorlage f&uuml;r die Bildergallerie');
define('_MI_YOGURT_MYPICTURES', 'Meine Bilder');
define('_MI_YOGURT_MODULEDESC', 'Dieses Modul simuliert ein soziales Netzwerk wie MySpace oder Facebook.');
define('_MI_YOGURT_TUBEW_TITLE', 'Breite von YouTube-Videos');
define('_MI_YOGURT_TUBEW_DESC', 'Breite in Pixel f&uuml;r den YouTube-Videoplayer');
define('_MI_YOGURT_TUBEH_TITLE', 'H&ouml;he von YouTube-Videos');
define('_MI_YOGURT_TUBEH_DESC', 'H&ouml;he in Pixel f&uuml;r den YouTube-Videoplayer');
define('_MI_YOGURT_PICTURE_TEMPLATENOTEBOOKDESC', 'Vorlage f&uuml;r das G&auml;stebuch');
define('_MI_YOGURT_PICTURE_TEMPLATESEUTUBODESC', 'Vorlage f&uuml;r die Video-Sektion');
define('_MI_YOGURT_PICTURE_TEMPLATEGROUPSDESC', 'Vorlage f&uuml;r die Gruppen');
define('_MI_YOGURT_MYNOTES', 'Mein G&auml;stebuch');
define('_MI_YOGURT_MYGROUPS', 'Meine Gruppen');
define('_MI_YOGURT_TEMPLATENAVBARDESC', 'Vorlage f&uuml;r die obere Navigationsleiste, die in allen Seiten verwendet wird');

define('_MI_YOGURT_VIDEOSPERPAGE_TITLE', 'Videos je Seite');
define('_MI_YOGURT_VIDEO_NOTIFYTIT', 'Videos');
define('_MI_YOGURT_VIDEO_NOTIFYDSC', 'Video-Benachrichtigung');
define('_MI_YOGURT_VIDEO_NEWVIDEO_NOTIFY', 'Neues Video');
define('_MI_YOGURT_VIDEO_NEWVIDEO_NOTIFYCAP', 'Benachrichtige mich, wenn dieser User ein neues Video einsendet');
define('_MI_YOGURT_VIDEO_NEWVIDEO_NOTIFYDSC', 'Benachrichtigt den User &uuml;ber neue Videos');
define('_MI_YOGURT_VIDEO_NEWVIDEO_NOTIFYSBJ', '{X_OWNER_NAME} hat eine neues Video in seinem Profil eingesendet');

define('_MI_YOGURT_NOTE_NOTIFYTIT', 'G&auml;stebuch');
define('_MI_YOGURT_NOTE_NOTIFYDSC', 'G&auml;stebuch-Benachrichtigungen');
define('_MI_YOGURT_NOTE_NEWNOTE_NOTIFY', 'Neuer G&auml;stebucheintrag');
define('_MI_YOGURT_NOTE_NEWNOTE_NOTIFYCAP', 'Benachrichtige mich, wenn ein neuer Eintrag in diesem G&auml;stebuch erstellt wurde');
define('_MI_YOGURT_NOTE_NEWNOTE_NOTIFYDSC', 'Benachrichtigt den User &uuml;ber neue G&auml;stebucheintr&auml;ge');
define('_MI_YOGURT_NOTE_NEWNOTE_NOTIFYSBJ', '{X_OWNER_NAME} hat einen Eintrag im G&auml;stebuch erhalten');

define('_MI_YOGURT_MAINTUBEW_TITLE', 'Hauptvideo Breite');
define('_MI_YOGURT_MAINTUBEW_DESC', 'Breite des Videos, welches in der Startseite des Moduls gezeigt wird');
define('_MI_YOGURT_MAINTUBEH_TITLE', 'Hauptvideo H&ouml;he');
define('_MI_YOGURT_MAINTUBEH_DESC', 'H&ouml;he des Videos, welches in der Startseite des Moduls gezeigt wird');

//24/09/2007
define('_MI_YOGURT_MYCONFIGS', 'Meine Einstellungen');
define('_MI_YOGURT_PICTURE_TEMPLATECONFIGSDESC', 'Vorlage Einstellungen f&uuml;r den User');
define('_MI_YOGURT_PICTURE_TEMPLATEFOOTERDESC', 'Vorlage f&uuml;r den Footer des Moduls');
define('_MI_YOGURT_PICTURE_TEMPLATEEDITGROUP', 'Vorlage f&uuml;r die Attribute der Gruppenseite');
define('_MI_YOGURT_LICENSE', 'Creative Commons Lizenz - Version 2.5 Brazil Lizenz');

//19/10/2007
define('_MI_YOGURT_GROUPSPERPAGE_TITLE', 'Gruppen je Seite');
define('_MI_YOGURT_GROUPSPERPAGE_DESC', 'Gruppen je Seite vor Seitenumruch');
define('_MI_YOGURT_PICTURE_TEMPLATESEARCHRESULTDESC', 'Diese Vorlage zeigt das Ergebnis einer Suche nach Gruppen');
define('_MI_YOGURT_PICTURE_TEMPLATEGROUPDESC', 'Diese Vorlage zeigt eine Gruppe und seine Mitglieder');

//22/10/2007
define('_MI_YOGURT_MYPROFILE', 'Mein Profil');
define('_MI_YOGURT_SEARCH', 'Suche Mitglieder');
define('_MI_YOGURT_PICTURE_TEMPLATESEARCHRESULTSDESC', 'Vorlage f&uuml;r die Suchergebnisse');
define('_MI_YOGURT_PICTURE_TEMPLATESEARCHFORMDESC', 'Vorlage f&uuml;r das Suchformular');

//26/10/2007
define('_MI_YOGURT_ENABLEPICT_TITLE', 'Aktiviere Bilder-Sektion');
define('_MI_YOGURT_ENABLEPICT_DESC', 'Das Aktivieren der Bildergallerie erm&ouml;glicht den Usern den Upload von Bildern');
define('_MI_YOGURT_ENABLEFRIENDS_TITLE', 'Aktiviere Freunde-Sektion');
define('_MI_YOGURT_ENABLEFRIENDS_DESC', 'Das Aktivieren der Freunde-Sektion erm&ouml;glicht den Usern Freundschaften zu schlie&szlig;en und Freunde zu bewerten');
define('_MI_YOGURT_ENABLEVIDEOS_TITLE', 'Aktiviere Video-Sektion');
define('_MI_YOGURT_ENABLEVIDEOS_DESC', 'Das Aktivieren der Videogallerie erm&ouml;glicht den Usern ein Verlinken von Videos in ihrem Profil');
define('_MI_YOGURT_ENABLENOTES_TITLE', 'Aktiviere G&auml;stebuch-Sektion');
define('_MI_YOGURT_ENABLENOTES_DESC', "Das Aktivieren der G&auml;stebuchfunktion erm&ouml;glicht Usern, Nachrichten bei anderen Usern zu hinterlassen. Diese Funktion ist wie die 'Wall' bei Facebook ");
define('_MI_YOGURT_ENABLEGROUPS_TITLE', 'Aktiviere Gruppen-Sektion');
define('_MI_YOGURT_ENABLEGROUPS_DESC', 'Das Aktivieren dieser Funktion erm&ouml;glicht das Anlegen von Gruppen, die die Interessen von Usern wiedergeben');
define('_MI_YOGURT_NOTESPERPAGE_TITLE', 'Anzahl G&auml;stebucheintr&auml;ge je Seite');
define('_MI_YOGURT_NOTESPERPAGE_DESC', 'Anzahl G&auml;stebucheintr&auml;ge, bevor die Seitennavigation angezeigt wird');

//25/11/2007
define('_MI_YOGURT_FRIENDS', 'Meine Freunde');
define('_MI_YOGURT_FRIENDS_DESC', 'Dieser Block zeigt die Freunde eines Users');

//26/01/2008
define('_MI_YOGURT_IMGORDER_TITLE', 'Bilder-Verzeichnis');
define('_MI_YOGURT_IMGORDER_DESC', 'Zeige neueste Bilder zuerst?');

//08/04/2008
define('_MI_YOGURT_PICTURE_TEMPLATENOTIFICATIONS', 'Vorlage f&uuml;r die Benachrichtigungen');

//11/04/2008
define('_MI_YOGURT_FRIENDSHIP_NOTIFYTIT', 'Freunde');
define('_MI_YOGURT_FRIENDSHIP_NOTIFYDSC', 'Freundschaftsanfragen');
define('_MI_YOGURT_FRIEND_NEWPETITION_NOTIFY', 'Anfrage');
define('_MI_YOGURT_FRIEND_NEWPETITION_NOTIFYCAP', 'Benachrichtige mich bei neuen Freundschaftsanfragen');
define('_MI_YOGURT_FRIEND_NEWPETITION_NOTIFYDSC', 'Benachrichtige mich bei neuen Freundschaftsanfragen');
define('_MI_YOGURT_FRIEND_NEWPETITION_NOTIFYSBJ', 'Jemand hat eine Freundschaftsanfrage an Dich gestellt');

//13/04/2008
define('_MI_YOGURT_PICTURE_TEMPLATEFANS', 'Vorlage f&uuml;r die Fan-Seite');

//17/07/2008
define('_MI_YOGURT_ENABLEAUDIO_TITLE', 'Aktivierte die Audio-Sektion');
define('_MI_YOGURT_ENABLEAUDIO_DESC', 'Das Aktivieren der Audio-Sektion erm&ouml;glichts den Usern das Einstellen und Hochladen eigener Playlists');
define('_MI_YOGURT_PICTURE_TEMPLATEAUDIODESC', 'Vorlage f&uuml;r die Autio-Sektion');
define('_MI_YOGURT_NUMBAUDIO_TITLE', 'Maximale Audio-Dateien die ein User haben darf');
define('_MI_YOGURT_AUDIOSPERPAGE_TITLE', 'Anzahl der Audio-Dateien pro Seite vor Seitenumbruch');

//19/04/2008
define('_MI_YOGURT_MYAUDIOS', 'Meine Audios');
