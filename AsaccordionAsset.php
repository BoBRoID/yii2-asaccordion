<?php
/**
 * Created by PhpStorm.
 * User: bobroid
 * Date: 06.11.15
 * Time: 13:09
 */

namespace bobroid\asaccordion;


class AsaccordionAsset extends AssetBundle
{
    public $sourcePath = '@vendor/bobroid/yii2-asaccordion/assets';

    public $css = [
        'css/sweetalert.css',
    ];

    public $js = [
        'js/jquery-asAccordion.min.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset'
    ];
}