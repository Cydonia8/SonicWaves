const audios = document.querySelectorAll("audio");
const img = document.querySelectorAll(".cancion-prev .img-fluid")
const button_menu = document.querySelector(".button-menu-responsive")
const header = document.querySelector("header")

// const height = img.clientHeight
// const width = img.clientWidth

button_menu.addEventListener("click", ()=>{
    if(header.classList.contains("header-mobile")){
        header.classList.remove("header-mobile")
    }else{
        header.classList.add("header-mobile")
    }
})

img.forEach(imagen => {
    let height = imagen.clientHeight
    let width = imagen.clientWidth
    imagen.addEventListener("mousemove", (evento) => {
        const {layerX, layerY} = evento
    
        const yRotation = ((layerX - width / 2) / width) * 20
        const xRotation = ((layerY - height / 2) / height) * 20
    
        const string = `perspective(500px)
                        scale(1.05)
                        rotateX(${xRotation}deg) 
                        rotateY(${yRotation}deg)`
        imagen.style.transform = string
    })

    imagen.addEventListener("mouseout", () => {
        imagen.style.transform = `
        perspective(0px)
        scale(1)
        rotateX(0deg)
        rotateY(0deg)
        `
    })
})

audios.forEach((audio) => {
    let start = 30
    audio.currentTime=start
    audio.addEventListener("timeupdate", (e) => {
        let currentTime = e.target.currentTime
        if (currentTime > start + 15){
            audio.pause()
        }
    })
})

// (function() {
  
//     var carousel = document.getElementsByClassName('carousel')[0],
//         slider = carousel.getElementsByClassName('carousel__slider')[0],
//         items = carousel.getElementsByClassName('carousel__slider__item'),
//         prevBtn = carousel.getElementsByClassName('carousel__prev')[0],
//         nextBtn = carousel.getElementsByClassName('carousel__next')[0];
    
//     var width, height, totalWidth, margin = 20,
//         currIndex = 0,
//         interval, intervalTime = 4000;
    
//     function init() {
//         resize();
//         move(Math.floor(items.length / 2));
//         bindEvents();
      
//         timer();
//     }
    
//     function resize() {
//         width = Math.max(window.innerWidth * .20, 276),
//         height = window.innerHeight * 1,
//         totalWidth = width * items.length;
      
//         slider.style.width = totalWidth + "px";
      
//         for(var i = 0; i < items.length; i++) {
//             let item = items[i];
//             item.style.width = (width - (margin * 2)) + "px";
//             item.style.height = height + "px";
//         }
//     }
    
//     function move(index) {
      
//         if(index < 1) index = items.length;
//         if(index > items.length) index = 1;
//         currIndex = index;
      
//         for(var i = 0; i < items.length; i++) {
//             let item = items[i],
//                 box = item.getElementsByClassName('item__3d-frame')[0];
//             if(i == (index - 1)) {
//                 item.classList.add('carousel__slider__item--active');
//                 box.style.transform = "perspective(1200px)"; 
//             } else {
//               item.classList.remove('carousel__slider__item--active');
//                 box.style.transform = "perspective(1200px) rotateY(" + (i < (index - 1) ? 40 : -40) + "deg)";
//             }
//         }
      
//         slider.style.transform = "translate3d(" + ((index * -width) + (width / 2) + window.innerWidth / 2) + "px, 0, 0)";
//     }
    
//     function timer() {
//         clearInterval(interval);    
//         interval = setInterval(() => {
//           move(++currIndex);
//         }, intervalTime);    
//     }
    
//     function prev() {
//       move(--currIndex);
//       timer();
//     }
    
//     function next() {
//       move(++currIndex);    
//       timer();
//     }
    
    
//     function bindEvents() {
//         window.onresize = resize;
//         prevBtn.addEventListener('click', () => { prev(); });
//         nextBtn.addEventListener('click', () => { next(); });    
//     }
//     init();
  
// })();  