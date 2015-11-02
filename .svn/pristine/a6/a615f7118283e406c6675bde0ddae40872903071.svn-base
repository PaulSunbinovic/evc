function loaded () {
	var myScroll,
		upIcon = $("#up-icon"),
		downIcon = $("#down-icon");
		
	myScroll = new IScroll('#wrapper', { probeType: 3, mouseWheel: true });
	
	myScroll.on("scroll",function(){
		var y = this.y,
			maxY = this.maxScrollY - y,
			downHasClass = downIcon.hasClass("reverse_icon"),
			upHasClass = upIcon.hasClass("reverse_icon");
		
		if(y >= 40){
			!downHasClass && downIcon.addClass("reverse_icon");
			return "";
		}else if(y < 40 && y > 0){
			downHasClass && downIcon.removeClass("reverse_icon");
			return "";
		}
		
		if(maxY >= 40){
			!upHasClass && upIcon.addClass("reverse_icon");
			return "";
		}else if(maxY < 40 && maxY >=0){
			upHasClass && upIcon.removeClass("reverse_icon");
			return "";
		}
	});
	
	myScroll.on("slideDown",function(){
		if(this.y > 40){
			slideDown();
			myScroll.refresh();
			upIcon.removeClass("reverse_icon");
		}
	});
	
	myScroll.on("slideUp",function(){
		if(this.maxScrollY - this.y > 40){
			slideUp();
			
			upIcon.removeClass("reverse_icon");myScroll.refresh();
		}
	});
}
