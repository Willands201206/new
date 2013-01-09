<?php
session_start();
/****************************************************************
*		global変数
****************************************************************/
$dbconn 			= null; //DB接続リソース
$gyojiData 			= null; //行事データ結果セット
$kyukambiData 		= null; //休館日データ結果セット
$createCount 		= null; //カレンダー作成数
$previewParamArray 	= null; //プレビュー用パラメータ
$classNameSuffix 	= null; //CSSクラス名サフィックス（トップページと博物館のご案内ページでクラスが異なる為）
$column_position 	= null; //カレンダー列位置

define("TOP_FLG_ON", 1); //トップページ判定ON
define("TOP_FLG_OFF", 0); //トップページ判定OFF

/****************************************************************
* 機　能： カレンダーを表示するHTMLタグ作成します。（全体）
* 引　数： ［入力］$count　カレンダー作成数
* 　　　　 ［入力］$previewParam　プレビュー用パラメータ
* 　　　　 　　　　行事情報：区分("gyoji")、行事区分、段落名、開始日、終了日、
* 　　　　 　　　　カレンダー公開("t":true、"t"以外：false)
* 　　　　 　　　　休館日情報：区分("kyukambi")、日付
* 戻り値： HTMLタグ（カレンダー全体）
****************************************************************/
function calendarCreate($count, $previewParam = null)
{
	global $createCount, $previewParamArray, $classNameSuffix;

	$createCount = $count;
	$previewParamArray = $previewParam;
	$classNameSuffix = ($createCount == 1) ? "1" : "2";

	//トップページかどうかの判断
	if($createCount == 1){	
		$top_flag = TOP_FLG_ON;
	}else{
		$top_flag = TOP_FLG_OFF;
	}
	
	$tag = "";

	for ($i=1; $i <= $createCount; $i++)
	{	
		$thisMonthFirstDay = date("Y/m/01");
		if ($i == 1)
		{	//当月
			$targetFirstDay = $thisMonthFirstDay;
			$targetLastDay  = date("Y/m/t");
		}
		else
		{	//翌月以降
			$addMonth = $i - 1;
			$targetFirstDay = date("Y/m/d", strtotime("+".$addMonth." month", 
									strtotime($thisMonthFirstDay)));
			$targetLastDay  = date("Y/m/t", strtotime("+".$addMonth." month", 
									strtotime($thisMonthFirstDay)));
		}

		$tag .= "<div class=\"sotowaku".$classNameSuffix."\">\n";
		$tag .= yearMonthTagCreate($targetFirstDay);
		$tag .= yobiTagCreate();
		$tag .= daysTagCreate($targetFirstDay, $targetLastDay, $top_flag);
		$tag .= "</div>\n";
	}

	return $tag;
}



/****************************************************************
* 機　能： カレンダーを表示するHTMLタグ作成します。（年月）
* 引　数： ［入力］$targetFirstDay　作成対象開始日
* 戻り値： HTMLタグ（年月）
****************************************************************/
function yearMonthTagCreate($targetFirstDay)
{
	global $createCount, $classNameSuffix;

	$className_year = "year".$classNameSuffix;
	$className_month = "month".$classNameSuffix;
	$className_3MonthLink = "link".$classNameSuffix;
	$className_YearLeft = "year_left".$classNameSuffix;
	$className_YearRight = "year_right".$classNameSuffix;
	
	
	list($year, $month, ) = explode("/", $targetFirstDay);

	$tag = "<div class=\"".$className_year."\"><div class=\"".$className_YearLeft."\">".$year.
			"年<span class=\"".$className_month."\">".$month."</span>月</div>";

	if ($createCount == 1)
	{
		define("hakubutsukanGuideFile", "museum/index.html");
		if(isset($_GET["preview"]) == true){
			$tag .= "<div class=\"".$className_YearRight."\"><span class=\"".$className_3MonthLink."\">".
					"<a href='javascript:void(0);'>３ヶ月表示</a></span></div>";
		}
		else{
			$tag .= "<div class=\"".$className_YearRight."\"><span class=\"".$className_3MonthLink."\">".
					"<a href=\"".hakubutsukanGuideFile."\">３ヶ月表示</a></span></div>";
		}
	}

	$tag .= "</div>\n";

	return $tag;
}



