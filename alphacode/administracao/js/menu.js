//fechar menu
$('.navbar-nav li a').click(function() {
	if ( !$(this).parent().hasClass('dropdown')) {
		$('.navbar-collapse').collapse('hide'); 
    }
}); 		
	
//voltar ao topo  
$(document).ready(function() {
	if ($(this).scrollTop() <= 150) {
		$("#topo").hide();
	}
});	
		
$(document).scroll(function() {  	
	if ($(this).scrollTop() > 150) {
		$("#topo").show();
	}else{
		$("#topo").hide();  	
	}   
});