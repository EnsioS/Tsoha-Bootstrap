$(document).ready(function(){
  //alert('Hello World!');
});

$(document).ready(function(){
    $('form.destroy-form').on('submit', function(submit){
       console.log('KIRJOITTAA') 
        
       var confirm_message = $(this).attr('data-confirm');
       
       if(!confirm(confirm_message)){
           submit.preventDefault();
       }
    });
});