/****************************************************************
* 機　能： カレンダーを表示するHTMLタグ作成します。（曜日）
* 引　数： なし
* 戻り値： HTMLタグ（曜日）
****************************************************************/
function yobiTagCreate()
{
	global $classNameSuffix;

	$className_sun  = "column_sun".$classNameSuffix;
	$className_week = "column_week".$classNameSuffix;
	$className_yobi = "calendar_week".$classNameSuffix;

	return <<< __yobi__
<div class="{$className_sun}"><div class="{$className_yobi}">日</div></div>
<div class="{$className_week}"><div class="{$className_yobi}">月</div></div>
<div class="{$className_week}"><div class="{$className_yobi}">火</div></div>
<div class="{$className_week}"><div class="{$className_yobi}">水</div></div>
<div class="{$className_week}"><div class="{$className_yobi}">木</div></div>
<div class="{$className_week}"><div class="{$className_yobi}">金</div></div>
<div class="{$className_week}"><div class="{$className_yobi}">土</div></div>\n
__yobi__;

}



/****************************************************************
* 機　能： カレンダーを表示するHTMLタグ作成します。（日付全体）
* 引　数： ［入力］$targetFirstDay　作成対象開始日
* 　　　　 ［入力］$targetLastDay　作成対象終了日
* 　　　　 ［入力］$top_flag　トップページ判定(TOP_FLG_ON or TOP_FLG_OFF)
* 戻り値： HTMLタグ（日付全体）
****************************************************************/
function daysTagCreate($targetFirstDay, $targetLastDay, $top_flag)
{
	require_once dirname( __FILE__ )."/../../maintenance/php_functions/common_functions.php";

	global $dbconn, $gyojiData, $kyukambiData, $column_position;

	$column_position = 0;
	$tag = "";

	//空枠作成（先頭行）
	//返却された曜日のインデックスは、空枠を作成する数と同値
	$count = date('w', strtotime($targetFirstDay));
	for ($i = 1; $i <= $count; $i++)
	{	
		$tag .= dayTagCreate("", $top_flag);
	}

	//休館日情報取得
	if (dbConnect($dbconn) == false)
	{
		exit(dbErrorMessageCreate("DB接続に失敗しました。"));
	}
	
	$sql = "select * from kyukambi where hizuke between '".$targetFirstDay."' and '".$targetLastDay."'";

	$kyukambiData = pg_query($dbconn, $sql);

	if ($kyukambiData == false)
	{
		exit(dbErrorMessageCreate("DB抽出に失敗しました。", $sql, $dbconn));
	}

	//行事情報取得
	$sql = "select * from gyoji where ".
			"(kaishi_bi between '".$targetFirstDay."' and '".$targetLastDay."') or ".
			"(shuryo_bi between '".$targetFirstDay."' and '".$targetLastDay."') or ".
			"(kaishi_bi <= '".$targetFirstDay."' and shuryo_bi >= '".$targetLastDay."') ".
			"order by hyoji_yusendo";

	$gyojiData = pg_query($dbconn, $sql);

	if ($gyojiData == false)
	{
		exit(dbErrorMessageCreate("DB抽出に失敗しました。", $sql, $dbconn));
	}

	//日付作成
	list( , , $lastDay) = explode("/", $targetLastDay);
	
	for ($i=1; $i<=$lastDay; $i++)
	{
		$targetDate = date("Y/m/d", strtotime("+".($i - 1)." day", strtotime($targetFirstDay)));
		$tag .= dayTagCreate($targetDate, $top_flag);
	}

	//空枠作成（最終行）
	$count = 6 - date('w', strtotime($targetLastDay));
	for ($i=1; $i<=$count; $i++)
	{	
		$tag .= dayTagCreate("", $top_flag);
	}

	return $tag;
}



