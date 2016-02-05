<?php
/**
 * Created by PhpStorm.
 * User: bobroid
 * Date: 06.11.15
 * Time: 13:08
 */

namespace bobroid\asaccordion;

use yii\helpers\Html;

class Widget extends \yii\base\Widget{

    public $clientOptions = [];
    public $id;
    public $containerOptions = [];
    public $items = [];
    public $direction = self::DIRECTION_HORIZONTAL;
    public $type = self::TYPE_BOX;

    const DIRECTION_HORIZONTAL = 'horizontal';
    const DIRECTION_VERTICAL = 'vertical';

    const TYPE_BOX = 'box';
    const TYPE_BASIC = 'basic';

    private $defaultClientOptions = [
        'namespace' =>  '-accordion'
    ];

    private $defaultContainerOptions = [
        'data-direction'    =>  self::DIRECTION_HORIZONTAL,

    ];

    private $defaultItemOptions = [
    ];

    public function init(){
        $this->clientOptions = array_merge($this->defaultClientOptions, $this->clientOptions);

        if(empty($this->id)) {
            $this->id = 'asaccordion-' . $this->getId();
        }

        $this->defaultContainerOptions['class'] = $this->clientOptions['namespace'].' '.$this->clientOptions['namespace'].'--'.$this->type.' '.$this->clientOptions['namespace'].'--'.$this->direction;
        $this->defaultItemOptions['class'] = $this->clientOptions['namespace'].'__panel';

        $this->containerOptions = array_merge($this->defaultContainerOptions, $this->containerOptions);
    }

    public function run(){
        AsaccordionAsset::register($this->getView());

        $js = "$('#".$this->id."').asAccordion(".json_encode($this->clientOptions).")";

        echo Html::tag('ul', $this->renderItems(), array_merge($this->containerOptions, [
            'id'    =>  $this->id
        ]));

        $this->getView()->registerJs($js);
    }

    public function renderItems(){
        $renderedItems = [];

        foreach($this->items as $item){
            $renderedItems[] = $this->renderItem($item);
        }

        return implode('', $renderedItems);
    }

    public function renderItem($item){
        $result = '';

        !isset($item['options']) ? $item['options'] = [] : null;

        if(empty($item['header'])){
            throw new \ErrorException("У каждого элемента должен быть header!");
        }

        if(empty($item['content'])){
            throw new \ErrorException("У каждого элемента должен быть content!");
        }

        $result .= Html::tag('span', $item['header'], [
            'class' =>  $this->clientOptions['namespace'].'__heading'
        ]);

        $result .= Html::tag('span', $item['content'], [
            'class' =>  $this->clientOptions['namespace'].'__expander'
        ]);

        return Html::tag('li', $result, array_merge($this->defaultItemOptions, $item['options']));
    }

}