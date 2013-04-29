<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
function getSection($string, $start, $end){
	return trim(substr($string,$start- 1,$end - $start + 1));
}
	
if(file_exists('EO_TX.LST'))
{
	print('start');
	$file = @fopen('EO_TX.LST', "r") ;  
	require_once($_SERVER["DOCUMENT_ROOT"] . "/schooldu/structs/charity.php");

	while (!feof($file))
	{
		print('charity read');
		$currentLine = fgets($file);
		if(getSection($currentLine,201,201) == "1")
		{
			$aCharity = new Charity(null);
			$aCharity->set_ein((int)getSection($currentLine,1,9));
			$aCharity->set_name(getSection($currentLine,10,79));
			$aCharity->set_careOf(getSection($currentLine,80,114));
			$aCharity->set_address(getSection($currentLine,115,149));
			$aCharity->set_city(getSection($currentLine,150,171));
			$aCharity->set_state(getSection($currentLine,172,173));
			$aCharity->set_zip(getSection($currentLine,174,183));
			$aCharity->set_subsection((int)getSection($currentLine,188,189)); //03 60 70
			$aCharity->set_classification((int)getSection($currentLine,191,194));//2 5
			$aCharity->set_deductibility((int)getSection($currentLine,201,201)); //must be 1
			$aCharity->set_foundation((int)getSection($currentLine,202,203)); //11 13
			$aCharity->set_activity((int)getSection($currentLine,204,212));//030-059
			$aCharity->set_nteeCode(getSection($currentLine,279,282));//Bxx Oxx
			
			if(substr($aCharity->get_nteeCode(),0,1) == "B" || ($aCharity->get_activity() > 29 && $aCharity->get_activity() < 60))
			{
				echo(' - charity saved');
				$aCharity->save();
			}
		}

	}   

	fclose($file);
	print('done');
}
/*
  1,9	Employer Identification Number (EIN).
 10,79	Primary Name of Organization.
PENELOPE SPEIER                  P
 80,114	In Care of Name.
115,149	Street Address.
150,171	City.
172,173	State.
174,183	Zip Code.
188,189	Subsection Code.
191,194	Classification Code(s).
195,200	Ruling Date.
201		Deductibility Code.
202,203	Foundation Code.
204,212	Activity Codes.
213		Organization Code. 
214,215	Exempt Organization Status Code (New)
216,221	The Advance Ruling process is obsolete as of July 2008. These positions will be blank or zeroed out. For further information, please check the URL below: http://www.irs.gov/charities/charitable/article/0,,id=185568,00.html:
222,227	Tax Period.
228		Asset Code.
229		Income Code.
230,231	Filing Requirement Code.
232		PF Filing Requirement Code. (New)
233,235	Blanks.
236,237	Accounting Period.
238,250	Asset Amount.
251,263	Income Amount.
264 If the Income Amount is negative this contains a negative sign.
265,277	Form 990 Revenue Amount
278		If Revenue Amount is negative this contains a negative sign.
279,282	National Taxonomy of Exempt Entities (NTEE) Code.
283,317	Sort Name (Secondary Name Line).
318	      0A,Line Feed	*/
?>