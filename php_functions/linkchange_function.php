<?php

/*********************************************
* 画　面：トップページ
* 機　能：メニュー一覧表示
* 状　態：通常画面時
*********************************************/

function TopPageMenuForm(){

$tag = <<< __EOS__
<a href="museum/index.html"><img src="topimg/menu1_1.gif" onmouseover="this.src='topimg/menu1_1on.gif';" onmouseout="this.src='topimg/menu1_1.gif';" alt="博物館のご案内" class="a"></a> 

<a href="tatemono/index.html"><img src="topimg/menu1_5.gif" onmouseover="this.src='topimg/menu1_5on.gif';" onmouseout="this.src='topimg/menu1_5.gif';" alt="博物館のご案内" class="a"></a>

<a href="access/index.html"><img src="topimg/menu1_6.gif" onmouseover="this.src='topimg/menu1_6on.gif';" onmouseout="this.src='topimg/menu1_6.gif';" alt="博物館のご案内" class="a"></a>

<a href="guide/index.html"><img src="topimg/menu1_2.gif" onmouseover="this.src='topimg/menu1_2on.gif';" onmouseout="this.src='topimg/menu1_2.gif';" alt="常設展示" class="a"></a>

<a href="tokubetsu/index.html"><img src="topimg/menu1_3.gif" onmouseover="this.src='topimg/menu1_3on.gif';" onmouseout="this.src='topimg/menu1_3.gif';" alt="博物館のご案内" class="a"></a>

<a href="info/index.html"><img src="topimg/menu1_4.gif" onmouseover="this.src='topimg/menu1_4on.gif';" onmouseout="this.src='topimg/menu1_4.gif';" alt="博物館のご案内" class="a"></a>


<a href="links/index.html"><img src="topimg/menu1_7.gif" onmouseover="this.src='topimg/menu1_7on.gif';" onmouseout="this.src='topimg/menu1_7.gif';" alt="博物館のご案内" class="a"></a>

<a href="contact/index.html"><img src="topimg/menu1_8.gif" onmouseover="this.src='topimg/menu1_8on.gif';" onmouseout="this.src='topimg/menu1_8.gif';" alt="博物館のご案内" class="a"></a>
__EOS__;

return $tag;

}

/*********************************************
* 画　面：トップページ
* 機　能：メニュー一覧表示
* 状　態：プレビュー画面時
*********************************************/

function TopPageMenuForm_Pre(){

$tag = <<< __EOS__
<a href="javascript:void(0);"><img src="topimg/menu1_1.gif" onmouseover="this.src='topimg/menu1_1on.gif';" onmouseout="this.src='topimg/menu1_1.gif';" alt="博物館のご案内" class="a"></a> 
<a href="javascript:void(0);"><img src="topimg/menu1_2.gif" onmouseover="this.src='topimg/menu1_2on.gif';" onmouseout="this.src='topimg/menu1_2.gif';" alt="常設展示" class="a"></a>
<a href="javascript:void(0);"><img src="topimg/menu1_3.gif" onmouseover="this.src='topimg/menu1_3on.gif';" onmouseout="this.src='topimg/menu1_3.gif';" alt="博物館のご案内" class="a"></a>
<a href="javascript:void(0);"><img src="topimg/menu1_4.gif" onmouseover="this.src='topimg/menu1_4on.gif';" onmouseout="this.src='topimg/menu1_4.gif';" alt="博物館のご案内" class="a"></a>
<a href="javascript:void(0);"><img src="topimg/menu1_5.gif" onmouseover="this.src='topimg/menu1_5on.gif';" onmouseout="this.src='topimg/menu1_5.gif';" alt="博物館のご案内" class="a"></a>
<a href="javascript:void(0);"><img src="topimg/menu1_6.gif" onmouseover="this.src='topimg/menu1_6on.gif';" onmouseout="this.src='topimg/menu1_6.gif';" alt="博物館のご案内" class="a"></a>
<a href="javascript:void(0);"><img src="topimg/menu1_7.gif" onmouseover="this.src='topimg/menu1_7on.gif';" onmouseout="this.src='topimg/menu1_7.gif';" alt="博物館のご案内" class="a"></a>
<a href="javascript:void(0);"><img src="topimg/menu1_8.gif" onmouseover="this.src='topimg/menu1_8on.gif';" onmouseout="this.src='topimg/menu1_8.gif';" alt="博物館のご案内" class="a"></a>
__EOS__;

return $tag;

}

