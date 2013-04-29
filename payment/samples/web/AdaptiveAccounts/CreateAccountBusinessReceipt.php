<?php

/********************************************
CreateAccountBusinessReceipt.php
Calls CreateAccount API of CreateAccounts webservices.

Called by CreateAccountBusiness.php
Calls  AdaptiveAccounts.php,and APIError.php.
********************************************/

require_once '../../../lib/AdaptiveAccounts.php';
require_once '../../../lib/Stub/AA/AdaptiveAccountsProxy.php' ;
require_once 'web_constants.php';
session_start();

		try {
		
		       $currencyCode=$_REQUEST["currencyCode"];
		       $accountType=$_REQUEST["accountType"];
		       $namefirstName=$_REQUEST["name_firstName"];
		       $namemiddleName=$_REQUEST["name_middleName"];
		       $namelastName=$_REQUEST["name_lastName"];
		       $dateOfBirth=$_REQUEST["dateOfBirth"];
		       $addressline1=$_REQUEST["address_line1"];
		       $addressline2=$_REQUEST["address_line2"];
		       $addresscity=$_REQUEST["address_city"];
		       $addressstate=$_REQUEST["address_state"];
		       $addresspostalCode=$_REQUEST["address_postalCode"];
		       $name_salutation=$_REQUEST["name_salutation"];
		       $addresscountryCode=$_REQUEST["address_countryCode"];
		       $contactPhoneNumber=$_REQUEST["contactPhoneNumber"];
		       $citizenshipCountryCode=$_REQUEST["citizenshipCountryCode"];
		       $notificationURL=$_REQUEST["notificationURL"];
		       $partnerField1=$_REQUEST["partnerField1"];
		       $partnerField2=$_REQUEST["partnerField2"];
		       $partnerField3=$_REQUEST["partnerField3"];
		       $partnerField4=$_REQUEST["partnerField4"];
		       $partnerField5=$_REQUEST["partnerField5"];
		       $sandboxEmail = $_REQUEST["sandboxEmailAddress"];
		       $email = $_REQUEST["emailAddress"];
		       
		       $bizName =$_REQUEST["biz_firstName"];
				$bizAddressline1 = 	$_REQUEST["biz_address_line1"];
				$bizAddressline2 = $_REQUEST["biz_address_line2"];
				$bizcity = $_REQUEST["biz_address_city"];
				$bizZIP = $_REQUEST["biz_address_postalCode"];
				$bizCountryCode = $_REQUEST["biz_address_countryCode"];
				$biz_address_state = $_REQUEST["biz_address_state"];
				$bizWorkPhone = $_REQUEST["biz_contactPhoneNumber"];
				$bizCategoryCode= $_REQUEST["biz_CategoryCode"]; 
				$bizSubCategory = $_REQUEST["biz_subCategoryCode"]; 
				$bizCustomerServicePhone = $_REQUEST["biz_customerServicePhone"];	
				$bizCustomerServiceEmail = $_REQUEST["biz_customerServiceEmail"];
				$bizWebSite = $_REQUEST["biz_webSite"];
				$bizDateOfEstablishment = $_REQUEST["biz_dateOfEstablishment"];
				$businessType = $_REQUEST["businessType"];
				$averagePrice = $_REQUEST["biz_averagePrice"];
				$averageMonthlyVolume = $_REQUEST["biz_averageMonthlyVolume"];
				$percentageRevenueFromOnline = $_REQUEST["biz_percentageRevenueFromOnline"];
				$salesVenue = $_REQUEST["biz_salesVenue"];
		       
				
				
		       /* Make the call to PayPal to create Account on behalf of the caller
		        If an error occured, show the resulting errors
		        */
		       	$CARequest = new CreateAccountRequest();
		       	$CARequest->accountType = $accountType;
		       	       	
		       	$address = new AddressType();
		       	$address->city = $addresscity;
		       	$address->countryCode = $addresscountryCode;
		       	$address->line1 = $addressline1;
		       	$address->line2 = $addressline2;
		       	$address->postalCode = $addresspostalCode;
		       	$address->state = $addressstate ;
		       	$CARequest->address = $address;
		
		       	$CARequest->citizenshipCountryCode = $citizenshipCountryCode;
		       	$CARequest->clientDetails = new ClientDetailsType();
		        $CARequest->clientDetails->applicationId ="APP-1JE4291016473214C";
		       	//$CARequest->clientDetails->applicationId ="APP-80W284485P519543T";
		        $CARequest->clientDetails->deviceId = DEVICE_ID;
		        $CARequest->clientDetails->ipAddress = "127.0.0.1";
		           	
		       	$CARequest->contactPhoneNumber = $contactPhoneNumber;
		       	$CARequest->currencyCode = $currencyCode;
		       	$CARequest->dateOfBirth = $dateOfBirth;
		       	       	
		       	$name = new NameType();
		       	$name->firstName = $namefirstName;
		       	$name->middleName = $namemiddleName;
		       	$name->lastName = $namelastName;
		       	$name->salutation = $name_salutation;
		       	$CARequest->name = $name;
		       	       	
		       	$CARequest->notificationURL = $notificationURL;
		       	$CARequest->partnerField1 = $partnerField1;
		       	$CARequest->partnerField2 = $partnerField2;
		       	$CARequest->partnerField3 = $partnerField3;
		       	$CARequest->partnerField4 = $partnerField4;
		       	$CARequest->partnerField5 = $partnerField5;
		       	$CARequest->preferredLanguageCode = "en_US";
		       	
		       	//only required for business account
		       	$bizInfo = new BusinessInfoType();
		       	$bizInfo->businessName = $bizName;
		       	$bizAddress = new AddressType();
		       	$bizAddress->city = $bizcity;
		       	$bizAddress->countryCode = $bizCountryCode;
		       	$bizAddress->line1 = $bizAddressline1;
		       	$bizAddress->line2 = $bizAddressline2;
		       	$bizAddress->postalCode = $bizZIP;
		       	$bizAddress->state = $biz_address_state ;
		       	$bizInfo->businessAddress = $bizAddress;
		       			       	
				$bizInfo->workPhone = $bizWorkPhone;
				$bizInfo->category = $bizCategoryCode;
				$bizInfo->subCategory = $bizSubCategory;
				$bizInfo->customerServicePhone = $bizCustomerServicePhone;
				$bizInfo->customerServiceEmail = $bizCustomerServiceEmail;
				$bizInfo->webSite = $bizWebSite;
				$bizInfo->dateOfEstablishment = $bizDateOfEstablishment;
				$bizInfo->businessType = $businessType;
				$bizInfo->averagePrice = $averagePrice;
				$bizInfo->averageMonthlyVolume = $averageMonthlyVolume;
				$bizInfo->percentageRevenueFromOnline = $percentageRevenueFromOnline;
				$bizInfo->salesVenue = $salesVenue;
				$CARequest->businessInfo = $bizInfo;
		       	
		       	$rEnvelope = new RequestEnvelope();
				$rEnvelope->errorLanguage = "en_US";
		       	$CARequest->requestEnvelope = $rEnvelope ;
		       	
		       	$CARequest->createAccountWebOptions = new CreateAccountWebOptionsType();
		       	$serverName = $_SERVER['SERVER_NAME'];
		        $serverPort = $_SERVER['SERVER_PORT'];
		        $url=dirname('http://'.$serverName.':'.$serverPort.$_SERVER['REQUEST_URI']);
		        $returnURL = $url."/CreateAccountDetails.php";
		
		       	$CARequest->createAccountWebOptions->returnUrl = $returnURL;
				$CARequest->registrationType = "WEB";
		       	
				$CARequest->sandboxEmailAddress = $sandboxEmail;
		       	$CARequest->emailAddress = $email;
		       	
		       	$aa = new AdaptiveAccounts();
		       	$aa->sandBoxEmailAddress = $sandboxEmail;
				$response=$aa->CreateAccount($CARequest);
				
				if(strtoupper($aa->isSuccess) == 'FAILURE')
				{
					$_SESSION['FAULTMSG']=$aa->getLastError();
					$location = "APIError.php";
					header("Location: $location");
				
				}
				else {
					
										
					$location = $response->redirectURL;
					if(!empty($location)) {
						$_SESSION['createdAccount'] = $response;
						header("Location: $location");	
					}
					
				}
		
		}
		catch(Exception $ex) {
			
			$fault = new FaultMessage();
			$errorData = new ErrorData();
			$errorData->errorId = $ex->getFile() ;
  			$errorData->message = $ex->getMessage();
	  		$fault->error = $errorData;
			$_SESSION['FAULTMSG']=$fault;
			$location = "APIError.php";
			header("Location: $location");
		}
	
       
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <link href="common/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<br/>
        <div id="jive-wrapper">
            <div id="jive-header">
                <div id="logo">
                    <span >You must be Logged in to <a href="<?php echo DEVELOPER_PORTAL;?>" target="_blank">PayPal sandbox</a></span>
                    <a title="Paypal X Home" href="#"><div id="titlex"></div></a>
                </div>
            </div>

<div id="main">
<?php include 'menu.html'?>
<div id="request_form">
<h3><b>Account Creation Confirmation</b></h3> <br>
<br>
<h5>Account Created!</h5><br>
<br>
<table align="center" width="50%">
    <tr>
        <td class="thinfield">CorrelationId:</td>
        <td class="thinfield"><?php echo $response->responseEnvelope->correlationId ?></td>
    </tr>
    <tr>
        <td class="thinfield">CreatedAccountKey:</td>
        <td class="thinfield"><?php echo $response->createAccountKey ?></td>
    </tr>
    <tr>
        <td class="thinfield">Status:</td>
        <td class="thinfield"><?php echo $response->execStatus ?></td>
    </tr>
</table>
</div>
</div>
</body>
</html>