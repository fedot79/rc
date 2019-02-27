<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 01.08.2018
 * Time: 13:30
 */
/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AdminAsset;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
AdminAsset::register($this);

$menu_items = [];


if(Yii::$app->user->can('admin'))
{
    $menu_items[] = ['label' => 'Юзеры', 'url' => ['/user/admin/index']];


}

if(Yii::$app->user->can('managerRole'))
{
    $menu_items[] = ['label' => 'Объекты', 'url' => ['/objects/objects/index']];
    $menu_items[] = ['label' => 'Потребности', 'url' => ['/searches/search/index']];
    $menu_items[] = ['label' => 'Переговоры', 'url' => ['/negotiation/negotiations/index']];
    $menu_items[] = ['label' => 'Реф-ссылки', 'url' => ['/referal/referal/index']];
    $menu_items[] = ['label' => 'Отзывы', 'url' => ['/review/review/index']];
    $menu_items[] = ['label' => 'Рейтинг', 'url' => ['/rating/rating/index']];
    $menu_items[] = '<li>'
     . Html::beginForm(['/site/logout'], 'post')
     . Html::submitButton(
         'Logout (' . Yii::$app->user->identity->username . ')',
         ['class' => 'btn btn-link logout']
     )
     . Html::endForm()
     . '</li>';
}



?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>

    <div class="wrap">
        <?php
        NavBar::begin([
            'brandLabel' => 're-connect|admin',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $menu_items,
        ]);
        NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>