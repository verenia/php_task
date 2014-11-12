<?php 
class Translator{
	private $language;
	private $dictionary;
	private static $translator;

	public static function createTranslator(){
		if(self::$translator === null){
			self::$translator = new self();
		}
		return self::$translator;
	}

	private function __construct(){
		$this->setLanguage("ua");
	}

	public function setLanguage($lang){
		if($this->language != $lang){
			$this->language = $lang;
			$this->loadDictionary();
		}
	}

	private function loadDictionary(){
		$this->dictionary = simplexml_load_file("xml/".$this->language."_numbers.xml");
	}

	public function translateNumber($number){
		$num = $number;
		$level = 0;
		$outputstring = "";

		if($num < 0){
			$num *= -1;
		}

		$checked = $this->checkNumber($num);
		if($checked === true){
				while($num != 0){
					$tmp = $num % 1000;
					if($tmp != 0){
						$string = $this->getStringNumber($tmp,$level).$string;
					}
					$num = intval($num/1000);
                $level +=1;
				}
			//echo "ddsd";
			return $string;
		}else{
			return $checked;
		}

	}

	private function getStringNumber($num,$level){
        //parsing
        $firstDigit = intval($num/100);
        $secondDigit = intval(($num - $firstDigit * 100)/10);
        $thirdDigit = ($num - $firstDigit * 100)%10;
        $string = "";
        //additional word for thousands
        if ($level == 1) {
            if($secondDigit != 1){
                if ( $thirdDigit  == 1) {
                    $string = $this->dictionary->oneThousand.$string;
                } else if ((  $thirdDigit == 2) || ($thirdDigit  == 4) || ($thirdDigit == 3)) {
                    $string = $this->dictionary->twoThreeFourThousand.$string;
                } else {
                    $string = $this->dictionary->manyThousand.$string;
                }
            } else {
                $string = $this->dictionary->manyThousand.$string;
            }
        }   
        //additional word for millions
        if ($level == 2) {
            if($secondDigit != 1){
                if ( $thirdDigit  == 1) {
                    $string = $this->dictionary->oneMillion.$string;
                } else if ((  $thirdDigit == 2) || ($thirdDigit  == 4) || ($thirdDigit == 3)) {
                    $string = $this->dictionary->twoThreeFourMillion.$string;
                } else {
                    $string = $this->dictionary->manyMillion.$string;
                }
            } else {
                $string = $this->dictionary->manyMillion.$string;
            }   
        }
        //words for two-digit number
        if($secondDigit == 1){    
                $string = $this->dictionary->units->digit[$thirdDigit + $secondDigit * 10].$string;
        } else {
                if(($level == 1) && ($thirdDigit == 1)){
                    $string = $this->dictionary->units->alterOne.$string;
                } else if (($level == 1) && ($thirdDigit == 2)){
                    $string = $this->dictionary->units->alterTwo.$string;
                } else {
                    $string = $this->dictionary->units->digit[$thirdDigit].$string;
                }
            $string = $this->dictionary->tens->digit[$secondDigit].$string;
        }
         //word for hundreds
        $string = $this->dictionary->hundreds->digit[$firstDigit].$string;
        return $string;
    }

	private function checkNumber($number){
		if($number >= 1000000000){
			return "Must be less than billion.";
		}

		if(!is_numeric($number)){
			return "Must be integer.";
		}

		if($number - intval($number) != 0){
			return "Must be integer.";
		}
		return true;
	}
}
?>