/****************************************************************
* 機　能： カレンダーを表示するHTMLタグ作成します。（日付）
* 引　数： ［入力］$targetDate　作成対象日
* 　　　　 ［入力］$top_flag　トップページ判定(TOP_FLG_ON or TOP_FLG_OFF)
* 戻り値： HTMLタグ（日付）
****************************************************************/
function dayTagCreate($targetDate, $top_flag)
{
	global $classNameSuffix, $column_position;

	//列位置クラスの選択
	if ($column_position == 7)
	{
		$column_position = 1;	//土曜日を処理後は列を先頭に位置づける
	}
	else
	{
		$column_position++;
	}

	//CSSクラス名定義
	if ($column_position == 1)
	{
		$classNameColumn = "column_first".$classNameSuffix;
	}
	else
	{
		$classNameColumn = "column_other".$classNameSuffix;
	}
	
	//背景画像クラスの選択
	if ($targetDate == "")
	{
		$classNameBack = "back7_".$classNameSuffix; //空枠の場合
	}
	else
	{
		$linkInfoArray = array();
		$backGroundPattern = backGroundPatternGet($targetDate, $linkInfoArray);
		$classNameBack = "back".$backGroundPattern."_".$classNameSuffix;
	}
	
	$tag = "<div class=\"".$classNameColumn." ".$classNameBack."\">";
	
	if ($targetDate != "")
	{
		list( , $targetMonth, $targetDay) = explode("/", $targetDate);
		list( , $todayMonth,  $todayDay)  = explode("/", date("Y/m/d"));

		//昨日以前、または休館日、行事なしの場合はリンク不要
		if (($targetMonth == $todayMonth && $targetDay < $todayDay) ||
			($backGroundPattern == 1 || $backGroundPattern == 7))
		{
			$tag .= "<div class=\"calendar_day".$classNameSuffix."\">".$targetDay."</div>";
		}
		else
		{
			$tag .= linkTagCreate($targetDay, $linkInfoArray, $top_flag);
		}
	}
	
	$tag .= "</div>\n";

	return $tag;
}



/****************************************************************
* 機　能： カレンダーを表示するHTMLタグ作成します。（リンク）
* 引　数： ［入力］$targetDay　作成対象日
* 　　　　 ［入力］$linkInfoArray　リンク情報配列（行事区分、段落名）
* 　　　　 ［入力］$top_flag　トップページ判定(TOP_FLG_ON or TOP_FLG_OFF)
* 戻り値： HTMLタグ（リンク）
****************************************************************/
function linkTagCreate($targetDay, $linkInfoArray, $top_flag)
{
	global $classNameSuffix;

	$tag = "<ul class=\"menu".$classNameSuffix."\">";
	$tag .= "<li>"."<div class=\"calendar_day".$classNameSuffix."\">".$targetDay."</div>";
	$tag .= "<ul class=\"sub".$classNameSuffix."\">";

	//$top_flagから取得URL分岐
	if($top_flag == TOP_FLG_ON){
		$tokubetsutenEventFile = "tokubetsu/index.html";
		$ehagakiFile = "info/index.html";
	}else{
		$tokubetsutenEventFile = "../tokubetsu/index.html";
		$ehagakiFile = "../info/index.html";
	}

	for ($i=0; $i<count($linkInfoArray); $i++)
	{
		$tag .= "<li>";

		$className_Gyoji = "gyoji".$classNameSuffix;

		if(isset($_GET["preview"]) == true){
			switch ($linkInfoArray[$i]["gyoji_kubun"])
			{
				case 1: $tag .= "<a href='javascript:void(0);'>".
								"<div class=\"".$className_Gyoji."\">特別展</div></a>";
						break;
				case 2: $tag .= "<a href='javascript:void(0);'>".
								"<div class=\"".$className_Gyoji."\">絵はがき教室</div></a>";
						break;
				case 3: $tag .= "<a href='javascript:void(0);'>".
								"<div class=\"".$className_Gyoji."\">イベント</div></a>";
						break;
			}
		}
		else{
			switch ($linkInfoArray[$i]["gyoji_kubun"])
			{
				case 1: $tag .= "<a href=\"".$tokubetsutenEventFile.
								"#".$linkInfoArray[$i]["danraku_mei"]."\">".
								"<div class=\"".$className_Gyoji."\">特別展</div></a>";
						break;
				case 2: $tag .= "<a href=\"".$ehagakiFile."\">".
								"<div class=\"".$className_Gyoji."\">絵はがき教室</div></a>";
						break;
				case 3: $tag .= "<a href=\"".$tokubetsutenEventFile.
								"#".$linkInfoArray[$i]["danraku_mei"]."\">".
								"<div class=\"".$className_Gyoji."\">イベント</div></a>";
						break;
			}
		}
		$tag .= "</li>";
	}

	$tag .= "</ul>";
	$tag .= "</li>";
	$tag .= "</ul>";

	return $tag;
}



