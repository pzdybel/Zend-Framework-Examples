$(function(){
	$("a.vote_up").click(function(){
		the_id = $(this).attr("id");
		$(this).parent().html("<img src='" + BASE_APP + "/images/spinner.gif'/>");
		
	    //fadeout the vote-count
	    $("span#votes_count"+the_id).fadeOut("fast");

		$.ajax({
			type: "POST",
			data: "action=vote_up&id="+the_id,
			url: BASE_APP + "/index/vote",
			success: function(msg)
			{
	            $("span#votes_count"+the_id).html(msg);
	            $("span#votes_count"+the_id).fadeIn();
	            $("span#vote_buttons"+the_id).remove();
			}
		});

		return false;
	});
	
	$("a.vote_down").click(function(){
		the_id = $(this).attr("id");
		$(this).parent().html("<img src='" + BASE_APP + "/images/spinner.gif'/>");
		
	    //fadeout the vote-count
	    $("span#votes_count"+the_id).fadeOut("fast");

		$.ajax({
			type: "POST",
			data: "action=vote_down&id="+the_id,
			url: BASE_APP + "/index/vote",
			success: function(msg)
			{
	            $("span#votes_count"+the_id).html(msg);
	            $("span#votes_count"+the_id).fadeIn();
	            $("span#vote_buttons"+the_id).remove();
			}
		});

		return false;
	});
});