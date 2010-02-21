	/**	
	 *	Mambo Site Server Open Source Edition Version 3.0.7
	 *	Dynamic portal server and Content managment engine
	 *	27-11-2002
 	 *
	 *	Copyright (C) 2000 - 2001 Miro Contruct Pty Ltd
	 *	Distributed under the terms of the GNU General Public License
	 *	This software may be used without warrany provided these statements are left 
	 *	intact and a "Powered By Mambo" appears at the bottom of each HTML page.
	 *	This code is Available at http://sourceforge.net/projects/mambo
	 *
	 *	Site Name: Mambo Site Server Open Source Edition Version 3.0.7
	 *	File Name: adminjavascript.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27/11/2002 
	 * 	Version #: 3.0.7
	 *	Comments:
	**/

function isChecked(isitchecked){
	if (isitchecked == true){
		document.adminForm.boxchecked.value++;
		}
	else {
		document.adminForm.boxchecked.value--;
		}
	}

function submitbutton(pressbutton, section){
	switch (section){
		case "articles":
			if ((document.adminForm.mytitle.value == "") || (document.adminForm.category.options.value == "") || (document.adminForm.content.value == "")){
				alert("Articles must have a title, category and content");
				}
			else {
				submitform(pressbutton);
				}
		break;
		case "category":
			if (document.adminForm.categoryname.value == ""){
				alert("Category must have a name");
				}
			else {
				submitform(pressbutton);
				}
		break;
		case "bannerscurrent":
			if ((document.adminForm.bname.value == "") || (document.adminForm.clientid.options.value == "") || ((document.adminForm.imptotal.value == "") && (document.adminForm.unlimited.checked == false)) || (document.adminForm.imageurl.options.value == "") || (document.adminForm.clickurl.value == "")){
				alert("All fields must be filled in");
				}
			else {
				submitform(pressbutton);
				}
		break;
		case "bannersclient":
			if ((document.adminForm.cname.value == "") || (document.adminForm.contact.value == "") || (document.adminForm.email.value == "")){
				alert("Banner client must have a client name, contact name and contact email");
				}
			else {
				submitform(pressbutton);
				}
		break;
		case "faq":
			if ((document.adminForm.mytitle.value == "") || (document.adminForm.category.options.value == "") || (document.adminForm.content.value == "")){
				alert("Faq's must have a title, category and content");
				}
			else {
				submitform(pressbutton);
				}
		break;
		case "topsection":
			if (pressbutton == "savenewType"){
				if (document.adminForm.pagecontent.value == ""){
					alert("Page must have some content");
				}else {
					pressbutton = "savenew";
					submitform(pressbutton);
				}
			}else if (pressbutton == "savenewLink"){
				if (document.adminForm.userfile.value == ""){
					alert("You must choose a file to upload");
				}else {
					pressbutton = "savenew";
					submitform(pressbutton);
				}
			}else if (pressbutton == "savenewMambo"){
				if (document.adminForm.moduleID.options.value == ""){
					alert("You must choose a module to use");
				}else {
					pressbutton = "savenew";
					submitform(pressbutton);
				}
			}else if (pressbutton == "savenewWeb"){
				if (document.adminForm.Weblink.value == ""){
					alert("Page must have a link");
				}else {
					pressbutton = "savenew";
					submitform(pressbutton);
				}
			}else if (pressbutton == "saveeditType"){
				if ((document.adminForm.pagecontent.value == "") || (document.adminForm.ItemName.value == "")){
					alert("Page must have a name and content");
				}else {
					pressbutton = "saveedit";
					submitform(pressbutton);
				}	
			}else if (pressbutton == "saveeditLink"){
				if ((document.adminForm.ItemName.value == "") || (document.adminForm.filecontent.value == "")){
					alert("Page must have a name and content");
				}else {
					pressbutton = "saveedit";
					submitform(pressbutton);
				}
			}else if (pressbutton == "saveeditMambo"){
				if ((document.adminForm.moduleID.options.value == "") || (document.adminForm.ItemName.value == "")){
					alert("Page must have a name and mambo module.");
				}else {
					pressbutton = "saveedit";
					submitform(pressbutton);
				}
			}else if (pressbutton == "saveeditWeb"){
				if ((document.adminForm.Weblink.value == "") || (document.adminForm.ItemName.value == "")){
					alert("Page must have a name and link");
				}else {
					pressbutton = "saveedit";
					submitform(pressbutton);
				}
			}
		break;
		case "subsections":
			if (pressbutton == "savenewType"){
				if (document.adminForm.pagecontent.value == ""){
					alert("Page must have some content");
				}else {
					pressbutton = "savenew";
					submitform(pressbutton);
				}
			}else if (pressbutton == "savenewLink"){
				if (document.adminForm.userfile.value == ""){
					alert("You must choose a file to upload");
				}else {
					pressbutton = "savenew";
					submitform(pressbutton);
				}
			}else if (pressbutton == "savenewMambo"){
				if (document.adminForm.moduleID.options.value == ""){
					alert("You must choose a module to use");
				}else {
					pressbutton = "savenew";
					submitform(pressbutton);
				}
			}else if (pressbutton == "savenewWeb"){
				if (document.adminForm.Weblink.value == ""){
					alert("Page must have a link");
				}else {
					pressbutton = "savenew";
					submitform(pressbutton);
				}
			}else if (pressbutton == "saveeditType"){
				if ((document.adminForm.pagecontent.value == "") || (document.adminForm.ItemName.value == "")){
					alert("Page must have a name and content");
				}else {
					pressbutton = "saveedit";
					submitform(pressbutton);
				}	
			}else if (pressbutton == "saveeditLink"){
				if ((document.adminForm.ItemName.value == "") || (document.adminForm.filecontent.value == "")){
					alert("Page must have a name and content");
				}else {
					pressbutton = "saveedit";
					submitform(pressbutton);
				}
			}else if (pressbutton == "saveeditMambo"){
				if ((document.adminForm.moduleID.options.value == "") || (document.adminForm.ItemName.value == "")){
					alert("Page must have a name and mambo module.");
				}else {
					pressbutton = "saveedit";
					submitform(pressbutton);
				}
			}else if (pressbutton == "saveeditWeb"){
				if ((document.adminForm.Weblink.value == "") || (document.adminForm.ItemName.value == "")){
					alert("Page must have a name and link");
				}else {
					pressbutton = "saveedit";
					submitform(pressbutton);
				}
			}
		break;
		case "news":
			//if ((document.adminForm.mytitle.value == "") || (document.adminForm.newstopic.options.value == "") || (document.adminForm.introtext.value == "") || (document.adminForm.fultext.value == "") || (document.adminForm.image.options.value == "")){
			if ((document.adminForm.mytitle.value == "") || (document.adminForm.newstopic.options.value == "") || (document.adminForm.introtext.value == "")){
				alert("News story must have a title, category and introduction");
				}
			else {
				submitform(pressbutton);
				}
		break;
		case "newsflash":
			var contentlength=document.adminForm.content.value;
			if ((document.adminForm.flashtitle.value == "") || (contentlength == "")) {
				alert("Please fill in all fields");
				}
			else {
				contentlength=contentlength.length;
				if (contentlength > 600){
					alert("Content is " + contentlength + " characters long. Max allowed is 600 characters");
				}else{
					submitform(pressbutton);
				}
			}
		break;
		case "pagemodule":
				if (document.adminForm.mytitle.value == ""){
				alert("Page module must have a title");
				}
			else {
				submitform(pressbutton);
				}
		break;
		case "survey":
			if ((document.adminForm.mytitle.value == "") ||  (document.adminForm.menu.options.value == "") || (document.adminForm.textfieldcheck.value == 0)){
				alert("Survey must have a page, title and options");
				}
			else {
				submitform(pressbutton);
				}
		break;
		case "weblinks":
			if ((document.adminForm.mytitle.value == "") || (document.adminForm.url.value == "") || (document.adminForm.category.options.value == "")){
				alert("Web link must have a title and url");
				}
			else {
				submitform(pressbutton);
				}
		break;
		case "contact":
			if ((document.adminForm.companyname.value == "") ||  (document.adminForm.email.value == "")){
				alert ("Please fill out company name and email");
				}
			else {
				submitbutton(pressbutton);
				}
			break;
		case "newsfeeds":
			if ((document.adminForm.num.value == 0) || (document.adminForm.num.value == "")){
				alert("Must enter number of articles to fetch for each newsfeeds");
				}
			else {
				submitform(pressbutton);
				}
			break;
		case "Administrators":
			if ((document.adminForm.realname.value == "") || (document.adminForm.email.value == "") || (document.adminForm.username.value == "")){
				alert("Administrators must have name, email and username.");
				} 
			else {
				submitform(pressbutton);
				}
		break;
		case "Users":
			if ((document.adminForm.realname.value == "") || (document.adminForm.username.value=="") || (document.adminForm.email.value == "")){
				alert ("Users must have a name, email and username.");
				}
			else {
				submitform(pressbutton);
				}
			break;
		case "Forums":
			if ((document.adminForm.forumName.value == "") || (document.adminForm.description.value == "") || (document.adminForm.moderatorID.options.value == "")){
				alert("Forums must have a title, description and moderator");
			}else {
				submitform(pressbutton);
			}
		break;
		case "threads":
			if ((document.adminForm.subject.value == "") || (document.adminForm.content.value == "") || (document.adminForm.author.value =="")){
				alert("Messages must have a title, author and content");
			}else {
				submitform(pressbutton);
			}
		break;
		default:
			submitform(pressbutton);
		}	
	}
	
function submitform(pressbutton){
	document.adminForm.task.value=pressbutton; 
	document.adminForm.action='index2.php'; 
	document.adminForm.submit();
	}

// Getting radio button that is selected.
function getSelected(allbuttons){
    for (i=0;i<allbuttons.length;i++) {
	    if (allbuttons[i].checked) {
    		return allbuttons[i].value
    		}
    	}
    }