/****************************************************************
* 機　能： 指定された日の背景画像タイプを取得します。
* 引　数： ［入力］$targetDate　判定対象日付文字列
* 　　　　 ［出力］$linkInfoArray　リンク情報配列（行事区分、段落名）
* 戻り値： 背景画像パターンコード
* 　　　　 1:休館日、2:特別展、3:絵はがき、4:イベント、
*					 5:特別展＆絵はがき、6:特別展＆イベント、7:行事無しの開館日、
*					 8:特別展＆絵はがき＆イベント、9：絵はがき＆イベント、
****************************************************************/
function backGroundPatternGet($targetDate, &$linkInfoArray)
{
	global $gyojiData, $previewParamArray;

	if (isKyukambi($targetDate) == true)
	{
		return 1;
	}
	
	$targetDatetime = strtotime($targetDate);

	if (pg_num_rows($gyojiData) != 0)
	{
		$isExistTokubetsuten = false;
		$isExistEhagaki 	 = false;
		$isExistEvent 		 = false;

		$count = 0; //繰り返し検索するので、位置を先頭にリセットする
	
		while ($record = @pg_fetch_object($gyojiData, $count))
		{
			if($record->id == $_SESSION["check_id"] && isset($_GET["preview"])){
				gyojiJudgement($previewParamArray[5] == "t" ? true : false, 
							   $targetDatetime, $previewParamArray[3], $previewParamArray[4], 
							   $previewParamArray[1], $previewParamArray[2], $isExistTokubetsuten,
							   $isExistEhagaki, $isExistEvent, $linkInfoArray);
			}
			else{
				gyojiJudgement($record->calendar_kokai == "t" ? true : false, 
							   $targetDatetime, $record->kaishi_bi, $record->shuryo_bi, 
							   $record->gyoji_kubun, $record->danraku_mei, $isExistTokubetsuten,
							   $isExistEhagaki, $isExistEvent, $linkInfoArray);
			}
			$count++;
		}
	}

	if (is_null($previewParamArray) == false &&
		$previewParamArray[0] == "gyoji")
	{
		if($_SESSION["check_id"] == ""){
			gyojiJudgement($previewParamArray[5] == "t" ? true : false, 
						   $targetDatetime, $previewParamArray[3], $previewParamArray[4], 
						   $previewParamArray[1], $previewParamArray[2], $isExistTokubetsuten,
						   $isExistEhagaki, $isExistEvent, $linkInfoArray);
		}
	}
	
	$code = 7; //行事無しの開館日を初期値とする
		


		//当該日に行事情報がある場合（情報数分の処理を行う）
		for ($i=0; $i < count($linkInfoArray); $i++){
				switch ($linkInfoArray[$i]["gyoji_kubun"]){
				
				case 1:	//特別展示がある時
					$code = tokubetu_chk($code); 
				break;

				case 2:	//絵はがきがある時
					$code = ehagaki_chk($code); 
				break;

				case 3:	//イベントがある時
					$code = event_chk($code); 
				break;

				default: //その他がある時
				break;
				}
			
		}

	return $code;
}

