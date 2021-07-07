<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class plugin_laozhoubuluo_ranklistlimit {

	public function common() {
		global $_G;

		// 开关关闭或不是 SPACECP 模块时直接返回 array() 结束 Hook
		if(CURMODULE != 'spacecp' || !$_G['cache']['plugin']['laozhoubuluo_ranklistlimit']['status']) {
			return array();
		}

		// 修改单价时接受单价上下限设置
		if(isset($_GET['ac']) && isset($_GET['op']) && isset($_POST['unitprice']) && $_GET['ac'] == 'common' && $_GET['op'] == 'modifyunitprice') {
			$unitprice = intval($_POST['unitprice']);
			$unitlowerlimit = is_numeric($_G['cache']['plugin']['laozhoubuluo_ranklistlimit']['unitlowerlimit']) ? intval($_G['cache']['plugin']['laozhoubuluo_ranklistlimit']['unitlowerlimit']) : 0;
			$unithigherlimit = is_numeric($_G['cache']['plugin']['laozhoubuluo_ranklistlimit']['unithigherlimit']) ? intval($_G['cache']['plugin']['laozhoubuluo_ranklistlimit']['unithigherlimit']) : 2147483647;
			if($unitprice < $unitlowerlimit) {
				showmessage(lang('plugin/laozhoubuluo_ranklistlimit', 'lower_unit', array('limit' => $unitlowerlimit)));
			}
			if($unitprice > $unithigherlimit) {
				showmessage(lang('plugin/laozhoubuluo_ranklistlimit', 'higher_unit', array('limit' => $unithigherlimit)));
			}
		}

		// 他人上榜时接受总价上下限设置
		if(isset($_GET['ac']) && isset($_POST['friendsubmit']) && isset($_POST['fusername']) && isset($_POST['stakecredit']) && $_GET['ac'] == 'top') {
			$uid = C::t('common_member')->fetch_uid_by_username($_POST['fusername']);
			$showcredit = C::t('home_show')->fetch_by_uid_credit($uid)['credit'] + intval($_POST['stakecredit']);
			$creditlowerlimit = is_numeric($_G['cache']['plugin']['laozhoubuluo_ranklistlimit']['creditlowerlimit']) ? intval($_G['cache']['plugin']['laozhoubuluo_ranklistlimit']['creditlowerlimit']) : 0;
			$credithigherlimit = is_numeric($_G['cache']['plugin']['laozhoubuluo_ranklistlimit']['credithigherlimit']) ? intval($_G['cache']['plugin']['laozhoubuluo_ranklistlimit']['credithigherlimit']) : 2147483647;
			if($showcredit < $creditlowerlimit) {
				showmessage(lang('plugin/laozhoubuluo_ranklistlimit', 'lower_credit_friend', array('limit' => $creditlowerlimit)));
			}
			if($showcredit > $credithigherlimit) {
				showmessage(lang('plugin/laozhoubuluo_ranklistlimit', 'higher_credit_friend', array('limit' => $credithigherlimit)));
			}
		}

		// 本人上榜时接受单价上下限、总价上下限设置
		if(isset($_GET['ac']) && isset($_POST['showsubmit']) && isset($_POST['showcredit']) && isset($_POST['unitprice']) && $_GET['ac'] == 'top') {
			$showcredit = C::t('home_show')->fetch_by_uid_credit($_G['uid'])['credit'] + intval($_POST['showcredit']);
			$unitprice = intval($_POST['unitprice']);
			$creditlowerlimit = is_numeric($_G['cache']['plugin']['laozhoubuluo_ranklistlimit']['creditlowerlimit']) ? intval($_G['cache']['plugin']['laozhoubuluo_ranklistlimit']['creditlowerlimit']) : 0;
			$credithigherlimit = is_numeric($_G['cache']['plugin']['laozhoubuluo_ranklistlimit']['credithigherlimit']) ? intval($_G['cache']['plugin']['laozhoubuluo_ranklistlimit']['credithigherlimit']) : 2147483647;
			$unitlowerlimit = is_numeric($_G['cache']['plugin']['laozhoubuluo_ranklistlimit']['unitlowerlimit']) ? intval($_G['cache']['plugin']['laozhoubuluo_ranklistlimit']['unitlowerlimit']) : 0;
			$unithigherlimit = is_numeric($_G['cache']['plugin']['laozhoubuluo_ranklistlimit']['unithigherlimit']) ? intval($_G['cache']['plugin']['laozhoubuluo_ranklistlimit']['unithigherlimit']) : 2147483647;
			if($unitprice < $unitlowerlimit) {
				showmessage(lang('plugin/laozhoubuluo_ranklistlimit', 'lower_unit', array('limit' => $unitlowerlimit)));
			}
			if($unitprice > $unithigherlimit) {
				showmessage(lang('plugin/laozhoubuluo_ranklistlimit', 'higher_unit', array('limit' => $unithigherlimit)));
			}
			if($showcredit < $creditlowerlimit) {
				showmessage(lang('plugin/laozhoubuluo_ranklistlimit', 'lower_credit', array('limit' => $creditlowerlimit)));
			}
			if($showcredit > $credithigherlimit) {
				showmessage(lang('plugin/laozhoubuluo_ranklistlimit', 'higher_credit', array('limit' => $credithigherlimit)));
			}
		}

		// 如果没被拦截, 直接返回 array() 结束 Hook
		return array();
	}

}