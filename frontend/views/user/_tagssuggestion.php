<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Url;

?>
<div class="panel-heading" id="add_all_tag">
    <a href="javascript:void(0)" class="pull-right suggest_tag_all">Add All</a>
    <h3 class="panel-title text-muted">Tag Suggestions</h3>
</div>
<div class="panel-body no-padd text-center">
    <div class="bootstrap-tagsinput">
        <?php if (count($model) != count($TAG_LIST_USER)) {
            foreach ($model as $TK => $TV) {
                if (!in_array($TV['ID'], $SET_TAGS)) {
                    ?>
                    <button class="btn btn-default suggest_tag_add"
                            data-id="<?= $TV['ID'] ?>"><?= $TV['Name'] ?></button> <!--suggest_tag-->
                <?php }
            }
        } else { ?>
            <span
                class="tag label label-default">Tag Suggestion Not Available</span>
        <?php }
        ?>

    </div>
</div>
<?php
$this->registerJs('
function getTagData(url,htmlId,id){
     Pace.restart();
     loaderStart();
        $.ajax({
        url : url,
        type:"POST",
        data:{"TagId":id},
        success:function(res){
          loaderStop();
          $(htmlId).html(res);
        }
      });
    }
    $(".suggest_tag_add").click(function(e){
        getTagData("' . Url::to(['user/tag-list']) . '","#user_tag_list",$(this).data("id"));
        setTimeout(function(){
        getTagData("' . Url::to(['user/tag-suggestion-list']) . '","#suggest_tag_list","1");
        getTagData("' . Url::to(['user/tag-count']) . '","#tag_count","1");
        }, 1000);
        
    });
  ');
?>
