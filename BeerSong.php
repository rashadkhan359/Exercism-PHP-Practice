<?php
class BeerSong
{
    public function verse(int $number): string
    {
        if($number == 0 || $number == null){
			$line = "No more bottles of beer on the wall, no more bottles of beer./nGo to the store and buy some more, 99 bottles of beer on the wall.";
		}else if($number == 1){
			$line = "1 bottle of beer on the wall, 1 bottle of beer./nTake it down and pass it around, no more bottles of beer on the wall./n";
		}else{
			$line = "$number bottles of beer on the wall, $number bottles of beer./nTake one down and pass it around, ".($number-1);
			(($number-1)==1)? $line .= " bottle " : $line.=" bottles ";
			$line .= "of beer on the wall./n";
			return $line;
		}
		return $line;
    }

    public function verses(int $start, int $finish): string
    {
		$song = "";
        for($i=$start; $i>=$finish; $i--){
            $song  .= $this->verse($i);
            ($i!=$finish) ? $song .= "/n" : $song .= "";
			
		}
		return $song;
    }

    public function lyrics(): string
    {
        return $this->verses(99,0);
    }
}
$song = new BeerSong();
echo nl2br($song->verses(99,98));
?>