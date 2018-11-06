jQuery( document ).ready(function( $ ) {

    $(document).on('change', '#blog-cat-menu', function() {
        var theForm = $(this);
        $.ajax({
            url:      afp_vars.afp_ajax_url,
            data:     theForm.serialize() + '&action=filter_posts',
            type:     'POST',
            dataType: 'json',
            beforeSend: function() {
                $('body').addClass('ajax-sort');
            },
            success: function(data) {
                $.get(data.url, function(got) {
//console.log(got); <--this is the full markup of the new page
                    $('.blog_wrap').replaceWith($(got).find('.blog_wrap'));
                })
                .done(function() {
                    $('body').removeClass('ajax-sort');
                    //this is optional but can make for a nice URL
                    //history.pushState(data, 'Filter Results', data.url);
                });
            },
        });
        return false;
    });

/*
   //Blog Dropdown Sort
   $(document).on("change", '#blog-cat-menu', function(e) {
      // Prevent default action - opening tag page
      if (event.preventDefault) {
          event.preventDefault();
      } else {
        
        event.returnValue = false;
      }
      
      // Get category slug from title attirbute
      var category = $(this).val();
      
      // After user click on tag, fade out list of posts
      jQuery('.my-blogs').fadeOut();
      
      data = {
        action: 'filter_posts', // function to execute
        afp_nonce: afp_vars.afp_nonce, // wp_nonce
        category: category, // selected cat
      };
      
      jQuery.post( afp_vars.afp_ajax_url, data, function(response) {
      
          if( response ) {
          
              // Display posts on page
              jQuery('.my-blogs').html( response );
              
              
              // Restore div visibility
              jQuery('.my-blogs').fadeIn();
          };
      });
      
      
  });
   //Blog Dropdown Sort END 
*/
  $(window).on("load resize", function(e) {
    // Select and loop the container element of the elements you want to equalise
    $('.team-members').each(function() {

       // Cache the highest
       var highestBox = 0;

       // Select and loop the elements you want to equalise
       $('.member-wrapper .member-job-title', this).each(function() {

           // If this box is higher than the cached highest then store it
           if ($(this).height() > highestBox) {
               highestBox = $(this).height();
           }

       });

       if ($(window).width() > 768) {

           // Set the height of all those children to whichever was highest 
           $('.member-wrapper .member-job-title', this).height(highestBox);
       }

    });

  }); 
  
  
  //fade site in
         $('body').fadeIn(1000);
        //  $('#topbar').delay(1500).fadeIn(1000);
        
        // team page menu
        
   
        $('.team-menu-link').click(function() { 
            $('.team-menu-link').removeClass('team-menu-active');
            $(this).addClass('team-menu-active');
        });
        
            $(window).load(function(){
                var childHeight = $("#services").height();
                $(".team-section").height(childHeight);
            });
       
        var fadeOutSpeed = 300;
        var changeHeightSpeed = 500;
         
        
        function scrollDown() {
            $('html,body').delay(500).animate({
            scrollTop: $(".team-section").offset().top -100},
            'slow');
        }

        $('.services-link').click(function() {
            $('.team-members').fadeOut(fadeOutSpeed);
            var childHeight = $("#services").height();
            $(".team-section").delay(changeHeightSpeed).animate({
                    height: childHeight
                  }, 500, function() {
            $('#services').delay().fadeIn();
            });
            
            scrollDown(); 
        });
        
        $('.support-link').click(function() {
            $('.team-members').fadeOut(fadeOutSpeed);
            var childHeight = $("#support").height();
            $(".team-section").delay(changeHeightSpeed).animate({
                    height: childHeight
                  }, 500, function() {
            $('#support').delay().fadeIn();
            });
           scrollDown(); 
        });
        $('.research-link').click(function() {
            $('.team-members').fadeOut(fadeOutSpeed);
            var childHeight = $("#research").height();
            $(".team-section").delay(changeHeightSpeed).animate({
                    height: childHeight
                  }, 500, function() {
            $('#research').delay().fadeIn();
            });
           scrollDown(); 
        });
        
        $('.legal-link').click(function() {
            $('.team-members').fadeOut(fadeOutSpeed);
            var childHeight = $("#legal").height();
            $(".team-section").delay(changeHeightSpeed).animate({
                    height: childHeight
                  }, 500, function() {
            $('#legal').delay().fadeIn();
            });
            scrollDown(); 
        });
        

         $(window).on("resize", function(e) { 
            $('.team-members').hide();
            var childHeight = $("#services").height();
             $(".team-section").height(childHeight);
              $('.team-menu-link').removeClass('team-menu-active');
              $('.services-link').addClass('team-menu-active');
             $('#services').show();
         
          }); 
             
        
   //     team page bio popup
        
//        $('.window-link---').click(function() {
//            $('.team-page-container').css('z-index','9999');
//             $('.bio-background').fadeIn('fast', function() {
//                $('html').css('overflow','hidden');
//             });
//            $(this).parent().next('.bio-window').delay(500).fadeIn(500);
//        });
        
//        $('.close-icon').click(function() {
//             $('.bio-window').fadeOut('fast', function() {  
//                 $('.bio-background').fadeOut(500);
//                
//             });
//             $('html').delay(1000).css('overflow-y','scroll');
//             $('.team-page-container').delay(1000).css('z-index','3');
//        }); 
        


        $('.window-link').click(function() {
           // $('.team-page-container').css('z-index','9999');
            $(' #header-outer').css('z-index','3');
             $(' #topbar').css('z-index','5');
             $(' #footer-outer').hide();
            
             $('.bio-background').fadeIn(100, function() {
                $('html').delay(1000).css('overflow','hidden');
             });
            $(this).parent().siblings('.bio-slider-fixed-wrapper').delay(500).fadeIn(500);
        });
        
        
        $('.close-icon').click(function() {
             $('.bio-slider-fixed-wrapper').fadeOut(100, function() {  
                 $('.bio-background').fadeOut(500);
                 $('html').delay(1000).css('overflow-y','scroll');
             });
            
             //$('.team-page-container').delay(1000).css('z-index','3');
             $('#footer-outer').show();
        });  
        
        
         $(window).on("load resize", function(e) {
             // team hover
             $('.window-link')
                 .mouseenter(function() {
                     if ($(window).width() > 768) {
                         $(this).children('h3').css('color', '#cc9500');
                         $(this).siblings('.member-job-title').css('color', '#cc9500');
                         $(this).children('img').css('opacity', '1');
                     }
                 })
                 .mouseleave(function() {
                     if ($(window).width() > 768) {
                         $(this).children('h3').css('color', '#333');
                         $(this).siblings('.member-job-title').css('color', '#333');
                         $(this).children('img').css('opacity', '.5');
                     }
                 });

             if ($(window).width() < 768) {
                 $('.window-link').children('img').css('opacity', '1');
             } else {
                 $('.window-link').children('img').css('opacity', '.5');
             }

         });

        
        // career page position popup
        
        $('.career-box').click(function() {
            $('.careers-page-container').css('z-index','999999');
             $('.bio-background').fadeIn('fast', function() {
                $('html').css('overflow','hidden');
             });
            $(this).next().siblings('.bio-window').delay(500).fadeIn(500);
        });
        
        $('.close-icon').click(function() {
             $('.bio-window').fadeOut('fast', function() {  
                 $('.bio-background').fadeOut(500);
                
             });
             $('html').delay(1000).css('overflow-y','scroll');
             $('.team-page-container').delay(1000).css('z-index','3');
        });  
        
        
        
        $(" .contact-form input").focus(function() {
           $(this).siblings('label').hide();
                
        });
        
        $(" .contact-form textarea").focus(function() {
           $(this).siblings('label').hide();
                
        });
                
        $('#slide-out-widget-area .open-dialog a').click(function (e) {
            
            e.preventDefault();                 
             var goTo = this.getAttribute("href");
            
            $('.dialog-window').fadeIn(); 
            $('.dialog-background').fadeIn(); 
             setTimeout(function(){
                    window.location = goTo;
             },5000);  

        });
        
       $('.close-dialog').click(function (e) {
            location.reload();
           
       });
        
        var i=0;
        $('#services .member-wrapper').each(function(){
            i++;
            var newID='member-'+i;
            $(this).attr('id',newID);
            $(this).val(i);
        });
        
        var sup=0;
        $('#support .member-wrapper').each(function(){
            sup++;
            var newID='member-'+sup;
            $(this).attr('id',newID);
            $(this).val(i);
        });
        
        var res=0;
        $('#research .member-wrapper').each(function(){
            res++;
            var newID='member-'+res;
            $(this).attr('id',newID);
            $(this).val(i);
        });
        
        var leg=0;
        $('#legal .member-wrapper').each(function(){
            leg++;
            var newID='member-'+leg;
            $(this).attr('id',newID);
            $(this).val(i);
        });
        
        
        
        var ii=0;
        $('.slider-bio-item').each(function(){
            ii++;
            var newID='bio-slide-'+i;
            $(this).attr('id',newID);
            $(this).val(i);
        });
                   
        $('.bio-slider').slick({
            arrows: true,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            slide: '.slider-bio-item',


            
       });
        


        
        $('.team-members .member-wrapper').click(function () {
            
          var $memberID = $(this).attr("id").replace(/member-/, '');
            
        var numReset = $memberID - 1;
            
           
             
            
          $('.bio-slider').slick('slickGoTo', numReset);
         });

  
   
  // init controller
  var controller = new ScrollMagic.Controller();
  
  // create a scene
   var scene = new ScrollMagic.Scene({
          triggerElement: '#share-social', // starting scene, when reaching this element
          duration: $(".content-inner").height() + 75, // pin element for the window height - 1
          // duration: 70000 // pin the element for a total of 400px
        })
        
        .setPin('#share-social'); // the element we want to pin
        // Add Scene to ScrollMagic Controller
        controller.addScene(scene);

  if ($(".page-template-template-login-news .validation_error")[0]){
      // Do something if class exists
      document.getElementById("defaultOpen-thank").click(); 
  } else {
      // Do something if class does not exist
  }
  if ($(".page-template-template-login-news .gform_confirmation_wrapper")[0]){
      // Do something if class exists
      $(".register-title").css("display", "none")
      document.getElementById("defaultOpen-thank").click(); 
  } else {
      // Do something if class does not exist
  }
  if ($(".page-template-template-login-whitepapers .validation_error")[0]){
      // Do something if class exists
      document.getElementById("defaultOpen-thank").click(); 
  } else {
      // Do something if class does not exist
  }
  if ($(".page-template-template-login-whitepapers .gform_confirmation_wrapper")[0]){
      // Do something if class exists
      $(".register-title").css("display", "none")
      document.getElementById("defaultOpen-thank").click(); 
  } else {
      // Do something if class does not exist
  }
  $("#loginform").submit(function(e) {
    if ($('input#user_login').val() === "") {
      e.preventDefault();
    } else {
      
    }
    if ($('input#user_pass').val() === "") {
      e.preventDefault();
    } else {
      
    }
  });
  $(' .main-content .open-dialog').click(function (e) {            
      e.preventDefault();                 
      var goTo = this.getAttribute("href");      
      $('.dialog-window').fadeIn(); 
      $('.dialog-background').fadeIn();      
      setTimeout(function(){
          window.location = goTo;
      },5000); 
  });
  $(' #topbarinner .open-dialog').click(function (e) {
      e.preventDefault();                 
      var goTo = this.getAttribute("href");      
      $('.dialog-window').fadeIn(); 
      $('.dialog-background').fadeIn();       
      setTimeout(function(){
          window.location = goTo;
      },5000);      
  });
  $('#lostpasswordform #user_login').click(function (e) {            
      $('.text-inner').css('display', 'none'); 
  });
  
  
        
  
});