/*********************************************
* 画　面：トップページ
* 機　能：FLASH PLAYERサイトリンク表示
* 状　態：通常画面時
*********************************************/

function FlashLink(){

$tag = <<< __EOS__
<a href="http://www.macromedia.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash&Lang=Japanese" target="_blank"><img src="topimg/get_flash_player.gif" alt="FLASH PLAYERをダウンロード" width="88" height="31" border="0"></a>
__EOS__;

return $tag;

}

/*********************************************
* 画　面：トップページ
* 機　能：FLASH PLAYERサイトリンク表示
* 状　態：プレビュー画面時
*********************************************/

function FlashLink_Pre(){

$tag = <<< __EOS__
<a href="javascript:void(0);"><img src="topimg/get_flash_player.gif" alt="FLASH PLAYERをダウンロード" width="88" height="31" border="0"></a>
__EOS__;

return $tag;

}

/*********************************************
* 画　面：博物館のご案内
* 機　能：メニュー一覧表示
* 状　態：通常画面時
*********************************************/

function MuseumPageMenuForm(){

	echo <<< __EOS__
<a href="../index.html"><img src="../common/pagemenu_0.gif" alt="ホーム" name="menu_1" width="143" height="28" border="0" id="menu_1"></a><br>
<a href="../museum/index.html"><img src="../common/pagemenu_1.gif" onmouseover="this.src='../common/pagemenu_1on.gif';" onmouseout="this.src='../common/pagemenu_1.gif';" alt="博物館のご案内" name="menu_2" width="143" height="28" border="0"></a><br>
<a href="../tatemono/index.html"><img src="../common/pagemenu_2.gif"  onmouseover="this.src='../common/pagemenu_2on.gif';" onmouseout="this.src='../common/pagemenu_2.gif';" alt="建物の由来" name="menu3" width="143" height="28" border="0"></a><br>
<a href="../access/index.html"><img src="../common/pagemenu_3.gif" onmouseover="this.src='../common/pagemenu_3on.gif';" onmouseout="this.src='../common/pagemenu_3.gif';"  alt="交通のご案内" name="menu_4" width="143" height="28" border="0" id="menu_3"></a><br>
<a href="../guide/index.html"><img src="../common/pagemenu_4.gif" onmouseover="this.src='../common/pagemenu_4on.gif';" onmouseout="this.src='../common/pagemenu_4.gif';"  alt="常設展示" name="menu_5" width="143" height="28" border="0" id="menu_3"></a><br>
<a href="../tokubetsu/index.html"><img src="../common/pagemenu_5.gif" onmouseover="this.src='../common/pagemenu_5on.gif';" onmouseout="this.src='../common/pagemenu_5.gif';"  alt="特別展示/イベント" name="menu_6" width="143" height="28" border="0" id="menu_3"></a><br>
<a href="../info/index.html"><img src="../common/pagemenu_6.gif" onmouseover="this.src='../common/pagemenu_6on.gif';" onmouseout="this.src='../common/pagemenu_6.gif';"  alt="絵はがき教室" name="menu_7" width="143" height="28" border="0" id="menu_3"></a><br>
<a href="../links/index.html"><img src="../common/pagemenu_7.gif" onmouseover="this.src='../common/pagemenu_7on.gif';" onmouseout="this.src='../common/pagemenu_7.gif';"  alt="関連リンク集" name="menu_8" width="143" height="28" border="0" id="menu_3"></a><br>
<a href="../contact/index.html"><img src="../common/pagemenu_8.gif" onmouseover="this.src='../common/pagemenu_8on.gif';" onmouseout="this.src='../common/pagemenu_8.gif';"  alt="お問い合わせ" name="menu_9" width="143" height="28" border="0" id="menu_3"></a>
__EOS__;

}

