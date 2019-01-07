 $('document').ready(function () {



     $('#menuButtonIndex').click(function () {
         $('#headerBoxIndex').height('15vh');
     });
     $('#menuButtonIndex').mouseover(function () {
         $('#headerBoxIndex').height('15vh');
     });
     $('#headerBoxIndex').mouseleave(function () {
         $('#headerBoxIndex').height('0vh');
     });

     $('#indexCarouselImgOne').hide();
     $('#indexCarouselImgTwo').hide();
     $('#indexCarouselImgThree').hide();
     $('#indexCarouselImgFour').hide();
     $('#indexCarouselImgFive').hide();
     $('#indexCarouselImgSix').hide();
     $('#indexCarouselImgSeven').hide();
     $('#indexCarouselImgEight').hide();
     $('#indexCarouselImgNine').hide();
     $('#indexCarouselImgTen').hide();

     var gallerSlider = function () {
         $('#indexCarouselImgOne').fadeIn(2000, function () {
             $('#indexCarouselImgOne').fadeOut(2000, function () {
                 $('#indexCarouselImgTwo').fadeIn(2000, function () {
                     $('#indexCarouselImgTwo').fadeOut(2000, function () {
                         $('#indexCarouselImgThree').fadeIn(2000, function () {
                             $('#indexCarouselImgThree').fadeOut(2000, function () {
                                 $('#indexCarouselImgFour').fadeIn(2000, function () {
                                     $('#indexCarouselImgFour').fadeOut(2000, function () {
                                         $('#indexCarouselImgFive').fadeIn(2000, function () {
                                             $('#indexCarouselImgFive').fadeOut(1000, function () {
                                                 $('#indexCarouselImgSix').fadeIn(2000, function () {
                                                     $('#indexCarouselImgSix').fadeOut(2000, function () {
                                                         $('#indexCarouselImgSeven').fadeIn(2000, function () {
                                                             $('#indexCarouselImgSeven').fadeOut(2000, function () {
                                                                 $('#indexCarouselImgEight').fadeIn(2000, function () {
                                                                     $('#indexCarouselImgEight').fadeOut(2000, function () {
                                                                         $('#indexCarouselImgNine').fadeIn(2000, function () {
                                                                             $('#indexCarouselImgNine').fadeOut(2000, function () {
                                                                                 gallerSlider().fadeIn(5000);
                                                                             })
                                                                         })
                                                                     })
                                                                 })
                                                             })
                                                         })
                                                     })
                                                 })
                                             })
                                         })
                                     })
                                 })
                             })
                         })
                     })
                 })
             })
         })
     }
     gallerSlider();
     gallerSlider();
     gallerSlider();
     gallerSlider();

 });