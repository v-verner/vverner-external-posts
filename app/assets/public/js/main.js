const $sliders = document.querySelectorAll('.vvep__slider');
 
if($sliders) {
    $sliders.forEach(el => {
        new Flickity(el, {
            cellAlign: 'left',
            contain: true,
            wrapAround: true,
            autoPlay: true,
            imagesLoaded: true,
            adaptiveHeight: false
        });
    }); 

}