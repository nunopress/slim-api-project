<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Slim 3</title>
        <link href='//fonts.googleapis.com/css?family=Lato:300' rel='stylesheet' type='text/css'>
        <link href="<?php echo url('assets/css/style.css') ?>" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <h1>Slim API</h1>
        <div>a simple skeleton starter for your website</div>

        <?php if (true === isset($name)): ?>
            <h2>Hello <?php echo $name ?>!</h2>
        <?php endif ?>

        <h3>Powered by <a href="http://nunopress.com">NunoPress LLC</a> with <a href="http://www.slimframework.com">SlimFramework</a></h3>
    </body>
</html>