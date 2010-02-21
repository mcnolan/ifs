/********************************************************************************
*	HVMenu variables for Mambo Open Source Administration	         	*
*	(C) Emir Sakic <saka@hotmail.com>		          		*		
*********************************************************************************/

	var NoOffFirstLineMenus=5;			// Number of first level items
	var LowBgColor='';			// Background color when mouse is not over
	var LowSubBgColor='#999999';			// Background color when mouse is not over on subs
	var HighBgColor='';			// Background color when mouse is over
	var HighSubBgColor='#666666';			// Background color when mouse is over on subs
	var FontLowColor='white';			// Font color when mouse is not over
	var FontSubLowColor='white';			// Font color subs when mouse is not over
	var FontHighColor='#ccff00';			// Font color when mouse is over
	var FontSubHighColor='#ccff00';		// Font color subs when mouse is over
	var BorderColor='';			// Border color
	var BorderSubColor='#000000';			// Border color for subs
	var BorderWidth=1;				// Border width
	var BorderBtwnElmnts=0;				// Border between elements 1 or 0
	var FontFamily="Arial, Helvetic,sans-serif"	// Font family menu items
	var FontSize=9;					// Font size menu items
	var FontBold=1;					// Bold menu items 1 or 0
	var FontItalic=0;					// Italic menu items 1 or 0
	var MenuTextCentered='left';			// Item text position 'left', 'center' or 'right'
	var MenuCentered='left';			// Menu horizontal position 'left', 'center' or 'right'
	var MenuVerticalCentered='top';		// Menu vertical position 'top', 'middle','bottom' or static
	var ChildOverlap=.1;				// horizontal overlap child/ parent
	var ChildVerticalOverlap=.5;			// vertical overlap child/ parent
	var StartTop=0;					// Menu offset x coordinate
	var StartLeft=5;					// Menu offset y coordinate
	var VerCorrect=0;					// Multiple frames y correction
	var HorCorrect=0;					// Multiple frames x correction
	var LeftPaddng=5;					// Left padding
	var TopPaddng=1;					// Top padding
	var FirstLineHorizontal=1;			// SET TO 1 FOR HORIZONTAL MENU, 0 FOR VERTICAL
	var MenuFramesVertical=1;			// Frames in cols or rows 1 or 0
	var DissapearDelay=1000;			// delay before menu folds in
	var TakeOverBgColor=1;				// Menu frame takes over background color subitem frame
	var FirstLineFrame='navig';			// Frame where first level appears
	var SecLineFrame='space';			// Frame where sub levels appear
	var DocTargetFrame='space';			// Frame where target documents appear
	var TargetLoc='';					// span id for relative positioning
	var HideTop=0;					// Hide first level when loading new document 1 or 0
	var MenuWrap=1;					// enables/ disables menu wrap 1 or 0
	var RightToLeft=0;				// enables/ disables right to left unfold 1 or 0
	var UnfoldsOnClick=0;				// Level 1 unfolds onclick/ onmouseover
	var WebMasterCheck=0;				// menu tree checking on or off 1 or 0
	var ShowArrow=1;					// Uses arrow gifs when 1
	var KeepHilite=1;					// Keep selected path highligthed
	var Arrws=['../images/admin/tri.gif',5,10,'../images/admin/tridown.gif',10,5,'../images/admin/trileft.gif',5,10];	// Arrow source, width and height

function BeforeStart(){return}
function AfterBuild(){return}
function BeforeFirstOpen(){return}
function AfterCloseAll(){return}


// Menu tree
//	MenuX=new Array(Text to show, Link, background image (optional), number of sub elements, height, width);
//	For rollover images set "Text to show" to:  "rollover:Image1.jpg:Image2.jpg"

