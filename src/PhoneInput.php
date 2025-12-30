<?php

namespace borales\extensions\phoneInput;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 * Widget of the phone input
 * @package borales\extensions\phoneInput
 */
class PhoneInput extends InputWidget
{
    /** @var string HTML tag type of the widget input ("tel" by default) */
    public $htmlTagType = 'tel';

    /** @var array Default widget options of the HTML tag */
    public $defaultOptions = ['autocomplete' => 'off', 'class'=>'form-control'];

    /**
     * @link https://github.com/jackocnr/intl-tel-input#options More information about JS-widget options.
     * @var array Options of the JS-widget
     */
    public $jsOptions = [];

    public function init()
    {
        parent::init();
        PhoneInputAsset::register($this->view);
        $id = ArrayHelper::getValue($this->options, 'id');
        $jsOptions = $this->jsOptions ? Json::encode($this->jsOptions) : "";
        $jsInit = <<<JS
(function () {
    "use strict";
    const input = document.querySelector("#$id");
    window.intlTelInput(input, $jsOptions);
})();
JS;
        $this->view->registerJs($jsInit);
        if ($this->hasModel()) {
            $js = <<<JS
(function () {
    "use strict";
    const input = document.querySelector('#$id');
    const form = input.closest('form');
    if (form) {
        form.addEventListener('submit', function() {
            const iti = window.intlTelInput.getInstance(input);
            if (iti) {
                input.value = iti.getNumber();
            }
        });
    }
})();
JS;
            $this->view->registerJs($js);
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        $options = ArrayHelper::merge($this->defaultOptions, $this->options);
        if ($this->hasModel()) {
            return Html::activeInput($this->htmlTagType, $this->model, $this->attribute, $options);
        }
        return Html::input($this->htmlTagType, $this->name, $this->value, $options);
    }
}
