<?php
class Tournament
{
	private $scoreTable = [];

	public function tally(string $scores){
		if($scores == ""){
			return $this->makeResult($this->scoreTable);
		}
		$this->scoreTable = $this->getScoreTable($scores);
		$this->scoreTable = $this->sortScoreBasedOnPoint($this->scoreTable);
		return $this->makeResult($this->scoreTable);
	}

	private function getScoreTable(string $scores){
		$array = explode("\n", $scores);
		$explodedArray = [];
		for($i=0; $i<count($array); $i++){
			array_push($explodedArray,explode(";", $array[$i]));
		}
		$scoreTable = [];
		for($i=0; $i<count($explodedArray); $i++){
			if(!isset($scoreTable[$explodedArray[$i][0]])) {
					$scoreTable[$explodedArray[$i][0]]['MP'] = 0;
					$scoreTable[$explodedArray[$i][0]]['W'] = 0;
					$scoreTable[$explodedArray[$i][0]]['D'] = 0;
					$scoreTable[$explodedArray[$i][0]]['L'] = 0;
			}
			if(!isset($scoreTable[$explodedArray[$i][1]])){
					$scoreTable[$explodedArray[$i][1]]['MP'] = 0;
					$scoreTable[$explodedArray[$i][1]]['W'] = 0;
					$scoreTable[$explodedArray[$i][1]]['D'] = 0;
					$scoreTable[$explodedArray[$i][1]]['L'] = 0;
			}
			if($explodedArray[$i][2] == "win"){
				$scoreTable[$explodedArray[$i][0]]['MP']++;
				$scoreTable[$explodedArray[$i][0]]['W']++;
				$scoreTable[$explodedArray[$i][1]]['MP']++;
				$scoreTable[$explodedArray[$i][1]]['L']++;
			}else if($explodedArray[$i][2] == "draw"){
				$scoreTable[$explodedArray[$i][0]]['MP']++;
				$scoreTable[$explodedArray[$i][0]]['D']++;
				$scoreTable[$explodedArray[$i][1]]['MP']++;
				$scoreTable[$explodedArray[$i][1]]['D']++;
			}else{
				$scoreTable[$explodedArray[$i][0]]['MP']++;
				$scoreTable[$explodedArray[$i][0]]['L']++;
				$scoreTable[$explodedArray[$i][1]]['MP']++;
				$scoreTable[$explodedArray[$i][1]]['W']++;
			}	
		}
		return $scoreTable;
	}

	private function sortScoreBasedOnPoint($scoreTable){
		//Calculate Points for each Player
		foreach ($scoreTable as $key => $value) {
			$scoreTable[$key]['P']=3*$scoreTable[$key]['W'] + 1*$scoreTable[$key]['D'];
		}
		//SORT Based on Name(key)
		ksort($scoreTable);
		//SORT Based on Point
		array_multisort(array_column($scoreTable, 'P'), SORT_DESC, $scoreTable);
		return $scoreTable;
	}

	private function makeResult($scoreTable){
		$result = "Team                           | MP |  W |  D |  L |  P";
		if($scoreTable != null){
			$result .= "\n";
		}

		$count = 1;
		foreach ($scoreTable as $key => $value) {
			$result .= "$key";
			for($i=0; $i<31-strlen($key); $i++){
				$result .= " ";
			}
			$mp = $value['MP'];
			$w = $value['W'];
			$d = $value['D'];
			$l = $value['L'];
			$p = $value['P'];
			$result .= "|  $mp |  $w |  $d |  $l |  $p";
			if($count != count($scoreTable)){
				$result .= "\n";
			}
			$count++;
		}
		return $result;
	}
}

$new = new Tournament();
echo $new->tally("Allegoric Alaskans;Blithering Badgers;win");

?>