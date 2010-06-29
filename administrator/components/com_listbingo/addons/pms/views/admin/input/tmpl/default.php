<?php 
/**
 * @package Gobingoo
 * @subpackage agent
 * @author alex@gobingoo.com
 * @copyright www.gobingoo.com
 * 
 * 
 * Admin agent add/edit form
 * 
 */

defined('_JEXEC') or die('Restricted access');
?>
 <fieldset class="adminform">
  
  <legend>Assign This Property To Agent</legend>
  <div>
 Assigning a property to an agent allows the assigned agent to view, edit or delete the property from the agent's panel.
  This will also override the user assignment above.
  </div>
  <table width="100%" cellpadding="5" class="admintable">
  <tr>
      <td width="30%"  valign="top" class="key">Agent</td>
      <td ><?php echo $this->lists['agents'];?></td>
      
    </tr>
    <tr>
      <td  valign="top" class="key">Access</td>
      <td ><?php echo $this->lists['access'];?></td>
      
    </tr>
    </table>
  </fieldset>