<?php
class Robot
{
    protected $position;
    protected $direction;
	const DIRECTION_NORTH  = 0;
	const DIRECTION_EAST  = 1;
	const DIRECTION_SOUTH  = 2;
	const DIRECTION_WEST  = 3;
	
    public function __construct(array $position, string $direction)
    {
		$this->position = $position;
		$this->direction = $direction;
    }

    public function turnRight(): self
    {
		$this->direction = ($this->direction + 1)%4;
		return $this;
    }

    public function turnLeft(): self
    {
		$this->direction = ($this->direction + 3)%4;
		return $this;
    }

    public function advance(): self
    {
        if($this->direction == Robot::DIRECTION_NORTH){
			$this->position[1] = $this->position[1]+1;
		}else if($this->direction == Robot::DIRECTION_SOUTH){
			$this->position[1] = $this->position[1]-1;
		}else if($this->direction == Robot::DIRECTION_EAST){
			$this->position[0] = $this->position[0]+1;
		}else if($this->direction == Robot::DIRECTION_WEST){
			$this->position[0] = $this->position[0]-1;
		}
		return $this;
    }

	public function instructions(string $instruct){
		$instruction = str_split($instruct);
		foreach ($instruction as $value) {
			if($value == 'L'){
				$this->turnLeft();
			}else if($value == 'R'){
				$this->turnRight();
			}else if($value == 'A'){
				$this->advance();
			}
		}
	}
	public function getDir(){
		return $this->direction;
	}
	public function getPos(){
		return $this->position;
	}
}

$robot = new Robot([8,4], Robot::DIRECTION_NORTH);
$robot->instructions('LAAARRRALLLL');

echo $robot->getDir()."<br>";
print_r($robot->getPos());

?>