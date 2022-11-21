<?php
class PhoneNumber
{
	public $numberString = '';
	public $finalNumber = '';
	public function __construct(string $numberString){
		$this->numberString = $numberString;
		
		preg_match_all('/[0-9a-zA-Z@:!]+/',$this->numberString, $matches);
		$newNumberString = implode('',$matches[0]);
		$matches = str_split($newNumberString);
		if(count($matches) < 10){
			throw new InvalidArgumentException('incorrect number of digits');
		}else if(count($matches) > 11){
			throw new InvalidArgumentException('more than 11 digits');
		}else if(count($matches) == 11){
			if($matches[0] != 1 ){
				throw new InvalidArgumentException('11 digits must start with 1');
			}else{
				array_shift($matches);
				$newNumberString = implode('',$matches);
			}
		}
		
		if(count($matches) == 10){
			if(preg_match('/[a-z]/i', $newNumberString,)){
				throw new InvalidArgumentException('letters not permitted');
			}else if(preg_match('/[!:@]/', $newNumberString)){
				throw new InvalidArgumentException('punctuations not permitted');
			}
			if($matches[0] == 0){
				throw new InvalidArgumentException('area code cannot start with zero');
			}else if($matches[0] == 1){
				throw new InvalidArgumentException('area code cannot start with one');
			}else if($matches[3] == 0){
				throw new InvalidArgumentException('exchange code cannot start with zero');
			}else if($matches[3] == 1){
				throw new InvalidArgumentException('exchange code cannot start with one');
			}
		}
		$this->finalNumber = implode('', $matches);
	}
    
	public function number(): string
    {
        return $this->finalNumber;
    }
}
$phone = new PhoneNumber("12345687879");
echo $phone->number();

?>