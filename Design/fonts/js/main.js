/* $, global, consol , alert */ 

$(document).ready(function () {
    
    'use strict';

// show any form to show 

$('.login-page h1 span').click(function () {

        $(this).addClass('selected').siblings().removeClass('selected');

       $('.login-page form').hide();

        $('.' + $(this).data('class')).fadeIn(100);


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

//
    $('.option span').click(function () {

        $(this).addClass('active').siblings('span').removeClass('active');

        if($(this).data('view') === 'full') {

            $('.category .cat .full-view').fadeIn(200);

        }else{

          $('.category .cat .full-view').fadeOut(200);

        }

    }); 

    // the adding item live previw in cation

    $('.user-live').keyup(function () {

        $('.live-preview .caption h3').text($(this).val());

    });


    $('.desc').keyup(function () {

        $('.live-preview .caption p').text($(this).val());

    });


    $('.price-live').keyup(function () {

        $('.live-preview .price').text('$' + $(this).val());

    });
    
});