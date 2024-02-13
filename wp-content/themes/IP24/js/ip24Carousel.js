"use strict";
let ip24MediaCarousel;
(ip24MediaCarousel = function() {
  let me = ip24MediaCarousel;
  me.ip24CarouselConfig = {};
  me.observerSlides = [];
  console.log("[ip24MediaCarousel] init");

  me.cbObserverSlides = (entries, observer) => {
    //entries.forEach(entry => {
    for (const entry of entries) {
      requestAnimationFrame(() => {
        let parentCarousel = entry.target.parentElement;

        let targetId = parentCarousel.getAttribute("id");

        if (me.ip24CarouselConfig[targetId]) {
          if (
            entry.intersectionRatio == 1 &&
            !entry.target.classList.contains("ip24CarouselItemActive")
          ) {
            if (me.ip24CarouselConfig[targetId].classi) {
              entry.target.classList.add("ip24CarouselItemActive");
            }

            if (me.ip24CarouselConfig[targetId].eventi) {
              let eventSlideAttivata = new CustomEvent(
                "ip24CarouselSlideAttivata",
                {
                  detail: {
                    carousel: parentCarousel,
                    carouselId: targetId,
                    indexSlide: Array.from(parentCarousel.children).indexOf(
                      entry.target
                    )
                  }
                }
              );
              document.dispatchEvent(eventSlideAttivata);
            }

            //gestione per rimozione classe slide attiva
            if (me.ip24CarouselConfig[targetId].classi) {
              let allSlides = parentCarousel.querySelectorAll(
                  ":scope > .ip24CarouselItem"
                ),
                allSlidesL = allSlides.length,
                i;
              for (i = 0; i < allSlidesL; i++) {
                let rect = allSlides[i].getBoundingClientRect();
                if (rect.left < 0 || rect.right > document.body.clientWidth) {
                  allSlides[i].classList.remove("ip24CarouselItemActive");
                }
              }
            }
          }
        }

        //gestione prev
        let isFirstSlide = entry.target.previousElementSibling;
        if (entry.intersectionRatio == 1 && isFirstSlide == null) {
          document
            .querySelector(".ip24CarouselPrev[data-target='#" + targetId + "']")
            .classList.add("ip24CarouselDisabled");
        } else if (entry.intersectionRatio < 1 && isFirstSlide == null) {
          document
            .querySelector(".ip24CarouselPrev[data-target='#" + targetId + "']")
            .classList.remove("ip24CarouselDisabled");
        }
        //gestione next
        let isLastSlide = entry.target.nextElementSibling;
        if (entry.intersectionRatio == 1 && isLastSlide == null) {
          document
            .querySelector(".ip24CarouselNext[data-target='#" + targetId + "']")
            .classList.add("ip24CarouselDisabled");
        } else if (entry.intersectionRatio < 1 && isLastSlide == null) {
          document
            .querySelector(".ip24CarouselNext[data-target='#" + targetId + "']")
            .classList.remove("ip24CarouselDisabled");
        }
      });
    }
  };

  me.observeSlides = function(slideNodes, id) {
    let slideNodesl = slideNodes.length,
      i;
    for (i = 0; i < slideNodesl; i++) {
      me.observerSlides[id].observe(slideNodes[i]);
      slideNodes[i].classList.add("observerProcessed");
    }
  };

  me.setObserversSlides = function(carousel) {
    let carouselId = carousel.getAttribute("id");
    console.log("[ip24MediaCarousel] setObserver per id:", carouselId);

    let config = carousel.getAttribute("data-config") || null;

    if (config != null) {
      me.ip24CarouselConfig[carouselId] = JSON.parse(config);
    }

    let options = {
      root: carousel,
      rootMargin: "10px 10px 10px 10px",
      threshold: 1
    };

    me.observerSlides[carouselId] = new IntersectionObserver(
      me.cbObserverSlides,
      options
    );

    let slides;
    if (config != null) {
      slides = carousel.querySelectorAll(":scope > .ip24CarouselItem");
    } else {
      slides = carousel.querySelectorAll(
        ":scope > .ip24CarouselItem:first-child, :scope > .ip24CarouselItem:last-child"
      );
    }

    me.observeSlides(slides, carouselId);
  };

  me.outerWidth = function(el) {
    var width = el.offsetWidth;
    var style = getComputedStyle(el);

    width += parseInt(style.marginLeft) + parseInt(style.marginRight);
    return width;
  };

  me.cbObserverCarousels = (entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add("ip24CarouselInViewport");
        me.setObserversSlides(entry.target);
      } else {
        entry.target.classList.remove("ip24CarouselInViewport");
        let carouselId = entry.target.getAttribute("id");
        if (me.observerSlides[carouselId]) {
          me.observerSlides[carouselId].disconnect();
          console.log(
            "[ip24MediaCarousel] disconnect observer per id:",
            carouselId
          );
        }
      }
    });
  };

  me.observeCarousels = function(allCarousels) {
    let allCarouselsl = allCarousels.length,
      i;
    for (i = 0; i < allCarouselsl; i++) {
      me.observerCarousels.observe(allCarousels[i]);
    }
  };

  me.setObserversCarousels = function() {
    let options = {
      rootMargin: "150px 10px 150px 10px",
      threshold: 0.01
    };

    me.observerCarousels = new IntersectionObserver(
      me.cbObserverCarousels,
      options
    );

    let allCarousels = document.querySelectorAll(".ip24Carousel");

    me.observeCarousels(allCarousels);
  };

  //gestisce i controlli avanti e indietro
  me.setControls = function() {
    let ip24CarouselAllControls = document.querySelectorAll(
        ".ip24CarouselControl:not(.ip24CarouselProcessed)"
      ),
      i,
      ip24CarouselAllControlsL = ip24CarouselAllControls.length;
    for (i = 0; i < ip24CarouselAllControlsL; i++) {
      //me.setObserver(ip24CarouselAllControls[i]);

      ip24CarouselAllControls[i].addEventListener("click", function(e) {
        e.preventDefault();
        let direction;
        e.currentTarget.classList.contains("ip24CarouselPrev")
          ? (direction = -1)
          : (direction = 1);
        //identifichiamo il target
        let target = e.currentTarget.getAttribute("data-target");
        let ip24Carousel = document.querySelector(target);

        //leggiamo il passo impostato
        let ip24CarouselPasso = ip24Carousel.getAttribute("data-passo");
        //scroll di partenza
        let scrollLeft = ip24Carousel.scrollLeft;
        //diamo per scontato che abbiano tutti la stessa larghezza
        let itemWidth = me.outerWidth(
          ip24Carousel.querySelector(".ip24CarouselItem")
        );

        let destination = Math.floor(
          scrollLeft + itemWidth * ip24CarouselPasso * direction
        );
        if (destination < 0) destination = 0;

        let carouselScrollWidth = ip24Carousel.scrollWidth;
        let carouselWidth = ip24Carousel.offsetWidth;
        let itemInview = carouselWidth / itemWidth;
        let itemActive = Math.round(scrollLeft / itemWidth);

        if (
          scrollLeft + carouselWidth == carouselScrollWidth &&
          direction == -1
        ) {
          destination = Math.round(itemActive - ip24CarouselPasso) * itemWidth;
        }

        if (getComputedStyle(ip24Carousel).scrollBehavior === "smooth") {
          requestAnimationFrame(function() {
            ip24Carousel.scrollTo({
              top: 0,
              left: destination
            });
          });
        } else {
          //fallback per no smooth
          console.log("[ip24MediaCarousel] fallback per no smooth");
          //leggiamo il tempo di animazione per fallback
          let ip24CarouselTime =
            parseInt(ip24Carousel.getAttribute("data-time")) || 300;
          let start = new Date().getTime();
          let timer = setInterval(function() {
            requestAnimationFrame(function() {
              let step = Math.min(
                1,
                (new Date().getTime() - start) / ip24CarouselTime
              );
              let position = scrollLeft + step * (destination - scrollLeft) + 0;
              if (step === 1) clearInterval(timer);
              ip24Carousel.scrollLeft = position;
            });
          }, 25);
        }
      });
      ip24CarouselAllControls[i].classList.add("ip24CarouselProcessed");
    }

    //init degli observer
    //me.setObserversSlides();
    me.setObserversCarousels();
  };

  //init di tutti i controlli
  me.setControls();
})();
