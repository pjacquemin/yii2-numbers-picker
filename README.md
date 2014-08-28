yii2-numbers-picker
===================

A Yii2 numbers picker with digits and decimals

How to use
============

Put the file under common/extensions

Add this line at top of your view file : 
<pre>
use common\extensions\IndexPicker;
</pre>

Then use it with an ActiveField like this :

<pre>
// for an input like 0000000,00

<?= $form->field($model, 'index_value')->widget(IndexPicker::className(), [
				'numberOfDigits' => 7,
				'numberOfDecimals' => 2
			]); ?>
</pre>
