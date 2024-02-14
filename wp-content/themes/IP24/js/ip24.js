// ip24.js

let menulinks = () => {
	const menuScope = document.getElementById('primary-menu').children;

	for (var i = menuScope.length - 1; i >= 0; i--) {
		let link = menuScope[i].firstChild.href;
		console.debug(link);
		if (link.includes("#") === true) {
			menuScope[i].firstChild.addEventListener('click',(e) => {
				e.preventDefault();

			});
		}
	}
}

let galleryBlock = document.querySelectorAll('.single .wp-block-gallery');

let galleryToCarousel = () => {
	if (galleryBlock) {

		if (window.innerWidth < 768 ){ // MOBILE MODE
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

				var children = el.querySelectorAll('figure');

				children.forEach(item => {
					k == 0 ? item.classList = 'ip24GalleryItem selected' :  item.classList = 'ip24GalleryItem';
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




			let thumbs = document.querySelectorAll('.ip24GalleryItem');
			let bigpic = document.getElementById('ip24img');
			thumbs.forEach(item => {
				item.addEventListener('click', () => {
					document.querySelector('.ip24GalleryItem.selected').classList.remove('selected');
					item.classList.toggle("selected");
					bigpic.style.opacity = 0;
					bigpic.src = item.firstChild.src;
					bigpic.style.opacity = 1;
				});

			})

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

galleryToCarousel();
item_share_print();

