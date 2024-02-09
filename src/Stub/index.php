<?php

require dirname(__DIR__) . '/../bootstrap.php';

$phlide = new \Phlide\Phlide(realpath(__DIR__));

print $phlide->render();
