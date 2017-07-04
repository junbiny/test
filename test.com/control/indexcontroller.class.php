<?php
/**
 * index控制器类
 * @主要做demo
 */
class indexcontroller extends control {
	/**
	 * 构造函数
	 */
	public function __construct($c, $a) {
        parent::__construct($c, $a);
    }

	public function index() {

		$smarty = $this->view;
		$smarty->assign('row', '123');
		$smarty->display($this->c . '/' . $this->a . '.html');
	}

	public function demo() {
		//爷爷辈、父辈、我、

	}

	public function getWeeks(){
		$date = date('Y-m-d');  //当前日期
		$first = 1; //$first =1 表示每周星期一为开始日期 0表示每周日为开始日期
		$w = date('w',strtotime($date));  //获取当前周的第几天 周是0, 周一到周六是 1 - 6

		//获取本周开始日期，如果$w是0，则表示周日，减去6天
		$now_start = date('Y-m-d',strtotime("$date -".($w ? $w - $first : 6).' days')); 
		$now_end = date('Y-m-d',strtotime("$now_start +6 days"));  //本周结束日期

		$tmp = 0;
		$week = 4;
		$week_list = [];
		for ($i = $week; $i >= 1; $i--) {
			$days = 7 * $i;
			$start = date('Y-m-d',strtotime("$now_start - $days days")); //开始日期
			$week_list[$tmp]['start'] = $start;
			$week_list[$tmp]['end'] = date('Y-m-d',strtotime("$start +6 days")); //结束日期
			$tmp++;
		}
		var_dump($week_list);
	}
}
