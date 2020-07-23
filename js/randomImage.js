$(document).ready(function(){
// using ajax to display an image loaded from database without refreshing the page
  var getRandomImage = function(){
    $.ajax({
      // getRandomImage randomly fetchs an image from database
      method : 'post',
      url : './application/getRandomImage.php'
    }).then(function(data){
      // console.log(data);
      // returns an object from JSON data
      data = JSON.parse(data);
      // loads random main image on index.php
      $('#imageRandom').attr('src', 'img/upload/'+data.file)
      // sends to artwork.php with the right image id when main image is clicked
      $('#imageId').attr('href', 'artwork.php?id='+data.id)
      // loads background image with the same id as main image 
      $('#bodyImg').css('background-image', 'url(img/upload/'+ data.file +')')
      })
  }

  getRandomImage();
  // displays a random image when clicked
  $('#next').on('click',getRandomImage);

})


