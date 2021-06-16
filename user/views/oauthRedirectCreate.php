<?php

use yii\helpers\Json;

/* @var $this \yii\base\View */
/* @var $url string */
/* @var $enforceRedirect bool */

$url = \yii\helpers\Url::to(['site/create']);
?>
<!DOCTYPE html>
<html>
<head>
    <script>
        function popupWindowRedirect(url, enforceRedirect) {
            if (window.opener && !window.opener.closed) {
                if (enforceRedirect === undefined || enforceRedirect) {

                    console.log('1 ' + url)
                    // window.opener.location = url;
                }
                window.opener.focus();
                // window.close();
            } else {
                console.log('2 ' + url)
                // window.location = url;
            }
        }

        console.log(<?= Json::htmlEncode($url) ?>);
        popupWindowRedirect(<?= Json::htmlEncode($url) ?>, <?= Json::htmlEncode($enforceRedirect) ?>);
    </script>
</head>
<body>
<h2 id="title" style="display:none;">Redirecting back to the &quot;<?= Yii::$app->name ?>&quot;...</h2>
<h3 id="link"><a href="<?= $url ?>">Click here to return to the &quot;<?= Yii::$app->name ?>&quot;.</a></h3>
<script type="text/javascript">
    document.getElementById('title').style.display = '';
    document.getElementById('link').style.display = 'none';
</script>
</body>
</html>
