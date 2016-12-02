<?php

?>

<li><a href="#">Выбор двигателя автомобиля</a></li>
<li role="separator" class="divider"></li>
<?php foreach ($engines as $engine): ?>
    <li><a target="_blank" href="<?= $engine->getUrl() ?>" engineId="<?= $engine->getId() ?>" href="#"><?= $engine->getName() ?></a></li>
<?php endforeach; ?>

