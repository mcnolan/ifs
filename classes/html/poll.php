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
  * This file based on code from Mambo Site Server 4.0.12
  * Copyright (C) 2000 - 2002 Miro International Pty Ltd
  *
  * Date: 12/13/03
  * Comments: Display poll
 ***/

class poll
{
    function pollresult($pollTitle, $last_vote, $first_vote, $voters, $percentInt, $optionText, $count, $sum, $month, $pollID)
    {
        $months = array("January","Februrary","March","April","May","June","July","August","September","October","November","December");
        $months_num = array("01","02","03","04","05","06","07","08","09","10","11","12");
        ?>

	    <table cellpadding="0" cellspacing="0" border="0" width="100%">
	    <tr>
			<td class="articlehead" colspan="2" height="40">
            	&nbsp;&nbsp;Polls/Surveys - Results
            </td>
	    </tr>
	    <tr>
	    	<td align="right" width="181"><b>Survey Title:</b></td>
	    	<td width="606">
            	&nbsp;<?php echo $pollTitle ?>
	    	</td>
	    </tr>
	    <tr>
	    	<td align="right" width="181"><b>Number of voters:</b></td>
	    	<td width="606"> &nbsp;
	    		<?php echo $voters ?>
	    	</td>
	    </tr>
	    <tr>
	    	<td align="right" width="181"><b>First Vote:</b></td>
	    	<td width="606"> &nbsp;
	        	<?php echo $first_vote ?>
	    	</td>
	    </tr>
	    <tr>
			<td align="right" width="181"><b>Last Vote:</b></td>
	    	<td width="606"> &nbsp;
	    		<?php echo $last_vote ?>
	    	</td>
	    </tr>
	    <tr>
	    	<td colspan="3" align="center">
	    		<table width="100%" border="0" cellspacing="0" cellpadding="0">
	        	<tr>
	            	<td width="33%">&nbsp;</td>
		            <td width="26%" align="center">&nbsp;</td>
		            <td width="41%">&nbsp;</td>
				</tr>
	        	<tr>
	            	<td width="33%" height="30" align="right">Select a month:&nbsp; </td>
	            	<td width="26%" align="left" height="30">
	              		<select name="months" width="200" style="width:200px" onChange="document.location.href='index.php?option=surveyresult&task=Results&polls=<?php echo $pollID ?>&month=' + this.options[selectedIndex].value">
	                	<option value="">Show All Months</option>
	                	<?php
                        for ($i = 0; $i < count($months); $i++)
                        {
                            if ($month == $months_num[$i])
                            {
                                ?>
                                <option value="<?php echo $month ?>" selected="selected">
                                <?php echo $months[$i] ?>
                                </option>
                                <?php
                            }
                            else
                            {
                                ?>
                                <option value="<?php echo $months_num[$i] ?>">
                                <?php echo $months[$i] ?>
                                </option>
                                <?php
                            }
                        }
                        ?>
						</select>
	            	</td>
		            <td width="41%" height="30">&nbsp;</td>
				</tr>
	          	<tr>
	                <td width="33%">&nbsp;</td>
	                <td width="33%">
				    <table cellpadding="0" cellspacing="0" border="0" bgcolor="#000000" width="100%">
	                	<?php
                        if (count($percentInt) <> 0)
                        {
	                        for ($i = 0; $i < count($optionText); $i++)
                            {
	                            if ($percentInt[$i] <> "")
                                {
	                                $percentage = $count[$i]/$sum * 100;
	                                $percentage = round($percentage, 2);
	                                ?>
			                    	<tr>
			                        <td valign="top" height="40">
                                    	<img src="images/polls/Col<?php echo $i+1 ?>M.gif" width="<?php echo $percentInt[$i] ?>" height="15" vspace="5" hspace="0" /><img src="images/polls/Col<?php echo $i+1 ?>R.gif" width="10" height="15" vspace="5" hspace="0" /><br />
		 	                        	<?php echo "$optionText[$i] - $count[$i] ($percentage%)" ?>
			                        </td>
	    		                    </tr>
	              			        <?php
                                }
                                else
                                {
                                	?>
				                    <tr>
			                        <td valign="top" height="40">
                                    	<img src="images/polls/Col<?php echo $i+1 ?>M.gif" width="3" height="15" vspace="5" hspace="0" /><img src="images/polls/Col<?php echo $i+1 ?>R.gif" width="10" height="15" vspace="5" hspace="0" /><br />
							            <?php echo "$optionText[$i] - $count[$i] (0%)" ?>
	                        		</td>
		 	                    	<?php
                                }
		                        unset($percentage);
	                        }
	                    }
	                    else
                        {
                        	?>
							<tr>
	                        	<td valign="bottom">There are no results for this month.</td>
	                    	</tr>
	                      	<?php
	                    }
                        ?>
	                </table>
		            </td>
		            <td width="41%">&nbsp;</td>
	    		</tr>
		        </table>
		    </td>
		</tr>
		</table>
    	<?php
	}
}
?>