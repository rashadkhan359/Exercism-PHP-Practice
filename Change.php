<?php
function findFewestCoins(array $coins, int $amount): array
{
	if($amount < 0){
		throw new InvalidArgumentException('Cannot make change for negative value');
	}
	if($amount == 0){
		return [];
	}
	//If any coin value greater than amount, remove if beforehand. Can go without doing it but it just helps remove unnecessary repititive results
	$possibleCoins = [];
	foreach($coins as $value){
		if($value <= $amount){
			array_push($possibleCoins, $value);
		}
	}

	if($possibleCoins == []){
		throw new InvalidArgumentException('No coins small enough to make change');
	}
	//Sort Coins accourding to value (high to low)
	rsort($possibleCoins);
	$allCombinations = [];
	//find every possible combinations possible to achieve amount and store it in $allCombinations
	while($possibleCoins != null){
		array_push($allCombinations, possibleCombination($possibleCoins, $amount));
		array_shift($possibleCoins);
	}
	//filter out the least possible way
	$min = [PHP_INT_MAX, 0];
	foreach ($allCombinations as $key=>$value) {
		if(count($value) < $min[0] && count($value) != 0){
			$min[0] = count($value);
			$min[1] = $key;
		}
	}
	if(empty($allCombinations)){
		return [];
	}else if(empty($allCombinations[$min[1]])){
		throw new InvalidArgumentException('No combination can add up to target');
	}else{
		sort($allCombinations[$min[1]]);
		return $allCombinations[$min[1]];
	}
}

function possibleCombination(array $coins, int $amount){
	if($amount == 0 || $amount < min($coins)){
		return [];
	}
	if(array_search($amount, $coins) !== false){
		return [$amount];
	}else{
		$possibleCoins = [];
		foreach($coins as $value){
			if($value < $amount){
				array_push($possibleCoins, $value);
			}
		}
		$list = [];
		foreach($possibleCoins as $value){
			$subList = possibleCombination($possibleCoins, $amount - $value);
			if(!empty($subList)){
				$list = array_merge([$value], $subList);
			}
			$breakCondition = $amount - $value - array_sum($subList);
			if($breakCondition == 0){
				break;
			}
		}
		return $list;
	}
}

print_r(findFewestCoins([1, 5, 10, 25, 100], 25));
?>