/****************************************************************
* 機　能： 現在の$codeを参照しカレンダーに表示するアイコンを作成
* 背景画像パターンコード
* 　　　　 1:休館日、2:特別展、3:絵はがき、4:イベント、
*					 5:特別展＆絵はがき、6:特別展＆イベント、7:行事無しの開館日、
*					 8:特別展＆絵はがき＆イベント、9：絵はがき＆イベント、
****************************************************************/

function tokubetu_chk($code){
	switch ($code) {
		case 7:
			return 2;
			break;
		case 3:
			return 5;
			break;
		case 4:
			return 6;
			break;
		case 9:
			return 8;
			break;
		default:
			break;
	}
}

function ehagaki_chk($code){
	switch ($code) {
		case 7:
			return 3;
			break;
		case 2:
			return 5;
			break;
		case 4:
			return 9;
			break;
		case 6:
			return 8;
			break;
		default:
			break;

	}
}


function event_chk($code){
	switch ($code) {
		case 7:
			return 4;
			break;
		case 2:
			return 6;
			break;
		case 3:
			return 9;
			break;
		case 5:
			return 8;
			break;
		default:
			break;
	}
}

/****************************************************************
* 機　能： 指定された行事がカレンダー表示対象かどうか判定します。
* 引　数： ［入力］$kokai　カレンダー公開
* 　　　　 ［入力］$targetDatetime　判定対象日付
* 　　　　 ［入力］$kaishibi　開始日
* 　　　　 ［入力］$shuryobi　終了日
* 　　　　 ［入力］$gyojiKubun　行事区分
* 　　　　 ［入力］$danrakuMei　段落名
* 　　　　 ［出力］$isExistTokubetsuten　特別展存在フラグ
* 　　　　 ［出力］$isExistEhagaki　絵はがき教室存在フラグ
* 　　　　 ［出力］$isExistEvent　イベント存在フラグ
* 　　　　 ［出力］$linkInfoArray　リンク情報配列（行事区分、段落名）
* 戻り値： なし
****************************************************************/
function gyojiJudgement($kokai, $targetDatetime, $kaishibi, $shuryobi, 
						$gyojiKubun, $danrakuMei, &$isExistTokubetsuten,
						&$isExistEhagaki, &$isExistEvent, &$linkInfoArray)
{
	$kaishibiDatetime = strtotime($kaishibi);
	$shuryobiDatetime = strtotime($shuryobi);

	if ($kokai == true)
	{
		if ($kaishibiDatetime <= $targetDatetime &&
			$targetDatetime   <= $shuryobiDatetime)
		{
			switch ($gyojiKubun)
			{
				case 1: $isExistTokubetsuten = true; break;
				case 2: $isExistEhagaki 	 = true; break;
				case 3: $isExistEvent 		 = true; break;
			}
	
			$linkInfoArray[] = array("gyoji_kubun" => $gyojiKubun,
									 "danraku_mei" => $danrakuMei);
		}
	}
}



/****************************************************************
* 機　能： 指定された日が休館日かどうか判定します。
* 引　数： ［入力］$datestr　判定対象日付文字列
* 戻り値： true：休館日　false：開館日
****************************************************************/
function isKyukambi($targetDate)
{
	global $kyukambiData, $previewParamArray;

	$isMatch = false;

	if (pg_num_rows($kyukambiData) != 0)
	{
		$count = 0; //繰り返し検索するので、位置を先頭にリセットする
	
		while ($record = @pg_fetch_object($kyukambiData, $count))
		{
			if (strtotime($record->hizuke) == strtotime($targetDate))
			{
				if($record->id == $_SESSION["check_id"] && isset($_GET["preview"])){
					break;
				}
				else{
					$isMatch = true;
					break;
				}
			}
			
			$count++;
		}
	}
	
	//プレビュー用パラメータの判定
	if (is_null($previewParamArray) == false &&
		$previewParamArray[0] == "kyukambi" &&
		strtotime($previewParamArray[1]) == strtotime($targetDate))
	{
		$isMatch = true;
	}
	
	return $isMatch;
}


?>

