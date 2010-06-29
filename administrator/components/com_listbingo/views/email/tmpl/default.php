<?php 
defined('_JEXEC') or die('Restricted access');
$titlestring=($this->edit)?'Edit Email Format':'Add Email Format';
JToolBarHelper::title(JText::_($titlestring), 'email.png');
JToolBarHelper::save("emails.save");
JToolBarHelper::apply("emails.apply");
JToolBarHelper::cancel("emails");

gbimport("css.icons");
gbimport("css.layout");
gbimport("js.trackfocus");

$editor=&JFactory::getEditor();
jimport('joomla.html.pane');

?>
<script>


window.addEvent('domready',function(){
	t=new TrackFocus();
	tinymce.dom.Event.add(window, 'load', function(e) {
	var ed=tinyMCE.get('body');
	tinymce.dom.Event.add(ed.getWin(), 'focus', function(e) {
		t.setCurrentElement(null);
	    });
	});
	
	$$('.variables').addEvent('click',function(e){
		currenteditor=t.getFocusedElement();
		if(currenteditor==null)
		{
			insertVariable('body',this.getText());
		}
		else
		{
			insertVariable_input(currenteditor,this.getText());
		}
	});
});

function insertVariable_input(editor,txt) {
	editor.value+=txt.trim();
}

function insertVariable(editor,txt) {

		jInsertEditorText(txt, editor);
	
}
</script>
<form name="adminForm" id="adminForm" action="index.php" method="post">
  <input type="hidden" name="id" id="id" value="<?=$this->row->id?>" />
  <table width="100%" cellpadding="0" cellspacing="0" border="0">
  <tr>
  <td width="70%">
  
  
  <fieldset class="adminform">
  <legend><?php echo JText::_("EMAIL_DETAILS");?></legend>
  <table width="80%" cellpadding="5" class="admintable">
    <tr>
      <td width="16%"  valign="top" class="key"><?php echo JText::_("SUBJECT");?></td>
      <td width="84%" ><input name="subject" type="text" class="inputbox" id="subject" value="<?=$this->row->subject?>" size="45"/></td>
    </tr>
     <tr>
    <td valign="top" class="key"><?php echo JText::_("MAILTO");?></td>
      <td><?php echo $this->lists['mailto'];?></td>
    </tr>
    <tr>
    <td valign="top" class="key"><?php echo JText::_("SEND_ON_EVENT");?></td>
      <td><?php echo $this->lists['events'];?></td>
    </tr>
    <tr>
    <td valign="top" class="key"><?php echo JText::_("PUBLISHED");?></td>
      <td><?php echo $this->lists['published'];?></td>
    </tr>
    
    <tr>
      <td colspan="2" align="left" valign="top"><strong><?php echo JText::_("BODY");?></strong></td>
    </tr>
    <tr>
      <td colspan="2" valign="top"><?php echo $editor->display('body',$this->row->body,'100%','500','40','5',false,array("mode"=>"extended")); ?></td>
    </tr>
    <tr>
   
    </tr>
  </table>
  </fieldset>
  </td>
  <td valign="top">
    
  <fieldset class="adminform">
  <legend><?php echo JText::_("SENDER_DETAILS");?></legend>
  <table width="100%" cellpadding="5" class="admintable">
    <tr>
      <td   valign="top" class="key"><?php echo JText::_("FROM_NAME");?></td>
      <td  ><input name="from_name" type="text" class="inputbox" id="from_name" value="<?=$this->row->from_name?>" size="25"/></td>
    </tr>
     <tr>
    <td valign="top" class="key"><?php echo JText::_("FROM_EMAIL");?></td>
      <td><input name="from_email" type="text" class="inputbox" id="from_email" value="<?=$this->row->from_email?>" size="25"/></td>
    </tr>
    <tr>
    <td valign="top" class="key"><?php echo JText::_("REPLY_TO");?></td>
      <td><input name="reply_to" type="text" class="inputbox" id="reply_to" value="<?=$this->row->reply_to?>" size="25"/></td>
    </tr>
    <tr>
    <td valign="top" class="key"><?php echo JText::_("REPLY_TO_EMAIL");?></td>
      <td><input name="reply_to_email" type="text" class="inputbox" id="reply_to_email" value="<?=$this->row->reply_to_email?>" size="25"/></td>
    </tr>

    <tr>
   
    </tr>
  </table>
  </fieldset>
  <fieldset class="adminform">
  <legend><?php echo JText::_("AVAILABLE_VARIABLES");?></legend>
  <?php 
  $pane = &JPane::getInstance('sliders', array('allowAllClose' => true));
  	echo $pane->startPane('plugin-pane');
  		echo $pane->startPanel(JText :: _('BASIC_VARIABLES'), 'basic-pane');
		?>
		<ul class="variablelist">
  		<li class="variables">{sendername}</li>
  		<li class="variables">{senderemail}</li>  		
  		<li class="variables">{receivername}</li>
		<li class="variables">{receiveremail}</li>
		<li class="variables">{sitename}</li>
		
			<li class="variables">{siteslogan}</li>
			<li class="variables">{sitelink}</li>
		
 		</ul>
		<?php 
		echo $pane->endPanel();
		echo $pane->startPanel(JText :: _('ADS_VARIABLES'), 'property-pane');
		?>
		<ul class="variablelist">
		<li class="variables">{adid}</li>
  		<li class="variables">{adimage}</li>
  		<li class="variables">{adlink}</li>  		
  		<li class="variables">{adtitle}</li>
		<li class="variables">{amount}</li>
		<li class="variables">{postdate}</li>		
		<li class="variables">{fulldescription}</li>
		<li class="variables">{address}</li>
		<li class="variables">{fulladdress}</li>
 		</ul>
		<?php 
		echo $pane->endPanel();
		
			
		
			
			echo $pane->startPanel(JText :: _('ERROR_VARIABLES'), 'error-pane');
		?>
		<ul class="variablelist">
  		<li class="variables">{errortitle}</li>
  		<li class="variables">{errordescription}</li>  		
  		<li class="variables">{errordate}</li>

 		</ul>
		<?php 
		echo $pane->endPanel();
			
		GApplication::triggerEvent('onEmailVariablesLoad',array(&$pane));		
		
		echo $pane->endPane();
  ?>
 
  </fieldset>
  
  </td>
  </tr>
  </table>
  <input type="hidden" name="option" value="<?php echo $option?>" />
  <input type="hidden" name="ordering" value="<?php echo $this->row->ordering;?>" />
  <input type="hidden" name="task" value="emails" />
</form>