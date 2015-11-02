
var myScroll,
	pullDownEl, pullDownOffset,
	pullUpEl, pullUpOffset,
	generatedCount = 0;

/**
 * 下拉刷新 （自定义实现此方法）
 * myScroll.refresh();		// 数据加载完成后，调用界面更新方法
 */
function pullDownAction () {
	setTimeout(function () {	// <-- Simulate network congestion, remove setTimeout from production!
		// var el, li, i;
		// el = document.getElementById('thelist');

		// for (i=0; i<10; i++) {
		// 	li = document.createElement('li');
		// 	li.innerText = 'Generated row ' + (++generatedCount);
		// 	el.insertBefore(li, el.childNodes[0]);
		// }
		
		slideDown();
		myScroll.refresh();		//数据加载完成后，调用界面更新方法   Remember to refresh when contents are loaded (ie: on ajax completion)
	}, 1000);	// <-- Simulate network congestion, remove setTimeout from production!
}

/**
 * 滚动翻页 （自定义实现此方法）
 * myScroll.refresh();		// 数据加载完成后，调用界面更新方法
 */
function pullUpAction () {
	setTimeout(function () {	// <-- Simulate network congestion, remove setTimeout from production!
		// var el, li, i;
		// el = document.getElementById('thelist');

		// for (i=0; i<10; i++) {
		// 	//li = document.createElement('li');
		// 	//li.innerText = 'Generated row ' + (++generatedCount);
		// 	// li.innerText="<div class='col-md-12 col-xs-12'><div class='col-md-1 col-xs-1 nopadding'>1</div><div class='col-md-3 col-xs-3 nopadding'>沪B11111</div><div class='col-md-4 col-xs-4 nopadding'>杭州桩</div><div class='col-md-2 col-xs-2 nopadding'>2012-09-08 01:01:01</div><div class='col-md-1 col-xs-1 nopadding' style='padding-left:20px;'><doing style='color:#3CB371'><i class='glyphicon glyphicon-time'></i></doing></div></div>";
		// 	// el.appendChild(li, el.childNodes[0]);
		// 	var str="<li><div class='col-md-12 col-xs-12'><div class='col-md-1 col-xs-1 nopadding'>1</div><div class='col-md-3 col-xs-3 nopadding'>沪B11111</div><div class='col-md-4 col-xs-4 nopadding'>杭州桩</div><div class='col-md-2 col-xs-2 nopadding'>2012-09-08 01:01:01</div><div class='col-md-1 col-xs-1 nopadding' style='padding-left:20px;'><doing style='color:#3CB371'><i class='glyphicon glyphicon-time'></i></doing></div></div></li>";
		// 	$('#thelist').append(str);
		// }
		
		slideUp();
		myScroll.refresh();		// 数据加载完成后，调用界面更新方法 Remember to refresh when contents are loaded (ie: on ajax completion)
	}, 1000);	// <-- Simulate network congestion, remove setTimeout from production!
}

/**
 * 初始化iScroll控件
 */
function loaded() {
	pullDownEl = document.getElementById('pullDown');
	pullDownOffset = pullDownEl.offsetHeight;
	pullUpEl = document.getElementById('pullUp');	
	pullUpOffset = pullUpEl.offsetHeight;
	
	myScroll = new iScroll('wrapper', {
		scrollbarClass: 'myScrollbar', /* 重要样式 */
		useTransition: false, /* 此属性不知用意，本人从true改为false */
		topOffset: pullDownOffset,
		onRefresh: function () {
			if (pullDownEl.className.match('loading')) {
				pullDownEl.className = '';
				pullDownEl.querySelector('.pullDownLabel').innerHTML = '下拉刷新...';
			} else if (pullUpEl.className.match('loading')) {
				pullUpEl.className = '';
				pullUpEl.querySelector('.pullUpLabel').innerHTML = '上拉加载更多...';
			}
		},
		onScrollMove: function () {
			if (this.y > 5 && !pullDownEl.className.match('flip')) {
				pullDownEl.className = 'flip';
				pullDownEl.querySelector('.pullDownLabel').innerHTML = '松手开始更新...';
				this.minScrollY = 0;
			} else if (this.y < 5 && pullDownEl.className.match('flip')) {
				pullDownEl.className = '';
				pullDownEl.querySelector('.pullDownLabel').innerHTML = '下拉刷新...';
				this.minScrollY = -pullDownOffset;
			} else if (this.y < (this.maxScrollY - 5) && !pullUpEl.className.match('flip')) {
				pullUpEl.className = 'flip';
				pullUpEl.querySelector('.pullUpLabel').innerHTML = '松手开始更新...';
				this.maxScrollY = this.maxScrollY;
			} else if (this.y > (this.maxScrollY + 5) && pullUpEl.className.match('flip')) {
				pullUpEl.className = '';
				pullUpEl.querySelector('.pullUpLabel').innerHTML = '上拉加载更多...';
				this.maxScrollY = pullUpOffset;
			}
		},
		onScrollEnd: function () {
			if (pullDownEl.className.match('flip')) {
				pullDownEl.className = 'loading';
				pullDownEl.querySelector('.pullDownLabel').innerHTML = '加载中...';				
				pullDownAction();	// Execute custom function (ajax call?)
			} else if (pullUpEl.className.match('flip')) {
				pullUpEl.className = 'loading';
				pullUpEl.querySelector('.pullUpLabel').innerHTML = '加载中...';				
				pullUpAction();	// Execute custom function (ajax call?)
			}
		}
	});
	
	setTimeout(function () { document.getElementById('wrapper').style.left = '0'; }, 800);
}

//初始化绑定iScroll控件 
document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);
document.addEventListener('DOMContentLoaded', loaded, false); 

