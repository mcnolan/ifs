<?php
/***
  * INTEGRATED FLEET MANAGEMENT SYSTEM
  * OBSIDIAN FLEET
  * http://www.obsidianfleet.net/ifs/
  *
  * Developer:	Frank Anon
  * 	    	fanon@obsidianfleet.net
  *
  * Version:	1.11
  * Release Date: June 3, 2004
  *
  * Copyright (C) 2003-2004 Frank Anon for Obsidian Fleet RPG
  * Distributed under the terms of the GNU General Public License
  * See doc/LICENSE for details
  *
  * Date:	6/03/04
  * Comments: Install file
  *
 ***/

if(isset($output)) { $_POST['doinstall'] = 'go'; }

if ( !$_POST['doinstall'] )
{
	echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>";
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	    "DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
	<title>Obsidian Fleet IFS : INSTALL</title>
	</head>

	<body bgcolor="#000000" text="#CCCCCC">
	<font size="+2"><b><u>Manually Install IFS</u></b></font>

    <p>Before you run the install script, be sure to read doc/install.txt and
    set up your configuration.php file first!</p>

    <p>When you have read the documentation and set up your configuration.php
    file, click the button below...</p>

    <form action="" method="post">
    <input type="hidden" name="doinstall" value="go" />
    <input type="submit" value="Install" />
    </form>

    <?php
}

