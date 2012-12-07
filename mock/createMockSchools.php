<?phpclass MockSchools{    public $schools = array();	private $currentIndex = 0;	private $names = array("Texas A&M",							"Oklahoma University",							"University of Alabama");								private $pictures = array("Texas.jpg",								"Oklahoma.gif",								"Alabama.gif");								private $numbers;			public function __construct() 	{		for($i = 0; $i < sizeof($this->names); $i++)		{			$this->schools[$i] = new School();			$this->schools[$i]->name = $this->names[$i];			$this->schools[$i]->pictureUrl = "img/school_thumb/" . $this->pictures[$i];			$this->schools[$i]->moneyDonated = rand(0, 20) * 34 + rand(0, 9);		}		$this->numbers = range(0, sizeof($this->schools));        shuffle($this->numbers);		    }		public function resetUniqueIndex()	{		$this->currentIndex = 0;	}		public function getUniqueSchool()	{		if($this->currentIndex < sizeof($this->schools))		{			$schoolToReturn = $this->schools[$this->currentIndex];			$this->currentIndex++;			return $schoolToReturn;		}		return NULL;	}		public function getRandomSchool()	{		return $this->schools[rand(0, sizeof($this->schools) - 1)];	}}?>