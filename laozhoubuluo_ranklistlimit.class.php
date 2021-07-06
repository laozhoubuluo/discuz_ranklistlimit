<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class plugin_laozhoubuluo_ranklistlimit {

}

class plugin_laozhoubuluo_ranklistlimit_spacecp extends plugin_laozhoubuluo_ranklistlimit {

	public function common() {
		global $_G;

		// 开关关闭时直接返回 array() 结束 Hook
		if(!$_G['cache']['plugin']['laozhoubuluo_ranklistlimit']['status']) {
			return array();
		}

		// 修改单价时接受单价上下限设置
		if(isset($_GET['ac']) && isset($_GET['op']) && isset($_POST['unitprice']) && $_GET['ac'] == 'common' && $_GET['op'] == 'modifyunitprice') {
			$unitprice = intval($_POST['unitprice']);
			$unitlowerlimit = is_numeric($_G['cache']['plugin']['laozhoubuluo_ranklistlimit']['unitlowerlimit']) ? intval($_G['cache']['plugin']['laozhoubuluo_ranklistlimit']['unitlowerlimit']) : 0;
			$unithigherlimit = is_numeric($_G['cache']['plugin']['laozhoubuluo_ranklistlimit']['unithigherlimit']) ? intval($_G['cache']['plugin']['laozhoubuluo_ranklistlimit']['unithigherlimit']) : 2147483647;
			if($unitprice < $unitlowerlimit) {
				showmessage('laozhoubuluo_ranklistlimit_lower_unit');
			}
			if($unitprice > $unithigherlimit) {
				showmessage('laozhoubuluo_ranklistlimit_higher_unit');
			}
		}

		// 他人上榜时接受总价上下限设置
		if(isset($_GET['ac']) && isset($_POST['friendsubmit']) && isset($_POST['fusername']) && isset($_POST['stakecredit']) && $_GET['ac'] == 'top') {
			$uid = C::t('common_member')->fetch_uid_by_username($_POST['fusername']);
			$showcredit = C::t('home_show')->fetch_by_uid_credit($uid) + intval($_POST['stakecredit']);
			$creditlowerlimit = is_numeric($_G['cache']['plugin']['laozhoubuluo_ranklistlimit']['creditlowerlimit']) ? intval($_G['cache']['plugin']['laozhoubuluo_ranklistlimit']['creditlowerlimit']) : 0;
			$credithigherlimit = is_numeric($_G['cache']['plugin']['laozhoubuluo_ranklistlimit']['credithigherlimit']) ? intval($_G['cache']['plugin']['laozhoubuluo_ranklistlimit']['credithigherlimit']) : 2147483647;
			if($showcredit < $creditlowerlimit) {
				showmessage('laozhoubuluo_ranklistlimit_lower_credit_friend');
			}
			if($showcredit > $credithigherlimit) {
				showmessage('laozhoubuluo_ranklistlimit_higher_credit_friend');
			}
		}

		// 本人上榜时接受单价上下限、总价上下限设置
		if(isset($_GET['ac']) && isset($_POST['showsubmit']) && isset($_POST['showcredit']) && isset($_POST['unitprice']) && $_GET['ac'] == 'top') {
			$showcredit = C::t('home_show')->fetch_by_uid_credit($_G['uid']) + intval($_POST['showcredit']);
			$unitprice = intval($_POST['unitprice']);
			$creditlowerlimit = is_numeric($_G['cache']['plugin']['laozhoubuluo_ranklistlimit']['creditlowerlimit']) ? intval($_G['cache']['plugin']['laozhoubuluo_ranklistlimit']['creditlowerlimit']) : 0;
			$credithigherlimit = is_numeric($_G['cache']['plugin']['laozhoubuluo_ranklistlimit']['credithigherlimit']) ? intval($_G['cache']['plugin']['laozhoubuluo_ranklistlimit']['credithigherlimit']) : 2147483647;
			$unitlowerlimit = is_numeric($_G['cache']['plugin']['laozhoubuluo_ranklistlimit']['unitlowerlimit']) ? intval($_G['cache']['plugin']['laozhoubuluo_ranklistlimit']['unitlowerlimit']) : 0;
			$unithigherlimit = is_numeric($_G['cache']['plugin']['laozhoubuluo_ranklistlimit']['unithigherlimit']) ? intval($_G['cache']['plugin']['laozhoubuluo_ranklistlimit']['unithigherlimit']) : 2147483647;
			if($unitprice < $unitlowerlimit) {
				showmessage('laozhoubuluo_ranklistlimit_lower_unit');
			}
			if($unitprice > $unithigherlimit) {
				showmessage('laozhoubuluo_ranklistlimit_higher_unit');
			}
			if($showcredit < $creditlowerlimit) {
				showmessage('laozhoubuluo_ranklistlimit_lower_credit');
			}
			if($showcredit > $credithigherlimit) {
				showmessage('laozhoubuluo_ranklistlimit_higher_credit');
			}
		}

		// 如果没被拦截, 直接返回 array() 结束 Hook
		return array();
}