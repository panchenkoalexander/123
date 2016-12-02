<?php


?>

<li><a href="#">Выбор модели автомобиля</a></li>
<li role="separator" class="divider"></li>
<?php foreach ($models as $model): ?>
    <li><a class="modelLink" modelId="<?= $model->getId() ?>" href="#"><?= $model->getName() ?></a></li>
<?php endforeach; ?>

