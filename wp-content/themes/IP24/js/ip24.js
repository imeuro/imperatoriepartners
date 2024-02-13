// ip24.js

let galleryBlock = document.querySelectorAll('.single .wp-block-gallery');

let galleryToCarousel = () => {
	if (galleryBlock) {

		if (window.innerWidth < 1000 ){ // MOBILE MODE
			let i = 0;
			Array.from(galleryBlock).forEach((el) => {
				// console.debug('el',el);

				// reset classes
				el.id = 'photoset-mobile-'+i;
				el.classList = 'ip24Carousel';
				el.dataset.passo = '1';

				// add 'ip24CarouselItem' class to single slide items;
				var children = el.childNodes;
				children.forEach((item) => {
					item.classList = 'ip24CarouselItem ip24Slide';
				});

				// wrap everything into div + append control arrows
				el.outerHTML = `
					<div class="photoset-wrapper">
						${el.outerHTML}
						<a class="ip24CarouselPrev ip24CarouselControl ip24CarouselDisabled" data-target="#${el.id}">Indietro</a>
						<a class="ip24CarouselNext ip24CarouselControl" data-target="#${el.id}">Avanti</a>
					</div>`;
				i++;
			});

		} else { // DESKTOP MODE

			let i = 0;
			let k = 0;
			Array.from(galleryBlock).forEach((el) => {
				// reset classes
				el.id = 'photoset-desktop-'+i;
				el.classList = 'ip24Thumbs';

				// add 'ip24CarouselItem' class to single slide items;
				var children = el.children;
				//console.debug('el',children);
				Array.from(children).forEach((item) => {
					k == 0 ? item.classList = 'ip24GalleryItem selected' :  item.classList = 'ip24GalleryItem';

					console.debug('item',item.firstElementChild);

					item.firstElementChild.addEventListener('click', (e) => {
						console.debug('click',e);
						item.classList.add('selected');
						document.getElementById('ip24img').src = thumb.src;
					});

					k++;
				});

				// wrap everything into div + first pic
				el.outerHTML = `
					<div class="photoset-desktop-wrapper">
						${el.outerHTML}
						<div id="ip24Pic">
							<img id="ip24img" src="${children[0].firstChild.src}" />
						</div>
					</div>`;

				// load first pic into #ip24Pic


				i++;
			});

		}

	}
	img_counter();
}

let img_counter = () => {
	const targetDiv = document.getElementById('entry-img');

	if (targetDiv && galleryBlock){
		let PicNumber = galleryBlock[0].children.length;
		// console.debug('PicNumber',PicNumber);
		// console.debug('galleryBlock',galleryBlock);

		targetDiv.innerHTML = PicNumber+' immagini';
		targetDiv.addEventListener('click', () => {
			document.getElementById(galleryBlock[0].id).scrollIntoView({ behavior: 'smooth' }); 
		});
	}
}

let item_share_print = () => {
	const targetDiv = document.getElementById('entry-share');

	if (targetDiv){

		if (typeof(navigator.share) === "undefined"){
			targetDiv.id = 'entry-print';
			targetDiv.innerHTML = '<a onclick="window.self.print();" title="stampa la scheda immobile" class="printme">stampa</a>';
		} else {
				//const resultPara = targetDiv;
				const shareData = {
					title: document.title,
					text: '',
					url: document.location.href,
				};
				targetDiv.id = 'entry-share';
				targetDiv.innerHTML = '<a href="#">condividi</a>';
				targetDiv.addEventListener("click", async () => {
					try {
						await navigator.share(shareData);
						// resultPara.textContent = "MDN shared successfully";
					} catch (err) {
						// resultPara.textContent = `Error: ${err}`;
					}
				});
		}

	} 

}

//document.addEventListener("DOMContentLoaded", (event) => {
	galleryToCarousel();
	item_share_print();
//});