/*********************************************
* 画　面：博物館のご案内
* 機　能：メニュー一覧表示
* 状　態：プレビュー画面時
*********************************************/

function MuseumPageMenuForm_Pre(){

	echo <<< __EOS__
<a href="javascript:void(0);"><img src="../common/pagemenu_0.gif" alt="ホーム" name="menu_1" width="143" height="28" border="0" id="menu_1"></a><br>
<a href="javascript:void(0);"><img src="../common/pagemenu_1.gif" onmouseover="this.src='../common/pagemenu_1on.gif';" onmouseout="this.src='../common/pagemenu_1.gif';" alt="博物館のご案内" name="menu_2" width="143" height="28" border="0"></a><br>
<a href="javascript:void(0);"><img src="../common/pagemenu_2.gif" onmouseover="this.src='../common/pagemenu_2on.gif';" onmouseout="this.src='../common/pagemenu_2.gif';" alt="建物の由来" name="menu3" width="143" height="28" border="0"></a><br>
<a href="javascript:void(0);"><img src="../common/pagemenu_3.gif" onmouseover="this.src='../common/pagemenu_3on.gif';" onmouseout="this.src='../common/pagemenu_3.gif';"  alt="交通のご案内" name="menu_4" width="143" height="28" border="0" id="menu_3"></a><br>
<a href="javascript:void(0);"><img src="../common/pagemenu_4.gif" onmouseover="this.src='../common/pagemenu_4on.gif';" onmouseout="this.src='../common/pagemenu_4.gif';"  alt="常設展示" name="menu_5" width="143" height="28" border="0" id="menu_3"></a><br>
<a href="javascript:void(0);"><img src="../common/pagemenu_5.gif" onmouseover="this.src='../common/pagemenu_5on.gif';" onmouseout="this.src='../common/pagemenu_5.gif';"  alt="特別展示/イベント" name="menu_6" width="143" height="28" border="0" id="menu_3"></a><br>
<a href="javascript:void(0);"><img src="../common/pagemenu_6.gif" onmouseover="this.src='../common/pagemenu_6on.gif';" onmouseout="this.src='../common/pagemenu_6.gif';"  alt="絵はがき教室" name="menu_7" width="143" height="28" border="0" id="menu_3"></a><br>
<a href="javascript:void(0);"><img src="../common/pagemenu_7.gif" onmouseover="this.src='../common/pagemenu_7on.gif';" onmouseout="this.src='../common/pagemenu_7.gif';"  alt="関連リンク集" name="menu_8" width="143" height="28" border="0" id="menu_3"></a><br>
<a href="javascript:void(0);"><img src="../common/pagemenu_8.gif" onmouseover="this.src='../common/pagemenu_8on.gif';" onmouseout="this.src='../common/pagemenu_8.gif';"  alt="お問い合わせ" name="menu_9" width="143" height="28" border="0" id="menu_3"></a>
__EOS__;

}

/*********************************************
* 画　面：博物館のご案内
* 機　能：「交通のご案内」ページリンク表示
* 状　態：通常画面時
*********************************************/

function AccessLink(){

	echo <<< __EOS__
<a href="../access/index.html">→住所・地図のご案内はこちら</a>
__EOS__;

}

/*********************************************
* 画　面：博物館のご案内
* 機　能：「交通のご案内」ページリンク表示
* 状　態：プレビュー画面時
*********************************************/

function AccessLink_Pre(){

	echo <<< __EOS__
<a href="javascript:void(0);">→住所・地図のご案内はこちら</a>
__EOS__;

}

?>