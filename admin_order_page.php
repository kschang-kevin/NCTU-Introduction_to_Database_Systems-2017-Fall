<?
include 'db.php';
	session_start();
$tmp=$_GET['id'];
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name = "format-detection" content="telephone = no" />
		<meta http-equiv="X-UA-Compatible" content="IE=11,IE=10,IE=9,IE=8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0" />
		<link rel="stylesheet" type="text/css" href="calendar.css" />
		<div style="font-family: arial;
    			font-size: 40px;
   				color:#AAAAAA;
    			line-height: 50px;
    			text-align:center; ">
			<h2>Choose an Interval</h2>
		</div>
		<button onclick="location.href='admin_order.php'">Cancel</button>
	</head>

	<body>

		<script type="text/javascript" src="calendar.js"></script>

		<script type="text/javascript">
			(function () {
				function fn (timeArry, indexArry) {
					console.log(timeArry); // 开始时间和结束时间的数组
					console.log(indexArry);
					var tmpid=<?php echo $tmp ?>;
					location.href="admin_order.inc.php?id="+tmpid+"&std="+timeArry[0]+"&ltd="+timeArry[1];



					 // 开始时间和结束时间对应的索引值数组，可用于在回调函数中进行相关dom操作
				}

				var calendar = new Calendar({
					step: 100, // 最多显示从本月开始的step个月
					leastDays: 2, // 最少选择天数
					callback: fn, // 回调函数，默认有两个数组参数，第一个是所选开始时间和结束时间，第二个是开始时间和结束时间对应的element索引
					priceData: null // 价格数据数组集合，如果没有，则为null
				}).init();
				
				// 日历默认是隐藏的，初始化之后可以按照需要进行显示或隐藏操作
				document.querySelector('#calendar-wraper').style.display = 'block';
			})();
		</script>
	</body>
</html>