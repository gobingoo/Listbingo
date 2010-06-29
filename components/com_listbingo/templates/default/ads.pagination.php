<?php 
if($this->pagination->total>$this->pagination->limit)
{
?>

<div class="gbNextButton">
<?php echo $this->pagination->getPagesLinks();?>
</div>

<?php 
}
?>