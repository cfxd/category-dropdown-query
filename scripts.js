jQuery( document ).ready(function( $ ) {
   
   
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
  
});
