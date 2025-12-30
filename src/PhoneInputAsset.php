<?php

namespace borales\extensions\phoneInput;

use yii\web\AssetBundle;

/**
 * Asset Bundle of the phone input widget. Registers required CSS and JS files.
 * @package borales\extensions\phoneInput
 */
class PhoneInputAsset extends AssetBundle
{
    /** @inheritdoc */
    public $sourcePath = '@npm/intl-tel-input/build';

    /** @inheritdoc */
    public $css = [
        'css/intlTelInput.min.css'
    ];

    /** @inheritdoc */
    public $js = [
        'js/intlTelInputWithUtils.min.js',
    ];
}
