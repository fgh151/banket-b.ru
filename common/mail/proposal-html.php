<?php
/**
 * Created by IntelliJ IDEA.
 * User: fedorgorskij
 * Date: 2019-05-13
 * Time: 17:31
 */
?>

Здравствуйте, в ваш ресторан <?= $recipient->name ?> поступила новая заявка №<?= $proposal->id ?> на проведение банкета.
Для просмотра заявки зайдите в <a href="https://banket-b.ru/conversation/index/<?= $proposal->id ?>">личный кабинет</a>.
