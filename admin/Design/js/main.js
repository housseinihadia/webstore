/* $, global, consol ,alert */ 

$(document).ready(function () {
    
    'use strict';

  
 

    // toggle home page 

    $('.toggle').click(function () {

        $(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);

        if($(this).hasClass('selected')) {

            $(this).html("<i class='fa fa-minus fa-lg'></i>");
        }else {

            $(this).html('<i class="fa fa-plus"></i>');

        }
    });




    // trigger select box
      $("select").selectBoxIt({

        autowidth:false
      });



    // hide place holder in form 
    
    $('[placeholder]').focus(function () {
      
            $(this).attr('data-text', $(this).attr('placeholder'));

            $(this).attr('placeholder', '');
        
    }).blur(function () {
        
            $(this).attr('placeholder', $(this).attr('data-text'));
        
            $('.form-control').css('background-color', '#fff');
        
    });
    
    // creat astrix after input 
    
    $('input').each(function () {
       
        if($(this).attr('required') == 'required') {
            
            $(this).after('<span class="astrix">*</span>');
        }
        
    });
    
    // show pass on hover 
    var pass = $('.password');
    
    $('.show-pass').hover(function () {
        
        pass.attr('type', 'text');
        
    }, function () {
       
        pass.attr('type', 'password');
        
    });
    
    // confirm delete member
    $('.confirm').click(function () {
        
        return confirm('You are sure delete');
        
    });

    // full show of category

    $('.category .cat h2').click(function () {

        $(this).next('.full-view').fadeToggle(200);


    });

    $('.option span').click(function () {

        $(this).addClass('active').siblings('span').removeClass('active');

        if($(this).data('view') === 'full') {

            $('.category .cat .full-view').fadeIn(200);

        }else{

          $('.category .cat .full-view').fadeOut(200);

        }

    });

    // show delete in child category 
    $('.child-link').hover(function () {

        $(this).find('.show-delete').fadeIn(400);

    }, function() {

        $(this).find('.show-delete').fadeOut(400);

    }); 

  
    
});