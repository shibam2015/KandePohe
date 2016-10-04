<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Url;

?>
<?php
if (count($model) != 0) {
    foreach ($model as $TK => $TV) {
        ?>
        <span class="tag label label-danger" id="tag_delete_<?= $TV->id ?>">
                <?= $TV->tagName->Name ?>
            <i data-role="remove" class="fa fa-times user_tag_delete" data-id="<?= $TV->id ?>"></i>
            </span>
    <?php }
} else { ?>
    <span class="tag label label-danger">Tag Not Available</span>
<?php }
?>

<?php
$this->registerJs('
$(".user_tag_delete").click(function(e){
        getTagData("' . Url::to(['user/tag-delete']) . '","#user_tag_list",$(this).data("id"));
        setTimeout(function(){ 
            getTagData("' . Url::to(['user/tag-list']) . '","#user_tag_list","0");
            getTagData("' . Url::to(['user/tag-suggestion-list']) . '","#suggest_tag_list","1");
            getTagData("' . Url::to(['user/tag-count']) . '","#tag_count","1"); 
        }, 1000);
        
    });
  ');
?>