Menu1=new Array("Main","","",14,17,80);
	Menu1_1=new Array("Articles","","",2,20,120);	
		Menu1_1_1=new Array("Edit/View Articles","index2.php?option=Articles","",0,20,150);
		Menu1_1_2=new Array("Edit/View Categories","index2.php?option=Articles&act=categories","",0);
	Menu1_2=new Array("Banners","","",2);
		Menu1_2_1=new Array("Active Banners","index2.php?option=Current","",0,20,150);
		Menu1_2_2=new Array("Edit/View Clients","index2.php?option=Clients","",0);
	Menu1_3=new Array("FAQ's","","",2);
		Menu1_3_1=new Array("Edit/View FAQ's","index2.php?option=Faq","",0,20,150);
		Menu1_3_2=new Array("Edit/View Categories","index2.php?option=Faq&act=categories","",0);
/*	Menu1_4=new Array("Forum","","",2);
		Menu1_4_1=new Array("View Threads","index2.php?option=Forums&act=threads","",0,20,120);
		Menu1_4_2=new Array("View Forums","index2.php?option=Forums","",0);
*/
	Menu1_4=new Array("Main Menu","","",2);
		Menu1_4_1=new Array("Top Sections","index2.php?option=MenuSections","",0,20,120);
		Menu1_4_2=new Array("Sub Sections","index2.php?option=SubSections","",0);
	Menu1_5=new Array("News","","",2);
		Menu1_5_1=new Array("Edit/View News","index2.php?option=News","",0,20,150);
		Menu1_5_2=new Array("Edit/View Categories","index2.php?option=News&act=categories","",0);
	Menu1_6=new Array("Web Links","","",2);
		Menu1_6_1=new Array("Edit/View Web Links","index2.php?option=Weblinks","",0,20,150);
		Menu1_6_2=new Array("Edit/View Categories","index2.php?option=Weblinks&act=categories","",0);
	Menu1_7=new Array("Page Modules","","",2);
		Menu1_7_1=new Array("Edit/View Modules","index2.php?option=Components","",0,20,150);
		Menu1_7_2=new Array("Install Custom","javascript:window.open('module_installer.php', '','width=400, height=400,toolbars=no,scrollbars=yes')","",0);
	Menu1_8=new Array("News Feeds","index2.php?option=newsfeeds","",0);
	Menu1_9=new Array("News Flash","index2.php?option=Newsflash","",0);
	Menu1_10=new Array("Survey/Polls","index2.php?option=Survey","",0);
	Menu1_11=new Array("Contact Details","index2.php?option=contact","",0);
	Menu1_12=new Array("Gallery","javascript:OnClick=window.open('gallery/gallery.php', '', 'height=500, toolbars=no, scrollbars=yes')","",0);
	Menu1_13=new Array("Theme Manager","index2.php?option=systemInfo","",0);
	Menu1_14=new Array("Site Preview","javascript:OnClick=window.open('../index.php', '', 'height=500, toolbars=no, scrollbars=yes')","",0);

Menu2=new Array("System","","",3);
	Menu2_1=new Array("Site Statistics","","",2,20,150);	
		Menu2_1_1=new Array("Web Browser","index2.php?option=statistics&task=browser","",0,20,120);
		Menu2_1_2=new Array("Operating System","index2.php?option=statistics&task=os","",0);
	Menu2_2=new Array("Top 10","","",2);
		Menu2_2_1=new Array("News Stories", "index2.php?option=top10&task=news","",0,20,120);
		Menu2_2_2=new Array("Articles", "index2.php?option=top10&task=articles","",0);
	Menu2_3=new Array("Launch phpMyAdmin","index2.php?option=phpMyAdmin","",0);


Menu3=new Array("Users","","",2);
	Menu3_1=new Array("Edit/View Administrators","index2.php?option=Administrators","",0,20,170);
	Menu3_2=new Array("Edit/View Users","index2.php?option=Users","",0);

Menu4=new Array("Help","","",2);
	Menu4_1=new Array("About","javascript:window.open('about.php', '','width=380, height=380,toolbars=no,scrollbars=no')","",0,20,120);
	Menu4_2=new Array("PHP Information","javascript:window.open('phpinfo.php', '', 'height=500, toolbars=no, scrollbars=yes')","",0);
Menu5=new Array("Logout","logout.php","",0);
