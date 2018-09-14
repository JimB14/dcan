<script>
$('#show').click(function(){
    if($('#show_more').is(':hidden')){
        $('#show_more').slideDown(2000);
        $('#less').show();
        $('#show').hide();
    }else{
        $('#show_more').slideUp('slow');
    }
});

$("#less").click(function() {
    $("#show_more").slideUp("slow");
    $('#show').show();
    $('#less').hide();
});

$('#show2').click(function(){
    if($('#show_more2').is(':hidden')){
        $('#show_more2').slideDown(2000);
        $('#less2').show();
        $('#show2').hide();
    }else{
        $('#show_more2').slideUp('slow');
    }
});

$("#less2").click(function() {
    $("#show_more2").slideUp("slow");
    $('#show2').show();
    $('#less2').hide();
});

$('#show3').click(function(){
    if($('#show_more3').is(':hidden')){
        $('#show_more3').slideDown(2000);
        $('#less3').show();
        $('#show3').hide();
    }else{
        $('#show_more3').slideUp('slow');
    }
});

$("#less3").click(function() {
    $("#show_more3").slideUp("slow");
    $('#show3').show();
    $('#less3').hide();
});

$('#show4').click(function(){
    if($('#show_more4').is(':hidden')){
        $('#show_more4').slideDown(2000);
        $('#less4').show();
        $('#show4').hide();
    }else{
        $('#show_more4').slideUp('slow');
    }
});

$("#less4").click(function() {
    $("#show_more4").slideUp("slow");
    $('#show4').show();
    $('#less4').hide();
});



</script>
