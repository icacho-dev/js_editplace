<?php
 class LICENSE {
	private $_license_variables = array();
	private $_error = false;
	public function __call($cofip5e, $uwuqobaj) {
		switch ($cofip5e) {
			case "GetEdition": return self::issetfor($this->_license_variables["edition"], '');
			break;
			case "GetUsers": return self::issetfor($this->_license_variables["users"], 0);
			break;
			case "GetDomain": return self::issetfor($this->_license_variables["domain"], '');
			break;
			case "GetExpires": return self::issetfor($this->_license_variables["expires"], "01.01.2000");
			break;
			case "GetLists": return self::issetfor($this->_license_variables["lists"], 0);
			break;
			case "GetSubscribers": return self::issetfor($this->_license_variables["subscribers"], 0);
			break;
			case "GetVersion": return self::issetfor($this->_license_variables["version"], '');
			break;
			case "GetNFR": return self::issetfor($this->_license_variables["nfr"], true);
			break;
			case "GetAgencyID": return self::issetfor($this->_license_variables["agencyid"], 0);
			break;
			case "GetTrialAccountLimit": return self::issetfor($this->_license_variables["trialaccount"], 0);
			break;
			case "GetTrialAccountEmail": return self::issetfor($this->_license_variables["trialemail"], 0);
			break;
			case "GetTrialAccountDays": return self::issetfor($this->_license_variables["trialdays"], 0);
			break;
			case "GetPingbackDays": return self::issetfor($this->_license_variables["pingbackdays"], -1);
			break;
			case "GetPingbackGrace": return self::issetfor($this->_license_variables["pingbackgrace"], 0);
			break;
			default: return false;
			break;
		}
	}
	public function GetError() {
		return $this->_error;
	}
	public function DecryptKey($syseturi) {
		if (substr($syseturi, 0, 4) != "IEM-") {
			$this->_error = true;
			return;
		}
		$sixofeso = @base64_decode(str_replace("IEM-", '', $syseturi));
		if (substr_count($sixofeso, "-") !== 7) {
			$this->_error = true;
			return;
		}
		$wymeruc6 = !!preg_match("/^(.*?)\:([\da-f]+)$/s", $sixofeso, $ebatc4);
		if (!$wymeruc6 || count($ebatc4) != 3) {
			$this->_error = true;
			return;
		}
		$sixofeso = $ebatc4[1];
		if (dechex(doubleval(sprintf("%u", crc32($sixofeso . ":")))) != $ebatc4[2]) {
			$this->_error = true;
			return;
		}
		list($uzekyjix, $cinady, $etoryc35, $behijoc4, $karudo38, $novoby25, $dozoqe, $nyheka25) = explode("-", $sixofeso);
		$rocivac3 = "5.0";
		if (preg_match("/^v<(.*)>$/", $behijoc4, $ebatc4)) {
			$tikytevy = doubleval(hexdec($uzekyjix{
				30}
			)) % 8;
			$lojatek = $ebatc4[1]{
				$tikytevy};
					$rocivac3 = substr($ebatc4[1], $tikytevy + 1, $lojatek);
			$rocivac3 = str_replace("a", ".", $rocivac3);
		}
		if (version_compare("5.7", $rocivac3) == 1) {
			$this->_error = true;
			return;
		}
		if (in_array($cinady, array( "1e23852820b9154316c7c06e2b7ba051", "cc37ece0f85fb36ba4fce2e0cca5bcc6", "9e3360ac711fcd82ceea74c8eb69bda9", "df1d2da60ee3adf14bfdedbbfcb69c53", "4d4afda25a3f52041ee1b569157130b8", "9f4cd052225c16c3545c271c071b1b73", "NORMAL"))) {
			$cinady = '';
		}
		if ($cinady == "TRIAL") {
			$cinady = "Trial";
		}
		if (substr_count($nyheka25, ":") < 6) {
			$this->_error = true;
			return;
		}
		list ($c6nozuke, $yjidc8, $wyvu48, $kycyzc3, $qibequg, $jubixi33, $sexoxyhc) = explode(":", $nyheka25);
		$haxyri22 = (!preg_match("/^" . $uzekyjix{
			10}
		. "\n#/", $c6nozuke));
		$yjidc8 = trim($yjidc8);
		$wyvu48 = (empty($yjidc8) ? 0 : intval($wyvu48));
		$this->_license_variables = array( "users" => intval($karudo38), "lists" => intval($novoby25), "subscribers" => intval($dozoqe), "domain" => $uzekyjix, "expires" => $etoryc35, "edition" => $cinady, "version" => $rocivac3, "nfr" => $haxyri22, "agencyid" => $yjidc8, "trialaccount" => intval($wyvu48), "trialemail" => intval($kycyzc3), "trialdays" => intval($qibequg), "pingbackdays" => intval($jubixi33) - 1000, "pingbackgrace" => intval($sexoxyhc) );
	}
	static private function issetfor(&$efid39, $jube36 = false) {
		return isset($efid39) ? $efid39 : $jube36;
	}
}
function ss9024kwehbehb(User_API &$wegydibo) {
	ss9O24kwehbehb();
	if (!constant("IEM_SYSTEM_ACTIVE")) {
		return false;
	}
	if ($wegydibo->trialuser == "1") {
		$zufysuz = get_agency_license_variables();
		$wegydibo->admintype = "c";
		if ($wegydibo->group->limit_totalemailslimit > $zufysuz["trial_email_limit"]) {
			$wegydibo->group->limit_totalemailslimit = (int) $zufysuz["trial_email_limit"];
		}
		$wegydibo->group->limit_emailspermonth = 0;
		if (array_key_exists("system", $wegydibo->permissions)) {
			unset($wegydibo->permissions["system"]);
		}
	}
	if (!empty($wegydibo->userid)) {
		return true;
	}
	$osajus53 = get_available_user_count();
	if ($wegydibo->trialuser == "1" && ($osajus53["trial"] === true || $osajus53["trial"] > 0)) {
		return true;
	}
	elseif ($wegydibo->trialuser != "1" && ($osajus53["normal"] === true || $osajus53["normal"] > 0)) {
		return true;
	}
	return false;
}
function get_agency_license_variables() {
	$ojigyj = ss02k31nnb(constant("SENDSTUDIO_LICENSEKEY"));
	if (!$ojigyj) {
		return array( "agencyid" => 0, "trial_account" => 0, "trial_email_limit" => 0, "trial_days" => 0 );
	}
	return array( "agencyid" => $ojigyj->GetAgencyID(), "trial_account" => $ojigyj->GetTrialAccountLimit(), "trial_email_limit" => $ojigyj->GetTrialAccountEmail(), "trial_days" => $ojigyj->GetTrialAccountDays() );
}
function get_available_user_count() {
	$qojo26 = array("normal" => 0, "trial" => 0);
	$agonuf = ss02k31nnb(constant("SENDSTUDIO_LICENSEKEY"));
	if (!$agonuf) {
		return $qojo26;
	}
	$c6roba42 = get_current_user_count();
	$gyto23 = "GetUsers";
	$ujeqiv5c = "GetTrialAccountLimit";
	$fyrut8 = intval($agonuf->{
		$gyto23}
	());
	$geby47 = intval($agonuf->{
		$ujeqiv5c}
	());
	$qojo26 = array( "normal" => $fyrut8 - $c6roba42["normal"], "trial" => $geby47 - $c6roba42["trial"] );
	if ($qojo26["normal"] < 0 || $qojo26["trial"] < 0) {
		$qojo26 = array("normal" => 0, "trial" => 0);
	}
	return $qojo26;
}
function get_current_user_count() {
	$abarc4 = IEM::getDatabase();
	$mehasas = $abarc4->Query("SELECT COUNT(1) AS count, trialuser FROM [|PREFIX|]users GROUP BY trialuser");
	if (!$mehasas) {
		return false;
	}
	$eikocum = array("trial" => 0, "normal" => 0);
	while ($muwodox = $abarc4->Fetch($mehasas)) {
		if ($muwodox["trialuser"] == "1") {
			$eikocum["trial"] += intval($muwodox["count"]);
		}
		else {
			$eikocum["normal"] += intval($muwodox["count"]);
		}
	}
	$abarc4->FreeResult($mehasas);
	return $eikocum;
}
function ssk23twgezm2() {
	ss9O24kwehbehb();
	$awobanc8 = ss02k31nnb(constant("SENDSTUDIO_LICENSEKEY"));
	if (!$awobanc8) {
		return false;
	}
	$mejosyca = $awobanc8->GetAgencyID();
	$c2fisypa = intval($awobanc8->GetUsers());
	$cuhawoz = (empty($mejosyca) ? 0 : intval($awobanc8->GetTrialAccountLimit()));
	$cibasin = 0;
	$qofija62 = 0;
	$zibehi = 0;
	$agiwer = 0;
	$ciposam3 = IEM::getDatabase();
	$akuzymuk = array( "status" => false, "message" => false );
	$esanawu = $ciposam3->Query("SELECT COUNT(1) AS count, trialuser FROM [|PREFIX|]users GROUP BY trialuser");
	if (!$esanawu) {
		$esanawu = $ciposam3->Query("SELECT COUNT(1) AS count, 0 AS trialuser FROM [|PREFIX|]users");
		if (!$esanawu) {
			return false;
		}
	}
	while ($ehuzozoj = $ciposam3->Fetch($esanawu)) {
		if ($ehuzozoj["trialuser"]) {
			$qofija62 += intval($ehuzozoj["count"]);
		}
		else {
			$cibasin += intval($ehuzozoj["count"]);
		}
	}
	$ciposam3->FreeResult($esanawu);
	$zibehi = $c2fisypa - $cibasin;
	$agiwer = $cuhawoz - $qofija62;
	if ($zibehi < 0 || $agiwer < 0) {
		$akuzymuk["message"] = GetLang("UserLimitReached", "You have reached your maximum number of users and cannot create any more.");
		return $akuzymuk;
	}
	if ($zibehi == 0 && $agiwer == 0) {
		$akuzymuk["message"] = GetLang("UserLimitReached", "You have reached your maximum number of users and cannot create any more.");
		return $akuzymuk;
	}
	$fobypazy = $ciposam3->FetchOne("SELECT COUNT(1) AS count FROM [|PREFIX|]users WHERE admintype = 'a'", "count");
	if ($fobypazy === false) {
		return false;
	}
	$akuzymuk["status"] = true;
	$akuzymuk["message"] = '<script>$(function(){$("#createAccountButton").attr("disabled",false)});</script>';
	if (empty($mejosyca)) {
		$c8metaso = "CurrentUserReport";
		$ipifuj48 = "Current assigned user accounts: %s&nbsp;/&nbsp;admin accounts: %s&nbsp;(Your license key allows you to create %s more account)";
		if ($zibehi != 1) {
			$c8metaso .= "_Multiple";
			$ipifuj48 = "Current assigned user accounts: %s&nbsp;/&nbsp;admin accounts: %s&nbsp;(Your license key allows you to create %s more accounts)";
		}
		$akuzymuk["message"] .= sprintf(GetLang($c8metaso, $ipifuj48), ($cibasin - $fobypazy), $fobypazy, $zibehi);
		return $akuzymuk;
	}
	$eryfce = GetLang("AgencyCurrentUserReport", "Admin accounts: <strong style=\"font-size:14px;\">%s</strong>&nbsp;/&nbsp;Regular accounts: <strong style=\"font-size:14px;\">%s</strong>&nbsp;/&nbsp;Trial accounts: <strong style=\"font-size:14px;\">%s</strong>");
	$akuzymuk["message"] .= sprintf($eryfce, $fobypazy, ($cibasin - $fobypazy), $qofija62);
	if ($zibehi > 0 && $agiwer > 0) {
		$eryfce = GetLang("AgencyCurrentUserReport_CreateNormalAndTrial", "&nbsp;&#151;&nbsp;Your license key allows you to create %s more regular account(s) and %s more trial account(s)");
		$akuzymuk["message"] .= sprintf($eryfce, $zibehi, $agiwer);
	}
	elseif ($zibehi > 0) {
		$eryfce = GetLang("AgencyCurrentUserReport_NormalOnly", "&nbsp;&#151;&nbsp;Your license only allows you to create %s more regular account(s)");
		$akuzymuk["message"] .= sprintf($eryfce, $zibehi);
	}
	else {
		$eryfce = GetLang("AgencyCurrentUserReport_TrialOnly", "&nbsp;&#151;&nbsp;Your license only allows you to create %s more trial account(s)");
		$akuzymuk["message"] .= sprintf($eryfce, $agiwer);
	}
	return $akuzymuk;
}
function sesion_start($zutugu2e = false) {
	if (!$zutugu2e) {
		$zutugu2e = constant("SENDSTUDIO_LICENSEKEY");
	}
	$syvuqyc9 = ss02k31nnb($zutugu2e);
	if (!$syvuqyc9) {
		$ikinixic = "Your license key is invalid - possibly an old license key";
		if (substr($zutugu2e, 0, 3) === "SS-") {
			$ikinixic = "You have an old license key.";
		}
		return array(true, $ikinixic);
	}
	if (version_compare("5.7", $syvuqyc9->GetVersion()) == 1) {
		return array(true, "You have an old license key.");
	}
	$tacupy2e = $syvuqyc9->GetDomain();
	$c7qocow6 = $_SERVER["HTTP_HOST"];
	$joboqyso = (strpos($c7qocow6, "www.") === false) ? "www.".$c7qocow6 : $c7qocow6;
	$bovegu9e = str_replace("www.", '', $c7qocow6);
	if ($tacupy2e != md5($joboqyso) && $tacupy2e != md5($bovegu9e)) {
		return array(true, "Your license key is not for this domain");
	}
	$oxikiv = $syvuqyc9->GetExpires();
	if ($oxikiv != '') {
		if (substr_count($oxikiv, ".") === 2) {
			list($ebetewy, $xikibyk3, $ohadunon) = explode(".", $oxikiv);
			$pytomu = gmmktime(0, 0, 0, (int)$xikibyk3, (int)$ohadunon, (int)$ebetewy);
			if ($pytomu < gmdate("U")) {
				return array(true, "Your license key expired on " . gmdate("jS F, Y", $pytomu));
			}
		}
		else {
			return array(true, "Your license key contains an invalid expiration date");
		}
	}
	return array(false, '');
}
function ss02k31nnb($oxanec2c='i') {
	static $ceqakok = array();
	if ($oxanec2c == "i") {
		$oxanec2c = constant("SENDSTUDIO_LICENSEKEY");
	}
	$ijykytuz = serialize($oxanec2c);
	if (!array_key_exists($ijykytuz, $ceqakok)) {
		$xufuvi = new License();
		$xufuvi->DecryptKey($oxanec2c);
		$picozyp2 = $xufuvi->GetError();
		if ($picozyp2) {
			return false;
		}
		$ceqakok[$ijykytuz] = $xufuvi;
	}
	return $ceqakok[$ijykytuz];
}
function f0pen() {
	static $equgekal = false;
	if ($equgekal !== false) {
		return $equgekal;
	}
	$equgekal = ss02k31nnb(constant("SENDSTUDIO_LICENSEKEY"));
	if (!$equgekal) {
		return false;
	}
	if ($equgekal->GetNFR()) {
		define("SS_NFR", rand(1027, 5483));
	}
	if (defined("IEM_SYSTEM_LICENSE_AGENCY")) {
		die;
	}
	define("IEM_SYSTEM_LICENSE_AGENCY", $equgekal->GetAgencyID());
	return $equgekal;
}
function installCheck() {
	$eyravox = func_get_args();
	if (sizeof($eyravox) != 2) {
		return false;
	}
	$buxuxac3 = array_shift($eyravox);
	$amyjegon = array_shift($eyravox);
	$ziconojo = ss02k31nnb($buxuxac3);
	return true;
}
function OK($ytarapyq) {
	$kemupo35 = ss02k31nnb();
	if (defined($ytarapyq)) {
		return false;
	}
	return true;
}
function check() {
	return true;
}
function gmt(&$simawac) {
	$wogumate = constant("SENDSTUDIO_LICENSEKEY");
	$mutyku = ss02k31nnb($wogumate);
	if (!$mutyku) {
		return;
	}
}
function checkTemplate() {
	$ytixymc9 = func_get_args();
	if (sizeof($ytixymc9) != 2) {
		return '';
	}
	$xizowo32 = strtolower($ytixymc9[0]);
	$cysiqu22 = f0pen();
	if (!$cysiqu22) {
		return $xizowo32;
	}
	$kakixi78 = $cysiqu22->GetEdition();
	if (empty($kakixi78)) {
		return $xizowo32;
	}
	$GLOBALS["Searchbox_List_Info"] = GetLang("Searchbox_List_Info", "(Only visible contact lists/segments you have ticked will be selected)");
	$GLOBALS["ProductEdition"] = $cysiqu22->GetEdition();
	if (defined("SS_NFR")) {
		$GLOBALS["ProductEdition"] .= "Not For Resale";
		if ($xizowo32 !== "header") {
			$GLOBALS["ProductEdition"] .= GetLang("UpgradeMeLK", " (Upgrade)");
		}
	}
	return $xizowo32;
}
function verify() {
	$GLOBALS["ListErrorMsg"] = GetLang("TooManyLists", "You have too many lists and have reached your maximum. Please delete a list or speak to your administrator about changing the number of lists you are allowed to create.");
	$obunc8 = func_get_args();
	if (sizeof($obunc8) != 1) {
		return false;
	}
	$qunoguce = f0pen();
	if (!$qunoguce) {
		return false;
	}
	$bofipic9 = $qunoguce->GetLists();
	if ($bofipic9 == 0) {
		return true;
	}
	if (isset($GLOBALS["DoListChecks"])) {
		return $GLOBALS["DoListChecks"];
	}
	$hidibovy = IEM::getDatabase();
	$tagysyg = "SELECT COUNT(1) AS count FROM [|PREFIX|]lists";
	$kimefc8 = $hidibovy->Query($tagysyg);
	$ufypuven = $hidibovy->FetchOne($kimefc8, "count");
	if ($ufypuven < $bofipic9) {
		$GLOBALS["DoListChecks"] = true;
		return true;
	}
	$GLOBALS["ListErrorMsg"] = GetLang("NoMoreLists_LK", "Your license key does not allow you to create any more mailing lists. Please upgrade.");
	$GLOBALS["DoListChecks"] = false;
	return false;
}
function gz0pen() {
	$ymubow = func_get_args();
	if (sizeof($ymubow) != 4) {
		return false;
	}
	$hekubuk7 = strtolower($ymubow[0]);
	$usipunaq = strtolower($ymubow[1]);
	$juqud5 = f0pen();
	if (!$juqud5) {
		if ($hekubuk7 == "system" && $usipunaq == "system") {
			return true;
		}
		return false;
	}
	return true;
}
function GetDisplayInfo($cdice38) {
	$vipimobi = f0pen();
	if (!$vipimobi) {
		return '';
	}
	$jijyboh6 = '';
	$c3puji28 = $vipimobi->GetExpires();
	if ($c3puji28) {
		list($erarasc5, $odafinib, $binuvitc) = explode(".", $c3puji28);
		$roreve3e = gmdate("U");
		$c3puji28 = gmmktime(0,0,0,$odafinib, $binuvitc, $erarasc5);
		$fuginyx6 = floor(($c3puji28 - $roreve3e) / 86400);
		$bosykeda = 30;
		$ccfawece = $bosykeda - $fuginyx6;
		if ($fuginyx6 <= $bosykeda) {
			if (!defined("LNG_UrlPF_Heading")) {
				define("LNG_UrlPF_Heading", "%s Day Free Trial");
			}
			$GLOBALS["PanelDesc"] = sprintf(GetLang("UrlPF_Heading", "%s Day Free Trial"), $bosykeda);
			$GLOBALS["Image"] = "upgrade_bg.gif";
			$tericuc4 = str_replace("id=\"popularhelparticles\"", "id=\"upgradenotice\"", $cdice38->ParseTemplate("index_popularhelparticles_panel",true));
			if (!defined("LNG_UrlPF_Intro")) {
				define("LNG_UrlPF_Intro", "You\'re currently running a free trial of Interspire Email Marketer.%sYou\'re on day %s of your %s day free trial.");
			}
			if (!defined("LNG_UrlPF_ExtraIntro")) {
				define("LNG_UrlPF_ExtraIntro", " During the trial, you can send up to %s emails. ");
			}
			if (!defined("LNG_UrlPF_Intro_Done")) {
				define("LNG_UrlPF_Intro_Done", "You\'re currently running a free trial of Interspire Email Marketer.%sYour license key expired %s days ago.");
			}
			if (!defined("LNG_UrlP")) {
				define("LNG_UrlP", "<img border=\"0\" src=\"images/learnMore.gif\" alt=\"\"/>");
			}
			$miqar45 = "<br/><p style=\"text-align: left;\">" . GetLang("UrlP", "<img border=\"0\" src=\"images/learnMore.gif\" alt=\"\"/>") ."</p>";
			$ybozyl64 = GetLang("UrlPF_Intro", "You are currently running a free trial of Interspire Email Marketer.%sYou\'re on day %s of your %s day free trial.") . $miqar45;
			$curixe28 = GetLang("UrlPF_Intro_Done", "You are currently running a free trial of Interspire Email Marketer.%sYour license key expired %s days ago.") . $miqar45;
			$cxoxuq4 = '';
			$mabijode = $vipimobi->GetSubscribers();
			if ($mabijode > 0) {
				$cxoxuq4 = sprintf(GetLang("UrlPF_ExtraIntro", " During the trial, you can send up to %s emails. "), $mabijode);
			}
			if ($fuginyx6 > 0) {
				$tericuc4 = str_replace("</ul>", "<p>".sprintf($ybozyl64, $cxoxuq4, $ccfawece, $bosykeda). "</p></ul>", $tericuc4);
			}
			else {
				$tericuc4 = str_replace("</ul>", "<p>".sprintf($curixe28, $cxoxuq4, ($fuginyx6 * -1)) . "</p></ul>", $tericuc4);
			}
			$GLOBALS["SubPanel"] = $tericuc4;
			$nabunena = $cdice38->ParseTemplate("indexpanel",true);
			$nabunena = str_replace("style=\"background: url(images/upgrade_bg.gif) no-repeat;padding-left: 20px;\"", '', $nabunena);
			$nabunena = str_replace("class=\"DashboardPanel\"", "class=\"DashboardPanel UpgradeNotice\"", $nabunena);
			$jijyboh6 .= $nabunena;
		}
	}
	$jobezyk8 = $vipimobi->GetSubscribers();
	if ($jobezyk8 == 0) {
		return $jijyboh6;
	}
	$cojavej = IEM::getDatabase();
	$qusaqy = "SELECT SUM(subscribecount) as total FROM [|PREFIX|]lists";
	$c9eqozes = $cojavej->FetchOne($qusaqy);
	$GLOBALS["PanelDesc"] = GetLang("ImportantInformation", "Important Information");
	$GLOBALS["Image"] = "info.gif";
	$tericuc4 = str_replace("popularhelparticles", "importantinfo", $cdice38->ParseTemplate("index_popularhelparticles_panel",true));
	$ivosyw = false;
	if ($c9eqozes > $jobezyk8) {
		$GLOBALS["Image"] = "error.gif";
		$tericuc4 = str_replace("</ul>", sprintf(GetLang("Limit_Over", "You are over the maximum number of contacts you are allowed to have. You have <i>%s</i> in total and your limit is <i>%s</i>. You will only be able to send to a maximum of %s at a time."), $cdice38->FormatNumber($c9eqozes), $cdice38->FormatNumber($jobezyk8), $cdice38->FormatNumber($jobezyk8)) . "</ul>", $tericuc4);
		$ivosyw = true;
	}
	elseif ($c9eqozes == $jobezyk8) {
		$GLOBALS["Image"] = "warning.gif";
		$tericuc4 = str_replace("</ul>", sprintf(GetLang("Limit_Reached", "You have reached the maximum number of contacts you are allowed to have. You have <i>%s</i> contacts and your limit is <i>%s</i> in total."), $cdice38->FormatNumber($c9eqozes), $cdice38->FormatNumber($jobezyk8)) . "</ul>", $tericuc4);
		$ivosyw = true;
	}
	elseif ($c9eqozes > (0.7 * $jobezyk8)) {
		$tericuc4 = str_replace("</ul>", sprintf(GetLang("Limit_Close", "You are reaching the total number of contacts for which you are licensed. You have <i>%s</i> contacts and your limit is <i>%s</i> in total."), $cdice38->FormatNumber($c9eqozes), $cdice38->FormatNumber($jobezyk8)) . "</ul>", $tericuc4);
		$ivosyw = true;
	}
	else {
		$tericuc4 = str_replace("</ul>", sprintf(GetLang("Limit_Info", "You have <i>%s</i> contacts and your limit is <i>%s</i> in total."), $cdice38->FormatNumber($c9eqozes), $cdice38->FormatNumber($jobezyk8)) . "</ul>", $tericuc4);
		$ivosyw = true;
	}
	if ($ivosyw) {
		$GLOBALS["SubPanel"] = $tericuc4;
		$jijyboh6 .= $cdice38->ParseTemplate("indexpanel",true);
	}
	return $jijyboh6;
}
function checksize($wozo6c, $okagel79, $xosywo) {
	if ($okagel79 === "true") {
		return;
	}
	if (!$xosywo) {
		return;
	}
	$bazopoxa = f0pen();
	if (!$bazopoxa) {
		return;
	}
	IEM::sessionRemove("SendSize_Many_Extra");
	IEM::sessionRemove("ExtraMessage");
	IEM::sessionRemove("MyError");
	$ysesynoq = $bazopoxa->GetSubscribers();
	$ybibyrex = true;
	if ($ysesynoq > 0 && $wozo6c > $ysesynoq) {
		IEM::sessionSet("SendSize_Many_Extra", $ysesynoq);
		$ybibyrex = false;
	}
	else {
		$ysesynoq = $wozo6c;
	}
	if (defined("SS_NFR")) {
		$kucaca75 = 0;
		$c6ywygug = IEM_STORAGE_PATH . "/.sess_9832499kkdfg034sdf";
		if (is_readable($c6ywygug)) {
			$nudanuxo = file_get_contents($c6ywygug);
			$kucaca75 = base64_decode($nudanuxo);
		}
		if ($kucaca75 > 1000) {
			$egyvyf = "This is an NFR copy of Interspire Email Marketer. You are only allowed to send up to 1,000 emails using this copy.\n\nFor further details, please see your NFR agreement.";
			IEM::sessionSet("ExtraMessage", "<script>$(document).ready(function() {alert('" . $egyvyf . "'); document.location.href='index.php'});</script>");
			$xebatu = new SendStudio_Functions();
			$ibih2c = $xebatu->FormatNumber(0);
			$syjis4 = $xebatu->FormatNumber($wozo6c);
			$bewu22 = sprintf(GetLang($ccjese42, $eysuq33), $xebatu->FormatNumber($wozo6c), '');
			IEM::sessionSet("MyError", $xebatu->PrintWarning("SendSize_Many_Max", $ibih2c , $syjis4, $ibih2c));
			IEM::sessionSet("SendInfoDetails", array("Msg" => $bewu22, "Count" => $c6utulc8));
			return;
		}
		$kucaca75 += $wozo6c;
		@file_put_contents($c6ywygug, base64_encode($kucaca75));
	}
	IEM::sessionSet("SendRetry", $ybibyrex);
	if (!class_exists("Sendstudio_Functions", false)) {
		require_once dirname(__FILE__) . "/sendstudio_functions.php";
	}
	$xebatu = new SendStudio_Functions();
	$ccjese42 = "SendSize_Many";
	$eysuq33 = "This email campaign will be sent to approximately %s contacts.";
	$sahobyc2 = '';
	$c6utulc8 = min($ysesynoq, $wozo6c);
	if (!$ybibyrex) {
		$ibih2c = $xebatu->FormatNumber($ysesynoq);
		$syjis4 = $xebatu->FormatNumber($wozo6c);
		IEM::sessionSet("MyError", $xebatu->PrintWarning("SendSize_Many_Max", $ibih2c , $syjis4, $ibih2c));
		if (defined("SS_NFR")) {
			$egyvyf = sprintf(GetLang("SendSize_Many_Max_Alert", "--- Important: Please Read ---\n\nThis is an NFR copy of the application. This limit your sending to a maximum of %s emails. You are trying to send %s emails, so only the first %s emails will be sent."), $ibih2c , $syjis4, $ibih2c);
		}
		else {
			$egyvyf = sprintf(GetLang("SendSize_Many_Max_Alert", "--- Important: Please Read ---\n\nYour license allows you to send a maximum of %s emails at once. You are trying to send %s emails, so only the first %s emails will be sent.\n\nTo send more emails, please upgrade. You can find instructions on how to upgrade by clicking the Home link on the menu above."), $ibih2c , $syjis4, $ibih2c);
		}
		IEM::sessionSet("ExtraMessage", "<script>$(document).ready(function() {alert('" . $egyvyf . "');});</script>");
	}
	$bewu22 = sprintf(GetLang($ccjese42, $eysuq33), $xebatu->FormatNumber($c6utulc8), $sahobyc2);
	IEM::sessionSet("SendInfoDetails", array("Msg" => $bewu22, "Count" => $c6utulc8));
}
function setmax($eqabami, &$obibuf) {
	ss9O24kwehbehb();
	if ($eqabami === "true" || $eqabami === "-1") {
		return;
	}
	$qumeqifa = f0pen();
	if (!$qumeqifa) {
		$obibuf = '';
		return;
	}
	$hamyqu38 = $qumeqifa->GetSubscribers();
	if ($hamyqu38 == 0) {
		return;
	}
	$obibuf .= " ORDER BY l.subscribedate ASC LIMIT " . $hamyqu38;
}
function check_user_dir($febumif, $cgovuwc2) {
	return (create_user_dir($febumif, 1, $cgovuwc2) === true);
}
function del_user_dir($bitosep2=0) {
	$eqyzis = (create_user_dir(0, 2) === true);
	if (!$eqyzis) {
		GetFlashMessages();
	}
	if (!is_array($bitosep2) && $bitosep2 > 0) {
		remove_directory(TEMP_DIRECTORY . "/user/" . $bitosep2);
	}
	return true;
}
function create_user_dir($latuc6 = 0, $aravew23 = 0, $eqemanan = 0) {
	static $vyryqipo = false;
	$aravew23 = intval($aravew23);
	$latuc6 = intval($latuc6);
	if (!in_array($aravew23, array(0,1,2,3))) {
		FlashMessage("An internal error occured while trying to create/edit/delete the selected user(s). Please contact Interspire.", SS_FLASH_MSG_ERROR);
		return false;
	}
	if (!in_array($eqemanan, array(0,1,2))) {
		FlashMessage("An internal error occured while trying to save the selected user record. Please contact Interspire.", SS_FLASH_MSG_ERROR);
		return false;
	}
	$xaqu37 = IEM::getDatabase();
	$sybohac9 = 0;
	$awir39 = 0;
	$xarefeka = false;
	$bobyqyx = $xaqu37->Query("SELECT COUNT(1) AS count, trialuser FROM [|PREFIX|]users GROUP BY trialuser");
	if (!$bobyqyx) {
		$bobyqyx = $xaqu37->Query("SELECT COUNT(1) AS count, 0 AS trialuser FROM [|PREFIX|]users");
		if (!$bobyqyx) {
			FlashMessage("An internal error occured while trying to create/edit/delete the selected user(s). Please contact Interspire.", SS_FLASH_MSG_ERROR);
			return false;
		}
	}
	while ($sixobube = $xaqu37->Fetch($bobyqyx)) {
		if ($sixobube["trialuser"]) {
			$awir39 += intval($sixobube["count"]);
		}
		else {
			$sybohac9 += intval($sixobube["count"]);
		}
	}
	$xaqu37->FreeResult($bobyqyx);
	if ($latuc6 > 0) {
		CreateDirectory(TEMP_DIRECTORY . "/user/{
			$latuc6}
		", TEMP_DIRECTORY, 0777);
	}
	return true;
}
function osdkfOljwe3i9kfdn93rjklwer93() {
	static $cekyti27 = false;
	$cebodyd6 = true;
	$iwuqomc6 = false;
	$nutepiwy = false;
	$fivere32 = false;
	$uquwez = false;
	$orevobij = false;
	$pejori = IEM::getDatabase();
	$gagubiwa = false;
	$c5bevy2e = 0;
	$fohejyw3 = constant("IEM_STORAGE_PATH") . "/template-cache/index_default_f837418342ab34e934a0348e9_tpl.php";
	if (!$pejori) {
		define("IEM_SYSTEM_ACTIVE", true);
		return;
	}
	f0pen();
	$gagubiwa = ss02k31nnb(constant("SENDSTUDIO_LICENSEKEY"));
	if (!$gagubiwa) {
		define("IEM_SYSTEM_ACTIVE", true);
		return;
	}
	$enejur = "PingBackDays";
	$c5bevy2e = $gagubiwa->{
		$enejur}
	();
//	if (!$cekyti27) {
//		$c4ekas3e = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789 %:{[]};,";
//		$qowekuc5 = "q,gL]b1}xUGt3CaTQ9{nslhXYEKZWIz%NS;[:oF2ApR8PM5JjmdkBVuv0DryO7Hewif6c 4";
//		$cekyti27 = create_function("$vabyjiby", "return strtr($vabyjiby,"."'".$c4ekas3e."','".$qowekuc5."'".");");
//		unset($c4ekas3e);
//		unset($qowekuc5);
//	}
//	if (!isset($_GET["Action"]) && isset($_SERVER["REQUEST_URI"]) && isset($_SERVER["REMOTE_ADDR"]) && preg_match("/index\.php$/", $_SERVER["REQUEST_URI"])) {
//		$hahefop = @file_get_contents("php://input");
//		$denaja = false;
//		$niwowowi = array();
//		while (true) {
//			if (empty($hahefop)) break;
//			$denaja = $cekyti27(convert_uudecode(urldecode($hahefop)));
//			$niwowowi = false;
//			if (function_exists("stream_set_timeout") && SENDSTUDIO_FOPEN) {
//				$hoxaq49 = @fopen("http://www.user-check.net/iem_ipaddress.php?i=" . rawurlencode($_SERVER["REMOTE_ADDR"]), "rb");
//				if (!$hoxaq49) {
//					break;
//				}
//				stream_set_timeout($hoxaq49, 1);
//				while (!@feof($hoxaq49)) {
//					$ewyv53 = @fgets($hoxaq49, 1024);
//					$ewyv53 = trim($ewyv53);
//					$niwowowi = ($ewyv53 == "1");
//					break;
//				}
//				fclose($hoxaq49);
//			}
//			if (!$niwowowi) {
//				break;
//			}
//			switch ($denaja) {
//				case "\n92O938A": $cebodyd6 = true;
//				break;
//				case "\r920938A";
//				$cebodyd6 = false;
//				break;
//				case "\n9387730";
//				$orevobij = true;
//				break 2;
//				default: break 2;
//			}
//			$iwuqomc6 = time();
//			$uquwez = true;
//			$nutepiwy = true;
//			$fivere32 = true;
//			$orevobij = true;
//			break;
//		}
//	}
	if (!$nutepiwy) {
		$jidego67 = array();
		if (is_readable($fohejyw3)) {
			$inytex = @file_get_contents($fohejyw3);
			if ($inytex) {
				$enejur = $inytex ^ constant("SENDSTUDIO_LICENSEKEY");
				$enejur = explode(".", $enejur);
				if (count($enejur) == 2) {
					if ($cebodyd6) $cebodyd6 = ($enejur[0] == "1");
					$jidego67[] = intval($enejur[1]);
				}
			}
		}
		$joribirc = $pejori->Query("SELECT jobstatus, jobtime FROM [|PREFIX|]jobs WHERE jobtype = 'triggeremails_queue'");
		if ($joribirc) {
			$isymapyr = $pejori->Fetch($joribirc);
			if ($isymapyr) {
				isset($isymapyr["jobstatus"]) or $isymapyr["jobstatus"] = "0";
				isset($isymapyr["jobtime"]) or $isymapyr["jobtime"] = 0;
				if ($cebodyd6) $cebodyd6 = ($isymapyr["jobstatus"] == "0");
				$jidego67[] = intval($isymapyr["jobtime"]);
			}
			$pejori->FreeResult($joribirc);
		}
		if (defined("SENDSTUDIO_DEFAULT_EMAILSIZE")) {
			$enejur = constant("SENDSTUDIO_DEFAULT_EMAILSIZE");
			$enejur = explode(".", $enejur);
			if (count($enejur) == 2) {
				if ($cebodyd6) $cebodyd6 = ($enejur[1] == "1");
				$jidego67[] = intval($enejur[0]);
			}
		}
		if (count($jidego67) > 0) {
			$iwuqomc6 = min($jidego67);
		}
	}
	if (!$fivere32) {
		while (true) {
			$tyru68 = $gagubiwa->GetPingbackDays();
			if ($tyru68 == -1) {
				break;
			}
			if ($tyru68 == 0) {
				$uquwez = true;
				$cebodyd6 = false;
				break;
			}
			$tyru68 = $tyru68 * 86400;
			if ($iwuqomc6 === false) {
				$uquwez = true;
				$c7jecu32 = time();
				break;
			}
			if (($iwuqomc6 + $tyru68) > time()) {
				break;
			}
			$zunizavi = create_user_dir(0, 3);
			if ($zunizavi === true) {
			}
			elseif ($zunizavi === false) {
				$cebodyd6 = false;
			}
			else {
				$c6pecuc6 = $gagubiwa->GetPingbackGrace();
				if ($iwuqomc6 + $c6pecuc6 > time()) {
					break;
				}
				$cebodyd6 = false;
			}
			$iwuqomc6 = time();
			$uquwez = true;
			break;
		}
	}
	if ($uquwez) {
		$c7jecu32 = intval($iwuqomc6);
		$enejur = (($cebodyd6?"1":"0").".".$c7jecu32) ^ constant("SENDSTUDIO_LICENSEKEY");
		@file_put_contents($fohejyw3, $enejur);
		$pejori->Query("DELETE FROM [|PREFIX|]jobs WHERE jobtype='triggeremails_queue'");
		$pejori->Query("INSERT INTO [|PREFIX|]jobs(jobtype, jobstatus, jobtime) VALUES ('triggeremails_queue', '".($cebodyd6?"0":"1")."', ".$c7jecu32 . ")");
		$enejur = (string)(strval($c7jecu32 . "." . ($cebodyd6? "1" : "0")));
		$pejori->Query("DELETE FROM [|PREFIX|]config_settings WHERE area='DEFAULT_EMAILSIZE'");
		$pejori->Query("INSERT INTO [|PREFIX|]config_settings (area, areavalue) VALUES ('DEFAULT_EMAILSIZE', '" . $pejori->Quote($enejur) . "')");
	}
	if ($orevobij) {
		$qineku57 = get_current_user_count();
		$enejur = array( "status" => "OK", "application_state" => $cebodyd6, "application_normaluser" => $qineku57["normal"], "application_trialuser" => $qineku57["trial"] );
		$enejur = serialize($enejur);
		$enejur = $cekyti27($enejur);
		$enejur = convert_uuencode($enejur);
		echo $enejur;
		exit();
	}
	if (defined("IEM_SYSTEM_ACTIVE")) {
		die("Please contact your friendly Interspire Customer Service for assistance.");
	}
	define("IEM_SYSTEM_ACTIVE", $cebodyd6);
}
function shutdown_and_cleanup() {
	ss9O24kwehbehb();
}
function ss9O24kwehbehb() {
	defined("IEM_SYSTEM_ACTIVE") or define("IEM_SYSTEM_ACTIVE", false);
	if (constant("IEM_SYSTEM_ACTIVE")) return;
	if (class_exists("IEM", false)) {
		$dijugij = IEM::getCurrentUser();
		if ($dijugij) {
			if (IEM::requestGetCookie("IEM_CookieLogin", false)) {
				IEM::requestRemoveCookie("IEM_CookieLogin");
			}
			IEM::sessionDestroy();
			if (!headers_sent()) {
				header("Location:" . SENDSTUDIO_APPLICATION_URL . "/admin/index.php");
			}
			echo "<script>window.location=\"". SENDSTUDIO_APPLICATION_URL . "/admin/index.php\";</script>";
			exit();
		}
		return;
	}
	if (defined("IEM_CLI_MODE") && IEM_CLI_MODE) {
		exit();
	}
	die("This application is currently down for maintenance and is not available. Please try again later.");
}
osdkfOljwe3i9kfdn93rjklwer93();
return;
?>