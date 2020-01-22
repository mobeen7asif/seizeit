$(document).ready(function() {	
	$('ul li:nth-child(5n)').addClass('fifth-child');
	$('ul li:nth-child(4n)').addClass('fourth-child');
	$('ul li:nth-child(3n)').addClass('third-item');
	$('ul li:first-child').addClass('first-item');
	$('ul li:last-child').addClass('last-item');
	$('.wrapper .box01:last-child,.wrapper .box02:last-child').addClass('last-item');
	$('ul li').addClass('odd-item');
	$('ul li:nth-child(2n)').removeClass('odd-item').addClass('even-item');
	$('.simple-list02 li:nth-child(4n)').addClass('fourth-child');
	$(".mobile-btn").click(function(){
        $(".main-nav").slideToggle();
		var hasclass = $("#navIcon").hasClass('fa-navicon');
		if(hasclass){
			$("#navIcon").removeClass('fa-navicon').addClass('fa-close');
		}
		else {
			$("#navIcon").addClass('fa-navicon').removeClass('fa-close');
		}
    });

	$('#chooseFile').bind('change', function () {
		var filename = $("#chooseFile").val();
		if (/^\s*$/.test(filename)) {
			$(".file-upload").removeClass('active');
			$("#noFile").text("No file chosen...");
		}
		else {
			$(".file-upload").addClass('active');
			$("#noFile").text(filename.replace("C:\\fakepath\\", ""));
		}
	});
});


$(window).on('scroll',function() {    
    var scroll = $(window).scrollTop();

    if (scroll >= 300) {
        $(".header").addClass("stikyHead");
    } else {
        $(".header").removeClass("stikyHead");
    }
});
// $('.navList li').each(function(){
//     if(window.location.href.indexOf($(this).find('a:first').attr('href'))>-1)
//     {
//         $(this).addClass('active').siblings().removeClass('active');
//     }
// });
$(document).ready(function () {
	$('#bulk_button').hide();
	$('#tableStyle').DataTable({
		columnDefs: [{
			targets: [0],
			orderData: [0, 1]
		}, {
			targets: [1],
			orderData: [1, 0]
		}, {
			targets: [1],
			orderData: [1, 0]
		}],
		order: [[0, false]],
		bSort: false
	});
});
$('.mainNav').mCustomScrollbar({
	theme: "dark-3"
});

$('.delete_check').click (function ()
{
	if($('.delete_check:checked').size() > 0){
		$('#bulk_button').show();
	}else{
		$('#bulk_button').hide();
	}
});

$("#checkAll").change(function () {
	$("input:checkbox").prop('checked', $(this).prop("checked"));
	if($('#checkAll:checked').size() > 0){
		$('#bulk_button').show();
	}else{
		$('#bulk_button').hide();
	}


});

$(document).on('click', '.del-img-btn', function(){
	var btn = $(this);
	var image_id = btn.attr('data-id');
	var col_name = btn.attr('data-col');
	var table = btn.attr('data-table');
	btn.closest('div').remove();
	$.ajax({type: 'POST' ,
		data: {'_token':"<?=csrf_token()?>" , 'id':image_id , 'table':table, 'col_name': col_name },
		url: base_url + '/delete/image' ,
		success: function (data){

			//hide_show_add_img_btn();
		}
	});
});


