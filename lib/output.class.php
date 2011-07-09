<?php
//	tag data.-
//	lef: (int)		left boundary
//	rig: (int)		right boundary
//	inn: (string)	inner tag declaration
//	nam: (string)	tag name
//	fun: (string)	requested function alias
//	var: (string)	requested variable alias
//	typ: (int)		tag type (0 = closed, 1 = starting, 2 = ending)
//	vld: (bool)		tag validity
//	surrounding.-
//	ldi: (int)		left distance
//	llo: (int)		left loneliness
//  rdi: (int)		right distance
//  rlo: (int)		right loneliness
//  flo: (int)		floor
//	alt: (int)		altittude
//	
abstract class dynamoParser
	{
	private static $parser_stag = '<?(';
	private static $parser_etag = ')?>';
	public static function mergefile($html,$vars=null)
		{
		if (!file_exists($html) || !is_readable($html)) return false;
		$html = file_get_contents($html);
		self::parsehtml($html,$vars);
		return $html;
		}
	private static function getzones(&$html)
		{
		$tag = array();
		//
		// fetching tags offsets
			{
			$st =& self::$parser_stag;
			$et =& self::$parser_etag;
			$cur = 0;
			while ($cur = strpos($html,$st,$cur))
				{
				$lef = $cur;
				$rig = strpos($html,$et,$lef+strlen($st));
				$inn = ($rig === false)? false: true;
				$rig = ($rig !== false)?
					$rig + strlen($et):
					strlen($html);
				$inn = (!$inn)? null:
					substr($html,
						$lef+strlen($st),
						$rig-$lef-strlen($st)-strlen($et));
				$tag[] = array(
					'lef'=>&$lef,
					'rig'=>&$rig,
					'inn'=>&$inn); // $html = substr_replace($html,"(TAG_COMES_HERE)",$lef,$rig-$lef);
				$cur = $rig;
				unset($lef,$rig,$inn);
				}
			unset($st,$et,$cur);
			}
		//
		// tag basic properties
			{
			while (list($key,) = each($tag))
				{
				$inn =& $tag[$key]['inn'];
				$vld =& $tag[$key]['vld'];
				$typ =& $tag[$key]['typ'];
				$nam =& $tag[$key]['nam'];
				$fun =& $tag[$key]['fun'];
				$par =& $tag[$key]['par'];
				$var =& $tag[$key]['var'];
				//
				$vld = (isset($inn) && strlen($inn))? true: false;
				if ($vld)
					{
					$ls = $inn[0] == '/';
					$rs = $inn[strlen($inn)-1] == '/';
					if ($ls && $rs) $vld = false;
						else
						{
						$typ = ($rs)? 0: (($ls)? 2: 1);
						$str = ($rs)? substr($inn,0,-1):
							(($ls)? substr($inn,1): $inn);
						@list($nam,$par) = explode(' ',$str,2);
						$par = explode(' ',trim($par));
						$par = array_flip($par);
						unset($str);
						$exp = explode(':',$nam,2);
						if (count($exp) == 2 &&	strlen($exp[0]) && strlen($exp[1]))
							list($fun,$var) = $exp;	else $vld = false;
						unset($exp);
						if (!$vld) $typ = $nam = $fun = $var = null;
						}
					unset($ls,$rs);
					}
				unset($key,$inn,$vld,$typ,$nam,$fun,$var);
				}
			reset($tag);
			}
		//
		// unregister contained tags
			{
			$lvl = 0;
			$see = null;
			while (list($key,) = each($tag))
				{
				$nam  = &$tag[$key]['nam'];
				$typ  = &$tag[$key]['typ'];
				$zer  = (!$lvl)? true:false;
				$lvl += ($typ == 1 && ($nam == $see || $zer))?	1:0;
				$lvl -= ($typ == 2 && ($nam == $see))?			1:0;
				if (!$zer &&  $lvl) unset($tag[$key]);
				if ($typ != 0)
					if		( $zer &&  $lvl) $see = $nam;
					elseif	(!$zer && !$lvl) $see = null;
				unset($nam,$typ,$zer);
				}
			reset($tag);
			unset($lvl,$see);
			}
		//
		// calculate surrounding
			{
			$tag = array_reverse($tag);
			while (list($key,) = each($tag))
				{
				// right distance
					{
					$dis =& $tag[$key]['rdi'];
					$lon =& $tag[$key]['rlo'];
					$cur =  $tag[$key]['rig'];
					for	($dis = 0 ; $html[$cur] == chr(32) || $html[$cur] == chr(9)	; $cur++) $dis++;
					$lon = ($html[$cur] == chr(10))? true:false;
					unset($dis,$lon,$cur);
					}
				// left distance, floor and altittude
					{
					$dis =& $tag[$key]['ldi'];
					$lon =& $tag[$key]['llo'];
					$cur =  $tag[$key]['lef'] - 1;
					$flo =& $tag[$key]['flo'];
					$alt =& $tag[$key]['alt'];
					for	($dis = 0 ; $html[$cur] == chr(32) || $html[$cur] == chr(9)	; $cur--) $dis++;
					$lon = ($html[$cur] == chr(10))? true:false;
					$cur++;
					$cur = strrpos($html,chr(10),$cur-strlen($html)) + 1;
					if ($cur == 1) $cur = 0; // should delete it :/
					$flo = $cur;
					for	($alt = 0 ; $html[$cur] == chr(32) || $html[$cur] == chr(9)	; $cur++) $alt++; // $html = substr_replace($html,$alt,$cur,0);
					unset($dis,$lon,$cur,$flo,$alt);
					}
				}
			reset($tag);
			}
		//
		return $tag;
		}
	private static function parsehtml(&$html,&$vars = null)
		{
		$zon = self::getzones($html);
		while (list($z,) = each($zon))
			{
			if (0)
				{
				echo "<pre>";
				echo "$z → ({$zon[$z]['vld']}) ({$zon[$z]['typ']}) {$zon[$z]['inn']}\n";
				echo "\tThis Cycle: {$z}\tActual Key: ".key($zon);
				//var_dump($zon[$z]);
				echo "</pre>";
				}
			if (!is_array($zon[$z])) break;
			$ref =& $zon[$z];
			$vld =  $ref['vld'];
			$typ =  $ref['typ'];
			$act =& $ref['act'];
			$con =& $ref['con'];
			$act = true;
			if		(!$vld)		$act = false;
			elseif	($typ == 0)	$act = true;
			elseif	($typ == 1)	$act = false;
			elseif  ($typ != 2) $act = false;
				else
				{
				$lef =& $ref['lef']; $rig =& $ref['rig'];
				$ldi =& $ref['ldi']; $llo =& $ref['llo'];
				$rdi =  $ref['rdi']; $rlo =  $ref['rlo'];
				$flo =& $ref['flo']; $alt =& $ref['alt'];
				$par =& $ref['par'];
				$nam1 =  $ref['nam'];
				unset($ref); $ref =& $zon[key($zon)];
				$nam2 = $ref['nam'];
				$vld =  $ref['vld']; $typ =  $ref['typ'];
				if (!($vld && $typ == 1 && $nam1 == $nam2))
					$act = false; else
					{
					$iri = $lef - $ldi - (($llo)?1:0);
					$ile = $ref['rig'] + $ref['rdi'] + (($ref['rlo'])?1:0);
					$lef = $ref['lef'];
					$ldi = $ref['ldi']; $llo = $ref['llo'];
					$flo = $ref['flo']; $alt = $ref['alt'];
					$par = $ref['par'];
					unset($ref); $ref =& $zon[$z];
					$con = true;
					$ref['ile'] = $ile;
					$ref['iri'] = $iri;
					if (0)
						{
						$html = substr_replace($html,'(RIG)',$rig,0);
						$html = substr_replace($html,'(IRI)',$iri,0);
						$html = substr_replace($html,'(ILE)',$ile,0);
						$html = substr_replace($html,'(LEF)',$lef,0);
						}
					unset($zon[key($zon)]);
					unset($iri,$ile,$par);
				//	unset(
				//		$ref['typ'],
				//		$ref['nam'],
				//		$ref['inn'],
				//		$ref['vld'],
				//		$ref['typ']);

					//$html = substr_replace($html,$con,$lef,$rig-$lef);
					}
				unset($lef,$rig,$ldi,$llo);
				unset($rdi,$rlo,$flo,$alt);
				}
			unset($ref,$vld,$typ,$con,$act);
			}
		reset($zon);
		// replace tags then
		while (list($z,) = each($zon))
			{
			$ref =& $zon[$z];
			$lef = $ref['lef']; $rig = $ref['rig'];
			$ldi = $ref['ldi']; $llo = $ref['llo'];
			$rdi = $ref['rdi']; $rlo = $ref['rlo'];
			$flo = $ref['flo']; $alt = $ref['alt'];
			$fun = $ref['fun'];
			$par = $ref['par']; $con = $ref['con'];
			$var = $vars[$ref['var']];
			if (isset($par['enter'])) $arr =& $var; else $arr =& $vars;
			if (!$con)
				{
				$con = null;
				switch($fun)
					{
					case 'print':
						$con = (isset($var))?(
							(!is_array($var))?(string)$var:count($var)
							): null;
						break;
					}
				}
				else
				{
				$ile = $ref['ile'];
				$iri = $ref['iri'];
				if (0)
					{
					$html = substr_replace($html,'(RIG)',$rig,0);
					$html = substr_replace($html,'(IRI)',$iri,0);
					$html = substr_replace($html,'(ILE)',$ile,0);
					$html = substr_replace($html,'(LEF)',$lef,0);
					}
				$con = null;
				switch($fun)
					{
					case 'isset':
						if (isset($var) && $var !== false)
							{
							$con = substr($html,$ile,$iri-$ile);
							self::parsehtml($con,$arr);
							}
						break;
					case '!isset':
						if (!isset($var) || !$var)
							{
							$con = substr($html,$ile,$iri-$ile);
							self::parsehtml($con,$arr);
							}
						break;
					case 'each':
						if (isset($var) && is_array($var))
							{
							$con = substr($html,$ile,$iri-$ile);
							while (list($z,) = each($var))
								{
								$cur = $con;
								self::parsehtml($cur,$var[$z]);
								$exp[] = $cur;
								}
							if (count($exp))
								$con = implode(chr(10),$exp);
							}
						break;
					}
				}
			$fle = $lef;
			$fri = (($rlo)? $rig + $rdi : $rig);
			if (!strlen($con))
				{
				// FIX THIS
				$fle = (($llo && $rlo)? $flo -1 : $fle);
				//$fle = $flo;
				//if ($fle && $html[$fle-1] == chr(10)) $fle--;
				//$fle = (($llo && $rlo)? $fle - $ldi -1 : $fle);
				}
				else
				{
				// minimum common altitude
				$com = null;
				$cur = -1;
				do	{ $cur++;
					for ($dis = 0; $con[$cur] == chr(32) || $con[$cur] == chr(9); $dis++, $cur++ );
					if (!isset($com) || $com > $dis) $com = $dis;
					}
				while ($cur = strpos($con,chr(10),$cur));
				unset($cur,$dis);
				//echo "($com)[[[[".htmlentities($con)."]]]]<br/>\n";
				if ($com)
					{
					$cur = -1;
					do $con = substr_replace($con,null,++$cur,$com);
					while ($cur = strpos($con,chr(10),$cur));
					} unset($cur,$com);
				// jump to parent floor
				$con = str_replace(chr(10),chr(10).substr($html,$flo,$alt),$con);
				}
			$html = substr_replace($html,$con,$fle,$fri-$fle);
			unset($ref);
			}
		reset($zon);
		if (0)
			{
			echo "<pre>";
			var_dump($zon);
			echo "<pre>";
			}
		}
	}
?>
