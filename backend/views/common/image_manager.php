<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use common\components\helpers\ImageHelper;

?>
<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title"><?=Yii::t('image_manager', 'Image Manager'); ?></h4>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="col-sm-5">
          <a href="<?php echo $parent; ?>" data-toggle="tooltip" title="<?=Yii::t('app', 'Parent'); ?>" id="button-parent" class="btn btn-default"><i class="fa fa-level-up"></i></a>
          <a href="<?php echo $refresh; ?>" data-toggle="tooltip" title="<?=Yii::t('app', 'Refersh'); ?>" id="button-refresh" class="btn btn-default"><i class="fa fa-refresh"></i></a>
          <button type="button" data-toggle="tooltip" title="<?=Yii::t('app', 'Upload'); ?>" id="button-upload" class="btn btn-primary"><i class="fa fa-upload"></i></button>
          <button type="button" data-toggle="tooltip" title="<?=Yii::t('app', 'New Folder'); ?>" id="button-folder" class="btn btn-default"><i class="fa fa-folder"></i></button>
          <button type="button" data-toggle="tooltip" title="<?=Yii::t('app', 'Delete'); ?>" id="button-delete" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
        </div>
        <div class="col-sm-7">
          <div class="input-group">
            <input type="text" name="search" value="<?php echo $filter_name; ?>" placeholder="<?=Yii::t('app', 'Search..'); ?>" class="form-control">
            <span class="input-group-btn">
            <button type="button" data-toggle="tooltip" title="<?=Yii::t('app', 'Search'); ?>" id="button-search" class="btn btn-primary"><i class="fa fa-search"></i></button>
            </span></div>
        </div>
      </div>
      <hr />
      <?php foreach (array_chunk($images, 4) as $image) {
    ?>
      <div class="row">
        <?php foreach ($image as $image) {
        ?>
        <div class="col-sm-3 text-center">
          <?php if ($image['type'] == 'directory') {
            ?>
          <div class="text-center"><a href="<?php echo $image['href']; ?>" class="directory" style="vertical-align: middle;"><i class="fa fa-folder fa-5x"></i></a></div>
          <label>
            <input type="checkbox" name="path[]" value="<?php echo $image['path']; ?>" />
            <?php echo $image['name']; ?></label>
          <?php

        } ?>
          <?php if ($image['type'] == 'image') {
            ?>
          <a href="<?php echo $image['href']; ?>" class="thumbnail"><img src="<?=ImageHelper::resize($image['thumb'], 100, 100); ?>" alt="<?php echo $image['name']; ?>" title="<?php echo $image['name']; ?>" /></a>
          <label>
            <input type="checkbox" name="path[]" value="<?php echo $image['path']; ?>" />
            <?php echo $image['name']; ?></label>
          <?php

        } ?>
        </div>
        <?php

    } ?>
      </div>
      <br />
      <?php

} ?>
    </div>
    <div class="modal-footer">
      <?= LinkPager::widget([
            'pagination' => $pages,
          ]); ?>
    </div>
  </div>
</div>
<script type="text/javascript">
<?php if ($target) {
              ?>
$('a.thumbnail').on('click', function(e) {
	e.preventDefault();

	<?php if ($thumb) {
                  ?>
	$('#<?php echo $thumb; ?>').find('img').attr('src', $(this).find('img').attr('src'));
	<?php

              } ?>

	$('#<?php echo $target; ?>').attr('value', $(this).parent().find('input').attr('value'));

	$('#modal-image').modal('hide');
});
<?php

          } ?>

$('a.directory').on('click', function(e) {
	e.preventDefault();

	$('#modal-image').load($(this).attr('href'));
});

$('.pagination a').on('click', function(e) {
	e.preventDefault();

	$('#modal-image').load($(this).attr('href'));
});

$('#button-parent').on('click', function(e) {
	e.preventDefault();

	$('#modal-image').load($(this).attr('href'));
});

$('#button-refresh').on('click', function(e) {
	e.preventDefault();

	$('#modal-image').load($(this).attr('href'));
});

$('input[name=\'search\']').on('keydown', function(e) {
	if (e.which == 13) {
		$('#button-search').trigger('click');
	}
});

$('#button-search').on('click', function(e) {

	var url = '<?=Url::to(['imgae-manager/index', 'directory' => $directory])?>';

	var filter_name = $('input[name=\'search\']').val();

	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

	<?php if ($thumb) {
              ?>
	url += '&thumb=' + '<?php echo $thumb; ?>';
	<?php

          } ?>

	<?php if ($target) {
              ?>
	url += '&target=' + '<?php echo $target; ?>';
	<?php

          } ?>

	$('#modal-image').load(url);
});
</script>
<script type="text/javascript">
$('#button-upload').on('click', function() {
	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="ImageManager[files][]" value="" multiple/></form>');

	$('#form-upload input[name=\'ImageManager[files][]\']').trigger('click');

	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'ImageManager[files][]\']').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: '<?=Url::to(['image-manager/upload', 'directory' => $directory])?>',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$('#button-upload i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
					$('#button-upload').prop('disabled', true);
				},
				complete: function() {
					$('#button-upload i').replaceWith('<i class="fa fa-upload"></i>');
					$('#button-upload').prop('disabled', false);
				},
				success: function(json) {
					if (json['error']) {
						alert(json['error']);
					}

					if (json['success']) {
						alert(json['success']);

						$('#button-refresh').trigger('click');
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});

$('#button-folder').popover({
	html: true,
	placement: 'bottom',
	trigger: 'click',
	title: '<?=Yii::t('app', 'Folder Name'); ?>',
	content: function() {
		html  = '<div class="input-group">';
		html += '  <input type="text" name="folder" value="" placeholder="<?=Yii::t('app', 'Folder Name'); ?>" class="form-control">';
		html += '  <span class="input-group-btn"><button type="button" title="<?=Yii::t('app', 'New Folder'); ?>" id="button-create" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></span>';
		html += '</div>';

		return html;
	}
});

$('#button-folder').on('shown.bs.popover', function() {
	$('#button-create').on('click', function() {
		$.ajax({
			url: '<?=Url::to(['image-manager/folder', 'directory' => $directory])?>',
			type: 'post',
			dataType: 'json',
			data: 'folder=' + encodeURIComponent($('input[name=\'folder\']').val()),
			beforeSend: function() {
				$('#button-create').prop('disabled', true);
			},
			complete: function() {
				$('#button-create').prop('disabled', false);
			},
			success: function(json) {
				if (json['error']) {
					alert(json['error']);
				}

				if (json['success']) {
					alert(json['success']);

					$('#button-refresh').trigger('click');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	});
});

$('#modal-image #button-delete').on('click', function(e) {
	if (confirm('<?=Yii::t('app', 'Are you sure?'); ?>')) {
		$.ajax({
			url: '<?=Url::to(['image-manager/delete'])?>',
			type: 'post',
			dataType: 'json',
			data: $('input[name^=\'path\']:checked'),
			beforeSend: function() {
				$('#button-delete').prop('disabled', true);
			},
			complete: function() {
				$('#button-delete').prop('disabled', false);
			},
			success: function(json) {
				if (json['error']) {
					alert(json['error']);
				}

				if (json['success']) {
					alert(json['success']);

					$('#button-refresh').trigger('click');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
});
</script>