else
{

    require ("configuration.php");
    mysql_connect($host, $user, $password)
        or die("Cannot connect to database!  Check your configuration.php");
    mysql_select_db ($db);

	$qry = "

    CREATE TABLE `{$spre}acad_courses` (
      `course` tinyint(4) NOT NULL default '0',
      `section` tinyint(4) NOT NULL default '0',
      `name` tinytext NOT NULL,
      `descrip` text NOT NULL,
      `pass` tinyint(4) NOT NULL default '0',
      `coord` tinytext NOT NULL,
      `active` char(1) NOT NULL default ''
    ) TYPE=MyISAM PACK_KEYS=0;

    CREATE TABLE `{$spre}acad_instructors` (
      `id` int(11) NOT NULL auto_increment,
      `pid` int(11) NOT NULL default '0',
      `cid` int(11) NOT NULL default '0',
      `course` tinyint(4) NOT NULL default '0',
      `active` char(1) NOT NULL default '',
      PRIMARY KEY  (`id`)
    ) TYPE=MyISAM;

    CREATE TABLE `{$spre}acad_marks` (
      `id` int(11) NOT NULL auto_increment,
      `date` text NOT NULL,
      `sid` int(11) NOT NULL default '0',
      `section` tinyint(4) NOT NULL default '0',
      `secname` tinytext NOT NULL,
      `grade` tinyint(4) NOT NULL default '0',
      `comments` text NOT NULL,
      `name` tinytext NOT NULL,
      KEY `id` (`id`)
    ) TYPE=MyISAM;

    CREATE TABLE `{$spre}acad_students` (
      `id` int(11) NOT NULL auto_increment,
      `pid` int(11) NOT NULL default '0',
      `cid` int(11) NOT NULL default '0',
      `course` tinyint(4) NOT NULL default '0',
      `inst` tinytext NOT NULL,
      `status` char(1) NOT NULL default '',
      `sdate` tinytext NOT NULL,
      `edate` tinytext NOT NULL,
      KEY `id` (`id`)
    ) TYPE=MyISAM;

	CREATE TABLE `{$spre}apps` (
	  `id` int(11) NOT NULL auto_increment,
	  `type` varchar(4) NOT NULL default '',
	  `date` tinytext NOT NULL,
	  `app` longtext NOT NULL,
	  `forward` text NOT NULL,
	  `ip` varchar(15) NOT NULL default '',
	  KEY `id` (`id`)
	) TYPE=MyISAM;

    CREATE TABLE `{$spre}awardees` (
      `id` int(11) NOT NULL auto_increment,
      `date` tinytext NOT NULL,
      `award` int(11) NOT NULL default '0',
      `recipient` int(11) NOT NULL default '0',
      `player` int(11) NOT NULL default '0',
      `rank` int(11) NOT NULL default '0',
      `ship` int(11) NOT NULL default '0',
      `reason` text NOT NULL,
      `nominator` tinytext NOT NULL,
      `nemail` tinytext NOT NULL,
      `approved` char(1) NOT NULL default '',
      KEY `id` (`id`)
    ) TYPE=MyISAM;

    CREATE TABLE `{$spre}awards` (
      `id` int(11) NOT NULL auto_increment,
      `name` tinytext NOT NULL,
      `level` tinyint(4) NOT NULL default '0',
      `type` char(1) NOT NULL default '',
      `active` char(1) NOT NULL default '',
      `image` tinytext NOT NULL,
      `intro` tinytext NOT NULL,
      `descrip` text NOT NULL,
      KEY `id` (`id`)
    ) TYPE=MyISAM;

	CREATE TABLE `{$spre}banex` (
	  `id` int(11) NOT NULL auto_increment,
	  `name` varchar(20) NOT NULL default '',
	  `code` text NOT NULL,
	  `published` char(1) NOT NULL default '',
	  KEY `id` (`id`)
	) TYPE=MyISAM;

	CREATE TABLE `{$spre}banlist` (
	  `id` int(11) NOT NULL auto_increment,
	  `date` tinytext NOT NULL,
	  `auth` tinytext NOT NULL,
	  `reason` text NOT NULL,
	  `alias` int(11) NOT NULL default '0',
	  `email` tinytext NOT NULL,
	  `ip` varchar(15) NOT NULL default '',
	  `active` char(1) NOT NULL default '',
	  `expire` tinytext NOT NULL,
	  `level` varchar(7) NOT NULL default '',
	  KEY `id` (`id`)
	) TYPE=MyISAM;

	CREATE TABLE `{$spre}characters` (
	  `id` int(11) NOT NULL auto_increment,
	  `name` varchar(60) NOT NULL default '',
	  `race` tinytext NOT NULL,
	  `gender` varchar(10) NOT NULL default '',
	  `rank` int(4) NOT NULL default '0',
	  `ship` int(11) NOT NULL default '0',
	  `pos` tinytext NOT NULL,
	  `player` int(11) NOT NULL default '0',
	  `bio` text NOT NULL,
	  `app` int(11) NOT NULL default '0',
	  `other` text NOT NULL,
	  `pending` char(1) NOT NULL default '0',
	  `ptime` tinytext NOT NULL,
	  PRIMARY KEY  (`id`)
	) TYPE=MyISAM;

	CREATE TABLE `{$spre}flags` (
	  `flag` char(1) NOT NULL default '',
	  `name` tinytext NOT NULL,
	  `admin` int(1) NOT NULL default '0',
	  `ordering` tinyint(4) NOT NULL default '0'
	) TYPE=MyISAM;

    INSERT INTO `{$spre}flags` VALUES ('a', 'Triad', 1, 9);
    INSERT INTO `{$spre}flags` VALUES ('c', 'Commanding Officer', 0, 1);
	INSERT INTO `{$spre}flags` VALUES ('o', 'Fleet Chief Ops', 1, 3);
	INSERT INTO `{$spre}flags` VALUES ('p', 'Office of Personnel Management', 1, 5);
	INSERT INTO `{$spre}flags` VALUES ('t', 'Task Force CO', 1, 2);
	INSERT INTO `{$spre}flags` VALUES ('j', 'Judge Advocate General', 1, 6);
	INSERT INTO `{$spre}flags` VALUES ('r', 'R & D', 1, 8);
    INSERT INTO `{$spre}flags` VALUES ('w', 'Awards Director', 0, 8);
    INSERT INTO `{$spre}flags` VALUES ('g', 'Task Group CO', 0, 3);
    INSERT INTO `{$spre}flags` VALUES ('d', 'Academy', 1, 10);

	CREATE TABLE `{$spre}logs` (
	  `date` tinytext NOT NULL,
	  `user` tinytext NOT NULL,
	  `action` text NOT NULL,
	  `comments` text NOT NULL
	) TYPE=MyISAM;

	CREATE TABLE `{$spre}positions` (
	  `ship` tinyint(4) NOT NULL default '0',
	  `action` char(3) NOT NULL default '',
	  `pos` tinytext NOT NULL
	) TYPE=MyISAM;

	CREATE TABLE `{$spre}rank` (
	  `rankid` int(11) NOT NULL auto_increment,
	  `rankdesc` text NOT NULL,
	  `image` text NOT NULL,
	  `color` text NOT NULL,
	  `level` int(2) NOT NULL default '0',
	  PRIMARY KEY  (`rankid`)
	) TYPE=MyISAM;

	CREATE TABLE `{$spre}record` (
	  `id` int(11) NOT NULL auto_increment,
	  `pid` int(11) NOT NULL default '0',
	  `cid` int(11) NOT NULL default '0',
	  `level` tinytext NOT NULL,
	  `date` int(11) NOT NULL default '0',
	  `entry` tinytext NOT NULL,
	  `details` text NOT NULL,
	  `name` tinytext NOT NULL,
	  `admin` char(1) NOT NULL default '',
	  KEY `id` (`id`)
	) TYPE=MyISAM;

	CREATE TABLE `{$spre}reports` (
	  `id` int(11) NOT NULL auto_increment,
	  `date` tinytext NOT NULL,
	  `ship` int(11) NOT NULL default '0',
	  `co` tinytext NOT NULL,
	  `url` varchar(100) NOT NULL default '',
	  `status` text NOT NULL,
	  `crew` tinyint(4) NOT NULL default '0',
	  `crewlist` text NOT NULL,
	  `mission` tinytext NOT NULL,
	  `missdesc` tinytext NOT NULL,
	  `improvement` tinytext NOT NULL,
	  `comments` tinytext NOT NULL,
	  PRIMARY KEY  (`id`)
	) TYPE=MyISAM;

	CREATE TABLE `{$spre}ships` (
	  `id` int(11) NOT NULL auto_increment,
	  `name` varchar(225) NOT NULL default '',
	  `registry` varchar(20) NOT NULL default '',
	  `class` varchar(30) NOT NULL default '',
	  `website` varchar(150) NOT NULL default '',
	  `co` int(11) NOT NULL default '0',
	  `xo` int(11) NOT NULL default '0',
	  `tf` tinyint(2) NOT NULL default '0',
	  `tg` tinyint(2) NOT NULL default '0',
	  `status` varchar(50) NOT NULL default '',
	  `image` varchar(100) NOT NULL default '',
	  `sorder` int(11) unsigned NOT NULL default '0',
	  `report` text NOT NULL,
	  `description` varchar(250) NOT NULL default '',
	  `format` tinytext NOT NULL,
	  PRIMARY KEY  (`id`)
	) TYPE=MyISAM AUTO_INCREMENT=5;

    INSERT INTO `{$spre}ships` VALUES (1, 'Unassigned Characters', '', '', '', 0, 0, 99, 3, '', '', 1, '', '', '');
	INSERT INTO `{$spre}ships` VALUES (2, 'Transferred Characters', '', '', '', 0, 0, 99, 3, '', '', 0, '', '', '');
	INSERT INTO `{$spre}ships` VALUES (3, 'Deleted Characters', '', '', '', 0, 0, 99, 3, '', '', 0, '', '', '');
	INSERT INTO `{$spre}ships` VALUES (4, 'FSS Rule 10 Characters', '', '', '', 0, 0, 99, 3, '', '', 0, '', '', '');

	CREATE TABLE `{$spre}taskforces` (
	  `tf` int(2) NOT NULL default '0',
	  `tg` tinyint(1) NOT NULL default '0',
	  `name` varchar(30) NOT NULL default '',
	  `co` int(11) NOT NULL default '0',
	  `jag` tinytext NOT NULL
	) TYPE=MyISAM;

    INSERT INTO `{$spre}taskforces` VALUES (99, 0, 'Admin', 0, '');
    INSERT INTO `{$spre}taskforces` VALUES (99, 1, 'Queue', 0, '');
    INSERT INTO `{$spre}taskforces` VALUES (99, 2, 'Mothball', 0, '');
    INSERT INTO `{$spre}taskforces` VALUES (99, 3, 'Admin', 0, '');

	CREATE TABLE `{$spre}tfreports` (
	  `id` int(11) NOT NULL auto_increment,
	  `date` tinytext NOT NULL,
	  `tf` int(11) NOT NULL default '0',
	  `co` tinytext NOT NULL,
	  `ships` tinyint(4) NOT NULL default '0',
	  `cos` tinyint(4) NOT NULL default '0',
	  `active` tinyint(4) NOT NULL default '0',
	  `inactive` tinyint(4) NOT NULL default '0',
	  `open` tinyint(4) NOT NULL default '0',
	  `characters` int(11) NOT NULL default '0',
	  `avgchar` tinytext NOT NULL,
	  `promotions` text NOT NULL,
	  `newco` text NOT NULL,
	  `resigned` text NOT NULL,
	  `webupdates` text NOT NULL,
	  `notes` text NOT NULL,
	  KEY `id` (`id`)
	) TYPE=MyISAM;

	CREATE TABLE `{$mpre}articles` (
	  `artid` int(11) NOT NULL auto_increment,
	  `secid` int(11) NOT NULL default '0',
	  `title` text NOT NULL,
	  `userID` int(11) NOT NULL default '0',
	  `author` varchar(50) default NULL,
	  `content` text NOT NULL,
	  `date` date NOT NULL default '0000-00-00',
	  `counter` int(11) NOT NULL default '0',
	  `approved` tinyint(4) NOT NULL default '0',
	  `archived` int(11) NOT NULL default '0',
	  `ordering` int(11) NOT NULL default '0',
	  `checked_out` int(11) NOT NULL default '0',
	  `checked_out_time` time NOT NULL default '00:00:00',
	  `editor` varchar(50) default NULL,
	  `published` int(11) NOT NULL default '0',
	  `indent` tinyint(4) NOT NULL default '0',
	  PRIMARY KEY  (`artid`)
	) TYPE=MyISAM;

	CREATE TABLE `{$mpre}banner` (
	  `bid` int(11) NOT NULL auto_increment,
	  `cid` int(11) NOT NULL default '0',
	  `name` varchar(50) NOT NULL default '',
	  `imptotal` int(11) NOT NULL default '0',
	  `impmade` int(11) NOT NULL default '0',
	  `clicks` int(11) NOT NULL default '0',
	  `imageurl` varchar(100) NOT NULL default '',
	  `clickurl` varchar(200) NOT NULL default '',
	  `date` datetime default NULL,
	  `showBanner` tinyint(11) NOT NULL default '0',
	  `checked_out` tinyint(4) default NULL,
	  `checked_out_time` time default NULL,
	  `editor` varchar(50) default NULL,
	  PRIMARY KEY  (`bid`)
	) TYPE=MyISAM;

	CREATE TABLE `{$mpre}bannerclient` (
	  `cid` int(11) NOT NULL auto_increment,
	  `name` varchar(60) NOT NULL default '',
	  `contact` varchar(60) NOT NULL default '',
	  `email` varchar(60) NOT NULL default '',
	  `extrainfo` text NOT NULL,
	  `checked_out` tinyint(4) default NULL,
	  `checked_out_time` time default NULL,
	  `editor` varchar(50) default NULL,
	  PRIMARY KEY  (`cid`)
	) TYPE=MyISAM;

	CREATE TABLE `{$mpre}bannerfinish` (
	  `bid` int(11) NOT NULL auto_increment,
	  `cid` int(11) NOT NULL default '0',
	  `name` varchar(50) NOT NULL default '',
	  `impressions` int(11) NOT NULL default '0',
	  `clicks` int(11) NOT NULL default '0',
	  `imageurl` varchar(50) NOT NULL default '',
	  `datestart` datetime default NULL,
	  `dateend` datetime default NULL,
	  PRIMARY KEY  (`bid`)
	) TYPE=MyISAM;

	CREATE TABLE `{$mpre}categories` (
	  `categoryid` int(11) NOT NULL auto_increment,
	  `categoryname` text NOT NULL,
	  `categoryimage` varchar(50) default NULL,
	  `section` varchar(20) NOT NULL default '',
	  `image_position` varchar(20) default NULL,
	  `published` int(11) NOT NULL default '0',
	  `checked_out` int(11) NOT NULL default '0',
	  `checked_out_time` time NOT NULL default '00:00:00',
	  `editor` varchar(50) default NULL,
	  `ordering` int(11) NOT NULL default '0',
	  PRIMARY KEY  (`categoryid`),
	  UNIQUE KEY `categoryid` (`categoryid`),
	  KEY `categoryid_2` (`categoryid`)
	) TYPE=MyISAM AUTO_INCREMENT=2;

    INSERT INTO `{$mpre}categories` VALUES (1, 'Fleet News', NULL, 'News', NULL, 1, 0, '00:00:00', NULL, 0);

	CREATE TABLE `{$mpre}component_module` (
	  `id` int(4) NOT NULL auto_increment,
	  `content` text NOT NULL,
	  `componentid` int(4) NOT NULL default '0',
	  PRIMARY KEY  (`id`)
	) TYPE=MyISAM;

	CREATE TABLE `{$mpre}components` (
	  `id` int(11) NOT NULL auto_increment,
	  `title` text NOT NULL,
	  `ordering` tinyint(4) NOT NULL default '0',
	  `position` varchar(10) default NULL,
	  `checked_out` int(11) NOT NULL default '0',
	  `checked_out_time` time default NULL,
	  `publish` int(11) NOT NULL default '0',
	  `editor` varchar(50) default NULL,
	  `module` varchar(50) default NULL,
	  `numnews` int(11) NOT NULL default '0',
	  PRIMARY KEY  (`id`)
	) TYPE=MyISAM AUTO_INCREMENT=12;

    INSERT INTO `{$mpre}components` VALUES (1, 'Login', 2, 'right', 0, '00:00:00', 1, NULL, 'login', 0);
	INSERT INTO `{$mpre}components` VALUES (2, 'Surveys/Polls', 4, 'right', 0, '00:00:00', 1, NULL, 'survey', 0);
	INSERT INTO `{$mpre}components` VALUES (3, 'User Menu', 0, 'right', 0, '00:00:00', 1, NULL, 'usermenu', 0);
	INSERT INTO `{$mpre}components` VALUES (4, 'Todays\' Newsfeeds', 0, 'right', 0, '00:00:00', 0, NULL, 'newsfeeds', 3);
	INSERT INTO `{$mpre}components` VALUES (5, 'Past News', 2, 'right', 0, '00:00:00', 0, NULL, 'newsarchive', 0);
	INSERT INTO `{$mpre}components` VALUES (7, 'Past Articles', 5, 'right', 0, '00:00:00', 0, NULL, 'articlearchive', 0);
	INSERT INTO `{$mpre}components` VALUES (8, 'Who\'s online', 2, 'left', 0, '18:38:43', 1, NULL, 'whos_online', 0);
	INSERT INTO `{$mpre}components` VALUES (10, 'Today\'s Birthdays', 3, 'left', 0, '14:08:12', 1, NULL, 'birthday', 0);
	INSERT INTO `{$mpre}components` VALUES (11, 'Search', 1, 'left', 0, '14:08:12', 0, NULL, 'search', 0);

	CREATE TABLE `{$mpre}counter` (
	  `id` int(11) NOT NULL auto_increment,
	  `type` varchar(25) NOT NULL default '',
	  `name` varchar(50) NOT NULL default '',
	  `count` bigint(20) NOT NULL default '0',
	  PRIMARY KEY  (`id`)
	) TYPE=MyISAM AUTO_INCREMENT=10;

    INSERT INTO `{$mpre}counter` VALUES (1, 'browser', 'Netscape', 0);
	INSERT INTO `{$mpre}counter` VALUES (3, 'browser', 'Unknown', 0);
	INSERT INTO `{$mpre}counter` VALUES (2, 'browser', 'MSIE', 0);
	INSERT INTO `{$mpre}counter` VALUES (4, 'OS', 'Windows', 0);
	INSERT INTO `{$mpre}counter` VALUES (5, 'OS', 'Mac', 0);
	INSERT INTO `{$mpre}counter` VALUES (6, 'OS', 'Unknown', 0);
	INSERT INTO `{$mpre}counter` VALUES (7, 'OS', 'Linux', 0);
	INSERT INTO `{$mpre}counter` VALUES (8, 'OS', 'FreeBSD', 0);
	INSERT INTO `{$mpre}counter` VALUES (9, 'browser', 'Lynx', 0);

	CREATE TABLE `{$mpre}faqcont` (
	  `artid` int(11) NOT NULL auto_increment,
	  `faqid` int(11) NOT NULL default '0',
	  `title` text NOT NULL,
	  `content` text NOT NULL,
	  `counter` int(11) NOT NULL default '0',
	  `published` int(11) NOT NULL default '0',
	  `checked_out` int(11) NOT NULL default '0',
	  `checked_out_time` time NOT NULL default '00:00:00',
	  `editor` varchar(50) NOT NULL default '',
	  `archived` int(11) NOT NULL default '0',
	  `ordering` int(11) default NULL,
	  `approved` tinyint(4) default '1',
	  PRIMARY KEY  (`artid`)
	) TYPE=MyISAM;

	CREATE TABLE `{$mpre}links` (
	  `lid` int(11) NOT NULL auto_increment,
	  `cid` int(11) NOT NULL default '0',
	  `sid` int(11) NOT NULL default '0',
	  `title` varchar(100) NOT NULL default '',
	  `url` varchar(100) NOT NULL default '',
	  `date` datetime default NULL,
	  `hits` int(11) NOT NULL default '0',
	  `published` int(11) NOT NULL default '0',
	  `checked_out` tinyint(4) NOT NULL default '0',
	  `checked_out_time` time NOT NULL default '00:00:00',
	  `editor` varchar(50) NOT NULL default '',
	  `ordering` int(11) NOT NULL default '0',
	  `archived` int(11) NOT NULL default '0',
	  `approved` tinyint(4) default '1',
	  `ip` tinytext NOT NULL,
	  PRIMARY KEY  (`lid`)
	) TYPE=MyISAM;

	CREATE TABLE `{$mpre}mambo_modules` (
	  `moduleid` int(11) NOT NULL auto_increment,
	  `modulename` varchar(50) NOT NULL default '',
	  `modulelink` varchar(50) default NULL,
	  `menuid` int(4) default NULL,
	  PRIMARY KEY  (`moduleid`)
	) TYPE=MyISAM AUTO_INCREMENT=7;

    INSERT INTO `{$mpre}mambo_modules` VALUES (1, 'Story', 'index.php', 1);
	INSERT INTO `{$mpre}mambo_modules` VALUES (2, 'Stories List', 'index.php?option=news', 2);
	INSERT INTO `{$mpre}mambo_modules` VALUES (3, 'Articles', 'index.php?option=articles', 3);
	INSERT INTO `{$mpre}mambo_modules` VALUES (4, 'Web Links', 'index.php?option=weblinks', 4);
	INSERT INTO `{$mpre}mambo_modules` VALUES (5, 'FAQ', 'index.php?option=faq', 5);

	CREATE TABLE `{$mpre}menu` (
	  `id` int(11) NOT NULL auto_increment,
	  `menutype` tinytext,
	  `name` varchar(25) default NULL,
	  `link` text,
	  `contenttype` varchar(10) default NULL,
	  `inuse` tinyint(4) default '0',
	  `componentid` int(11) default NULL,
	  `sublevel` int(11) default '0',
	  `ordering` int(11) default '0',
	  `checked_out` tinyint(4) default NULL,
	  `checked_out_time` time default NULL,
	  `editor` varchar(50) default NULL,
	  `pollid` int(11) NOT NULL default '0',
	  `browserNav` tinyint(4) default '0',
	  PRIMARY KEY  (`id`),
	  UNIQUE KEY `id_2` (`id`),
	  KEY `id` (`id`)
	) TYPE=MyISAM AUTO_INCREMENT=1;

	INSERT INTO `{$mpre}menu` VALUES (NULL, 'mainmenu', 'News', 'index.php?option=news', 'mambo', 1, 0, 0, 7, 0, '00:00:00', NULL, 2, 0);
	INSERT INTO `{$mpre}menu` VALUES (NULL, 'mainmenu', 'Articles', 'index.php?option=articles', 'mambo', 1, 0, 0, 5, 0, '00:00:00', NULL, 0, 0);
	INSERT INTO `{$mpre}menu` VALUES (NULL, 'mainmenu', 'Web Links', 'index.php?option=weblinks', 'mambo', 1, 0, 0, 10, 0, '00:00:00', NULL, 0, 0);
	INSERT INTO `{$mpre}menu` VALUES (NULL, 'mainmenu', 'FAQ', 'index.php?option=faq', 'mambo', 1, 0, 0, 6, 0, '00:00:00', NULL, 0, 0);
	INSERT INTO `{$mpre}menu` VALUES (NULL, 'usermenu', 'Your Details', 'index.php?option=user~op=UserDetails', '', 0, 0, 0, 1, 0, '00:00:00', '', 0, 0);
	INSERT INTO `{$mpre}menu` VALUES (NULL, 'usermenu', 'Submit Article', 'index.php?option=user~op=UserArticle', '', 0, 0, 0, 3, 0, '00:00:00', '', 0, 0);
	INSERT INTO `{$mpre}menu` VALUES (NULL, 'usermenu', 'Logout', 'index.php?option=logout', '', 0, 0, 0, 6, 0, '00:00:00', '', 0, 0);
	INSERT INTO `{$mpre}menu` VALUES (NULL, 'usermenu', 'Submit FAQ', 'index.php?option=user~op=UserFAQ', '', 0, 0, 0, 4, 0, '00:00:00', '', 0, 0);
	INSERT INTO `{$mpre}menu` VALUES (NULL, 'usermenu', 'Submit Link', 'index.php?option=user~op=UserLink', '', 0, 0, 0, 5, 0, '00:00:00', '', 0, 0);
	INSERT INTO `{$mpre}menu` VALUES (NULL, 'usermenu', 'Submit News', 'index.php?option=user~op=UserNews', '', 0, 0, 0, 2, 0, '00:00:00', '', 0, 0);
	INSERT INTO `{$mpre}menu` VALUES (NULL, 'mainmenu', 'Join', 'index.php?option=app', 'mambo', 1, 0, 0, 4, 0, '00:00:00', NULL, 0, 0);
	INSERT INTO `{$mpre}menu` VALUES (NULL, 'Triad', 'Mambo Admin', 'administrator/', '', 0, 0, 0, 1, 0, '00:00:00', '', 0, 1);
	INSERT INTO `{$mpre}menu` VALUES (NULL, 'Commanding Officer', 'Update Manifest', 'index.php?option=ifs~task=co~action=view', '', 0, 0, 0, 1, 0, '00:00:00', '', 0, 1);
	INSERT INTO `{$mpre}menu` VALUES (NULL, 'Task Force CO', 'Ship Listings', 'index.php?option=ifs~task=tfco~action=listing', '', 0, 0, 0, 0, 0, '00:00:00', '', 0, 0);
	INSERT INTO `{$mpre}menu` VALUES (NULL, 'Office of Personnel Management', 'OPM Tools', 'index.php?option=ifs~task=opm~action=tools', '', 0, 0, 0, 0, 0, '00:00:00', '', 0, 0);
	INSERT INTO `{$mpre}menu` VALUES (NULL, 'Fleet Chief Ops', 'Ship Listing', 'index.php?option=ifs~task=fcops~action=listing', '', 0, 0, 0, 0, 0, '00:00:00', '', 0, 0);
	INSERT INTO `{$mpre}menu` VALUES (NULL, 'Fleet Chief Ops', 'FCOps Tools', 'index.php?option=ifs~task=fcops~action=tools', '', 0, 0, 0, 0, 0, '00:00:00', '', 0, 0);
	INSERT INTO `{$mpre}menu` VALUES (NULL, 'Office of Personnel Management', 'Ship Listing', 'index.php?option=ifs~task=opm~action=listing', '', 0, 0, 0, 0, 0, '00:00:00', '', 0, 0);
	INSERT INTO `{$mpre}menu` VALUES (NULL, 'mainmenu', 'Open Positions List', 'index.php?option=opl', 'web', 1, 0, 0, 3, 0, '00:00:00', NULL, 0, 1);
	INSERT INTO `{$mpre}menu` VALUES (NULL, 'Commanding Officer', 'Edit Positions', 'index.php?option=ifs~task=co~action=positions', '', 0, 0, 0, 1, 0, '00:00:00', '', 0, 1);
	INSERT INTO `{$mpre}menu` VALUES (NULL, 'Judge Advocate General', 'JAG Tools', 'index.php?option=ifs~task=jag', '', 0, 0, 0, 0, 0, '00:00:00', '', 0, 0);
	INSERT INTO `{$mpre}menu` VALUES (NULL, 'Commanding Officer', 'Monthly Report', 'index.php?option=ifs~task=co~action=report', '', 0, 0, 0, 1, 0, '00:00:00', '', 0, 1);
	INSERT INTO `{$mpre}menu` VALUES (NULL, 'Fleet Chief Ops', 'Fleet Stats', 'index.php?option=ifs~task=fcops~action=stats', '', 0, 0, 0, 0, 0, '00:00:00', '', 0, 0);
	INSERT INTO `{$mpre}menu` VALUES (NULL, 'Office of Personnel Management', 'Pending Characters', 'index.php?option=ifs~task=opm~action=pending', '', 0, 0, 0, 0, 0, '00:00:00', '', 0, 0);
	INSERT INTO `{$mpre}menu` VALUES (NULL, 'Task Force CO', 'TFCO Tools', 'index.php?option=ifs~task=tfco~action=tools', '', 0, 0, 0, 0, 0, '00:00:00', '', 0, 0);
	INSERT INTO `{$mpre}menu` VALUES (NULL, 'Judge Advocate General', 'Banlist Admin', 'index.php?option=ifs~task=jag~action=bans', '', 0, 0, 0, 0, 0, '00:00:00', '', 0, 0);
	INSERT INTO `{$mpre}menu` VALUES (NULL, 'Triad', 'Userlevels', 'index.php?option=ifs~task=admin~action=ulev', '', 0, 0, 0, 1, 0, '00:00:00', '', 0, 1);
	INSERT INTO `{$mpre}menu` VALUES (NULL, 'Task Force CO', 'Monthly Report', 'index.php?option=ifs~task=tfco~action=report', '', 0, 0, 0, 0, 0, '00:00:00', '', 0, 0);
    INSERT INTO `{$mpre}menu` VALUES (NULL, 'R & D', 'ShipDB Admin', 'index.php?option=ifs~task=rd', '', 0, 0, 0, 0, 0, '00:00:00', '', 0, 0);
    INSERT INTO `{$mpre}menu` VALUES (NULL, 'Awards Director', 'Awards Admin', 'index.php?option=ifs~task=awards~action=edit', '', 0, 0, 0, 0, 0, '00:00:00', '', 0, 0);
    INSERT INTO `{$mpre}menu` VALUES (NULL, 'Awards Director', 'Pending Awards', 'index.php?option=ifs~task=awards~action=pending', NULL, 0, NULL, 0, 0, NULL, NULL, NULL, 0, 0);
    INSERT INTO `{$mpre}menu` VALUES (NULL, 'Commanding Officer', 'Crew Awards', 'index.php?option=ifs~task=co~action=award', '', 0, 0, 0, 1, 0, '00:00:00', '', 0, 1);
    INSERT INTO `{$mpre}menu` VALUES (NULL, 'Task Force CO', 'TF Stats', 'index.php?option=ifs~task=tfco~action=stats', '', 0, 0, 0, 0, 0, '00:00:00', '', 0, 0);
    INSERT INTO `{$mpre}menu` VALUES (NULL, 'Awards Director', 'Grant an Award', 'index.php?option=ifs~task=awards~action=award', '', 0, 0, 0, 0, 0, '00:00:00', '', 0, 0);
    INSERT INTO `{$mpre}menu` VALUES (NULL, 'Task Group CO', 'Ship Listing', 'index.php?option=ifs~task=tgco~action=listing', NULL, 0, NULL, 0, 0, NULL, NULL, NULL, 0, 0);
    INSERT INTO `{$mpre}menu` VALUES (NULL, 'Task Group CO', 'TF Stats', 'index.php?option=ifs~task=tgco~action=stats', '', 0, 0, 0, 0, 0, '00:00:00', '', 0, 0);
    INSERT INTO `{$mpre}menu` VALUES (NULL, 'Academy', 'Academy Admin', 'index.php?option=ifs~task=academy~action=admin', '', 0, 0, 0, 0, 0, '00:00:00', '', 0, 0);
    INSERT INTO `{$mpre}menu` VALUES (NULL, 'Academy', 'Class List', 'index.php?option=ifs~task=academy~action=inst', '', 0, 0, 0, 0, 0, '00:00:00', '', 0, 0);
    INSERT INTO `{$mpre}menu` VALUES (NULL, 'Academy', 'Waiting List', 'index.php?option=ifs~task=academy~action=wait', '', 0, 0, 0, 0, 0, '00:00:00', '', 0, 0);
    INSERT INTO `{$mpre}menu` VALUES (NULL, 'Academy', 'Master List', 'index.php?option=ifs~task=academy~action=list', '', 0, 0, 0, 0, 0, '00:00:00', '', 0, 0);
    INSERT INTO `{$mpre}menu` VALUES (NULL, 'Commanding Officer', 'Academy', 'index.php?option=ifs~task=co~action=acad', '', 0, 0, 0, 0, 0, '00:00:00', '', 0, 0);
    INSERT INTO `{$mpre}menu` VALUES (NULL, 'Task Force CO', 'Academy', 'index.php?option=ifs~task=tfco~action=acad', '', 0, 0, 0, 0, 0, '00:00:00', '', 0, 0);
    INSERT INTO `{$mpre}menu` VALUES (NULL, 'Task Group CO', 'Academy', 'index.php?option=ifs~task=tgco~action=acad', '', 0, 0, 0, 0, 0, '00:00:00', '', 0, 0);
    INSERT INTO `{$mpre}menu` VALUES (NULL, 'mainmenu', 'Awards', 'index.php?option=ifs~task=common~action=common~lib=alist', 'mambo', 1, 0, 0, 8, 0, '00:00:00', NULL, 0, 1);
	INSERT INTO {$mpre}menu (id, menutype, name, link, contenttype, inuse, componentid, sublevel, ordering, checked_out, checked_out_time, editor, pollid, browserNav) VALUES (NULL, 'mainmenu', 'Ship Database', 'index.php?option=shipdb', 'web', 1, 0, 0, 9, NULL, NULL, NULL, 0, 1);
	INSERT INTO {$mpre}menu (id, menutype, name, link, contenttype, inuse, componentid, sublevel, ordering, checked_out, checked_out_time, editor, pollid, browserNav) VALUES (NULL, 'mainmenu', 'Home', 'index.php', 'web', 1, 0, 0, 1, 0, '00:00:00', NULL, 0, 1);
	INSERT INTO {$mpre}menu (id, menutype, name, link, contenttype, inuse, componentid, sublevel, ordering, checked_out, checked_out_time, editor, pollid, browserNav) VALUES (NULL, 'mainmenu', 'Ship Listing', 'index.php?option=ships', 'web', 1, 0, 0, 2, 0, '00:00:00', NULL, 0, 1);



	CREATE TABLE `{$mpre}menucontent` (
	  `mcid` int(11) NOT NULL auto_increment,
	  `menuid` int(11) NOT NULL default '0',
	  `content` text NOT NULL,
	  `heading` varchar(100) default NULL,
	  PRIMARY KEY  (`mcid`)
	) TYPE=MyISAM;

    INSERT INTO `{$mpre}menucontent` VALUES (1, 30, 'This is a menu sub-item.', 'Menu Item');

	CREATE TABLE `{$mpre}newsflash` (
	  `newsflashID` int(11) NOT NULL auto_increment,
	  `flashtitle` varchar(50) NOT NULL default '',
	  `flashcontent` text NOT NULL,
	  `showflash` tinyint(4) NOT NULL default '0',
	  `checked_out` tinyint(4) default NULL,
	  `checked_out_time` time default NULL,
	  `editor` varchar(50) default NULL,
	  PRIMARY KEY  (`newsflashID`)
	) TYPE=MyISAM AUTO_INCREMENT=2;

    INSERT INTO `{$mpre}newsflash` VALUES (1, 'Newflash', 'This is a newflash.', 1, NULL, NULL, NULL);

	CREATE TABLE `{$mpre}poll_data` (
	  `pollid` int(4) NOT NULL default '0',
	  `optionText` text NOT NULL,
	  `optionCount` int(11) NOT NULL default '0',
	  `voteid` int(11) NOT NULL default '0'
	) TYPE=MyISAM;

	CREATE TABLE `{$mpre}poll_date` (
	  `id` bigint(20) NOT NULL auto_increment,
	  `date` datetime NOT NULL default '0000-00-00 00:00:00',
	  `vote_id` int(11) NOT NULL default '0',
	  `poll_id` int(11) NOT NULL default '0',
	  `ip` varchar(15) NOT NULL default '',
	  PRIMARY KEY  (`id`),
	  UNIQUE KEY `id` (`id`),
	  KEY `ip` (`ip`)
	) TYPE=MyISAM;

	CREATE TABLE `{$mpre}poll_desc` (
	  `pollID` int(11) NOT NULL auto_increment,
	  `pollTitle` varchar(100) NOT NULL default '',
	  `voters` mediumint(9) NOT NULL default '0',
	  `checked_out` int(11) NOT NULL default '0',
	  `checked_out_time` time NOT NULL default '00:00:00',
	  `editor` varchar(50) default NULL,
	  `published` int(11) NOT NULL default '0',
	  PRIMARY KEY  (`pollID`)
	) TYPE=MyISAM;

	CREATE TABLE `{$mpre}poll_menu` (
	  `pollid` int(11) NOT NULL default '0',
	  `menuid` int(11) NOT NULL default '0',
	  PRIMARY KEY  (`pollid`,`menuid`)
	) TYPE=MyISAM;

	CREATE TABLE `{$mpre}queue` (
	  `qid` smallint(5) unsigned NOT NULL auto_increment,
	  `uid` mediumint(9) NOT NULL default '0',
	  `uname` varchar(40) NOT NULL default '',
	  `subject` varchar(100) NOT NULL default '',
	  `story` text,
	  `timestamp` datetime NOT NULL default '0000-00-00 00:00:00',
	  `topic` varchar(20) NOT NULL default '',
	  PRIMARY KEY  (`qid`)
	) TYPE=MyISAM;

	CREATE TABLE `{$mpre}session` (
	  `username` varchar(50) default NULL,
	  `time` varchar(14) default NULL,
	  `session_id` varchar(200) NOT NULL default '0',
	  `guest` tinyint(4) default '1',
	  `userid` int(11) default NULL,
	  `usertype` varchar(50) default NULL,
	  `ip` varchar(15) NOT NULL default '',
	  `remember` char(1) NOT NULL default '0',
	  `active` char(1) NOT NULL default '1',
	  `js` char(1) NOT NULL default '1',
	  PRIMARY KEY  (`session_id`)
	) TYPE=MyISAM;

	CREATE TABLE `{$mpre}stories` (
	  `sid` int(11) NOT NULL auto_increment,
	  `title` varchar(100) NOT NULL default '',
	  `time` datetime NOT NULL default '0000-00-00 00:00:00',
	  `introtext` text NOT NULL,
	  `fultext` text,
	  `counter` mediumint(8) unsigned default '0',
	  `topic` int(11) NOT NULL default '1',
	  `hits` int(11) default '0',
	  `archived` tinyint(4) default '0',
	  `newsimage` varchar(40) NOT NULL default '',
	  `published` int(11) default '0',
	  `checked_out` int(11) default '0',
	  `checked_out_time` time default NULL,
	  `editor` varchar(50) default NULL,
	  `image_position` varchar(10) NOT NULL default '',
	  `ordering` int(11) default '0',
	  `frontpage` int(11) default '0',
	  `approved` tinyint(4) default '1',
	  `ip` tinytext NOT NULL,
	  PRIMARY KEY  (`sid`)
	) TYPE=MyISAM AUTO_INCREMENT=2;

INSERT INTO `{$mpre}stories` ( `sid` , `title` , `time` , `introtext` , `fultext` , `counter` , `topic` , `hits` , `archived` , `newsimage` , `published` , `checked_out` , `checked_out_time` , `editor` , `image_position` , `ordering` , `frontpage` , `approved` , `ip` )
VALUES (
'', 'Welcome to Intergrated Fleet System', '2009-12-27 00:00:00', 'Congradulations! You have installed IFS. This news story is designed to help you get underway...', 'The good news is, if your looking at this news post, IFS was installed. So what next?<br><br> * Your first task should be to setup your fleet\'s organisational structure. Task Forces and Groups can be added from the Fleet Chief Ops menu under \"FCOps Tools\". Once those are setup, you can go about adding ships through the Task Force CO menu item \"TFCO Tools\". Note here you can also add Co\'s that have not applied through the join form, should you need to add existing Co\'s in your fleet. These created Co\'s can then be transfered to the correct vessel via the Office of Personnel Management menu option \"OPM Tools\" <br><br>* I have included a small list of ship classes to get you started, but sooner or later you will need to add some more. Note that you must have Starship Types (ie Starbase, Starship) in order to create Starship Categories (ie Crusier, Explorer) in order to create actual ship classes in these Categories. <br><br>* At some point you will need to upload a set of ranks into the images folder in order for IFS to use them. I have included support for the Kuro-Chan ranksets by default, so all you should have to do is upload the images into the correct folder (images/ranks) <br><br>* Should you require help, please use the OF Forum here : http://forums.obsidianfleet.net/viewforum.php?f=41 <br><br>This should cover the basic information you require. It may take some time to investigate all options at your disposal. <br><br>Good Luck!<br> ~Nolan', '0', '1', '0', '0', '', '1', '0', NULL , NULL , 'left', '1', '1', '1', ''
);
	CREATE TABLE `{$mpre}system` (
	  `id` int(11) NOT NULL default '0',
	  `sitename` varchar(50) NOT NULL default '',
	  `cur_theme` varchar(50) NOT NULL default '',
	  `col_main` char(1) NOT NULL default '1',
	  PRIMARY KEY  (`id`)
	) TYPE=MyISAM;

    INSERT INTO `{$mpre}system` VALUES (0, 'Default', 'default', '1');

	CREATE TABLE `{$mpre}users` (
	  `id` int(14) NOT NULL auto_increment,
	  `name` varchar(50) NOT NULL default '',
	  `username` varchar(25) NOT NULL default '',
	  `email` varchar(100) NOT NULL default '',
	  `password` varchar(100) NOT NULL default '',
	  `usertype` varchar(25) NOT NULL default '',
	  `flags` varchar(26) default NULL,
	  `mainchar` int(11) NOT NULL default '0',
	  `block` tinyint(4) NOT NULL default '0',
	  `sendEmail` tinyint(4) NOT NULL default '0',
	  `exp` tinytext NOT NULL,
	  `bday` varchar(4) NOT NULL default '',
	  `regdate` int(11) NOT NULL default '0',
	  PRIMARY KEY  (`id`)
	) TYPE=MyISAM PACK_KEYS=0 AUTO_INCREMENT=2;

    INSERT INTO `{$mpre}users` VALUES (1, 'Admin', 'admin', 'admin@domain.com', '21232f297a57a5a743894a0e4a801fc3', 'superadministrator', 'ACJOPRTW', 0, 0, 1, '', '', 0);

	CREATE TABLE `{$sdb}category` (
	  `id` int(11) NOT NULL auto_increment,
	  `name` tinytext NOT NULL,
	  `type` int(11) NOT NULL default '0',
	  `description` text NOT NULL,
	  KEY `id` (`id`)
	) TYPE=MyISAM;

	CREATE TABLE `{$sdb}classes` (
	  `id` int(11) NOT NULL auto_increment,
	  `name` tinytext NOT NULL,
	  `duration` smallint(4) NOT NULL default '0',
	  `resupply` smallint(4) NOT NULL default '0',
	  `refit` smallint(4) NOT NULL default '0',
	  `category` int(11) NOT NULL default '0',
	  `cruisevel` varchar(5) NOT NULL default '',
	  `maxvel` varchar(5) NOT NULL default '',
	  `emervel` varchar(5) NOT NULL default '',
	  `eveltime` char(3) NOT NULL default '',
	  `officers` mediumint(6) NOT NULL default '0',
	  `enlisted` mediumint(6) NOT NULL default '0',
	  `passengers` mediumint(6) NOT NULL default '0',
	  `marines` mediumint(6) NOT NULL default '0',
	  `evac` mediumint(6) NOT NULL default '0',
	  `shuttlebays` smallint(4) NOT NULL default '0',
	  `length` varchar(10) NOT NULL default '0',
	  `width` varchar(10) NOT NULL default '0',
	  `height` varchar(10) NOT NULL default '0',
	  `decks` smallint(6) NOT NULL default '0',
	  `notes` text NOT NULL,
	  `description` text NOT NULL,
	  `image` tinytext NOT NULL,
	  `active` char(1) NOT NULL default '1',
	  KEY `id` (`id`)
	) TYPE=MyISAM;

	CREATE TABLE `{$sdb}equip` (
	  `id` int(11) NOT NULL auto_increment,
	  `ship` int(11) NOT NULL default '0',
	  `type` char(1) NOT NULL default '',
	  `equipment` int(11) NOT NULL default '0',
	  `number` smallint(6) NOT NULL default '0',
	  `sort` int(11) NOT NULL default '0',
	  KEY `id` (`id`)
	) TYPE=MyISAM;

	CREATE TABLE `{$sdb}types` (
	  `id` int(11) NOT NULL auto_increment,
	  `type` tinytext NOT NULL,
	  `support` char(1) NOT NULL default '',
	  KEY `id` (`id`)
	) TYPE=MyISAM;

	CREATE TABLE `{$sdb}weapons` (
	  `id` int(11) NOT NULL auto_increment,
	  `sub` int(11) NOT NULL default '0',
	  `type` int(11) NOT NULL default '0',
	  `name` text NOT NULL,
	  `description` text NOT NULL,
	  `image` tinytext NOT NULL,
	  KEY `id` (`id`)
	) TYPE=MyISAM;

    CREATE TABLE `{$sdb}decks` (
      `ship` int(11) NOT NULL default '0',
      `deck` int(4) NOT NULL default '0',
      `descrip` text NOT NULL,
      KEY `ship_id_deckl` (`ship`)
    ) TYPE=MyISAM;

INSERT INTO {$sdb}types (id, type, support) VALUES (1, 'Starship', 'n');
INSERT INTO {$sdb}types (id, type, support) VALUES (2, 'Starbase', 'n');

INSERT INTO {$sdb}category (id, name, type, description) VALUES (1, 'Cruiser', 1, '');
INSERT INTO {$sdb}category (id, name, type, description) VALUES (2, 'Explorer', 1, '');
INSERT INTO {$sdb}category (id, name, type, description) VALUES (3, 'Escort', 1, '');
INSERT INTO {$sdb}category (id, name, type, description) VALUES (4, 'Docking Facility', 2, '');

INSERT INTO {$sdb}classes (id, name, duration, resupply, refit, category, cruisevel, maxvel, emervel, eveltime, officers, enlisted, passengers, marines, evac, shuttlebays, length, width, height, decks, notes, description, image, active) VALUES (1, 'Sovereign', 0, 0, 0, 2, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '', 0, '', '', '', '1');
INSERT INTO {$sdb}classes (id, name, duration, resupply, refit, category, cruisevel, maxvel, emervel, eveltime, officers, enlisted, passengers, marines, evac, shuttlebays, length, width, height, decks, notes, description, image, active) VALUES (2, 'Akira', 0, 0, 0, 1, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '', 0, '', '', '', '1');
INSERT INTO {$sdb}classes (id, name, duration, resupply, refit, category, cruisevel, maxvel, emervel, eveltime, officers, enlisted, passengers, marines, evac, shuttlebays, length, width, height, decks, notes, description, image, active) VALUES (3, 'Defiant', 0, 0, 0, 3, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '', 0, '', '', '', '1');
INSERT INTO {$sdb}classes (id, name, duration, resupply, refit, category, cruisevel, maxvel, emervel, eveltime, officers, enlisted, passengers, marines, evac, shuttlebays, length, width, height, decks, notes, description, image, active) VALUES (4, 'Galaxy', 0, 0, 0, 2, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '', 0, '', '', '', '1');
INSERT INTO {$sdb}classes (id, name, duration, resupply, refit, category, cruisevel, maxvel, emervel, eveltime, officers, enlisted, passengers, marines, evac, shuttlebays, length, width, height, decks, notes, description, image, active) VALUES (5, 'Intrepid', 0, 0, 0, 2, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '', 0, '', '', '', '1');
INSERT INTO {$sdb}classes (id, name, duration, resupply, refit, category, cruisevel, maxvel, emervel, eveltime, officers, enlisted, passengers, marines, evac, shuttlebays, length, width, height, decks, notes, description, image, active) VALUES (6, 'Nebula', 0, 0, 0, 2, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '', 0, '', '', '', '1');
INSERT INTO {$sdb}classes (id, name, duration, resupply, refit, category, cruisevel, maxvel, emervel, eveltime, officers, enlisted, passengers, marines, evac, shuttlebays, length, width, height, decks, notes, description, image, active) VALUES (7, 'Spacedock', 0, 0, 0, 4, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '', 0, '', '', '', '1');
INSERT INTO `{$spre}rank` VALUES (NULL, 'Rank Pending', 'ranks/w-blank1.png', '',0);
";
	$qry = trim($qry);

    do
    {
    	$pos = strpos($qry, ";");
        if ($pos === false)
        	$pos = strlen($qry);
    	$query = substr($qry, 0, $pos);
        $query = str_replace("~", "&amp;", $query);
        mysql_query($query);
        if ($pos != strlen($qry))
	        $qry = substr($qry, $pos+1);
    } while ($qry);

$types = array("Naval Gold","Marine");
$ranks = array("c0" => "Cadet 5th Class","c1" => "Cadet 4th Class","c2" => "Cadet 3rd Class","c3" => "Cadet 2nd Class","c4" => "Cadet 1st Class","e1" => "Crewman Recruit","e2" => "Crewman Apprentice","e3" => "Crewman","e4" => "Petty Officer 3rd Class","e5" => "Petty Officer 2nd Class","e6" => "Petty Officer 1st Class","e7" => "Chief Petty Officer","e8" => "Senior Chief Petty Officer","e9" => "Master Chief Petty Officer","e9a" => "Master Chief Petty Officer Of The Fleet","e9b" => "Master Chief Petty Officer Of Starfleet","w1" => "Warrant Officer","w2" => "Chief Warrant Officer","w3" => "Senior Chief Warrant Officer","w4" => "Master Chief Warrant Officer","o1" => "Ensign","o2" => "Lieutenant, Junior Grade","o3" => "Lieutenant","o4" => "Lieutenant Commander","o5" => "Commander","o6" => "Captain", "o7" => "Fleet Captain","a1" => "Commodore","a2" => "Rear Admiral","a3" => "Vice Admiral","a4" => "Admiral","a5" => "Fleet Admiral");
$ranksm = array("c0" => "Cadet 5th Class","c1" => "Cadet 4th Class","c2" => "Cadet 3rd Class","c3" => "Cadet 2nd Class","c4" => "Cadet 1st Class","e1" => "Private","e2" => "Private First Class","e3" => "Lance Corporal","e4" => "Corporal","e5" => "Sergeant","e6" => "Staff Sergeant","e7" => "Gunnery Sergeant","e8" => "Master Sergeant","e9" => "Sergeant Major","e9a" => "Command Sergeant Major","e9b" => "Sergeant Major of Starfleet","w1" => "Warrant Officer","w2" => "Chief Warrant Officer","w3" => "Senior Chief Warrant Officer","w4" => "Master Chief Warrant Officer","w5" => "Master Warrant Officer ","o1" => "Second Lieutenant","o2" => " First Lieutenant","o3" => "Captain","o4" => "Major","o5" => "Lieutenant Colonel","o6" => "Colonel","a1" => "Brigadier General","a2" => "Major General","a3" => "Lieutenant General","a4" => "General","a5" => "Field Marshal");
$colors = array("r" => "Red", "y" => "Yellow", "t" => "Teal", "b" => "Black", "l" => "Purple", "g" => "Green", "w" => "White");

//Generate Rank Set
foreach($types AS $type) {
	foreach($colors AS $color => $colorname) {
		$i = 1;
		if($type != "Marine") {
			foreach($ranks AS $rankpip => $rankname) {
				$querym = "INSERT INTO `{$spre}rank` VALUES (NULL, '".$rankname."', 'ranks/".$type."/".$color."-".$rankpip.".png', '".$colorname."', ".$i.")";
				mysql_query($querym);
				$i++;
			}
		} else {
			foreach($ranksm AS $rankpip => $rankname) {
				$queryn = "INSERT INTO `{$spre}rank` VALUES (NULL, '".$rankname."', 'ranks/".$type."/".$color."-".$rankpip.".png', 'Marine ".$colorname."', ".$i.")";
				mysql_query($queryn);
				$i++;
			}
		}
		$queryb = "INSERT INTO `{$spre}rank` VALUES (NULL, 'Blank', 'ranks/".$color."-blank1.png', '".$colorname."', 0)";
		mysql_query($queryb);
	}
}

    //Only show message if file run manually
    if(!isset($output)) { echo "Your mySQL database should be done installing!  Enjoy IFS!<br /><br />\n\n"; }
}
