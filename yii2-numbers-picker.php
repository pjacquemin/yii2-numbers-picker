<?php

/**
 * @link https://github.com/pjacquemin/yii2-numbers-picker
 * @author Patrick Jacquemin
 */

namespace common\extensions;

use yii\helpers\Html;

class NumbersPicker extends \yii\jui\InputWidget {
	
	const TYPE_DIGIT = 'Digit';
	const TYPE_DECIMAL = 'Decimal';
	
	/**
	 * @var integer number of digits to display
	 */
	public $numberOfDigits = 1;

	/**
	 * @var integer number of decimals to display
	 */
	public $numberOfDecimals = 0;
	
	public function run() {
		echo "<br />";
		echo $this->renderDropdowns();
	}
	
	protected function renderDropdowns() {
		$content = [];
		
		if($this->numberOfDigits < 1 || $this->numberOfDecimals < 0)
			throw new InvalidConfigException("Number of decimals or digits is wrong.");
		
		// render the digit dropdowns
		for($i=1; $i<=$this->numberOfDigits; $i++) {
			$content[] = $this->_renderDropdown(self::TYPE_DIGIT, $i);
		}
		
		// render the float ","
		if($this->numberOfDecimals >0)
			$content[] = "<span style='font-weight: bold; font-size:20px;'>,</span>";
		
		// render the decimal dropdowns
		for($i=1; $i<=$this->numberOfDecimals; $i++) {
			$content[] = $this->_renderDropdown(self::TYPE_DECIMAL, $i);
		}
		
		$content[] = Html::activeHiddenInput($this->model, $this->attribute, ['id' => 'counterValue']);
		$content[] = $this->_registerJs();
		
		return implode(" ", $content);
	}
	
	protected function _renderDropdown($type, $id) {
		return Html::activeDropDownList(
						$this->model, $this->attribute, [0, 1, 2, 3, 4, 5, 6, 7, 8, 9], [
							'class' => 'form-control counterDropdown',
							'style' => 'width : 50px; display: inline;',
							'id' => 'counterDropdown' . $type . $id,
						]
		);
	}

	protected function _registerJs() {
		// each time a dropdown is changed we build the index value with all number into a string
		$this->getView()->registerJs("
			$('.counterDropdown').change(function() {
				value = '';
						
				for(i =1; i<= " . $this->numberOfDigits . "; i++) {
					value += $('#counterDropdownDigit'+i).val();
				}
						
				for(i =1; i<= " . $this->numberOfDecimals . "; i++) {
					value += $('#counterDropdownDecimal'+i).val();
				}
						
				$('#counterValue').val(value);
			});
		");
	}

}